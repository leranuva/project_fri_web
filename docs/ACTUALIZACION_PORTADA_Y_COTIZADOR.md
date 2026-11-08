# Actualización de portada, cotizador y marca

**Revisión del 8 de noviembre de 2026.** Cambios implementados y verificados en el entorno local.

La revisión cubrió la [portada publicada](https://flatrateimports.com/) y el [cotizador público](https://flatrateimports.com/cotizador) en escritorio y a 390 px de ancho. El recorrido se comprobó hasta el formulario. El rendimiento de carga en producción queda pendiente de medición.

El objetivo es que una persona que llega por primera vez entienda el servicio, encuentre el botón de cotización y pueda completar el formulario sin mensajes contradictorios. Conviene conservar la explicación del proceso en cuatro pasos, el beneficio del casillero gratuito y las unidades visibles en los campos del cotizador.

## Hallazgos y cambios propuestos

| Prioridad | Hallazgo en la web publicada | Cambio propuesto |
| --- | --- | --- |
| 1. Selector de envío | El valor inicial indica «No hay métodos de envío configurados», aunque el desplegable contiene Aéreo, Courier 4x4 y Marítimo. En móvil, el mensaje aparece cortado. | Mostrar «Selecciona un método de envío» cuando haya opciones. Usar mensajes distintos para carga, error y ausencia real de métodos. |
| 2. Primera pantalla | El carrusel abre con «Bienvenido». Su botón principal lleva a preguntas frecuentes en el dominio de la tienda. En el escritorio revisado, «Cotizar ahora» queda parcialmente fuera de la primera pantalla. | Usar un encabezado que explique el servicio, como «Importa tus compras de EE. UU. a Ecuador». Dar prioridad a «Cotizar mi envío» y dejar «Obtener mi casillero gratis» como acción secundaria. |
| 3. Diseño móvil | A 390 px, la portada permite desplazamiento horizontal. El chat flotante invade el borde del botón de cotización y el de un campo del formulario. | Corregir el desbordamiento y ajustar los accesos flotantes para mantener despejados los botones y campos. |
| 4. Enlaces y títulos | Los enlaces de TikTok, Instagram y WhatsApp Business del pie apuntan a `#`. El botón «Obtener tu casillero» de un artículo lleva al mismo artículo. La portada y el cotizador comparten el título de pestaña. | Usar destinos oficiales confirmados, dirigir el CTA de casillero al flujo correspondiente y asignar al cotizador un título propio. |

## Criterios de aceptación

- [x] Con métodos disponibles, el selector muestra la indicación para elegir y permite seleccionar una opción. Con una lista vacía o un error de carga, muestra el mensaje correspondiente.
- [x] En escritorio y a 390 px, la propuesta de valor y el botón principal son visibles en la primera pantalla. El botón lleva al cotizador.
- [x] La portada no se desplaza horizontalmente y los accesos flotantes dejan libres el botón de cotización y los campos del formulario.
- [x] El CTA de casillero lleva al registro y el título de pestaña del cotizador identifica la página.
- [x] En local, el pie de página muestra los iconos de redes pendientes sin enlace y abre WhatsApp con el número configurado. Los enlaces a perfiles configurados se muestran como enlaces.
- [ ] Confirmar las URL oficiales de los perfiles sociales y guardarlas en el panel de administración.
- [x] Una cotización de prueba para un dron de 2 lb y USD 100 mediante Courier 4x4 llega al desglose de resultados en el entorno local.

## Datos de la vista previa local

La portada y el blog usan una muestra del [sitio público](https://flatrateimports.com/) con seis diapositivas, cuatro entradas, sus referencias públicas y el tema verde y rojo. Las entradas locales incluyen resúmenes y enlazan a los originales cuando están disponibles. En la muestra local se pueden usar las páginas generales de las redes para probar la navegación. Para publicar los enlaces de la marca, configura las URL de sus perfiles desde el panel del pie de página.

Las diez fotos de muestra de [Lorem Picsum](https://picsum.photos/) se guardan en `storage/app/public/fri-preview/` con nombres `carousel-1.webp` a `carousel-6.webp` y `blog-1.webp` a `blog-4.webp`. Son archivos locales ignorados por Git. Para recuperarlos en otra copia, usa las URL `https://picsum.photos/seed/fri-preview-{nombre}/1200/650.webp` para el carrusel y `https://picsum.photos/seed/fri-preview-{nombre}/900/600.webp` para el blog, con el nombre sin extensión.

El catálogo incluye los productos visibles del [cotizador público](https://flatrateimports.com/cotizador) y conserva los productos de prueba que ya estaban en local. Para reconstruir la muestra, guarda el objeto `data.products` de `https://flatrateimports.com/api/cotizador/data` como `storage/app/private/fri-preview-products.json`. El seeder agrega los productos que faltan y conserva los valores de arancel de los productos locales existentes.

Con Docker Desktop activo y los archivos de muestra en sus carpetas, puedes volver a cargar los datos en el entorno local. El seeder solo se ejecuta con APP_ENV=local y aplica la paleta de muestra mediante el mismo flujo de publicación del panel. Usa una base de desarrollo, ya que también actualiza secciones, diapositivas y entradas de la muestra.

```bash
(cd ~/.config/project_fri_web && docker compose exec app php artisan db:seed --class=LocalPublicSitePreviewSeeder)
```

## Logos de marca

Abre /admin/logos para subir o reemplazar una imagen de hasta 5 MB. Se aceptan PNG, JPEG, WebP, GIF, BMP, AVIF, ICO, TIFF, HEIC, HEIF y SVG.

En el panel de logos puedes comprobar cómo quedará una imagen en la cabecera de escritorio, la cabecera móvil y el pie antes de guardarla. Las nuevas subidas se convierten a WebP sin pérdida, con un máximo de 512 px por lado. Se conserva la proporción y la transparencia. Los archivos animados y los formatos con varias páginas usan la primera imagen. El procesamiento recorta el borde transparente y la vista previa muestra cuánto espacio ocupa el dibujo en cada contenedor. El favicon y el icono de inicio de iOS comparten el PNG cuadrado de marca. La PWA usa el mismo PNG y su variante SVG.

Al sustituir un logo disponible, el panel conserva la versión anterior y permite reactivarla. Las nuevas subidas guardan el archivo recibido en almacenamiento privado, con descarga desde el panel de administración. Si falta la imagen activa, la web muestra el logo de respaldo y el panel señala el archivo ausente. El logotipo de la cabecera y el pie se muestra en un marco circular blanco con 4 px de margen y conserva la proporción de la imagen.

El servidor necesita ImageMagick con soporte de WebP, HEIF y los formatos admitidos, además de `rsvg-convert` para SVG. En Debian se instalan con los paquetes `imagemagick` y `librsvg2-bin`. PHP debe permitir subidas de 5 MB y un límite de formulario superior. El disco público de Laravel debe estar disponible mediante `php artisan storage:link` o su URL configurada. Comprueba los formatos con `magick identify -list format` o `identify -list format`, según la versión instalada. Antes de desplegar, verifica una subida real en el entorno de destino.

## Temas

El sitio resuelve la paleta activa una vez por petición y ambos layouts usan las mismas variables CSS. Los temas guardados se mantienen. Si falta un tema activo o un color antiguo es inválido, el sitio toma el valor de respaldo correspondiente.

En /admin/themes, crea un borrador o duplica el publicado. El listado, el detalle y los formularios usan las tarjetas translúcidas y los controles del resto del panel. La vista previa de escritorio y móvil muestra ejemplos de navegación, tarjeta y botón. Los avisos de contraste estiman el mínimo sobre muestras del degradado y tienen en cuenta los colores transparentes. Publicar activa el borrador y conserva la versión anterior en el historial, desde donde puede restaurarse. Los temas publicados se editan a partir de una copia.

## Actualizar una instalación existente

1. Aplica las migraciones con `php artisan migrate`. La migración de temas registra la versión activa en el historial.
2. Compila los recursos con `npm ci` y `npm run build`. Si el entorno usa caché de Blade, actualízala después de instalar el código.
3. Comprueba la portada, el cotizador y el acceso a `/admin/logos` y `/admin/themes`. En el panel, prueba una subida de logo y verifica que un borrador de tema se puede previsualizar y guardar.

La base de datos, la configuración del entorno, los originales subidos y las fotos de muestra se gestionan por instalación. Si trasladas el contenido entre entornos, copia tanto el disco público de logos como el almacenamiento privado de originales.

## Verificación local

- La portada y el cotizador cargan correctamente. Las consultas a la tabla de temas por petición bajaron de 40 a 1 en la portada y de 28 a 1 en el cotizador.
- Se probó en MySQL local la creación, edición, publicación y restauración de un tema. La vista previa se comprobó en el navegador.
- Se verificaron la conversión y el recorte de logos, la descarga privada y la recuperación de la versión anterior.
- La suite general de SQLite tiene un fallo preexistente de instalación desde cero. La migración `2025_03_13_000001_add_store_button_fields_to_cotizador_sections_table.php` intenta modificar `cotizador_sections` antes de que se cree. En la ejecución local hubo 9 pruebas aprobadas y 11 fallidas por ese orden de migraciones.
