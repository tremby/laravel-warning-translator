Warning translator
==================

This translator is an extension of [Laravel](http://laravel.com/) 4's built-in 
one. The only differences are these:

- A warning (`Log::warning`) is logged whenever the translation is not found in 
  the current locale and it has to fall back to the fallback locale.
- An error (`Log::error`) is logged whenever the translation is not found in any 
  locale.

As an exception, any translation key beginning with `validation.custom.` will 
not trigger errors.

These logs will be handled however your log messages are normally logged -- 
whether appearing in the debug bar, logging to a file or going up to a cloud 
logging service.

Installation
------------

Require it in your Laravel project:

	composer require tremby/laravel-warning-translator

Comment out or delete the line in your `app/config/app.php` which loads the 
built in translation service provider:

	// 'Illuminate\Translation\TranslationServiceProvider',

Add a new similar line in its place or at the bottom of the `providers` array:

	'Tremby\WarningTranslator\WarningTranslationServiceProvider',

Use
---

Use translations as normal, as described in the [Laravel 
documentation](http://laravel.com/docs/localization).
