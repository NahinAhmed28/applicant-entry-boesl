---
description: Setup admin roles, applicant management, and dashboard for Brunei Worker Management
---

# Workflow: Setup Admin System

This workflow guides you through implementing the three admin types (boesl-admin, bhc-admin, super-admin), applicant data handling, notifications, and a responsive dashboard with a collapsible sidebar.

## Prerequisites
- Laravel project is set up and running (`php artisan serve`).
- Database configured and migrated.
- Existing `applicants` migration (see `database/migrations/2026_02_23_000001_create_applicants_table.php`).

## Steps
1. **Create Roles Seeder** (if not already present)
   ```bash
   php artisan make:seeder RoleSeeder
   ```
   // turbo
   // Edit `database/seeders/RoleSeeder.php` to insert roles:
   //   - super-admin
   //   - bhc-admin
   //   - boesl-admin

2. **Run Seeder**
   ```bash
   php artisan db:seed --class=RoleSeeder
   ```
   // turbo

3. **Create Middleware for Role Checks**
   ```bash
   php artisan make:middleware CheckRole
   ```
   // turbo
   // In `app/Http/Middleware/CheckRole.php`, implement logic to allow only users with the required role.

4. **Register Middleware**
   - Add to `$routeMiddleware` in `app/Http/Kernel.php`:
     ```php
     'role' => \App\Http\Middleware\CheckRole::class,
     ```

5. **Create Controllers**
   - Boesl Admin Controller:
     ```bash
     php artisan make:controller BoeslAdmin/ApplicantController
     ```
   - BHC Admin Controller:
     ```bash
     php artisan make:controller BhcAdmin/ApplicantController
     ```
   - Super Admin Controller (optional for user management):
     ```bash
     php artisan make:controller SuperAdmin/UserController
     ```
   // turbo

6. **Implement Applicant CRUD**
   - In `BoeslAdmin\ApplicantController` add methods:
     - `create()` – show form for BHC-No, Applicant Name, Passport No, Agency Name, Company Name, Flight Date.
     - `store(Request $request)` – validate, save applicant, set `status` to `sent_to_bhc`.
     - `importExcel(Request $request)` – handle Excel upload (use `Maatwebsite\Excel` package).
   - Ensure after storing, Boesl admin cannot edit the record again (disable edit routes).

7. **BHC Admin Functions**
   - `index()` – list all applicants (both admins can view).
   - `edit($id)` – allow updating Phone Number, Registration No, and marking as registered.
   - When "Mark as Registered" is clicked, automatically set `registered_at` to current timestamp and change `status` to `registered`.
   - Add routes for IC Card and Insurance receipt updates with toggleable status fields.

8. **Notifications**
   - Use Laravel Scheduler (`app/Console/Kernel.php`) to schedule daily checks:
     - 3 months after `flight_date` → if `status` is `registered` and `ic_received_at` is null, create a notification for BHC admin.
     - 6 months after `registered_at` → if `insurance_received_at` is null, create a notification.
   - Store notifications in a `notifications` table and display them in the BHC admin dashboard.

9. **Routes** (`routes/web.php`)
   ```php
   // Boesl Admin routes (protected by role:boesl-admin)
   Route::middleware(['auth', 'role:boesl-admin'])->prefix('boesl')->group(function () {
       Route::get('applicants/create', [BoeslAdmin\ApplicantController::class, 'create'])->name('boesl.applicants.create');
       Route::post('applicants', [BoeslAdmin\ApplicantController::class, 'store'])->name('boesl.applicants.store');
       Route::post('applicants/import', [BoeslAdmin\ApplicantController::class, 'importExcel'])->name('boesl.applicants.import');
   });

   // BHC Admin routes (role:bhc-admin)
   Route::middleware(['auth', 'role:bhc-admin'])->prefix('bhc')->group(function () {
       Route::get('applicants', [BhcAdmin\ApplicantController::class, 'index'])->name('bhc.applicants.index');
       Route::get('applicants/{id}/edit', [BhcAdmin\ApplicantController::class, 'edit'])->name('bhc.applicants.edit');
       Route::patch('applicants/{id}', [BhcAdmin\ApplicantController::class, 'update'])->name('bhc.applicants.update');
       Route::post('applicants/{id}/ic-received', [BhcAdmin\ApplicantController::class, 'markIcReceived'])->name('bhc.applicants.ic_received');
       Route::post('applicants/{id}/insurance-received', [BhcAdmin\ApplicantController::class, 'markInsuranceReceived'])->name('bhc.applicants.insurance_received');
   });

   // Super Admin routes (role:super-admin)
   Route::middleware(['auth', 'role:super-admin'])->prefix('super')->group(function () {
       Route::resource('users', SuperAdmin\UserController::class);
   });
   ```

10. **Dashboard Layout**
    - Create a Blade layout `resources/views/layouts/dashboard.blade.php` with a collapsible sidebar.
    - Use modern CSS (CSS variables, gradients, glassmorphism) for premium look.
    - Include project title "Brunei Worker Management" in the header.
    - Add a responsive landing page at `resources/views/welcome.blade.php` with custom branding.

11. **Statistical Charts**
    - Install Chart.js via npm (`npm install chart.js`).
    - In the dashboard view, add canvas elements for:
      - Applicants per status.
      - Registrations over time.
      - IC Card receipt rate.
      - Insurance receipt rate.
    - Populate data via controller passing JSON.

12. **Finalize**
    - Run migrations: `php artisan migrate`.
    - Seed roles: `php artisan db:seed --class=RoleSeeder`.
    - Compile assets: `npm run dev`.
    - Test all flows.

---
**Note**: Steps marked with `// turbo` can be auto‑executed using the `run_command` tool with `SafeToAutoRun: true`.
