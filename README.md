# Flat Rate Imports

> Sistema web completo para la gestión y cotización de importaciones desde Estados Unidos a Ecuador.

[![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?logo=laravel)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?logo=php)](https://php.net)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind-3.1-38B2AC?logo=tailwind-css)](https://tailwindcss.com)
[![Alpine.js](https://img.shields.io/badge/Alpine.js-3.4-8BC0D0?logo=alpine.js)](https://alpinejs.dev)
[![Vite](https://img.shields.io/badge/Vite-7.0-646CFF?logo=vite)](https://vitejs.dev)

---

## Demo en producción

https://flatrateimports.com

---

## Tabla de contenidos

- [Descripción](#descripción)
- [Screenshots](#screenshots)
- [Características principales](#características-principales)
- [Tecnologías](#tecnologías)
- [Requisitos](#requisitos)
- [Instalación](#instalación)
- [Configuración](#configuración)
- [Estructura del proyecto](#estructura-del-proyecto)
- [Funcionalidades](#funcionalidades)
- [SEO y Marketing](#seo-y-marketing)
- [API](#api)
- [Despliegue](#despliegue)
- [Documentación](#documentación)
- [Licencia](#licencia)

---

## Descripción

**Flat Rate Imports** es una aplicación web desarrollada con Laravel que permite a los usuarios cotizar el costo de importar productos desde Estados Unidos a Ecuador. Incluye un cotizador inteligente con cálculos automáticos de impuestos (Ad-Valorem, FODINFA, IVA), múltiples métodos de envío (marítimo, aéreo, aéreo express, Courier 4x4), tracking de paquetes en tiempo real y un panel de administración completo para gestionar todo el contenido del sitio.

El sistema funciona como **motor de generación de leads y tráfico SEO** para el negocio.

---

## Screenshots

### Página principal

![Home](docs/screenshots/home.png)

### Cotizador de importaciones

![Quote](docs/screenshots/quote.png)

### Panel de administración

![Admin](docs/screenshots/admin.png)

---

## Características principales

| Módulo | Descripción |
|--------|-------------|
| **Cotizador** | Cálculo automático de impuestos, tarifas por peso, sugerencias de métodos de envío, exportación a PDF |
| **Tracking** | Seguimiento de paquetes con TrackingMore API (USPS, FedEx, UPS, DHL, Amazon, OnTrac) |
| **Slider principal** | Carrusel con soporte para imágenes, videos directos (MP4) y **YouTube** |
| **Blog** | Artículos con CTA configurable (texto, colores, animación, URL por defecto) |
| **Panel admin** | CRUD completo: usuarios, productos, tarifas, sliders, blog, footer, temas, SEO |
| **Temas dinámicos** | Personalización de colores, gradientes y estilos del sitio |
| **SEO** | Sitemap dinámico, páginas SEO programáticas, meta tags, Open Graph |
| **Leads** | Captura automática al cotizar, scoring, webhooks para n8n/Zapier |
| **PWA** | Cotizador instalable con cache offline |
| **Widget embebible** | Cotizador embebible en iframe para terceros |

---

## Tecnologías

### Backend
- **Laravel 12** — Framework PHP
- **PHP 8.2+** — Lenguaje
- **MySQL 8.0+** / MariaDB — Base de datos

### Frontend
- **Tailwind CSS 3.1** — Estilos utility-first
- **Alpine.js 3.4** — Interactividad ligera
- **Vite 7** — Build tool
- **Blade** — Motor de plantillas

### Dependencias principales
- **Laravel Breeze** — Autenticación
- **Laravel Socialite** — Login con Google
- **jsPDF + html2canvas** — Exportación PDF
- **vite-plugin-pwa** — Soporte PWA

---

## Requisitos

- **PHP** ≥ 8.2 (extensiones: BCMath, Ctype, Fileinfo, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML)
- **Composer** ≥ 2.0
- **Node.js** ≥ 18.x
- **npm** ≥ 9.x
- **MySQL** ≥ 8.0 o MariaDB ≥ 10.3

---

## Instalación

### 1. Clonar el repositorio

```bash
git clone https://github.com/leranuva/project_fri_web.git
cd project_fri_web
```

### 2. Instalar dependencias

```bash
composer install
npm install
```

### 3. Configurar entorno

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configurar base de datos

Edita `.env` con tus credenciales:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=flat_rate_imports
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Ejecutar migraciones y seeders

```bash
php artisan migrate
php artisan db:seed
```

### 6. Crear enlace de storage

```bash
php artisan storage:link
```

### 7. Compilar assets

```bash
npm run build
```

### 8. Iniciar servidor

```bash
php artisan serve
```

Para desarrollo con hot reload:

```bash
composer run dev
```

---

## Configuración

### Variables de entorno principales

| Variable | Descripción |
|----------|-------------|
| `APP_URL` | URL base de la aplicación |
| `ECOMMERCE_STORE_URL` | URL de la tienda para enlaces "Comprar en tienda" |
| `GOOGLE_ANALYTICS_ID` | ID de GA4 para analítica |
| `POSTHOG_KEY` | Clave PostHog (opcional) |
| `TRACKINGMORE_API_KEY` | API key para tracking de paquetes |
| `WEBHOOK_LEADS_URL` | URL para enviar leads a n8n/Zapier |

### Crear usuario administrador

```bash
php artisan tinker
```

```php
\App\Models\User::create([
    'name' => 'Administrador',
    'email' => 'admin@ejemplo.com',
    'password' => bcrypt('password'),
    'role' => 'admin',
    'email_verified_at' => now(),
]);
```

---

## Estructura del proyecto

```
flat_rate_imports/
├── app/
│   ├── Console/Commands/     # Comandos Artisan
│   ├── Helpers/              # CotizadorHelper
│   ├── Http/Controllers/
│   │   ├── Admin/            # 20+ controladores CRUD
│   │   ├── Auth/
│   │   └── Api (Cotizador, Tracking, etc.)
│   ├── Models/               # 24 modelos Eloquent
│   ├── Services/             # TrackingService, Cotizador (calculadoras)
│   └── View/Components/      # Componentes UI
├── config/                   # Configuración (seo, products, etc.)
├── database/
│   ├── migrations/           # 35+ migraciones
│   └── seeders/
├── docs/                     # Documentación detallada
├── resources/
│   ├── css/app.css
│   ├── js/                   # app.js, cotizador-alpine.js
│   └── views/
├── routes/
│   ├── web.php
│   └── auth.php
└── tests/
```

---

## Funcionalidades

### Cotizador
- Selección de productos con códigos arancelarios
- Cálculo de impuestos (Ad-Valorem, FODINFA, IVA)
- Métodos de envío: Marítimo, Aéreo, Aéreo Express, Courier 4x4
- Régimen especial Courier 4x4 (arancel fijo $20)
- Sugerencias inteligentes según peso y valor
- Exportación a PDF
- Historial de cotizaciones (`/mis-cotizaciones`)
- Compartir cotización por enlace (`/quote/{token}`)

### Slider principal
- Imágenes y videos (MP4, WebM, OGG)
- **Videos de YouTube** (URL de youtube.com o youtu.be)
- Configuración de colores, textos y CTA por slide
- Intervalo configurable entre slides (10 segundos)
- Optimizado para móviles

### Blog
- Artículos con imagen destacada, excerpt y contenido
- **CTA configurable** por sección: texto, colores, animación, URL por defecto
- Rutas SEO-friendly: `/blog/{id}-{slug}`

### Panel de administración
- **Usuarios** — CRUD, roles (admin/customer)
- **Productos** — Catálogo con códigos arancelarios
- **Tarifas de envío** — Por método y rango de peso
- **Impuestos** — FODINFA, IVA, seguro CIF
- **Sliders** — Imágenes, videos (incl. YouTube)
- **Proceso, beneficios, alertas** — Contenido del home
- **Tiendas y logos** — Tiendas asociadas
- **Blog** — Artículos y configuración de sección
- **Footer** — Enlaces y configuración
- **Cotizador** — Títulos, colores, botón "Comprar en tienda"
- **Temas** — Personalización visual global
- **Páginas SEO** — Rutas dinámicas tipo `/importar-iphone-desde-amazon-a-ecuador`
- **Leads** — Listado y scoring

### Calculadoras virales
- `/calculadora-aranceles`
- `/calculadora-courier-4x4`
- `/calculadora-amazon-ecuador`

### Widget embebible
- `/embed/cotizador` — Cotizador en iframe para terceros

---

## SEO y Marketing

### Infraestructura SEO (Fase 8)
| Funcionalidad | Descripción |
|---------------|-------------|
| **Google Analytics 4** | Tracking de conversiones y eventos |
| **PostHog** | Analítica alternativa (opcional) |
| **Sitemap dinámico** | `/sitemap.xml` con home, cotizador, blog, páginas SEO y calculadoras |
| **Meta tags** | Título y descripción dinámicos por página |
| **Open Graph** | og:title, og:description, og:image, og:url para redes sociales |
| **Eventos de conversión** | `quote_calculated`, `quote_saved`, `store_redirect` enviados a GA4/PostHog |

### SEO programático (Fase 9)
| Funcionalidad | Descripción |
|---------------|-------------|
| **Páginas SEO dinámicas** | Rutas tipo `/importar-iphone-desde-amazon-a-ecuador` |
| **Tabla seo_pages** | Keyword, slug, título, contenido HTML, meta description, imagen OG |
| **Cotizador pre-seleccionado** | Enlace directo al cotizador con producto ya elegido |
| **Fallback de rutas** | Cualquier URL no definida se resuelve como página SEO |
| **Panel admin** | CRUD completo en `admin/seo-pages` |

### Embudo de leads (Fase 11)
| Funcionalidad | Descripción |
|---------------|-------------|
| **Captura automática** | Al calcular cotización (con email) y al enviar por email |
| **Lead scoring** | Puntuación 0-100 por valor, producto y frecuencia de cotizaciones |
| **Panel de leads** | `admin/leads` con filtros, búsqueda y colores por score |
| **Actualización** | Mismo email cotiza de nuevo → se actualiza lead y se recalcula score |

### Automatización marketing (Fase 12)
| Funcionalidad | Descripción |
|---------------|-------------|
| **Webhook de leads** | Evento `LeadCreated` → POST a `WEBHOOK_LEADS_URL` |
| **Integración n8n/Zapier** | Conectar a CRM, Mailchimp/Brevo, audiencias de ads |
| **Payload JSON** | email, producto, valor, score, quote_count, source, timestamp |

### Growth loops (Fase 13)
| Funcionalidad | Descripción |
|---------------|-------------|
| **Calculadoras virales** | Páginas SEO para keywords de alto tráfico |
| **Compartir cotización** | Botón genera `/quote/{token}` — enlace indexable y compartible |
| **QuoteShare** | Token único, expira en 30 días, contador de visitas |

### Autoridad SEO (Fase 14)
| Funcionalidad | Descripción |
|---------------|-------------|
| **Blog automático** | Comando `php artisan blog:generate --topic=amazon|alibaba|aranceles|courier4x4` |
| **Widget embebible** | `/embed/cotizador` — iframe para embeber en terceros |
| **Comparadores** | Páginas tipo `mejor-courier-ecuador`, `costos-importar-amazon-ecuador` |

### Variables de entorno (SEO/Marketing)

```env
GOOGLE_ANALYTICS_ID=
POSTHOG_KEY=
POSTHOG_HOST=https://us.i.posthog.com
SEO_DEFAULT_TITLE="Flat Rate Imports - Importa desde USA a Ecuador"
SEO_DEFAULT_DESCRIPTION="Cotiza tu envío desde USA a Ecuador..."
ECOMMERCE_STORE_URL=https://flatrateimports.store
WEBHOOK_LEADS_URL=https://tu-n8n.com/webhook/lead
WEBHOOK_QUOTES_URL=
```

---

## API

### Cotizador (público, rate limited)

| Método | Endpoint | Descripción |
|--------|----------|-------------|
| GET | `/api/cotizador/products` | Lista de productos |
| GET | `/api/cotizador/shipping-methods` | Métodos de envío |
| POST | `/api/cotizador/calculate` | Calcular cotización |
| POST | `/api/cotizador/share` | Compartir cotización |

Documentación completa para apps móviles: [`docs/API_MOBILE.md`](docs/API_MOBILE.md)

---

## Despliegue

### Hostinger (Shared / VPS)

1. Compilar assets: `npm run build`
2. Subir archivos (excluir: `node_modules`, `.git`, `.env`)
3. Configurar `.env` en el servidor
4. Ejecutar: `php artisan migrate --force`
5. Optimizar: `php artisan config:cache && php artisan route:cache`

Guía detallada: [`docs/DEPLOYMENT_HOSTINGER.md`](docs/DEPLOYMENT_HOSTINGER.md)

### Comandos post-despliegue

```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

---

## Documentación

| Documento | Descripción |
|-----------|-------------|
| [ANALISIS_PROYECTO.md](docs/ANALISIS_PROYECTO.md) | Análisis técnico del proyecto |
| [BASE_DE_DATOS.md](docs/BASE_DE_DATOS.md) | Esquema, migraciones y sincronización |
| [DEPLOYMENT_HOSTINGER.md](docs/DEPLOYMENT_HOSTINGER.md) | Guía de despliegue en Hostinger |
| [API_MOBILE.md](docs/API_MOBILE.md) | API para apps móviles (React Native/Flutter) |
| [INDICE_IMPLEMENTACIONES.md](docs/INDICE_IMPLEMENTACIONES.md) | Índice de fases implementadas (1-14) |

---

## Comandos útiles

```bash
# Desarrollo
php artisan serve
npm run dev
composer run dev

# Base de datos
php artisan migrate
php artisan migrate:fresh --seed

# Cache
php artisan config:clear
php artisan cache:clear

# Tests
php artisan test

# Comandos personalizados
php artisan cotizador:clear-cache
php artisan cotizador:diagnose
php artisan blog:generate
```

---

## Licencia

Este proyecto es de uso exclusivo para Flat Rate Imports.

---

## Autor

**Ramiro Nunez** — Full-Stack Developer  
GitHub: [github.com/leranuva](https://github.com/leranuva)

---

**Desarrollado con Laravel, Tailwind CSS y Alpine.js**
