![alt text](https://cdn.marshmallow-office.com/media/images/logo/marshmallow.transparent.red.png "marshmallow.")

# Marshmallow Products

[![Latest Version on Packagist](https://img.shields.io/packagist/v/marshmallow/products.svg?style=flat-square)](https://packagist.org/packages/marshmallow/products)
[![Total Downloads](https://img.shields.io/packagist/dt/marshmallow/products.svg?style=flat-square)](https://packagist.org/packages/marshmallow/products)

Basic building blocks for handling products and preparing them to be used in e-commerce. This package ships the `Product`, `ProductCategory` and `Supplier` models (with prices, SEO, slugs, soft deletes and flexible images) plus matching Laravel Nova resources. It is typically used together with Marshmallow's Cart or Ecommerce packages.

## Requirements

- PHP `^8.1`
- [Laravel Nova](https://nova.laravel.com) `^5.0`

Laravel Nova is a paid product. Make sure your Composer is authenticated against `https://nova.laravel.com` before installing.

## Installation

Install the package via Composer:

```bash
composer require marshmallow/products
```

The service provider is auto-discovered. It registers the package config and loads the package migrations automatically, so a `php artisan migrate` is all that is needed to create the `products`, `product_categories`, `suppliers` and pivot tables.

Register the product observer in your application's `AppServiceProvider::boot()` method:

```php
use Marshmallow\Product\Models\Product;
use Marshmallow\Product\Observers\ProductObserver;

public function boot()
{
    Product::observe(ProductObserver::class);
}
```

Seed the default VAT rates (provided by `marshmallow/priceable`) so products can be priced:

```bash
php artisan db:seed --class="Marshmallow\Priceable\Database\Seeds\VatRatesSeeder"
```

### Publishing the config

Optionally publish the config file to override the models, Nova resources and defaults:

```bash
php artisan vendor:publish --tag="config"
```

## After installation

Generate the Nova resources for this package (and for the Priceable resources it relies on) using the `marshmallow:resource` command from `marshmallow/commands`:

```bash
php artisan marshmallow:resource Product Product
php artisan marshmallow:resource Supplier Product
php artisan marshmallow:resource ProductCategory Product
php artisan marshmallow:resource Price Priceable
php artisan marshmallow:resource VatRate Priceable
php artisan marshmallow:resource Currency Priceable
```

Set your default currency in your `.env`:

```dotenv
CURRENCY=eur
```

## Configuration

The published `config/product.php` file exposes the following options:

| Key | Default | Description |
| --- | --- | --- |
| `models.product` | `Marshmallow\Product\Models\Product` | The Product Eloquent model. Override to use your own. |
| `models.product_category` | `Marshmallow\Product\Models\ProductCategory` | The ProductCategory Eloquent model. |
| `models.supplier` | `Marshmallow\Product\Models\Supplier` | The Supplier Eloquent model. |
| `nova.wysiwyg` | `Laravel\Nova\Fields\Trix` (env `NOVA_WYSIWYG`) | The Nova field used for the product body. |
| `nova.prices_are_including_vat` | `true` | Whether prices entered in Nova already include VAT. |
| `nova.defaults.currencies` | `1` | Default currency id used on new prices. |
| `nova.defaults.vat_rates` | `3` | Default VAT rate id used on new prices. |
| `nova.resources` | `Marshmallow\Product\Nova\*` | The Nova resource classes for product, category and supplier (price resource comes from Priceable). |
| `nova.relationships.product_supplier` | `Marshmallow\Product\Nova\Relationships\ProductSupplier::class` | The pivot definition for the product/supplier relationship. |
| `default_product_view` | `shop.product` | The blade view used to render a product detail page. |
| `channels` | `[]` | Optional sales channels (e.g. Bol.com) to expose the product on. |

## Usage

### The Product model

```php
use Marshmallow\Product\Models\Product;

$product = Product::factory()->create([
    'name' => 'Example product',
]);

// Eager load the common relationships to prevent N+1 queries.
$products = Product::active()->withRelationships()->get();

foreach ($products as $product) {
    $product->fullname();        // human readable name
    $product->freeStock();       // amount purchasable right now
    $product->getAvailability(); // Product::IN_STOCK | OUT_OF_STOCK | PREORDER
    $product->getCondition();    // 'new'
    $product->route();           // route('product.detail', $product)

    if ($product->hasImage()) {
        $product->firstImagePath();
    }
}
```

A `Product` is sluggable, SEO-able and priceable, uses soft deletes, and casts its `images` attribute to a Nova Flexible value. It exposes `category()` (belongs-to), `categories()` and `suppliers()` (belongs-to-many) relationships, all resolved through the configurable model classes.

### Available scopes

| Scope | Description |
| --- | --- |
| `active()` | Only products where `active = 1`. |
| `withRelationships()` | Eager loads `category`, `categories`, `suppliers` and `media`. |

### Stock status constants

```php
Product::IN_STOCK;
Product::OUT_OF_STOCK;
Product::PREORDER;
```

## Security Vulnerabilities

Please report security vulnerabilities by email to [stef@marshmallow.dev](mailto:stef@marshmallow.dev) rather than via the public issue tracker.

## Credits

- [Stef](https://marshmallow.dev)
- [All Contributors](https://github.com/marshmallow-packages/products/contributors)

## License

The MIT License (MIT). Please see the [License File](LICENSE) for more information.
