# ClinicSay — Contexto del negocio y del producto

## 1. Propósito
ClinicSay es una solución de recordatorios y gestión del ciclo de confirmación de citas para clínicas. Su objetivo es reducir ausencias, mejorar la comunicación paciente-clínica y mantener una trazabilidad confiable de los avisos enviados y las respuestas recibidas.

Esta documentación y la maqueta son una capa de diseño/planificación para la prueba técnica. No representan módulos funcionales implementados ni amplían el contrato API de evaluación.

## 2. Problema
Las clínicas pierden tiempo en confirmaciones manuales, tienen información dispersa de las respuestas, envían avisos en horarios inconvenientes y no siempre pueden distinguir una entrega real de un intento fallido o ambiguo.

## 3. Propuesta de valor
- Recordatorios automáticos y oportunos.
- Confirmación/cancelación por respuesta SI/NO.
- Seguimiento de entregas, reintentos y fallos.
- Configuración por clínica y zona horaria.
- Registro auditable de cambios y eventos.
- Operación segura frente a duplicados, concurrencia y fallos del proveedor.

## 4. Actores
- **Administrador de plataforma:** supervisa la operación global y configura capacidades generales.
- **Administrador de clínica:** gestiona datos y preferencias de su clínica.
- **Recepción / operador:** consulta citas y estados; revisa incidencias y seguimiento.
- **Paciente:** recibe el recordatorio y responde SI/NO.
- **Proveedor de mensajería:** transporta el aviso y entrega eventos/webhooks.
- **Sistema:** scheduler, workers, persistencia, auditoría y reconciliación.

## 5. Alcance de la prueba
La entrega debe cumplir el enunciado y el OpenAPI existentes: clínicas, pacientes, citas, reprogramación/cancelación, recordatorios, ejecución del job, webhook entrante, reloj de pruebas y proveedor simulado. El contrato es el baseline obligatorio. Mejoras internas son permitidas cuando no contradicen el contrato ni alteran los resultados esperados.

## 6. Principios de diseño
1. Contrato-first: OpenAPI y enunciado son fuente de verdad.
2. Tenant isolation: cada clínica solo puede operar sobre sus datos.
3. Idempotencia: reintentos del cliente, scheduler y webhooks no duplican efectos.
4. Consistencia: cambios de cita y recordatorios relacionados se coordinan transaccionalmente.
5. Resiliencia: fallos transitorios, permanentes y ambiguos se modelan explícitamente.
6. Observabilidad: correlación, logs estructurados, métricas y auditoría.
7. Seguridad: validar entradas, proteger proveedor, minimizar PII y ocultar secretos.
8. Mantenibilidad: módulos con responsabilidades claras y contratos internos.
9. Testabilidad: reloj controlado, proveedor simulado, datos deterministas y pruebas reproducibles.
10. Mejora compatible: estados internos adicionales pueden existir sin cambiar enums públicos.

## 7. Reglas de negocio conocidas
- Clínica tiene zona horaria IANA.
- Fechas entrantes deben ser ISO 8601 con zona; respuestas normalizadas en UTC.
- Citas se crean para fechas futuras y paciente perteneciente a la clínica indicada.
- Cita cancelada o iniciada no puede reprogramarse (409).
- Cancelación es idempotente (200 si ya cancelada).
- Recordatorios respetan horario silencioso 21:00–09:00 según zona/regla de la prueba.
- Máximo de tres intentos de envío por recordatorio.
- Consentimiento, teléfono y condiciones de envío determinan si corresponde enviar o descartar.
- Respuestas SI/NO deben correlacionarse con el recordatorio entregado más reciente válido para el teléfono.
- Webhooks repetidos no deben producir efectos repetidos.
- Pasadas del job pueden concurrir; el procesamiento debe reclamar trabajos de forma segura.

## 8. Semántica del proveedor simulado
- 202: aceptación del mensaje por el proveedor.
- 200: mensaje duplicado/idempotente.
- 400: solicitud inválida.
- 422: rechazo definitivo.
- 503: fallo transitorio, elegible para retry según política.
- 504: resultado ambiguo; no asumir que no fue entregado ni reenviar a ciegas. Reconciliar o aplicar una estrategia segura.

## 9. Estados: contrato vs. internos
**Appointment API:** scheduled, confirmed, cancelled (exactamente los estados públicos definidos en OpenAPI).

**Reminder API:** pending, sent, failed, skipped, cancelled (exactamente los estados públicos definidos en OpenAPI).

Internamente, los recordatorios/jobs pueden tener estados operativos más ricos: queued, processing, retry_scheduled, delivery_unknown, reconciliation_pending, exhausted, etc. Estos estados deben mapearse a la representación pública y nunca romper el contrato. Definir tabla de transiciones, guardas y efectos laterales antes de implementar.

## 10. Fuera del alcance inicial
- Integración con proveedores reales.
- Portal de paciente, pagos, facturación o historia clínica.
- Multi-canal (email/SMS/WhatsApp) salvo adaptabilidad del diseño.
- Cambiar o ampliar los endpoints del contrato público sin justificación y autorización.

## 11. Criterios de éxito
- Todas las rutas y reglas exigidas implementadas y probadas.
- Aislamiento entre clínicas.
- Sin doble envío por carreras/reintentos.
- Reintentos limitados y diferenciación de errores.
- Webhooks idempotentes y correlacionados correctamente.
- Horarios calculados con zona horaria y DST.
- Auditoría útil, sin exponer secretos ni datos sensibles innecesarios.
- CI reproducible, despliegue controlado y evidencia de aceptación.


## Decisión vigente de implementación (25/11/2026)
Anthony confirma Laravel-first. La implementación principal se construye en `backends/laravel/` en `main`, patrón FormRequest → Controller → Service → Repository → Model, PostgreSQL, Central/Tenant multitenant y RBAC. Node evaluable queda como Fase 2, tras GO de Laravel. La maqueta no cuenta como backend funcional.
