# Laravel Task Importer

A Laravel 12 application that demonstrates a full data‐import workflow with:

- **Authentication & scaffolding** via Laravel Breeze  
- **Authorization** via Spatie Roles & Permissions  
- **AdminLTE**–based admin UI  
- **CSV/XLSX import** of Orders, Customers, Invoices  
- **Import error logging** and **audit trail**  
- **Import history** and **view imported data** pages  

---

## 🚀 Features

1. **User management**  
   - CRUD for users & permissions  
   - Secured by `user-management` permission  

2. **Authentication**  
   - Registration, login, password reset, email verification with Breeze  

3. **Role & permission system**  
   - Roles: `admin`, `importer`, ...  
   - Permissions: `import-orders`, `import-customers`, `import-invoices`, `user-management`, etc.  

4. **AdminLTE UI**  
   - Sidebar, top nav, responsive layout  
   - Blade templates under `resources/views/layouts`  

5. **Data import**  
   - Upload CSV or XLSX files  
   - Config‐driven mapping & validation (`config/imports.php`)  
   - Queued `ProcessImport` job (with `GenericImport` importer or Utilizing Excel library)  
   - Full‐collection processing(chunking is possible)  

6. **Error logging & auditing**  
   - Validation failures stored in `import_errors`  
   - Any changes over existing records logged in `audits`  
   - All tied to an `imports` batch record  

7. **Import history & listing**  
   - “Imports” log page with batch status & error count  
   - “Imported Data” pages showing paginated tables of Orders, Customers, Invoices  

To add: **Automated tests**  
   - Feature tests faking the queue  
   - Ensures header validation and job dispatch  

---

## ⚙️ Requirements

- PHP >= 8.2 with **zip** extension enabled  
- MySQL (or MariaDB)  
- Composer  
- Node.js & npm  
- XAMPP or equivalent local server (Apache + PHP)  
- `QUEUE_CONNECTION=database` (for queued imports) or `sync` for inline processing  

---

## 📦 Installation

1. **Clone** the repo  
   ```bash
   git clone <your-repo-url> laravel-task
   cd laravel-task

2. Environment
    cp .env.example .env
    php artisan key:generate
    # Update DB_* and QUEUE_CONNECTION in your .env

3. Dependencies
composer install
npm install
npm run dev   # or npm run build

4. DB & Migrations
php artisan migrate
php artisan queue:table && php artisan migrate

5. php artisan db:seed --class=PermissionSeeder
   php artisan db:seed --class=DummyUsersSeeder etc

6. Serve & queue
    php artisan serve
    php artisan queue:work

🔧 Configuration (config/imports.php)
Defines each import type:
-headers_to_db: slugged CSV headers → DB columns

-validation: rules keyed by the same slugged headers

-update_or_create.match: DB columns to match for upsert


🗄️ Database Migrations
imports: batches (id, type, filename, status, user_id)

import_errors: row‐level validation failures (import_id, row_number, column, value, message)

audits: record‐level change history (import_id, table_name, row_id, column, old_value, new_value)

orders, customers, invoices: domain tables with unique keys


🛠️ Key Controllers & Jobs
ImportController
showForm(): displays upload form

handle():

stores file, normalizes headers

dispatches ProcessImport

ProcessImport Job
Creates an imports record

Loads rows via GenericImport (WithHeadingRow + ToCollection)

Validates & logs errors via $import->errors()->create[...]

Maps & upserts via Model::updateOrCreate()

Audits changes via $import->audits()->create[...]

Marks batch “completed”

ImportedDataController
index($type): paginates & displays imported records table

ImportLogController
index(): lists all import batches

errors(Import $import): paginated view of that batch’s errors

🎨 Views
resources/views/imports/form.blade.php – upload form with header preview

resources/views/imported/index.blade.php – dynamic tables of imported data

resources/views/imports/log.blade.php – batch history

resources/views/imports/errors.blade.php – error details

AdminLTE layout & partials under resources/views/layouts & partials

