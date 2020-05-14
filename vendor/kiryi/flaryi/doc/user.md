# FLARYI Endpoint Documentation *User*

This document describes the possible actions performable on the `User` Endpoint.

## get
```php
get(int $userId, ?array $responseFields = null): object
```
Get a User by its ID.

### Parameters
**userId**  
ID of the requested User.

**responseFields**  
Optional array containing the fields included in the response. Please keep in mind, that the Flarum API includes several other fields you are not able to filter.

### Return Values
Returns a data object containing the requested User object.

## getAll
```php
getAll(?array $responseFields = null): object
```
Get all Users.

### Parameters
**responseFields**  
Optional array containing the fields included in the response. Please keep in mind, that the Flarum API includes several other fields you are not able to filter.

### Return Values
Returns an array containing the requested User objects.

## setGroups
```php
setGroups(int $userId, array $groupIds = null): object
```
Set Groups to a User.

### Parameters
**userId**  
ID of the User the Groups will be set to.

**groupIds**  
Optional Array containing the IDs of the Groups to set. Always set all Groups. If null is provided, all Group relations will be deleted from the User.

### Return Values
Returns a data object containing the updated User object.
