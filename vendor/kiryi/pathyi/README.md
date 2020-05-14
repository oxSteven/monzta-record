# Kiryi's PATHYI
A simple path formatter.

## Installation
```bash
composer require kiryi/pathyi
```

## Usage
```php
$pathyi = new \Kiryi\Pathyi\Formatter();
$path = $pathyi->format($path);
```

## Method Definition *format*
```php
format(string $path, bool $leadingSlash = false, bool $trailingSlash = false): string
```
### Parameters
**path**  
The path to format. If only backslashes appearing, path will be returned with leading/trailing backslashes. If not, forward slashes are used.  

**leadingSlash**  
Defines if the returned path starts with a slash (true) or not (false, default).  

**trailingSlash**  
Defines if the returned path ends with a slash (true) or not (false, default).

### Return Values
Returns the formatted path as a string.

## Example
```php
$path = '/this/is/my/path';
$pathyi = new \Kiryi\Pathyi\Formatter();

$path = $pathyi->format($path);
// $path is now 'this/is/my/path'

$path = $pathyi->format($path, true);
// $path is now '/this/is/my/path'

$path = $pathyi->format($path, false, true);
// $path is now 'this/is/my/path/'
```
