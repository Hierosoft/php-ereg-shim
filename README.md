# php ereg shim

This package emulates the old php extension for POSIX regular expressions
(ereg) if it's not available. Internally, the PCRE extension is used to process
regular expressions.

## Requirements and Usage

The library requires php 5.3 or newer. It can be automatically included as follows:

```
git clone https://github.com/Hierosoft/php-ereg-shim
cd php-ereg-shim && echo "auto_prepend_file=`pwd`/php-ereg-shim-procedural.php" | sudo tee /etc/php.d/95-php-ereg-shim-procedural.ini
```
**However**, note that only the last `auto_prepend_file` will be respected, so if you need more than one shim (such as each-shim and mysql-shim) you will need to instead make a custom file. For example, make a file called "/opt/php8-shims.php" containing something like:
```PHP
<?php
require '/opt/git/mysql-shim/mysql-shim.php';
require '/opt/git/php-ereg-shim-procedural/php-ereg-shim-procedural.php';
require '/opt/git/polyfill-each/polyfill-each.php';
?>
```
- Change the paths as necessary. Only require files you need, are safe to include at the top (may only work properly in PHP 8.0 or later), and that exist.
- Then auto-include the shim file with everything instead of a limit of one required file:
```
if [ -f /etc/php.d/95-php-ereg-shim-procedural.ini ]; then
    rm /etc/php.d/95-php-ereg-shim-procedural.ini
fi
echo "auto_prepend_file=/opt/php8-shims.php" | sudo tee /etc/php.d/95-php8-shims.ini
```

Installing this way means the program requires PHP 8.0 or higher, otherwise the function would already exist.
- In earlier versions, the function already exist so you don't need php-ereg-shim at all
  (to make it compatible with both, php-ereg-shim would have to be entirely wrapped in `if (!function_exists("ereg")) {}` anyway, becoming a do-nothing include in that case).

Global function call
---------------------------
`ereg('[0-9][^0-9]', '2a')`

## Purpose and limitations

This library can be helpful if you need to quicky migrate a legacy codebase to
php 7.0 and beyond. It will be slower than the native implementation and is not
intended to be a permanent solution. Code that depends on the ereg extension
should be refactored to use the corresponding PCRE functions instead.

The library has been developed against the test suite of the php 5.6 ereg
extension in order to get as close to the original behavior as possible. While
PCRE and POSIX regular expressions are very similar, they're not 100%
compatible. There are certain edge cases that this library cannot cover.
