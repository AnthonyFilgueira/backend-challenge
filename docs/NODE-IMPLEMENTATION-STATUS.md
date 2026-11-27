# ClinicSay — estado real de implementación

**Corte documental:** 26 de noviembre de 2026 (America/Lima).  
**Estado:** NO-GO / entrega parcial; QA no verificado.  
**Repositorio:** https://github.com/AnthonyFilgueira/backend-challenge  
**Portal actualizado:** https://clinicsay-operations-mockup-kskafxu7u-innodite.vercel.app

## Qué quedó registrado en `main`
- Backend inicial Node 22 + TypeScript strict, Fastify, Zod, configuración/env, pool PostgreSQL, request ID y errores centralizados.
- Rutas iniciales de clínicas, pacientes y citas; crear/consultar/cancelar y reprogramación inicial.
- Migraciones base y esquema de recordatorios.
- Planner inicial de recordatorios con lógica de zona horaria y política de quiet hours.
- Dockerfile, compose y workflow CI skeleton.
- Documentación del estándar técnico y progreso.

## Verificación real
- Runtime Node `v22.16.0`: confirmado.
- `npm install`: intentado, terminó por timeout.
- Build, typecheck, suite de tests, DB/Compose, endpoints integrados y CI: **no ejecutados / sin evidencia**.
- No se declara aprobación QA ni backend terminado.

## Pendiente crítico
1. Completar contrato, reglas y persistencia de citas.
2. Test clock y manejo temporal inyectable.
3. Provider adapter, idempotency key estable y tratamiento 202/200, 422, 503 y timeout ambiguo 504.
4. Job de dispatch con claims seguros, retries acotados, máximo de intentos, consentimiento, teléfono y quiet hours.
5. Webhook entrante deduplicado, correlación y respuesta SI/NO.
6. Seguridad, auth, autorización y aislamiento de tenant según alcance.
7. Tests unitarios, integración, contrato, concurrencia y aceptación.
8. Verificar instalación, build, Docker Compose, CI, OpenAPI y README de entrega.

## Plan de cierre
- **P1:** asegurar instalación reproducible y build.
- **P2:** cerrar endpoints y test clock.
- **P3:** provider + idempotencia + dispatch + retries.
- **P4:** webhook y SI/NO.
- **P5:** cobertura de tests y QA.
- **P6:** revisión de contrato, Docker/CI y evidencia final.

## Registro temporal
Los commits disponibles registran hora de commit, no inicio ni cierre real de cada tarea. Algunas marcas en la bitácora histórica son estimaciones y no deben tratarse como evidencia temporal exacta.

## Enlaces
- Repositorio: https://github.com/AnthonyFilgueira/backend-challenge
- Portal de estado: https://clinicsay-operations-mockup-kskafxu7u-innodite.vercel.app
- OpenAPI: https://github.com/AnthonyFilgueira/backend-challenge/blob/main/openapi.yaml
- Provider simulado: https://github.com/AnthonyFilgueira/backend-challenge/tree/main/provider

Los datos y comunicaciones son sintéticos. No se enviaron comunicaciones reales. El portal es documentación/maqueta, no un backend desplegado.
