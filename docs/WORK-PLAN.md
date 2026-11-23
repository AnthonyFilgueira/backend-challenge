# ClinicSay — Plan de trabajo

> Documento vivo. La fase actual es diseño, documentación y maqueta visual; no se considera implementado ningún módulo funcional por la maqueta.

## Fase 0 — Baseline y gobierno
- [x] Identificar fork y rama principal.
- [x] Confirmar contrato OpenAPI, README y compose base.
- [x] Preservar enunciado, contrato y proveedor entregados.
- [ ] Inventariar archivos, dependencias y scripts del repositorio.
- [ ] Crear matriz requisito → diseño → implementación → prueba → evidencia.
- [ ] Registrar decisiones arquitectónicas (ADR) y riesgos.

## Fase 1 — Contexto, UX y documentación (ACTUAL)
- [x] Contexto de negocio, actores, propuesta de valor y alcance.
- [x] Principios, reglas de negocio y semántica del provider.
- [x] Definir separación de estados públicos e internos.
- [x] Maqueta navegable del portal de operación.
- [ ] Revisar mockup y cerrar estructura visual.
- [ ] Documentar flujos principales y excepciones.
- [ ] Documentar modelos de datos y relaciones.
- [ ] Matriz de aceptación completa desde enunciado.

## Fase 2 — Arquitectura y contratos internos
- [ ] Node.js 22+, TypeScript, framework/HTTP layer (decisión documentada).
- [ ] Modular monolith: Clinic, Patient, Appointment, Reminder, Messaging, Webhook, Audit.
- [ ] PostgreSQL: esquema, constraints, índices, migrations.
- [ ] Outbox/queue y mecanismo de claim/lease para jobs.
- [ ] Scheduler de pasada; worker batch acotado y seguro.
- [ ] Adapter del provider con idempotency key y clasificación de respuesta.
- [ ] Reloj de dominio/test y manejo robusto de timezone/DST.
- [ ] Modelo de audit event y correlation IDs.
- [ ] ADR de arquitectura, estrategia de retries, concurrency y ambiguity.

## Fase 3 — Base técnica
- [ ] Estructura del proyecto, configuración, env validation.
- [ ] Compose con API, PostgreSQL y provider original sin modificar.
- [ ] Health/readiness verificando conexión y migrations.
- [ ] Logging estructurado y errores homogéneos.
- [ ] CI: install, lint, typecheck, tests, build.
- [ ] Seguridad base, secrets y validación.

## Fase 4 — Implementación de dominio y API
- [ ] Clinics y timezone validation.
- [ ] Patients, phone E.164, consent.
- [ ] Appointments, create/get/reschedule/cancel y reglas.
- [ ] Reminders: scheduling, quiet hours, opt-out/no-phone, max attempts.
- [ ] Jobs: atomic claim, leases, overlap safety, bounded execution.
- [ ] Provider adapter: idempotency, transient/permanent/ambiguous responses.
- [ ] Webhooks: schema validation, dedupe, matching and SI/NO transitions.
- [ ] Serialización estricta al OpenAPI público.
- [ ] Auditoría y métricas.

## Fase 5 — QA y pruebas
- [ ] Unit tests por reglas de dominio y transición.
- [ ] Integration tests DB, migrations, locks, queue, provider.
- [ ] Contract tests OpenAPI.
- [ ] Concurrency tests: varias pasadas simultáneas, no duplicar.
- [ ] Retry matrix (202, duplicate 200, 400, 422, 503, 504).
- [ ] Quiet-hours, timezone/DST, consent, phone.
- [ ] SI/NO, webhook duplicate, phone mismatch, old/invalid response.
- [ ] Acceptance tests de flujo end-to-end.
- [ ] Evidencia por prueba; resultados fallidos visibles y corregidos.

## Fase 6 — CI, revisión y entrega
- [ ] PR descriptivo con alcance, arquitectura, riesgos y pruebas.
- [ ] CI verde en commit exacto.
- [ ] Revisión manual del owner; no auto-merge.
- [ ] Verificación de gate de despliegue y evidencia.
- [ ] Deploy solo con autorización explícita.
- [ ] Smoke checks, health, versión/commit y rollback documentado.
- [ ] Entrega con instrucciones reproducibles y resumen de decisiones.

## Orden de implementación propuesto
1. Contratos + esquema DB + migrations.
2. Clinic / Patient.
3. Appointment y cancel/reschedule invariants.
4. Reminder planner + quiet-hours.
5. Queue/claim/worker + adapter.
6. Webhook handling.
7. Auditoría/observabilidad.
8. API wiring y contract tests.
9. Integración Compose y CI.
10. QA de aceptación y hardening.

## Riesgos prioritarios
| Riesgo | Mitigación |
|---|---|
| Reenvío duplicado tras timeout ambiguo | Idempotency key, persistencia del intento y reconciliación |
| Jobs concurrentes | Claim atómico, lease, constraints y lock; pruebas de carrera |
| DST / timezone | IANA zone, librería correcta, tests de cambios horario |
| Respuesta webhook incorrectamente correlacionada | Teléfono normalizado, último reminder entregado válido y dedupe messageId |
| Contrato público alterado | Contract tests y serializer explícito |
| Proceso worker no persistente en hosting | Batch acotado y cron compatible, sujeto a límites del hosting |
| Scope creep | Priorizar requirements de prueba; mejoras internas justificadas y documentadas |

## Estado
La fase activa es **Fase 1: documentación, flujos, arquitectura conceptual y maqueta UX**. La maqueta contiene datos ficticios y navegación de presentación; no conecta con API ni base de datos.
