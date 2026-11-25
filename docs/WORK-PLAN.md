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


## Ejecución Laravel-first (decisión vigente 25/11/2026)

La prioridad explícita del proyecto se actualizó: **Fase 1 Laravel** como backend de referencia completo, luego QA GO, y Node/TypeScript como Fase 2. Laravel debe cumplir patrón FormRequest → Controller → Service → Repository → Model, PostgreSQL, multitenancy Central/Tenant, RBAC y aislamiento. No usar single-app. La implementación evaluable Node del challenge sigue siendo un requisito posterior, no queda sustituida.

### Registro atómico — 25/11/2026 (America/Lima)
| Tarea | Inicio | Fin | Estado | Evidencia |
|---|---|---|---|---|
| T1 Revisar fuentes y baseline remoto | 05:51 | 05:53 | Cerrada | Revisado enunciado/OpenAPI/provider/contexto; main inicial sin backends/laravel |
| T2 Scaffold Laravel 13, configuración base, rutas y DB | 05:53 | — | En curso | commits main abac616, d1044f2 |
| T3 Models/Repositories y validación HTTP | 05:55 | — | En curso | commits 31c7fab, 5e899f5, 6901e99 |
| T4 Casos de uso Clinics/Patients/Appointments | 05:57 | — | En curso, parcial | commit f40de28; crear, obtener, reprogramar y cancelar |
| T5 Reminder scheduler/dispatch y provider adapter | 06:00 | — | Parcial | commit 2ddccb2; faltan pruebas y revisión |
| T6 Webhook inbound SI/NO dedupe | 06:01 | — | Parcial | commit 8d4abc4 |
| T7 Clock test persistente y middleware | 06:02 | — | Parcial | commits a0c5adf, c49d15a |
| T8 Compose aislado, Module Maker multitenant y CI | 06:00 | — | Parcial | commits 4561139, d957848; CI run 45600646927 iniciado |

### Pendiente crítica
- Suite Innodite es privada. La integración GitHub permite inspeccionar su código, pero un Composer runner no tiene garantizado acceso/credenciales; no se incorporó como dependencia aún. Se inspeccionó el composer de Suite y sus scaffolds multitenant. Module Maker v5.2 sí es público y se añadió como Composer dependency VCS.
- Tenancy real y separación Central/Tenant aún no implementadas ni verificadas; contexts.json configura ambos contextos, pero no equivale a aislamiento runtime.
- RBAC granular no implementado todavía.
- Scheduler/claim concurrency, reintentos, DST, respuesta webhook correlación y contrato API no QA.
- No se ejecutó Composer local/remoto manualmente; el workflow CI está en curso.
- CI/tests actuales no son evidencia de QA aprobada hasta concluir y revisar resultados.
