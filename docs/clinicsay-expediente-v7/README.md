# ClinicSay — Expediente interactivo V7

Portal estático de presentación por etapas. Incluye visión, alcance, reglas del proyecto, citas y recordatorios, provider/retries/idempotencia, arquitectura, Central SaaS vs Tenant, simulación, QA y estado transparente.

## Despliegue

- Publicar `index.html` en hosting estático (Vercel, Netlify o similar).
- No requiere build, dependencias ni variables de entorno.
- La entrada del sitio debe ser `index.html`.
- ZIP portable disponible en el paquete compartido por el autor.

## Controles

- Botones de anterior/siguiente y puntos de navegación.
- Teclas de flechas, PageUp/PageDown, Home/End y espacio.
- Deslizamiento horizontal (swipe) en móvil.
- Sin scroll de página; una etapa visible a la vez.

## Prototipo

La simulación Central/Tenant utiliza datos sintéticos, no persiste datos ni envía comunicaciones. El portal distingue claramente lo documentado/demostrado de la implementación backend y QA pendientes.