# ClinicSay Mockup — relevo V5.6.1
Fecha: 2026-11-25

## Historial breve
- V5.5: vista compacta/mosaico del requerimiento; no coincidía con la solicitud de recorrer una sección por pantalla.
- V5.5.1: corrección CSS fuera de style; HTML servido revisado, sin QA visual integral.
- V5.6: visor secuencial: una sección activa; Anterior/Siguiente; teclado ←/→ y swipe; dos etapas separadas (requerimiento original e interpretación); scroll bloqueado en el visor; variantes root/web/móvil. JS/estructura validados; QA visual pendiente.
- V5.6.1: corrección del empaquetado. ZIP ahora tiene wrapper interno clinicsay-v5-rebuild/ y regla permanente de extracción documentada.

## Regla de ZIP
Seguir ENTREGA-ESTRUCTURA-ZIP-OBLIGATORIA.md. Extract siempre:
```bash
cd ~/storage/downloads
unzip -o ClinicSay_VX.Y.zip -d ~/storage/downloads
cd ~/storage/downloads/clinicsay-v5-rebuild
```
No extraer dentro del proyecto, no omitir -d, no crear ZIP con archivos sueltos en su raíz. Validar unzip -l y unzip -t.

## Estado y continuidad
- ZIP V5.6.1 empaquetado con wrapper y validado: unzip -t OK.
- Root, web, móvil incluidos.
- QA visual del visor en Preview sigue pendiente.
- Usuario debe desplegar Preview desde la carpeta correcta y compartir URL.
- No avanzar a otras pestañas hasta aprobar el visor: revisar viewport desktop y móvil, una sección, sin scroll, navegación, teclado, swipe y separación de etapas.

