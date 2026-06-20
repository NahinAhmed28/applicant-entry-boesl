# Applicant Entry BOESL

Applicant Entry BOESL is a Laravel-based application for applicant data entry and management related to BOESL workflows.

## Features

- Applicant entry and record management workflow
- Laravel backend for validation and persistence
- Admin-ready views for reviewing submitted data
- Database-backed applicant records
- Environment-based configuration for deployment

## Modules

- Applicant module: personal information, contact details, and submitted forms
- Entry module: create/edit workflows and validation rules
- Admin module: review, filtering, and status management
- Document module: supporting file upload or certificate handling when enabled
- Reporting module: searchable records, summaries, and exports

## System Architecture

The system follows Laravel MVC architecture. Entry forms collect applicant data and send requests to controllers. Controllers validate submissions and coordinate workflow actions. Models persist applicants, documents, statuses, and audit details. Admin views expose filtering and review workflows. Storage services can manage uploaded files if document handling is enabled.

## Getting Started

```bash
git clone https://github.com/NahinAhmed28/applicant-entry-boesl.git
cd applicant-entry-boesl
composer install
cp .env.example .env
php artisan key:generate
npm install
npm run dev
php artisan serve
```
