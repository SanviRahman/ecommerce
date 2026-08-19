# Flooring Business Website Database Schema

This document is the planned schema source of truth for the flooring website modules that still need to be implemented.

Existing repository migrations are not to be edited if already applied. New schema must be added through new timestamped migrations.

## Schema Convention

- Database: MySQL.
- Primary key: `id` unsigned bigint.
- Timestamps: `created_at`, `updated_at` where relevant.
- Admin-managed CRUD entities generally use `softDeletes()` to match current trash/restore behavior.
- Boolean visibility field uses `status` to match the current `admins.status` naming style.
- Sortable entities use `sort_order` unsigned integer default `0`.
- Managed media uses the existing Spatie `media` table; no duplicate image table.
- Slugs are unique where used publicly.

## Existing Foundation Schema

These already exist and must be preserved:

### `users`

Laravel skeleton table. Not currently used as a required customer account system.

### `admins`

Existing admin-auth table with soft deletes and `status`.

### `roles`

Existing Spatie role table, customized with soft deletes.

### `permissions`

Existing Spatie permission table, customized with `group_name` and soft deletes.

### `model_has_roles`

Existing Spatie pivot.

### `model_has_permissions`

Existing Spatie pivot.

### `role_has_permissions`

Existing Spatie pivot.

### `media`

Existing Spatie Media Library polymorphic media table.

### System Tables

Existing Laravel system tables include sessions, password reset tokens, cache, cache locks, jobs, job batches and failed jobs.

## Global Settings Schema

### `site_settings`

Singleton global identity/contact configuration.

| Column | Type | Nullable | Default | Index/Constraint |
| --- | --- | --- | --- | --- |
| id | BIGINT UNSIGNED | No | - | PK |
| site_name | VARCHAR(190) | No | `Flooring Website` | - |
| logo_alt | VARCHAR(255) | Yes | NULL | - |
| contact_phone | VARCHAR(50) | Yes | NULL | - |
| contact_email | VARCHAR(190) | Yes | NULL | - |
| whatsapp_url | VARCHAR(2048) | Yes | NULL | - |
| address | TEXT | Yes | NULL | - |
| business_hours | VARCHAR(255) | Yes | NULL | - |
| map_embed_url | TEXT | Yes | NULL | - |
| created_at | TIMESTAMP | Yes | NULL | - |
| updated_at | TIMESTAMP | Yes | NULL | - |

Media collections:

```text
logo     -> single image
favicon  -> single image
```

Only one active row should exist. Application service/controller should use `firstOrCreate(['id' => 1], ...)` or equivalent singleton behavior.

## Header Schema

### `header_settings`

Singleton header behavior.

| Column | Type | Nullable | Default | Index/Constraint |
| --- | --- | --- | --- | --- |
| id | BIGINT UNSIGNED | No | - | PK |
| topbar_enabled | BOOLEAN | No | true | - |
| topbar_text | VARCHAR(255) | Yes | NULL | - |
| show_phone | BOOLEAN | No | true | - |
| show_email | BOOLEAN | No | true | - |
| cta_enabled | BOOLEAN | No | false | - |
| cta_label | VARCHAR(80) | Yes | NULL | - |
| cta_url | VARCHAR(2048) | Yes | NULL | - |
| created_at | TIMESTAMP | Yes | NULL | - |
| updated_at | TIMESTAMP | Yes | NULL | - |

### `header_menu_items`

| Column | Type | Nullable | Default | Index/Constraint |
| --- | --- | --- | --- | --- |
| id | BIGINT UNSIGNED | No | - | PK |
| label | VARCHAR(100) | No | - | - |
| route_name | VARCHAR(150) | Yes | NULL | index |
| custom_url | VARCHAR(2048) | Yes | NULL | - |
| sort_order | INT UNSIGNED | No | 0 | index |
| open_new_tab | BOOLEAN | No | false | - |
| status | BOOLEAN | No | true | index |
| created_at | TIMESTAMP | Yes | NULL | - |
| updated_at | TIMESTAMP | Yes | NULL | - |
| deleted_at | TIMESTAMP | Yes | NULL | index |

Default seeded internal menu items:

```text
Home       -> home
Services   -> services.index
About      -> about.index
Products   -> products.index
Contact Us -> contact.index
```

Application validation must require at least one of `route_name` or `custom_url`.

## Footer Schema

### `footer_settings`

Singleton footer content.

| Column | Type | Nullable | Default | Index/Constraint |
| --- | --- | --- | --- | --- |
| id | BIGINT UNSIGNED | No | - | PK |
| about_heading | VARCHAR(120) | Yes | `About Us` | - |
| about_text | TEXT | Yes | NULL | - |
| navigation_heading | VARCHAR(120) | Yes | `Navigate` | - |
| products_heading | VARCHAR(120) | Yes | `Our Products` | - |
| contact_heading | VARCHAR(120) | Yes | `Our Showroom` | - |
| copyright_text | VARCHAR(255) | Yes | NULL | - |
| created_at | TIMESTAMP | Yes | NULL | - |
| updated_at | TIMESTAMP | Yes | NULL | - |

### `footer_links`

| Column | Type | Nullable | Default | Index/Constraint |
| --- | --- | --- | --- | --- |
| id | BIGINT UNSIGNED | No | - | PK |
| section_key | VARCHAR(50) | No | - | index |
| label | VARCHAR(120) | No | - | - |
| route_name | VARCHAR(150) | Yes | NULL | index |
| custom_url | VARCHAR(2048) | Yes | NULL | - |
| sort_order | INT UNSIGNED | No | 0 | index |
| open_new_tab | BOOLEAN | No | false | - |
| status | BOOLEAN | No | true | index |
| created_at | TIMESTAMP | Yes | NULL | - |
| updated_at | TIMESTAMP | Yes | NULL | - |
| deleted_at | TIMESTAMP | Yes | NULL | index |

Allowed `section_key` values at application validation level:

```text
navigation
products
social
```

## Product Catalog Schema

### `categories`

| Column | Type | Nullable | Default | Index/Constraint |
| --- | --- | --- | --- | --- |
| id | BIGINT UNSIGNED | No | - | PK |
| name | VARCHAR(150) | No | - | - |
| slug | VARCHAR(180) | No | - | UNIQUE |
| description | TEXT | Yes | NULL | - |
| sort_order | INT UNSIGNED | No | 0 | index |
| status | BOOLEAN | No | true | index |
| created_at | TIMESTAMP | Yes | NULL | - |
| updated_at | TIMESTAMP | Yes | NULL | - |
| deleted_at | TIMESTAMP | Yes | NULL | index |

Media collection:

```text
image -> single image
```

### `products`

| Column | Type | Nullable | Default | Index/Constraint |
| --- | --- | --- | --- | --- |
| id | BIGINT UNSIGNED | No | - | PK |
| category_id | BIGINT UNSIGNED | No | - | FK -> categories.id, index |
| name | VARCHAR(180) | No | - | - |
| slug | VARCHAR(220) | No | - | UNIQUE |
| sku | VARCHAR(120) | Yes | NULL | UNIQUE nullable |
| short_description | VARCHAR(500) | Yes | NULL | - |
| description | LONGTEXT | Yes | NULL | - |
| specifications | JSON | Yes | NULL | - |
| is_featured | BOOLEAN | No | false | index |
| sort_order | INT UNSIGNED | No | 0 | index |
| status | BOOLEAN | No | true | index |
| created_at | TIMESTAMP | Yes | NULL | - |
| updated_at | TIMESTAMP | Yes | NULL | - |
| deleted_at | TIMESTAMP | Yes | NULL | index |

Foreign-key behavior:

```text
category_id -> constrained('categories')->restrictOnDelete()
```

Recommended composite index:

```text
(category_id, status, sort_order)
```

Media collections:

```text
featured_image -> single image
gallery        -> multiple images
data_sheet     -> single PDF
```

Example `specifications` JSON:

```json
{
  "Description": "SPC Flooring",
  "Plank Size": "180×1220×4mm + 1mm PAD",
  "Wear Layer": "0.3mm (12mil)",
  "Surface": "Light embossed",
  "Gloss Level": "5–7",
  "Click": "Unilin Angle-Angle",
  "Edge": "Micro-bevel"
}
```

## Homepage Media Schema

### `home_section_photos`

| Column | Type | Nullable | Default | Index/Constraint |
| --- | --- | --- | --- | --- |
| id | BIGINT UNSIGNED | No | - | PK |
| section_key | VARCHAR(80) | No | - | index |
| title | VARCHAR(190) | Yes | NULL | - |
| caption | TEXT | Yes | NULL | - |
| link_url | VARCHAR(2048) | Yes | NULL | - |
| sort_order | INT UNSIGNED | No | 0 | index |
| status | BOOLEAN | No | true | index |
| created_at | TIMESTAMP | Yes | NULL | - |
| updated_at | TIMESTAMP | Yes | NULL | - |
| deleted_at | TIMESTAMP | Yes | NULL | index |

Allowed `section_key`:

```text
our_products
after_what_we_offer
```

Recommended composite index:

```text
(section_key, status, sort_order)
```

Media collection:

```text
image -> single image
```

## Review Schema

### `reviews`

| Column | Type | Nullable | Default | Index/Constraint |
| --- | --- | --- | --- | --- |
| id | BIGINT UNSIGNED | No | - | PK |
| reviewer_name | VARCHAR(150) | No | - | - |
| reviewer_title | VARCHAR(150) | Yes | NULL | - |
| review_text | TEXT | No | - | - |
| rating | TINYINT UNSIGNED | Yes | NULL | - |
| sort_order | INT UNSIGNED | No | 0 | index |
| status | BOOLEAN | No | true | index |
| created_at | TIMESTAMP | Yes | NULL | - |
| updated_at | TIMESTAMP | Yes | NULL | - |
| deleted_at | TIMESTAMP | Yes | NULL | index |

Validation for `rating`: nullable integer 1-5.

Media collection:

```text
avatar -> single image
```

## Tracking Schema

### `meta_pixel_scripts`

This table intentionally stores executable raw HTML/JavaScript strings.

| Column | Type | Nullable | Default | Index/Constraint |
| --- | --- | --- | --- | --- |
| id | BIGINT UNSIGNED | No | - | PK |
| name | VARCHAR(150) | No | - | - |
| placement | VARCHAR(30) | No | `head` | index |
| script_code | LONGTEXT | No | - | - |
| code_hash | CHAR(64) | No | - | index |
| sort_order | INT UNSIGNED | No | 0 | index |
| status | BOOLEAN | No | true | index |
| created_by | BIGINT UNSIGNED | Yes | NULL | FK -> admins.id, nullOnDelete |
| updated_by | BIGINT UNSIGNED | Yes | NULL | FK -> admins.id, nullOnDelete |
| created_at | TIMESTAMP | Yes | NULL | - |
| updated_at | TIMESTAMP | Yes | NULL | - |
| deleted_at | TIMESTAMP | Yes | NULL | index |

Allowed `placement` application values:

```text
head
body_start
body_end
```

Recommended unique/index rule:

```text
UNIQUE (placement, code_hash)
INDEX  (status, placement, sort_order)
```

`code_hash` should be generated from the exact normalized saved script string, e.g. SHA-256.

Important: `code_hash` is duplicate/change metadata, not sanitization.

## Contact Schema

### `contact_messages`

| Column | Type | Nullable | Default | Index/Constraint |
| --- | --- | --- | --- | --- |
| id | BIGINT UNSIGNED | No | - | PK |
| name | VARCHAR(150) | No | - | - |
| phone | VARCHAR(50) | Yes | NULL | - |
| email | VARCHAR(190) | Yes | NULL | index |
| subject | VARCHAR(180) | Yes | NULL | - |
| message | TEXT | No | - | - |
| status | VARCHAR(30) | No | `new` | index |
| created_at | TIMESTAMP | Yes | NULL | index |
| updated_at | TIMESTAMP | Yes | NULL | - |
| deleted_at | TIMESTAMP | Yes | NULL | index |

Allowed status values:

```text
new
read
replied
archived
```

## Media Mapping Summary

No custom `product_images` table is needed.

```text
media.model_type + media.model_id
        |
        +-> SiteSetting
        +-> Category
        +-> Product
        +-> HomeSectionPhoto
        +-> Review
```

## Permission Seeder Additions

Existing `RolePermissionSeeder` already owns permission creation. Extend it; do not create a competing RBAC seeder.

Recommended new permission groups:

### Site Settings

```text
site_setting_manage
site_setting_update
```

### Header

```text
header_manage
header_list
header_create
header_update
header_delete
header_trash
header_restore
header_force_delete
```

### Footer

```text
footer_manage
footer_list
footer_create
footer_update
footer_delete
footer_trash
footer_restore
footer_force_delete
```

### Categories

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

### Products

```text
product_manage
product_list
product_view
product_create
product_update
product_delete
product_trash
product_restore
product_force_delete
```

### Home Photos

```text
home_photo_manage
home_photo_list
home_photo_view
home_photo_create
home_photo_update
home_photo_delete
home_photo_trash
home_photo_restore
home_photo_force_delete
```

### Reviews

```text
review_manage
review_list
review_view
review_create
review_update
review_delete
review_trash
review_restore
review_force_delete
```

### Meta Pixel Scripts

```text
meta_pixel_script_manage
meta_pixel_script_list
meta_pixel_script_view
meta_pixel_script_create
meta_pixel_script_update
meta_pixel_script_delete
meta_pixel_script_trash
meta_pixel_script_restore
meta_pixel_script_force_delete
```

These permissions should be assigned to `super_admin` by default because the module stores executable code.

### Contact Messages

```text
contact_message_manage
contact_message_list
contact_message_view
contact_message_update
contact_message_delete
contact_message_trash
contact_message_restore
contact_message_force_delete
```

## Migration Order

Recommended new migration sequence:

1. `create_site_settings_table`
2. `create_header_settings_table`
3. `create_header_menu_items_table`
4. `create_footer_settings_table`
5. `create_footer_links_table`
6. `create_categories_table`
7. `create_products_table`
8. `create_home_section_photos_table`
9. `create_reviews_table`
10. `create_meta_pixel_scripts_table`
11. `create_contact_messages_table`

Do not recreate existing `media`, `admins`, `roles`, `permissions` or system tables.
