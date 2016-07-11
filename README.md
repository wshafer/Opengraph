Description
===========

This package adds an Open Graph tag manager to the Reliv Content Manager.


Install
=======

Composer:

```bash
$ composer require wshafer/opengraph
```

DB Updates
==========

Generate the SQL file needed to update your database with the needed
tables.  We use Docrine so a simple update should generate the needed
sql file:

```bash
$ php pubic/index.php orm:schema-tool:update --dump-sql
```

Run the generated sql file against your database.

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
