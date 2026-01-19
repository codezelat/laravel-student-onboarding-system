# SITC Student Onboarding System

A Laravel-based student onboarding platform for SITC Campus, covering degree and diploma registrations, secure exam paper submissions, and admin-only management tools for reviewing, exporting, and downloading submission documents.

## Features

### Public-facing

- Degree registration form with full personal, contact, academic details, and required document uploads.
- Diploma registration form with payment slip upload and program resolution from the register ID.
- Registration verification pages for both degree and diploma applicants.
- Secure exam paper submission form for lecturers (degree or diploma submission types).

### Admin

- Protected admin dashboard.
- Degree registrations list with search, filter, Excel export, and bulk document ZIP download.
- Diploma registrations list with search, filter, and Excel export.
- Exam paper submissions list with search, filtering by type, file download, and deletion.

## Tech Stack
# SITC Student Onboarding System

A Laravel-based onboarding platform for SITC Campus that handles degree and diploma registrations, applicant verification, secure exam paper submission, and admin-only review/export workflows.

## Table of Contents

- [Overview](#overview)
- [Features](#features)
- [Tech Stack](#tech-stack)
- [Architecture Overview](#architecture-overview)
- [Routes](#routes)
- [Data Model](#data-model)
- [File Storage](#file-storage)
- [Validation Rules](#validation-rules)
- [Admin Access](#admin-access)
- [Setup](#setup)
- [Build & Run](#build--run)
- [Exports](#exports)
- [Security Notes](#security-notes)
- [Troubleshooting](#troubleshooting)
- [Contact](#contact)
- [License](#license)

## Overview

This application provides:

- Degree and diploma student registration forms with required document uploads.
- Register ID verification pages for applicants.
- A secure lecturer exam paper submission form.
- Admin-only dashboards for viewing, filtering, exporting, and downloading submissions.

## Features

### Public-facing
- Degree registration with comprehensive personal, contact, academic details, and required documents.
- Diploma registration with payment slip upload and program resolution from register ID.
- Registration verification for both degree and diploma applicants.
- Secure exam paper submission (degree/diploma types).

### Admin
- Protected dashboard.
- Degree registrations list with search, filter, Excel export, and bulk document ZIP download.
- Diploma registrations list with search, filter, and Excel export.
- Exam paper submissions list with search, filtering by type, file download, and deletion.

## Tech Stack

- Laravel 12
- Laravel Breeze (authentication scaffolding)
- PHP 8.2+
- Tailwind CSS + Alpine.js
- Vite
- maatwebsite/excel (exports)
- SQLite by default (configurable)

## Architecture Overview

### Core controllers
- `DegreeRegistrationController` — degree registration, validation, document storage, verification.
- `DiplomaRegistrationController` — diploma registration, payment slip storage, verification.
- `ExamPaperSubmissionController` — lecturer paper submission, admin listing, download.
- `AdminDegreeController` — degree admin list, export, ZIP download of documents.
- `AdminDiplomaController` — diploma admin list and export.

### Middleware
- `IsAdmin` — restricts admin access by email address.

### Views
- `resources/views/degree_registrations` — degree registration form.
- `resources/views/diploma_registrations` — diploma registration form.
- `resources/views/view_degree_registrations` — degree verification and details.
- `resources/views/view_diploma_registrations` — diploma verification and details.
- `resources/views/exam_paper_submissions` — lecturer paper submission.
- `resources/views/admin` — admin lists and actions.

## Routes

### Public routes
- `/` — Landing page.
- `/degree-register` — Degree registration form.
- `/diploma-register` — Diploma registration form.
- `/degree-register-check` — Verify degree registration.
- `/diploma-register-check` — Verify diploma registration.
- `/submit-exam-paper` — Exam paper submission form.
- `/login` — Admin login.

### Admin routes (protected by `auth` and `is_admin`)
- `/admin/dashboard` — Admin dashboard.
- `/admin/degree-registrations` — Degree registrations list.
- `/admin/export-degree-registrations` — Degree export (Excel).
- `/admin/degree-registrations/{id}/download-all` — Download all degree documents (ZIP).
- `/admin/diploma-registrations` — Diploma registrations list.
- `/admin/export-diploma-registrations` — Diploma export (Excel).
- `/admin/exam-paper-submissions` — Exam paper submissions list.
- `/admin/exam-paper-submissions/{id}/download` — Download paper file.

## Data Model

### Degree registrations
Stored in `degree_registrations`:
- Identity and contact details.
- Academic and guardian details.
- Program selection and derived program name from register ID.
- File paths for required documents.

### Diploma registrations
Stored in `diploma_registrations`:
- Identity and contact details.
- Derived diploma name from register ID.
- Payment slip file path.

### Exam paper submissions
Stored in `exam_paper_submissions`:
- Lecturer details, submission type (degree/diploma), subject information.
- Exam date and file metadata.

### Auth users
Stored in `users` (Laravel Breeze).

## File Storage

- Degree documents: `storage/app/public/degree_documents/{register_id_slug}`
- Diploma payment slips: `storage/app/public/payment_slips`
- Exam papers: `storage/app/exam_papers` (local/private disk)

Ensure the public storage symlink exists so admin views and exports can resolve file URLs:

- `public/storage` → `storage/app/public`

## Validation Rules

### Degree registration
- Required fields: register ID, personal info, contact info, academic info.
- Program selection is validated and also derived from register ID.
- Documents: PDF/JPG/PNG with a max size of 5MB each.

### Diploma registration
- Required fields: register ID, personal info, contact info.
- Payment slip: PDF/JPG/PNG with a max size of 5MB.
- Diploma name is derived from register ID.

### Exam paper submission
- Required fields: lecturer name, exam date, submission type.
- Degree fields for degree submissions; diploma fields for diploma submissions.
- File types: PDF/DOC/DOCX, max 10MB.

## Admin Access

Admin access is restricted by `is_admin` middleware. The allowed email address is defined in:

- `app/Http/Middleware/IsAdmin.php`

Currently allowed admin email:

- `sitclk.it@gmail.com`

Create a user with that email in the database before logging in. Public registration routes are disabled.

## Setup

1. Install PHP dependencies:
    ```bash
    composer install
    ```

2. Install frontend dependencies:
    ```bash
    npm install
    ```

3. Configure environment:
    ```bash
    cp .env.example .env
    ```
    Update `.env` for `APP_URL`, database, mail, and storage settings as needed.

4. Generate application key:
    ```bash
    php artisan key:generate
    ```

5. Run migrations:
    ```bash
    php artisan migrate
    ```

6. Create the storage symlink:
    ```bash
    php artisan storage:link
    ```

## Build & Run

Run the development servers:

```bash
npm run dev
```

```bash
php artisan serve
```

## Exports

- Degree export includes all key fields, document URLs, and a ZIP download link for all documents.
- Diploma export includes key fields and submission timestamps.

## Security Notes

- Exam paper files are stored on the private local disk and are only downloadable through admin endpoints.
- Public document links require the storage symlink and are intended for admin review.
- Change the allowed admin email in `IsAdmin` before deployment if required.

## Troubleshooting

- If documents are missing in admin exports, ensure the storage symlink exists and the files are present in `storage/app/public`.
- If admin access fails, verify the authenticated user email matches the configured admin email.
- If file upload fails, check PHP upload limits and allowed MIME types.

## Contact

For support, contact info@sitc.lk or visit https://www.sitc.lk.

## License

This project is licensed under the MIT License. See the LICENSE file for details.
