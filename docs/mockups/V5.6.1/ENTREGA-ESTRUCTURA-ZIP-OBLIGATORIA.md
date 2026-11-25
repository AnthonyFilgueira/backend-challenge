# Regla obligatoria: estructura del ZIP y extracción ClinicSay

**Obligatoria para cada ZIP del mockup. No omitir ni cambiar sin confirmación explícita.**

## Estructura requerida
El ZIP debe contener una carpeta raíz interna `clinicsay-v5-rebuild/`. Nunca archivos del proyecto sueltos directamente en la raíz del archivo.

```
ClinicSay_VX.Y.zip
└── clinicsay-v5-rebuild/
    ├── index.html
    ├── web/index.html
    ├── movil/index.html
    ├── ACTIVITY_LOG.md
    └── documentación
```

## Validación antes de entregar
1. Root, web y móvil están sincronizados según el cambio.
2. ZIP se genera con wrapper `clinicsay-v5-rebuild/`.
3. `unzip -l` confirma que cada entry comienza por `clinicsay-v5-rebuild/`.
4. `unzip -t` confirma integridad.
5. Incluir instrucciones de extracción explícitas. No entregar el link antes de las comprobaciones.

## Extracción en Termux
```bash
cd ~/storage/downloads
unzip -o ClinicSay_VX.Y.zip -d ~/storage/downloads
cd ~/storage/downloads/clinicsay-v5-rebuild
pwd
ls -la
ls -la web movil
```

No extraer desde dentro de la carpeta del proyecto ni usar unzip sin destino explícito. Sobrescribe archivos coincidentes, pero no limpia archivos extra.

Ejecutar `vercel deploy` desde `~/storage/downloads/clinicsay-v5-rebuild` únicamente tras confirmar que están los tres HTML.

## Checklist
- [ ] Wrapper raíz interno correcto.
- [ ] No hay archivos fuera del wrapper.
- [ ] unzip -l revisado.
- [ ] unzip -t OK.
- [ ] Destino explícito `-d ~/storage/downloads`.
- [ ] CD posterior a la carpeta del proyecto.
- [ ] Registro de versión/commit/deploy/QA actualizado.
