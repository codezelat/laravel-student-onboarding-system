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
- Laravel 12
- Laravel Breeze (auth scaffolding)
- PHP 8.2+
- Tailwind CSS + Alpine.js
- Vite
- maatwebsite/excel for exports
- SQLite by default (configurable)

## Key Paths & Routes

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

## Data & Storage

- Degree registration documents are stored in `storage/app/public/degree_documents/{register_id_slug}`.
- Diploma payment slips are stored in `storage/app/public/payment_slips`.
- Exam paper submissions are stored in `storage/app/exam_papers` on the local (non-public) disk.
- Ensure `php artisan storage:link` is run so public document URLs are accessible for admin views and exports.

## Requirements

- PHP 8.2+
- Composer
- Node.js + npm
- A database (SQLite is default, but MySQL/PostgreSQL can be used)

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
   Update `.env` as needed (e.g., `APP_URL`, database settings).

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

7. Build assets:
   ```bash
   npm run dev
   ```

8. Start the server:
   ```bash
   php artisan serve
   ```

## Admin Access

Admin access is restricted by the `is_admin` middleware to a single email address:

- `sitclk.it@gmail.com`

Create a user with that email in the database before logging in. Registration routes are disabled; use a database seed, tinker, or direct DB insert to create the admin account.

## Exports

- Degree registrations export includes document URLs and a ZIP download link for all documents.
- Diploma registrations export includes key fields and submission timestamps.

## Testing

```bash
composer test
```

## Contact

For support, contact info@sitc.lk or visit https://www.sitc.lk.

## License

This project is licensed under the MIT License. See the LICENSE file for details.
