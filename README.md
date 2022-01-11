# Very short description of the package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/trinityrank/multilanguage.svg?style=flat-square)](https://packagist.org/packages/trinityrank/multilanguage)
[![Total Downloads](https://img.shields.io/packagist/dt/trinityrank/multilanguage.svg?style=flat-square)](https://packagist.org/packages/trinityrank/multilanguage)

Add alternate multilanguage tags for same pages but on other language.

## Installation

### Step 1: Install package

To get started with Laravel Multilanguage, use Composer command to add the package to your composer.json project's dependencies:

For Frontend and backend
```shell
    composer require trinityrank/multilanguage

```

Only for backend we need this package too
```shell

    composer require epartment/nova-dependency-container
```

## Laravel Nova admin - Backend part

### Step 2: Database

- You need to publish migration from package

```shell
    php artisan vendor:publish --provider="Trinityrank\Multilanguage\MultilanguageServiceProvider" --tag="multilanguage-migration"
```

- And then you need to run migration for alltenant(s)

```shell
    php artisan tenant:artisan "migrate"
```

- Or only for one speciffic tenant

```shell
    php artisan tenant:artisan "migrate" --tenant=[--TENANT-ID--]
```

### Step 3: Update database with default language

- Update database field "multilang_language" to default language for your website

```shell
    UPDATE `articles` SET `multilang_language`='us' WHERE 1;
    UPDATE `pages` SET `multilang_language`='us' WHERE 1;
    UPDATE `categories` SET `multilang_language`='us' WHERE 1;
    UPDATE `static_pages` SET `multilang_language`='us' WHERE 1;
```


### Step 4: Add field

- Add field to your (Operater) resource into "fields" method

```shell
    use Trinityrank\Multilanguage\MultilanguagePanel;
    
    ...
    
    MultilanguagePanel::make()
```

- Or if you use conditional fields than just add this into "fields" method

```shell
    // use "$this" or "self::", depends of resource structure
    $this->getMultilanguagePanel('Multilanguage', 'multilanguage')
```

- Fields where category depends on language select

```shell
    // use "$this" or "self::", depends of resource structure
    // $this->getMultilanguageCategory("Language", [Resource::class, Model::class, ['rules']]),
    // example:
    $this->getMultilanguageCategory("Language", [ReviewPageCategory::class, TypesReviewPageCategory::class, ['required']]),
```

### Step 5: If you are using conditional fields

Add this in tenant-default config

```shell
    'conditional_fields' => [
        ...

        '{{your_page_type_name}}' => [
            'categories' => [
                'visible' => true,
                'rules' => ['required', 'min:1', 'max:1', ... ]
            ],
        ]

        ...
    ]
```

Add this in tenant-{{tenant name}} config

```shell
    'conditional_fields' => [
        ...

        '{{your_page_type_name}}' => [
            'language' => [
                'visible' => true
            ],
            'categories' => [
                'visible' => true,
                'visibility' => ['onlyOnIndex'],
                'rules' => ['required', 'min:1', 'max:1']
            ],
        ]

        ...
    ]
```

### Step 6: Add languages

In your "config\app.php" add multilanguage locales (use ISO language codes). For example:

```shell
    'locales' => [
        "us" => "USA",
        "uk" => "Great Britain",
        "ca" => "Canada",
        "au" => "Australia",
        "de" => "German",
        "at" => "Austria",
    ],
```

## Frontend part

### Step 7: Frontend part

Add helper function to "composer.json" file

```shell
        "autoload": {
            "files": [
                "vendor/trinityrank/multilanguage/src/frontend/helpers.php"
            ],
            ...
        } 
```

And then run:

```shell
    composer dump-autoload
```

And change default "route()" method to "multilang_route()"


### Step 8: Add languages

In your "config\app.php" add multilanguage locales (use ISO language codes). For example:

```shell
    'locales' => ['us', 'uk', 'ca', 'au', 'de', 'at'],
```