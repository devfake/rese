Readable Session Helper
=======================

**Write your sessions in a more readable way. Great for multidimensional sessions.**


### Get started

**Create a helper function (if you like):**

```php
function session($keys = null)
{
  return new Session($keys, '.');
}
```

**Working with the new helper:**

```php
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

// Destroy complete session:
session()->destroy();
```

You can change the separation by edit the second parameter for the class call in the helper function.
Change to whatever you like (e.g '->' or '/'):

```php
session('key->and->other')->get();
session('key/and/other')->get();
```
