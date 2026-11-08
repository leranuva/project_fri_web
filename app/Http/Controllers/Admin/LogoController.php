<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Logo;
use App\Support\LogoImage;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Symfony\Component\Mime\MimeTypes;
use Throwable;

class LogoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $logos = Logo::latest()->paginate(15);
        return view('admin.logos.index', compact('logos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.logos.create');
    }

    public function store(Request $request, LogoImage $images)
    {
        $validated = $this->validateLogo($request, 'required');
        $path = $this->storeImage($validated['logo_image'], $images);

        try {
            DB::transaction(function () use ($validated, $path): void {
                $this->lockLogos();
                $logo = Logo::create([
                    'name' => $validated['name'] ?? 'Logo ' . now()->format('Y-m-d'),
                    'image_path' => $path,
                    'order' => $validated['order'] ?? 0,
                    'is_active' => false,
                ]);
                if ($validated['is_active'] ?? false) {
                    $logo->activate();
                }
            }, 3);
        } catch (Throwable $error) {
            $this->deleteManagedImage($path);
            throw $error;
        }

        return redirect()->route('admin.logos.index')->with('success', 'Logo creado exitosamente.');
    }

    public function preview(Request $request, LogoImage $images)
    {
        $validated = $request->validate(['logo_image' => ['required', 'file', 'max:5120']]);

        return response($images->optimize($validated['logo_image']), 200, [
            'Content-Type' => 'image/webp',
            'Cache-Control' => 'no-store',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $logo = Logo::findOrFail($id);
        $original = $logo->originalKey();
        $hasOriginal = $original && Storage::disk('local')->exists($original);

        return view('admin.logos.show', compact('logo', 'hasOriginal'));
    }

    public function downloadOriginal(string $id)
    {
        $original = Logo::findOrFail($id)->originalKey();
        $disk = Storage::disk('local');
        abort_unless($original && $disk->exists($original), 404);

        $mime = $disk->mimeType($original) ?: 'application/octet-stream';
        $extension = MimeTypes::getDefault()->getExtensions($mime)[0] ?? 'bin';

        return $disk->download($original, 'logo-original.' . $extension, [
            'Content-Type' => 'application/octet-stream',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $logo = Logo::findOrFail($id);
        return view('admin.logos.edit', compact('logo'));
    }

    public function update(Request $request, string $id, LogoImage $images)
    {
        Logo::findOrFail($id);
        $validated = $this->validateLogo($request, 'nullable');
        $file = $validated['logo_image'] ?? null;
        $path = $file ? $this->storeImage($file, $images) : null;

        try {
            DB::transaction(function () use ($id, $validated, $path): void {
                $this->lockLogos();
                $logo = Logo::findOrFail($id);
                if ($path && $logo->imageUrl()) {
                    $previous = $logo->replicate();
                    $previous->name = Str::limit($logo->name ?? 'Logo', 220, '') . ' · versión anterior';
                    $previous->is_active = false;
                    $previous->saveOrFail();
                }
                $logo->name = $validated['name'] ?? $logo->name;
                $logo->order = $validated['order'] ?? $logo->order;
                $logo->image_path = $path ?? $logo->image_path;
                $active = $validated['is_active'] ?? $logo->is_active;
                if ($active) {
                    $this->ensureImageAvailable($logo);
                    $logo->activate();
                } else {
                    $logo->is_active = false;
                    $logo->save();
                }
            }, 3);
        } catch (Throwable $error) {
            $this->deleteManagedImage($path);
            throw $error;
        }

        return redirect()->route('admin.logos.index')->with('success', 'Logo actualizado exitosamente.');
    }

    public function destroy(string $id)
    {
        $path = DB::transaction(function () use ($id): ?string {
            $this->lockLogos();
            $logo = Logo::findOrFail($id);
            $path = $logo->image_path;
            $logo->delete();

            return $path;
        }, 3);
        $this->deleteManagedImage($path);

        return redirect()->route('admin.logos.index')->with('success', 'Logo eliminado exitosamente.');
    }

    public function activate(string $id)
    {
        DB::transaction(function () use ($id): void {
            $this->lockLogos();
            $logo = Logo::findOrFail($id);
            $this->ensureImageAvailable($logo);
            $logo->activate();
        }, 3);

        return redirect()->route('admin.logos.index')->with('success', 'Logo activado exitosamente.');
    }

    private function validateLogo(Request $request, string $fileRequirement): array
    {
        return $request->validate([
            'name' => ['nullable', 'string', 'max:255'],
            'logo_image' => [$fileRequirement, 'file', 'max:5120'],
            'is_active' => ['nullable', 'boolean'],
            'order' => ['nullable', 'integer', 'min:0'],
        ]);
    }

    private function storeImage(UploadedFile $file, LogoImage $images): string
    {
        $optimized = $images->optimize($file);
        $key = 'logos/' . Str::uuid() . '.webp';
        $path = 'storage/' . $key;
        $source = Logo::sourceKey($path);

        try {
            if (! Storage::disk('local')->put($source, $file->get())
                || ! Storage::disk('public')->put($key, $optimized)) {
                throw ValidationException::withMessages(['logo_image' => 'No se pudo guardar el logo.']);
            }
        } catch (Throwable $error) {
            $this->deleteManagedImage($path);
            throw $error;
        }

        return $path;
    }

    private function ensureImageAvailable(Logo $logo): void
    {
        if (! $logo->imageUrl()) {
            throw ValidationException::withMessages(['logo_image' => 'Sube un archivo válido antes de activar este logo.']);
        }
    }

    private function deleteManagedImage(?string $path): void
    {
        if ($path && preg_match('~^storage/logos/[a-z0-9-]+\.(webp|png|jpe?g|svg)$~iD', $path)
            && ! Logo::where('image_path', $path)->exists()) {
            Storage::disk('public')->delete(substr($path, 8));
            if ($source = Logo::sourceKey($path)) {
                Storage::disk('local')->delete($source);
            }
        }
    }

    private function lockLogos(): void
    {
        Logo::orderBy('id')->lockForUpdate()->get(['id']);
    }
}
