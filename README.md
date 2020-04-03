![alt text](https://cdn.marshmallow-office.com/media/images/logo/marshmallow.transparent.red.png "marshmallow.")

# Marshmallow Products
Deze package gaat alle logica houden voor producten. Producten zullen in het algemeen gebruikt worden in combinatie met de Cart of Ecommerce package.

### Installatie
```
composer require marshmallow/package-ecommerce
```

Voeg de observer toe aan `AppServiceProvider.php`.
```
public function boot()
{
    ModelObserver::observe();
}
```

php artisan db:seed --class=Marshmallow\\Product\\Database\\Seeds\\VatRatesSeeder

## To do
`php artisan marshmallow:resource Product Product`

## Extra
factory(Marshmallow\Product\Models\Product::class, 10)->create();

## Hulp
Als de factory niet werkt, zet dan `'strict' => false,` in `config/database.php`.

...