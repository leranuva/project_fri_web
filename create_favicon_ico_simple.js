/**
 * Script simple para crear favicon.ico usando to-ico
 * 
 * Instalación:
 *   npm install to-ico sharp --save-dev
 * 
 * Uso: node create_favicon_ico_simple.js
 */

import fs from 'fs';
import path from 'path';
import { fileURLToPath } from 'url';

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

let toIco, sharp;
try {
    toIco = (await import('to-ico')).default;
    sharp = (await import('sharp')).default;
} catch (e) {
    console.log('❌ Error: Faltan dependencias.\n');
    console.log('💡 Instala las dependencias:\n');
    console.log('   npm install to-ico sharp --save-dev\n');
    process.exit(1);
}

const svgPath = path.join(__dirname, 'public', 'favicon.svg');
const icoPath = path.join(__dirname, 'public', 'favicon.ico');

if (!fs.existsSync(svgPath)) {
    console.log('❌ Error: No se encontró favicon.svg\n');
    process.exit(1);
}

console.log('📦 Creando favicon.ico desde favicon.svg...\n');

async function createIco() {
    try {
        const svgBuffer = fs.readFileSync(svgPath);
        
        // Tamaños para ICO
        const sizes = [16, 32, 48, 64];
        
        // Convertir SVG a PNG para cada tamaño
        const pngBuffers = await Promise.all(
            sizes.map(size => 
                sharp(svgBuffer)
                    .resize(size, size, {
                        fit: 'contain',
                        background: { r: 0, g: 0, b: 0, alpha: 0 }
                    })
                    .png()
                    .toBuffer()
            )
        );
        
        // Crear ICO desde los PNGs
        const icoBuffer = await toIco(pngBuffers);
        
        // Guardar ICO
        fs.writeFileSync(icoPath, icoBuffer);
        
        console.log('✅ favicon.ico creado exitosamente!\n');
        console.log(`📊 Ubicación: ${icoPath}\n`);
        console.log(`📊 Tamaño: ${fs.statSync(icoPath).size} bytes\n`);
        
    } catch (error) {
        console.error('❌ Error:', error.message);
        process.exit(1);
    }
}

createIco();

