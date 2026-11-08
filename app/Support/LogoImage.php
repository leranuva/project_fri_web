<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Validation\ValidationException;
use Symfony\Component\Process\Exception\ProcessTimedOutException;
use Symfony\Component\Process\ExecutableFinder;
use Symfony\Component\Process\Process;

class LogoImage
{
    public const FORMATS = 'PNG, JPG, JPEG, WebP, GIF, BMP, AVIF, ICO, TIFF, HEIC, HEIF y SVG';

    public const ACCEPT = '.png,.jpg,.jpeg,.webp,.gif,.bmp,.avif,.ico,.tif,.tiff,.heic,.heif,.svg';

    private const CODERS = [
        'image/png' => 'png',
        'image/jpeg' => 'jpeg',
        'image/webp' => 'webp',
        'image/gif' => 'gif',
        'image/bmp' => 'bmp',
        'image/x-ms-bmp' => 'bmp',
        'image/avif' => 'heic',
        'image/avif-sequence' => 'heic',
        'image/heic' => 'heic',
        'image/heic-sequence' => 'heic',
        'image/heif' => 'heic',
        'image/heif-sequence' => 'heic',
        'image/vnd.microsoft.icon' => 'ico',
        'image/x-icon' => 'ico',
        'image/tiff' => 'tiff',
    ];

    public function optimize(UploadedFile $file): string
    {
        $mime = $file->getMimeType();
        $svg = $mime === 'image/svg+xml';
        $coder = $svg ? 'png' : (self::CODERS[$mime] ?? null);

        if (! $coder) {
            throw ValidationException::withMessages(['logo_image' => 'Selecciona una imagen en un formato admitido.']);
        }

        $finder = new ExecutableFinder;
        $convert = $finder->find('magick') ?? $finder->find('convert');
        $renderSvg = $svg ? $finder->find('rsvg-convert') : null;
        if (! $convert || ($svg && ! $renderSvg)) {
            abort(503, 'El servidor necesita ImageMagick y librsvg para procesar el logo.');
        }

        $input = $file->get();
        if ($svg) {
            // El SVG se lee por stdin para que el renderizador no tenga una ruta base.
            $input = $this->run([$renderSvg, '--width=512', '--height=512', '--keep-aspect-ratio'], $input);
        }

        return $this->run([
            $convert,
            '-limit', 'thread', '2',
            '-limit', 'memory', '96MiB',
            '-limit', 'map', '96MiB',
            '-limit', 'disk', '0',
            '-limit', 'list-length', '32',
            '-limit', 'width', '6000',
            '-limit', 'height', '6000',
            $coder . ':-[0]',
            '-auto-orient', '-colorspace', 'sRGB',
            '-bordercolor', 'none', '-border', '1', '-trim', '+repage',
            '-thumbnail', '512x512>',
            '-strip', '-define', 'webp:lossless=true', 'webp:-',
        ], $input);
    }

    private function run(array $command, string $input): string
    {
        $process = new Process($command, input: $input, timeout: 8);

        try {
            $process->run();
            if ($process->isSuccessful() && $process->getOutput() !== '') {
                return $process->getOutput();
            }
        } catch (ProcessTimedOutException) {
            throw ValidationException::withMessages([
                'logo_image' => 'La imagen tardó demasiado en procesarse. Prueba con un archivo más pequeño o sencillo.',
            ]);
        }

        $error = strtolower($process->getErrorOutput());
        if (str_contains($error, 'no decode delegate') || str_contains($error, 'no encode delegate')
            || str_contains($error, 'security policy')) {
            abort(503, 'El servidor no tiene habilitado el conversor para este formato.');
        }

        $message = str_contains($error, 'resource limit') || str_contains($error, 'cache resources')
            || str_contains($error, 'exceeds limit')
            ? 'La imagen supera los límites de procesamiento. Usa un archivo más pequeño.'
            : 'El archivo no se pudo leer como imagen. Comprueba que esté en buen estado.';
        throw ValidationException::withMessages(['logo_image' => $message]);
    }
}
