# Filament Help Desk v2.0 - Compatibility Fixes for Filament 4.5

## Summary

The `jeffersongoncalves/filament-help-desk:^2.0` package has **3 breaking compatibility issues** with Filament 4.5 (filament/filament `^4.5`). These are caused by method signature and property changes in Filament's core classes.

---

## Issue 1: `ChartWidget::$heading` changed from `static` to non-static

**Affected files:**
- `src/Admin/Widgets/TicketsByPriorityWidget.php` (line 13)
- `src/Operator/Widgets/TicketsByStatusWidget.php` (line 13)

**Error:**
```
PHP Fatal error: Cannot redeclare non static Filament\Widgets\ChartWidget::$heading
as static JeffersonGoncalves\FilamentHelpDesk\Admin\Widgets\TicketsByPriorityWidget::$heading
```

**Root cause:**
In Filament 4.5, `Filament\Widgets\ChartWidget::$heading` was changed from:
```php
protected static ?string $heading = null;
```
to:
```php
protected ?string $heading = null;
```

**Fix:**
```diff
- protected static ?string $heading = null;
+ protected ?string $heading = null;
```

Apply in both:
- `src/Admin/Widgets/TicketsByPriorityWidget.php`
- `src/Operator/Widgets/TicketsByStatusWidget.php`

---

## Issue 2: `Resource::getSlug()` signature changed to accept `?Panel` parameter

**Affected files:**
- `src/User/Resources/TicketResource.php` (line 61)
- `src/Operator/Resources/TicketResource.php` (line 66)

**Error:**
```
PHP Fatal error: Declaration of JeffersonGoncalves\FilamentHelpDesk\User\Resources\TicketResource::getSlug(): string
must be compatible with Filament\Resources\Resource::getSlug(?Filament\Panel $panel = null): string
```

**Root cause:**
In Filament 4.5, `Filament\Resources\Resource::getSlug()` signature changed from:
```php
public static function getSlug(): string
```
to:
```php
public static function getSlug(?Panel $panel = null): string
```

**Fix for `src/User/Resources/TicketResource.php`:**
```diff
+ use Filament\Panel;

- public static function getSlug(): string
+ public static function getSlug(?Panel $panel = null): string
  {
      return config('filament-help-desk.user.slug', 'tickets');
  }
```

**Fix for `src/Operator/Resources/TicketResource.php`:**
```diff
+ use Filament\Panel;

- public static function getSlug(): string
+ public static function getSlug(?Panel $panel = null): string
  {
      return config('filament-help-desk.operator.slug', 'tickets');
  }
```

---

## How to Apply Fixes (Temporary Workaround)

Until a new version of the package is released, you can apply these fixes manually after `composer install/update`:

### Option A: Manual patch after install

Edit the vendor files directly (will be overwritten on next `composer update`).

### Option B: Composer patches (recommended)

Install `cweagans/composer-patches` and create a patch file:

```bash
composer require cweagans/composer-patches
```

Create `patches/filament-help-desk-filament-4.5-compat.patch` and add to `composer.json`:

```json
{
    "extra": {
        "patches": {
            "jeffersongoncalves/filament-help-desk": {
                "Filament 4.5 compatibility fixes": "patches/filament-help-desk-filament-4.5-compat.patch"
            }
        }
    }
}
```

---

## Checklist for Package Maintainer

- [ ] Fix `$heading` property in `Admin/Widgets/TicketsByPriorityWidget.php` (remove `static`)
- [ ] Fix `$heading` property in `Operator/Widgets/TicketsByStatusWidget.php` (remove `static`)
- [ ] Fix `getSlug()` signature in `User/Resources/TicketResource.php` (add `?Panel $panel = null`)
- [ ] Fix `getSlug()` signature in `Operator/Resources/TicketResource.php` (add `?Panel $panel = null`)
- [ ] Add `use Filament\Panel;` import in both TicketResource files
- [ ] Run tests against Filament 4.5
- [ ] Release as v2.0.1 (or v2.1.0)
