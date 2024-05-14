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
