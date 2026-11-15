<fieldset class="space-y-3 border-t border-white/20 pt-5">
    <legend class="text-lg font-semibold text-white">Actualización pública de seguimiento</legend>
    <p class="text-sm text-white/80">Al registrar el envío o cambiar el estado se añade un movimiento. Usa estos campos para dar más detalles o añadir otro movimiento con el mismo estado. Escribe solo información que el cliente pueda ver.</p>
    <div>
        <x-input-label for="event_description" value="Descripción del movimiento (opcional)" class="text-white/90 mb-2" />
        <input id="event_description" name="event_description" maxlength="500"
            value="{{ old('event_description') }}" class="auth-form-input w-full">
        <x-input-error :messages="$errors->get('event_description')" />
    </div>
    <div>
        <x-input-label for="event_location" value="Ciudad o centro logístico (opcional)" class="text-white/90 mb-2" />
        <input id="event_location" name="event_location" maxlength="120"
            value="{{ old('event_location') }}" class="auth-form-input w-full">
        <x-input-error :messages="$errors->get('event_location')" />
    </div>
</fieldset>
