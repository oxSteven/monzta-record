# FLARYI Endpoint Documentation *Post*

This document describes the possible actions performable on the `Post` Endpoint.

## get
```php
get(int $postId, ?array $responseFields = null): object
```
Get a Post by its ID.

### Parameters
**postId**  
ID of the requested Post.

**responseFields**  
Optional array containing the fields included in the response. Please keep in mind, that the Flarum API includes several other fields you are not able to filter.

### Return Values
Returns a data object containing the requested Post object.

## getAll
```php
getAll(?array $responseFields = null, ?string $filter = null): object
```
Get all Posts.

### Parameters
**responseFields**  
Optional array containing the fields included in the response. Please keep in mind, that the Flarum API includes several other fields you are not able to filter.

**filter**  
Optional search query (like in the actual Flarum frontend) to prefilter the results.

### Return Values
Returns an array containing the requested Post object(s).

## create
```php
create(string $userId, string $discussionId, string $content): object
```
Creates a Post.

### Parameters
**userId**  
ID of the User the new Post will be written by.

**discussionId**  
ID of the Discussion the new Post will be added to.

**content**  
Content of the new Post.

### Return Values
Returns a data object containing the newly created Post object.
