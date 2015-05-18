Readable Session Helper
=======================

**Write your php sessions in a more readable way. Great for multidimensional sessions.**

Extracted from [vume](https://github.com/devfake/vume) framework.

### Get started

Check the [example](https://github.com/devfake/Readable-Session-Helper/blob/master/example.php) file.

##### Requirements 

* PHP 5.3+
* Composer

##### Install

The easiest way to install Rese is via [Composer](https://getcomposer.org/). Add this to your `composer.json` file and run `$ composer update`:

```json
{
  "require": {
    "devfake/rese": "dev-master"
  }
}
```

**Create a helper function (if you like):**

```php
function session($keys = null)
{
  return new Devfake\Rese\Session($keys, '.');
}
```

**Working with the new helper:**

```php
// $_SESSION
session()->get();

// $_SESSION['key'];
session('key')->get();

// $_SESSION['key']['more']['deep'];
session('key.more.deep')->get();

// Pass a default value into get() if the key not exists:
session('not.available')->get('my default value');

// $_SESSION['key']['more'] = $data;
session('key.more')->set($data);

// isset($_SESSION['key']);
session('key')->exists();

// Send a flash message:
session('input.error')->message();

// $_SESSION['key'] == 'value';
session('key')->is('value');

// unset($_SESSION['key']['and']['more']['deeply']);
session('key.and.more.deeply')->remove();
// Alias for remove():
session('key.and.more.deeply')->delete();

// Destroy complete session:
session()->destroy();
```

You can change the separation by add a second argument for the class call in the helper function.
Change to whatever you like (e.g '->' or '/'):

```php
session('key->and->other')->get();
session('key/and/other')->get();
```
