New Base 60
===========

New base 60 is a base 60 numbering system using only ASCII numbers and letters created by Tantek Çelik (see <http://tantek.pbworks.com/w/page/19402946/NewBase60> for more information).

This PHP library converts between base 60 and base 10.

Installing
==========
Using Composer:

`composer require jaredhowland/new-base-60`

Or add the following to your `composer.json` file:

```
"require": {
    "jaredhowland/new-base-60": "^1.0"
}
```

Otherwise, just include the file in your project:

`require_once 'path/to/src/NewBase60.php';`

Usage
=====
Example Usage:

```
<?php

use NewBase60\NewBase60;

require_once 'src/NewBase60.php';

echo NewBase60::toNewBase60('20200108'); // Output: 1ZX8U

echo NewBase60::toBase10('1ZX8U'); // Output: 20200108

// For the next methods, the second argument is the length of the padding to include
// Based on PHP’s built-in `str_pad`

echo NewBase60::toNewBase60WithLeadingZeroes('20200108', 10); // Output: 000001ZX8U

echo NewBase60::toBase10WithLeadingZeroes('1ZX8U', 10); // Output: 0020200108
```

That’s it. Those are the only 4 functions included in this library. Very basic, but complete, new base 60 support. See <http://tantek.pbworks.com/w/page/19402946/NewBase60> for why you might want to use, or not use, new base 60 in a project.