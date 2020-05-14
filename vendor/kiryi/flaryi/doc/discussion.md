# FLARYI Endpoint Documentation *Discussion*

This document describes the possible actions performable on the `Discussion` Endpoint.

## get
```php
get(int $discussionId, ?array $responseFields = null): object
```
Get a Discussion by its ID.

### Parameters
**discussionId**  
ID of the requested Discussion.

**responseFields**  
Optional array containing the fields included in the response. Please keep in mind, that the Flarum API includes several other fields you are not able to filter.

### Return Values
Returns a data object containing the requested Discussion object.

## getAll
```php
getAll(?array $responseFields = null, ?string $filter = null): object
```
Get all Discussions.

### Parameters
**responseFields**  
Optional array containing the fields included in the response. Please keep in mind, that the Flarum API includes several other fields you are not able to filter.

**filter**  
Optional search query (like in the actual Flarum frontend) to prefilter the results.

### Return Values
Returns an array containing the requested Discussion object(s).

## getByTitle
```php
getByTitle(string $discussionTitle, ?array $responseFields = null, ?string $filter = null): object
```
Get a Discussion by its title.

### Parameters
**responseFields**  
Optional array containing the fields included in the response. Please keep in mind, that the Flarum API includes several other fields you are not able to filter.

**filter**  
Optional search query (like in the actual Flarum frontend) to prefilter the results.

### Return Values
Returns a data object containing the requested Discussion object(s).

## create
```php
create(string $title, string $content, ?array $tagIds = null): object
```
Creates a Discussion.

### Parameters
**title**  
Title of the new Discussion.

**content**  
Content of the new Discussion.

**tagIds**  
Optional array containing the ID(s) of the Tags added to the new Discussion.

### Return Values
Returns a data object containing the newly created Discussion object.
