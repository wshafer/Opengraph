Description
===========

This package adds an Open Graph tag manager to the Reliv Content Manager.


Install
=======

Composer:

```bash
$ composer require wshafer/opengraph
```

Config:

Add `WShafer\OpenGraph` to your config/application.config.php modules section.

DB Updates
==========

Generate the SQL file needed to update your database with the needed
tables.  We use Docrine so a simple update should generate the needed
sql file:

```bash
$ php pubic/index.php orm:schema-tool:update --dump-sql
```

Run the generated sql against your database.

Layouts
=======
To add the Open Graph tags, you'll need add the view helper to the 
header section of your layouts.

Start by removing any open graph tags currently in your view.  Then add
the following to your head section in the layouts where you want
your OG tags to appear

```php
<?= $this->openGraph(); ?>
```

Default Values
==============
The module contains some default values, but you'll want to customize
these to your liking.

Add the following config to global.php or local.php and adust the
values according to your needs:

```php
return [
    'openGraph' => [
        'defaults' => [
    
            'facebook' => [
                'appId' => '1234',
            ],
    
            'general' => [
                'ogType' => 'website',
            ],
    
            'website' => [
                'title' => 'No Title',
                'image' => 'https://upload.wikimedia.org/wikipedia/commons/4/4b/Blank_License_Plate_Shape.jpg',
                'description' => '',
                'siteName' => '',
            ],
    
            'article' => [
                'title' => 'No Title',
                'image' => 'https://upload.wikimedia.org/wikipedia/commons/4/4b/Blank_License_Plate_Shape.jpg',
                'description' => '',
                'siteName' => '',
                'author' => '',
                'section' => ''
            ],
        ],
    ],
];
```
