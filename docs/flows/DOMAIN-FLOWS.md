# ClinicSay — Flujos de negocio y estados

## 1. Alta de clínica
Cliente → API: nombre + timezone IANA → validar → persistir → responder 201 con Clinic.
Errores: campos inválidos/timezone desconocida → 400.

## 2. Alta de paciente
Cliente → validar clínica → validar name/phone E.164/acceptsReminders → persistir → 201.
Clínica inexistente → 404; datos inválidos → 400.

## 3. Crear cita y recordatorio
1. Validar clínica/paciente y pertenencia tenant.
2. Validar startsAt ISO8601 con offset y futuro.
3. Crear appointment scheduled.
4. Calcular schedule de reminder con timezone local, quiet hours y policy.
5. Crear reminder o registrar skip reason cuando las reglas indiquen no enviar.
6. Guardar transaccionalmente; responder 201 Appointment con reminders.

## 4. Confirmación SI
Webhook validado/deduplicado → normalizar remitente y texto → localizar reminder delivered/sent más reciente válido asociado al teléfono → confirmar cita si aún procede → registrar evento/audit. Respuesta desconocida o sin match se acepta y se ignora según contrato.

## 5. Cancelación NO
Webhook validado/deduplicado → identificar reminder relacionado → cancelar cita cuando corresponda → cancelar futuros reminders pendientes → auditar. Repetición de webhook no repite efectos.

## 6. Reprogramación
PATCH startsAt → validar fecha futura → lock/transaction → si cancelled o started, 409 → actualizar fecha → invalidar/cancelar reminder anterior pendiente y crear/recalcular reminder apropiado → retornar Appointment.

## 7. Cancelación manual
POST cancel → transaction → si ya cancelada, retornar estado sin side effects adicionales → cambiar estado → cancelar reminders pendientes → auditar → 200.

## 8. Job de reminders
Pasada concurrente:
- Buscar due reminders y elegibles.
- Claim atómico y lease con expiración.
- Revalidar appointment, consentimiento, teléfono y schedule.
- Evitar quiet hours; posponer dentro de la política.
- Construir mensaje exacto en timezone de la clínica.
- Enviar al provider con idempotency key estable.
- Registrar respuesta/attempt.
- 202 accepted → reminder público sent, sentAt.
- 200 duplicate → idempotent outcome, verificar/recuperar estado previo.
- 400 → error de payload/config; no retry automático.
- 422 → fallo definitivo.
- 503 → retry limitado; máximo 3 intentos total.
- 504 → estado interno ambiguo; reconciliar antes de reenvío ciego.
- Liberar/terminar lease y registrar auditoría.
- processed refleja trabajos tratados en esa pasada.

## 9. Flujos internos de reminder
Public statuses (contract): pending | sent | failed | skipped | cancelled.

Proposed internal lifecycle (refinar antes de implementar):
pending → queued → processing → sent
processing → retry_scheduled → processing → sent
processing → failed_permanently (public failed)
processing → delivery_unknown → reconciliation_pending → sent / retry_scheduled / failed
pending → skipped (too_late / no_phone / opted_out)
pending → cancelled
retry_scheduled → cancelled (appointment cancellation/reschedule)
retry_scheduled → exhausted (public failed)

Guardrails: transitions validated by domain service; attempt counter only increases when an actual provider call occurs; max attempts = 3; duplicate provider responses never create duplicate reminder records.

## 10. Appointment public state
scheduled → confirmed (SI)
scheduled → cancelled (NO or manual cancel)
confirmed → cancelled (NO/manual cancel, if business rule permits)
cancelled is terminal for rescheduling (409). Public enums remain exactly OpenAPI. No extra public appointment statuses unless contract revision explicitly approved.

## 11. Quiet hours
Reminder time is calculated using clinic timezone. Quiet hours 21:00–09:00. If due inside quiet hours, defer to allowed boundary (typically 09:00 local) while accounting for date/DST; verify exact enunciado rule before coding.

## 12. Webhook safeguards
- Validate required messageId/from/text/receivedAt.
- Unique provider message ID for dedupe.
- Normalize phone consistently.
- Match only relevant reminder delivery and phone captured at sending.
- Reject/ignore stale or uncorrelated responses safely.
- Handle SI/NO, case/accents/whitespace according to normalized policy.
- Unknown text returns 200 and does not mutate business state.
- Store minimal event evidence and audit without unnecessary PII.

## 13. Cross-cutting
- Correlation ID from request through job/provider/webhook.
- UTC persistence; timezone display from clinic.
- Tenant scoping at repository/service boundaries.
- Transactions for appointment/reminder mutations.
- Concurrency: DB atomic claim/lock; no relying on in-process mutex alone.
- Outbox if needed to ensure durable enqueue after transaction.
