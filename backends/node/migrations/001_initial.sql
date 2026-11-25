CREATE EXTENSION IF NOT EXISTS pgcrypto;
CREATE TABLE IF NOT EXISTS clinics(id uuid PRIMARY KEY DEFAULT gen_random_uuid(),name varchar(160) NOT NULL,timezone varchar(100) NOT NULL,created_at timestamptz NOT NULL DEFAULT now());
CREATE TABLE IF NOT EXISTS patients(id uuid PRIMARY KEY DEFAULT gen_random_uuid(),clinic_id uuid NOT NULL REFERENCES clinics(id),name varchar(160) NOT NULL,phone varchar(20),accepts_reminders boolean NOT NULL DEFAULT false,created_at timestamptz NOT NULL DEFAULT now());
CREATE TABLE IF NOT EXISTS appointments(id uuid PRIMARY KEY DEFAULT gen_random_uuid(),clinic_id uuid NOT NULL REFERENCES clinics(id),patient_id uuid NOT NULL REFERENCES patients(id),starts_at timestamptz NOT NULL,status varchar(16) NOT NULL CHECK(status IN('scheduled','confirmed','cancelled')),created_at timestamptz NOT NULL DEFAULT now());
CREATE INDEX IF NOT EXISTS idx_appointments_due ON appointments(starts_at,status);
