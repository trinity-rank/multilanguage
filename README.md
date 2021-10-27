# Very short description of the package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/trinityrank/geo-location.svg?style=flat-square)](https://packagist.org/packages/trinityrank/hreflang)
[![Total Downloads](https://img.shields.io/packagist/dt/trinityrank/geo-location.svg?style=flat-square)](https://packagist.org/packages/trinityrank/hreflang)

Add alternate hreflang tags for same pages but on other language.

## Installation

### Step 1: Install package

To get started with Laravel Geo Location, use Composer command to add the package to your composer.json project's dependencies:

```shell
    composer require trinityrank/hreflang
```

### Step 2: Migration

- You need to publish migration from package

```shell
    php artisan vendor:publish --provider="Trinityrank\Hreflang\HreflangServiceProvider" --tag="hreflang-migration"
```

- And then you need to run migration for alltenant(s)

```shell
    php artisan tenant:artisan "migrate"
```

- Or only for one speciffic tenant

```shell
    php artisan tenant:artisan "migrate" --tenant=[--TENANT-ID--]
```

### Step 3: Operaters Model database

Add this fields to '$fillable' inside Operaters model
    
```shell
    public $fillable = [
        ...
        'hreflang_const',
        'hreflang_language',
    ];
```

### Step 4: Add field

- Add field to your (Operater) resource into "fields" method

```shell
    use Trinityrank\Hreflang\HreflangPanel;
    
    ...
    
    HreflangPanel::make()
```

- Or if you use conditional fields than just add this into "fields" method
```shell
    $this->getHreflangPanel('Hreflang Page Settings', 'hreflang')
```

### Step 5: If you are using conditional fields

Add this in tenant config

```shell
    'conditional_fields' => [
        ...

        'operater' => [
            'hreflang' => [
                'visible' => true
            ]
        ]

        ...
    ]
```

### Step 6: Frontend part

- Without token

```shell
    use Trinityrank\Hreflang\HreflangOperater;

    ...

    $operaters = HreflangOperater::list($operaters_array);
```

- With token

Add new variable in .ENV file

```shell
    hreflang_API_TOKEN=[--Replace-this-with-website-token--]
```

You can connect with 'config/main.php' file

```shell
    'hreflang_api_token' => env('hreflang_API_TOKEN', null),
```

Then we can use our Geo Location

```shell
    use Trinityrank\Hreflang\HreflangOperater;

    ...

    $operaters = HreflangOperater::list($operaters_array, $api_token = [optional]);
```