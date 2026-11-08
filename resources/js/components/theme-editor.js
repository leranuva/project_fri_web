function parseColor(value, translucent = false) {
    const color = value.trim().toLowerCase();
    if (/^#(?:[0-9a-f]{3}|[0-9a-f]{6})$/.test(color)) {
        const hex = color.length === 4
            ? Array.from(color.slice(1), digit => digit.repeat(2)).join('')
            : color.slice(1);
        return [...hex.match(/../g).map(channel => parseInt(channel, 16)), 1];
    }
    if (!translucent || color.length > 64) return null;

    const rgb = color.match(/^rgb\(\s*(\d{1,3})\s*,\s*(\d{1,3})\s*,\s*(\d{1,3})\s*\)$/);
    const rgba = color.match(/^rgba\(\s*(\d{1,3})\s*,\s*(\d{1,3})\s*,\s*(\d{1,3})\s*,\s*(0(?:\.\d+)?|1(?:\.0+)?|\.\d+)\s*\)$/);
    const match = rgb || rgba;
    if (!match) return null;

    const channels = match.slice(1, 4).map(Number);
    return channels.every(channel => channel <= 255) ? [...channels, Number(match[4] ?? 1)] : null;
}

const cssColor = ([r, g, b, a]) => 'rgba(' + [r, g, b, a].join(', ') + ')';
const hexColor = color => '#' + color.slice(0, 3).map(channel => channel.toString(16).padStart(2, '0')).join('');
const over = (foreground, background) => background.slice(0, 3)
    .map((channel, index) => foreground[index] * foreground[3] + channel * (1 - foreground[3]));

function luminance(color) {
    return color.slice(0, 3).map(channel => {
        const sRGB = channel / 255;
        return sRGB <= 0.04045 ? sRGB / 12.92 : ((sRGB + 0.055) / 1.055) ** 2.4;
    }).reduce((total, channel, index) => total + channel * [0.2126, 0.7152, 0.0722][index], 0);
}

function contrast(first, second) {
    const a = luminance(first);
    const b = luminance(second);
    return (Math.max(a, b) + 0.05) / (Math.min(a, b) + 0.05);
}

function updateContrast(preview, list) {
    const style = getComputedStyle(preview);
    const read = name => parseColor(style.getPropertyValue('--theme-' + name), true);
    const stops = ['start', 'mid', 'end'].map(stop => read('background-gradient-' + stop));
    const backgrounds = stops.slice(0, -1).flatMap((start, index) => (
        Array.from({ length: 11 }, (_, step) => start.map((channel, i) => channel + (stops[index + 1][i] - channel) * step / 10))
    ));
    const secondary = read('secondary-color');
    // La mezcla CSS combina un 10 % de color de marca y un 90 % de blanco al 10 %.
    const surface = [...secondary.slice(0, 3).map(channel => (channel * 0.10 + 255 * 0.09) / 0.19), 0.19];
    const surfaces = backgrounds.map(background => over(surface, background));
    const buttons = backgrounds.map(background => over(read('button-color'), background));
    const text = read('text-color');
    const muted = read('text-secondary-color');
    const accent = read('accent-color');
    const focusShadow = parseColor('#111827');

    const checks = [
        ['Texto principal sobre el fondo', text, backgrounds, 4.5],
        ['Texto secundario sobre el fondo', muted, backgrounds, 4.5],
        ['Texto secundario sobre la tarjeta', muted, surfaces, 4.5],
        ['Etiqueta del botón', text, buttons, 4.5],
        ['Borde de foco frente al fondo', accent, backgrounds, 3],
        ['Borde de foco frente al contorno oscuro', accent, [focusShadow], 3],
    ];

    list.replaceChildren(...checks.map(([label, foreground, samples, target]) => {
        const minimum = Math.min(...samples.map(background => contrast(over(foreground, background), background)));
        const passes = minimum >= target;
        const item = document.createElement('li');
        const ratio = (Math.floor(minimum * 100) / 100).toLocaleString('es', { minimumFractionDigits: 2 });
        item.className = passes ? 'text-emerald-200' : 'text-amber-200';
        item.textContent = label + ' · ' + ratio + ':1 · ' + (passes ? 'Correcto' : 'Revisar (mínimo ' + target.toLocaleString('es') + ':1)');
        return item;
    }));
}

function bindColorField(field, preview, update) {
    const text = field.querySelector('[data-theme-value]');
    const picker = field.querySelector('[data-theme-picker]');
    const opacity = field.querySelector('[data-theme-opacity]');
    const opacityValue = field.querySelector('[data-theme-opacity-value]');
    const translucent = field.dataset.translucent === 'true';
    const token = '--theme-' + field.dataset.themeField.replaceAll('_', '-');
    let lastColor = parseColor(preview.style.getPropertyValue(token), translucent);

    function sync() {
        const color = parseColor(text.value || field.dataset.defaultColor, translucent);
        if (!color) return;

        lastColor = color;
        picker.value = hexColor(color);
        if (opacity) {
            opacity.value = Math.round(color[3] * 100);
            opacityValue.value = opacity.value + '%';
        }
        preview.style.setProperty(token, cssColor(color));
        update();
    }

    picker.addEventListener('input', () => {
        text.value = translucent ? cssColor([...parseColor(picker.value).slice(0, 3), lastColor[3]]) : picker.value;
        sync();
    });
    opacity?.addEventListener('input', () => {
        text.value = cssColor([...lastColor.slice(0, 3), Number(opacity.value) / 100]);
        sync();
    });
    text.addEventListener('input', sync);
    return sync;
}

document.querySelectorAll('[data-theme-editor]').forEach(editor => {
    const preview = editor.querySelector('[data-theme-preview]');
    const list = editor.querySelector('[data-theme-contrast]');
    const sizes = editor.querySelectorAll('[data-preview-size]');
    const update = () => updateContrast(preview, list);

    const fields = editor.querySelectorAll('[data-theme-field]');
    fields.forEach(field => bindColorField(field, preview, update)());
    sizes.forEach(button => button.addEventListener('click', () => {
        preview.dataset.size = button.dataset.previewSize;
        sizes.forEach(size => size.setAttribute('aria-pressed', String(size === button)));
    }));
    update();
});
