# FLARYI Endpoint Documentation *Tag*

This document describes the possible actions performable on the `Tag` Endpoint.

## get
```php
get(int $tagId): object
```
Get a Tag by its ID.
### Parameters
**tagId**  
ID of the requested Tag.

### Return Values
Returns a data object containing the requested Tag object.

## getAll
```php
getAll(): object
```
Get all Tags.

### Return Values
Returns a data object containing the requested Tag objects.

## getByName
```php
getByName(string $tagName): object
```
Get a Tag by its name.

### Parameters
**tagName**  
Name of the requested Tag.

### Return Values
Returns a data object containing the requested Tag object.
