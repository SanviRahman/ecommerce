# Flooring Business Website AI Agent Handoff Guide

এই file future AI agent/developer-এর project-specific handoff guide। Repository root-এর `AGENTS.md` সবসময় আগে follow করতে হবে; এই file তার পরে business/project context হিসেবে use হবে।

Reference user-facing website: https://floorexperts.ae/

Reference website-এর copyrighted text, images, logo, source code বা exact asset copy করা requirement না। Public information architecture, section flow, interaction pattern এবং flooring/product presentation style reference হিসেবে ব্যবহার হবে; final website-এ client-এর own brand/content/assets ব্যবহার করতে হবে।

## 1. Project Identity

Project working name: `Flooring Business Website`

Project type:

- Laravel company/catalog website.
- Two system areas:
  1. Public/User-facing website.
  2. Secured Admin Panel.
- No customer login/dashboard is required in current scope.
- No cart/checkout/order/payment flow is required in current scope.

Public top-level pages:

1. Home
2. Services
3. About
4. Products
5. Contact Us

Additional public route:

- Product Detail: `/products/{product:slug}`

## 2. Current Repository Audit

Attached repository has already completed the admin/RBAC foundation.

### 2.1 Installed Backend Stack

From `composer.lock` / `composer.json`:

- Laravel Framework: `v13.25.0`
- Composer constraint: `laravel/framework ^13.17`
- PHP Composer constraint: `^8.3`
- Root `AGENTS.md` target context: PHP 8.5
- Laravel UI: `v4.6.3`
- jeroennoten/laravel-adminlte: `v3.16.0`
- spatie/laravel-permission: `8.3.0`
- spatie/laravel-medialibrary: `11.23.5`
- Pest: project testing framework

Frontend packages already include Bootstrap, AdminLTE, Tailwind and Vite. Do not replace dependencies without approval.

### 2.2 Completed Foundation

Existing working areas that must be preserved:

- Admin guard and admin authentication flow.
- Admin dashboard route/layout.
- Admin profile/password management.
- Admin CRUD.
- Role CRUD.
- Permission CRUD.
- Spatie role/permission tables.
- `super_admin` role seeding.
- Permission grouping via `group_name`.
- Admin avatar management through Spatie Media Library.
- Admin CRUD uses AJAX modal + partial Blade + JSON responses.
- Soft delete/trash/restore/force-delete pattern exists for Admin/Role/Permission.

Important existing files:

```text
routes/web.php
routes/admin.php
app/Http/Middleware/AdminMiddleware.php
app/Http/Middleware/LteContextSwitcher.php
app/Http/Controllers/Admin/AdminController.php
app/Http/Controllers/Admin/RoleController.php
app/Http/Controllers/Admin/PermissionController.php
app/Models/Admin.php
app/Models/Role.php
app/Models/Permission.php
database/seeders/RolePermissionSeeder.php
resources/views/layouts/admin.blade.php
resources/views/admin/**
config/auth.php
config/adminlte.php
```

### 2.3 Current Public-Site Status

Current `/` route redirects to admin login. Public website has not been implemented yet.

The `users` table is Laravel skeleton infrastructure and does not mean the project currently has a customer user panel. Do not build customer registration/login unless a later requirement explicitly adds it.

## 3. Read These Files First

For every development task use this order:

1. Repository root `AGENTS.md`
2. `agent.md`
3. `prd.md`
4. `architecture.md`
5. `database-schema.md`
6. `database.md`
7. `requirement-validation.md`
8. `dfd.md`
9. Existing sibling code for the module being changed

If documents conflict:

- Root `AGENTS.md` wins for repository/Laravel conventions.
- Latest explicit client requirement wins for product behavior.
- `database-schema.md` wins for planned table/column names.
- Existing deployed migrations must never be edited; use new migrations.

## 4. Reference Website User-Panel Study

The reference site currently demonstrates these public patterns.

### 4.1 Home

Observed structure:

1. Top contact bar + main navigation.
2. Hero/banner.
3. About/credibility introduction.
4. Our Products visual/product-category presentation.
5. What We Offer/service summary.
6. Visual/gallery/social-style section after What We Offer.
7. Signature/featured flooring content.
8. Testimonials.
9. Experience/project counters.
10. FAQ/common questions.
11. Payment/business information.
12. Footer.

### 4.2 About

Observed structure:

- Company introduction.
- Expertise highlights.
- Vision.
- Mission.
- Numeric stats.
- What We Offer summary.
- Visual/gallery content.
- Testimonials.

### 4.3 Services

Observed structure:

- Service heading.
- Service cards/descriptions.
- Gallery/visual showcase.
- Testimonials.

### 4.4 Products

Observed structure:

- Category filters including `All`.
- Product cards.
- Category labels.
- Load-more style behavior.
- Featured/signature brand/product block.

### 4.5 Product Detail

Observed behavior includes:

- Product title/category.
- Product image(s).
- Product description.
- Technical specification rows.
- Optional Data Sheet.
- More/related products.

### 4.6 Contact

Observed structure:

- Contact intro.
- Address.
- Phone.
- Email.
- Enquiry form.
- Location/map area.

Our implementation should reproduce the useful flow, not copy the reference content/assets.

## 5. Confirmed Dynamic Requirements

Only the following areas are required to be admin-managed in current scope unless later changed:

1. Website logo.
2. Header section.
3. Footer section.
4. Categories.
5. Products.
6. Home photos:
   - `our_products`
   - `after_what_we_offer`
7. Reviews/testimonials.
8. Multiple Meta Pixel scripts stored as raw script strings and injected into selected page placement.

Contact enquiries are also persisted because the Contact Us page contains a working form.

Services/About/Hero/FAQ copy remain Blade/static content for MVP unless client later requests CMS editing.

## 6. Critical Architecture Rules

### 6.1 Stay Inside Existing Structure

Do not introduce repositories, modules, DDD folders, Actions folders or new architectural layers by default.

Current project is controller/model/service oriented. Reuse:

```text
app/Http/Controllers/Admin
app/Http/Controllers/Public
app/Models
app/Services
resources/views/admin
resources/views/frontend
routes/admin.php
routes/web.php
```

Create a service only when logic is reused or meaningfully complex, such as shared public layout data or tracking-script rendering/cache invalidation.

### 6.2 Admin UI Convention

New admin modules should match existing UI behavior:

- Extend `layouts.admin`.
- Use AdminLTE card/table layout.
- AJAX create/edit/show modal where appropriate.
- Use partial Blade files for forms/tables/scripts.
- Return JSON containing `success`, `message`, and `html` where existing modules do so.
- Use SweetAlert2 for confirmations/notifications.
- Preserve pagination/search/filter behavior.
- Use `@can(...)` for button visibility.

### 6.3 Validation Convention

Existing Admin/Role/Permission controllers validate via `$request->validate()` and private validation methods. Follow the existing convention for new modules unless the project is deliberately refactored to Form Requests as a separate decision.

Validation must be server-side even if JavaScript also validates.

### 6.4 Media Convention

Spatie Media Library is already installed and the `media` migration exists.

Do not create a separate `product_images` table for MVP.

Use media collections:

```text
SiteSetting: logo, favicon
Category: image
Product: featured_image, gallery, data_sheet
HomeSectionPhoto: image
Review: avatar
```

Use `singleFile()` for logo, favicon, featured image, data sheet and home-section-photo image. Product `gallery` is multi-file.

## 7. Authorization Rules

The existing UI uses `@can(...)`, but UI hiding alone is not sufficient authorization.

For every new admin action:

1. Keep `/admin/*` behind the existing admin guard/middleware.
2. Enforce the related permission server-side in controller/middleware/gate.
3. Use the existing `admin` guard.
4. Return/abort `403` when permission is missing.
5. Keep `@can(...)` in Blade as presentation only.

Before production, existing Admin/Role/Permission endpoints should also receive a security audit for server-side per-action permission enforcement.

## 8. Permission Naming Convention

Match existing snake_case permission pattern.

Recommended new groups:

```text
Site Settings
Header
Footer
Categories
Products
Home Photos
Reviews
Meta Pixel Scripts
Contact Messages
```

Recommended CRUD permission pattern where applicable:

```text
{module}_manage
{module}_list
{module}_view
{module}_create
{module}_update
{module}_delete
{module}_trash
{module}_restore
{module}_force_delete
```

Examples:

```text
category_manage
category_list
category_view
category_create
category_update
category_delete
category_trash
category_restore
category_force_delete
```

Raw Meta Pixel script permissions must only be assigned to the `super_admin` role unless the client explicitly approves another trusted role.

## 9. Database Overview

Existing tables remain untouched.

New main tables:

```text
site_settings
header_settings
header_menu_items
footer_settings
footer_links
categories
products
home_section_photos
reviews
meta_pixel_scripts
contact_messages
```

Images/files use the existing polymorphic `media` table.

Detailed source of truth: `database-schema.md`.

## 10. Meta Pixel Raw Script Rule

This requirement intentionally allows executable HTML/JavaScript from the database.

Admin must be able to save multiple script records as strings, for example complete Meta Pixel `<script>...</script>` or `<noscript>...</noscript>` snippets.

Each record must have:

- Name/label.
- Placement: `head`, `body_start`, or `body_end`.
- Raw `script_code`.
- Active/inactive status.
- Sort order.
- Created/updated admin IDs.

### 10.1 Rendering Contract

Raw script is rendered only from trusted stored records in public layout partials.

Example concept:

```blade
@foreach ($headTrackingScripts as $trackingScript)
    {!! $trackingScript->script_code !!}
@endforeach
```

This `{!! !!}` is an explicit exception. All normal user/admin content continues to use escaped `{{ }}`.

### 10.2 Raw Script Safety Rules

- Never render the submitted request value directly.
- Save first after authorization/validation, then render from DB.
- Only trusted super-admin can create/update/delete scripts.
- Never execute tracking snippets inside the admin preview/list page.
- In admin UI show script with escaped `<textarea>{{ ... }}</textarea>` or escaped `<pre>`.
- Use CSRF protection.
- Require current password confirmation for create/update if implemented in the UI flow.
- Keep an environment kill switch such as `TRACKING_SCRIPTS_ENABLED=false`.
- Cache must be invalidated immediately after script changes.
- Track who created/updated each script.

## 11. Public Route Expectations

```text
GET  /                         -> home
GET  /services                 -> services.index
GET  /about                    -> about.index
GET  /products                 -> products.index
GET  /products/{product:slug}  -> products.show
GET  /contact                  -> contact.index
POST /contact                  -> contact.store
```

Top navigation still contains exactly the five required top-level pages.

## 12. Public Rendering Rules

Public queries must only show content where applicable:

- Category `status = true`.
- Product `status = true`.
- Product category is active and not deleted.
- Home photo `status = true`.
- Review `status = true`.
- Header/footer link `status = true`.
- Meta Pixel script `status = true` and global environment tracking switch is enabled.

Use eager loading to avoid N+1 queries.

## 13. Product Rules

- Product belongs to exactly one category in MVP.
- Public route uses slug binding.
- Slug must be unique.
- Product featured image is required before public activation.
- Gallery is optional.
- `specifications` uses JSON key/value data to support flooring-specific fields without creating many nullable columns.
- Data sheet is optional PDF media.
- Force deleting a category that still owns products must be blocked.

## 14. Home Photo Rules

`home_section_photos.section_key` must only allow:

```text
our_products
after_what_we_offer
```

Do not create a new database table for each home photo section.

Each item may contain:

- image
- title
- caption
- optional URL
- sort order
- active status

## 15. Development Order

Existing admin/RBAC work is Phase 0 and must not be rebuilt.

### Phase 1 — Project Hardening and Public Skeleton

- Verify root `AGENTS.md` rules.
- Audit existing admin authorization.
- Replace `/` login redirect with public Home route.
- Create public layout/header/footer partial structure.
- Add module permission names to seeder.
- Replace AdminLTE placeholder menu entries with real module items.

### Phase 2 — Global Branding/Header/Footer

- Migrations/models.
- Logo via Media Library.
- Header/footer admin settings.
- Shared frontend layout data.

### Phase 3 — Categories

- Category migration/model/media.
- Admin CRUD matching existing AJAX pattern.
- Permissions/tests.

### Phase 4 — Products

- Product migration/model/media/specifications.
- Admin CRUD.
- Product gallery/data sheet.
- Public product list/filter/detail.

### Phase 5 — Home Photos

- HomeSectionPhoto model/media.
- Two required section keys.
- Admin CRUD + frontend rendering.

### Phase 6 — Reviews

- Review CRUD.
- Reuse on Home/Services/About where design needs it.

### Phase 7 — Contact

- Contact page.
- Contact form validation/throttling/persistence.
- Admin inbox.

### Phase 8 — Meta Pixel Scripts

- Raw script table/model/admin CRUD.
- Super-admin-only permissions.
- Placement-specific frontend partials.
- Tracking kill switch.

### Phase 9 — Final UI/QA

- Match reference information architecture using original content/assets.
- Responsive testing.
- Permission/security testing.
- Performance/SEO/accessibility testing.
- Production cache/build/deployment checks.

## 16. Agent Behavior Rules

When implementing any module:

1. Read related docs and current sibling code first.
2. Do not rewrite completed Admin/Role/Permission code unless required by the task.
3. Use Artisan generators for new Laravel files.
4. Do not edit already-run migrations; create new migrations.
5. Keep model `$fillable` explicit.
6. Use named routes and route model binding.
7. Validate all input server-side.
8. Protect every state-changing admin action with authorization.
9. Use Spatie Media Library for managed images/files.
10. Add/update Pest feature tests for each module.
11. Run focused tests, then broader test suite.
12. Run Pint after PHP changes.
13. Do not add a new dependency without approval.
14. Do not copy reference website copyrighted content/assets.
15. Do not interpret the Laravel `users` table as a required customer login system.

## 17. Final MVP Acceptance

MVP is complete when:

- Five public pages work responsively.
- Public Home follows the reference-style section flow.
- Admin can manage logo/header/footer.
- Admin can manage categories/products.
- Product filter/detail work.
- Admin can manage the two required home-photo groups.
- Admin can manage reviews.
- Contact enquiries work.
- Super admin can manage multiple raw Meta Pixel script strings and choose placement/status/order.
- Scripts inject only when enabled.
- Existing Admin/Role/Permission functionality remains working.
- New permissions are enforced server-side.
- Tests pass and production build succeeds.
