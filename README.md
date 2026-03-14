# Flat Rate Imports

Plataforma web completa para **cotizar, gestionar y optimizar importaciones desde Estados Unidos a Ecuador**.

El sistema incluye un **cotizador inteligente de impuestos**, tracking de paquetes en tiempo real, panel de administración completo, SEO programático para captación de tráfico orgánico y automatización de leads.

---

## 🌐 Demo en producción

https://flatrateimports.com

---

## 🚀 Características principales

* 📦 **Cotizador inteligente** con cálculo automático de impuestos ecuatorianos
* 🚚 **Tracking de paquetes en tiempo real** (USPS, FedEx, UPS, DHL, Amazon)
* 🧾 **Exportación de cotizaciones en PDF**
* 📊 **Panel de administración completo** con CRUD de productos, tarifas, contenido y SEO
* 📈 **Captura automática de leads** desde el cotizador
* 🔗 **Automatización con webhooks** para n8n, Zapier o CRM
* 🔍 **SEO programático** con generación automática de páginas optimizadas
* 📱 **PWA instalable** con soporte offline
* 🧩 **Widget embebible** para integrar el cotizador en sitios externos

---

## 🧠 Objetivo del proyecto

El objetivo del sistema es **automatizar completamente el proceso de cotización de importaciones**, permitiendo a los usuarios conocer el costo real de importar productos desde Estados Unidos a Ecuador considerando:

* impuestos aduaneros
* tarifas de envío
* seguros
* régimen courier 4x4

Al mismo tiempo el sistema funciona como **motor de generación de leads y tráfico SEO** para el negocio.

---

## 🖼️ Screenshots

### Página principal

![Home](docs/screenshots/home.png)

### Cotizador de importaciones

![Quote](docs/screenshots/quote.png)

### Panel de administración

![Admin](docs/screenshots/admin.png)

---

## 🏗️ Arquitectura del sistema

Frontend

* Blade (Laravel)
* Tailwind CSS
* Alpine.js

Backend

* Laravel 12
* PHP 8.2

Database

* MySQL / MariaDB

Build tools

* Vite

Integraciones externas

* TrackingMore API (tracking de paquetes)
* Google Analytics 4
* PostHog
* Webhooks para automatización (n8n / Zapier)

---

## 🧰 Tecnologías

### Backend

* Laravel 12
* PHP 8.2+
* MySQL / MariaDB

### Frontend

* Tailwind CSS
* Alpine.js
* Blade Templates
* Vite

### Librerías principales

* Laravel Breeze — Autenticación
* Laravel Socialite — Login con Google
* jsPDF + html2canvas — Exportación de cotizaciones
* vite-plugin-pwa — Soporte PWA

---

## ⚙️ Instalación

### 1. Clonar repositorio

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

Editar `.env`

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=flat_rate_imports
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Ejecutar migraciones

```bash
php artisan migrate
php artisan db:seed
```

### 6. Compilar assets

```bash
npm run build
```

### 7. Ejecutar servidor

```bash
php artisan serve
```

---

## 📂 Estructura del proyecto

```
app/
 ├── Console/Commands
 ├── Helpers
 ├── Http/Controllers
 │   ├── Admin
 │   ├── Auth
 │   └── Api
 ├── Models
 ├── Services
 └── View/Components

config/
database/
resources/
routes/
tests/
```

---

## 📊 Funcionalidades principales

### Cotizador inteligente

* cálculo automático de impuestos (Ad-Valorem, FODINFA, IVA)
* múltiples métodos de envío
* sugerencias inteligentes según peso y valor
* exportación de cotizaciones
* historial de cotizaciones
* enlaces compartibles

---

### Tracking de paquetes

Seguimiento de envíos desde múltiples carriers:

* USPS
* FedEx
* UPS
* DHL
* Amazon Logistics
* OnTrac

---

### Panel de administración

Gestión completa de:

* usuarios
* productos
* tarifas
* sliders
* blog
* SEO
* temas del sitio
* leads capturados

---

## 📈 Infraestructura SEO

El sistema incluye un módulo completo de **SEO programático**:

* sitemap dinámico
* páginas SEO generadas automáticamente
* meta tags dinámicos
* Open Graph
* calculadoras virales
* páginas optimizadas para keywords

Ejemplo de rutas generadas:

```
/importar-iphone-desde-amazon-a-ecuador
/calculadora-aranceles
/calculadora-courier-4x4
```

---

## 🔗 API

### Endpoints principales

| Método | Endpoint                          | Descripción          |
| ------ | --------------------------------- | -------------------- |
| GET    | `/api/cotizador/products`         | Lista productos      |
| GET    | `/api/cotizador/shipping-methods` | Métodos de envío     |
| POST   | `/api/cotizador/calculate`        | Calcular cotización  |
| POST   | `/api/cotizador/share`            | Compartir cotización |

---

## 🚀 Despliegue

Para despliegue en producción:

```bash
npm run build
php artisan migrate --force
php artisan config:cache
php artisan route:cache
```

Documentación completa en:

```
docs/DEPLOYMENT_HOSTINGER.md
```

---

## 👨‍💻 Autor

Ramiro Nuva
Full-Stack Developer

Especializado en:

* Web Applications
* AI Automation
* Backend Systems
* Growth Engineering

GitHub: https://github.com/leranuva

---

## 📄 Licencia

Este proyecto es de uso exclusivo para Flat Rate Imports.
