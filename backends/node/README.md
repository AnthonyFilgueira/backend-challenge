# ClinicSay Node API

Node.js 22+, TypeScript strict, Fastify and PostgreSQL. Architecture: Route/middleware → schema → Controller → Service → Repository → PostgreSQL.

## Setup
Copy .env.example to .env, configure PostgreSQL, apply migrations in migrations/, then npm install and npm run dev.

## Implemented scaffold
POST clinics, POST patients, POST appointments, GET appointment, cancel appointment; health check. Under /api/v1.

## Incomplete / not submission-ready
Authentication and RBAC, tenant enforcement, rescheduling, reminders/job processing, inbound webhook, provider adapter/idempotency, test clock endpoint, comprehensive integration/acceptance tests and Docker/CI verification remain incomplete. No QA GO claimed.
