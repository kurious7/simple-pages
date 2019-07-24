# Simple Pages

A [Laravel](http://laravel.com/docs/master) package designed to add pages to your Laravel application.  A page is just
**content** defined by specific URL, or **slug**.  A page may or may not be **published**.

## Installation

Require the package using composer:

```bash
composer require kurious7/simple-pages
```

Publish the migration and config files 
```bash
php artisan vendor:publish \
  --provider="Kurious7\Pages\PagesServiceProvider" 
``` 

Migrate
```bash
php artisan migrate 
``` 

## Usage

Create a **Page** model:

```php
\Kurious7\Pages\Page::create([
    'title' => 'Hello, World',
    'content' => '<p>Hi everybody</p>',
    'public' => true,
    'show_in_menu' => true,
]);
```

...which is now accessible by browsing to `/hello-world`!

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
[MIT](https://choosealicense.com/licenses/mit/)



