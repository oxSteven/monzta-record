# Kiryi's INYI
A simple INI file reader.

## Installation
```bash
composer require kiryi/inyi
```

## Usage
```php
$inyi = new \Kiryi\Inyi\Reader($filepath);
$value = $inyi->get($key);
```

## Constructor Definition
```php
__construct(string $filepath)
```
### Parameters
**filepath**  
The filepath to your INI file. It is relative to your project's root directory.

## Method Definition *get*
```php
get(string $key)
```
### Parameters
**key**  
The key to read the value from the INI file. Key levels are seperated by double colons.

### Return Values
Returns the value corresponding to the key. Since it is possible to define strings as well as arrays in an INI file, the return type can be either. If the key is not defined or the INI file is broken or non existing, an exception is thrown.

## Example
*configuration/config.ini*
```ini
[database]
user = kiryi
password = qwe123
```
*src/Config.php*
```php
(new \Kiryi\Inyi\Reader('configuration/config.ini'))->get('database::user');
```
*returns*
```
kiryi
```
