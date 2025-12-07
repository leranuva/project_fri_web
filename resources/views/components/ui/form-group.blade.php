@props(['name', 'label'])

<div class="mb-4 sm:mb-6">
    @isset($labelSlot)
        {!! $labelSlot !!}
    @else
        @if(isset($label) && $label)
            <x-input-label for="{{ $name }}" :value="$label" />
        @endif
    @endisset
    
    <div class="mt-1 sm:mt-2">
        {{ $slot }}
    </div>
    
    @error($name)
        <x-input-error :messages="$errors->get($name)" class="mt-2" />
    @enderror
</div>
