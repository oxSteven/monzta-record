# Kiryi's FLARYI
A [Flarum](https://flarum.org/) API client.

## Installation
```bash
composer require kiryi/flaryi
```

## Usage
First [initialize](#initialization) the client in one of two possible ways. Then call an [available Endpoint](#available-endpoints) and perform a method associated with it. You will get the response from Flarum's API as a return and may use it in your further logic.

## Constructor Definition

```php
__construct(string $filepath = null)
```
### Parameters
**filepath**  
Optional filepath relative your project's root directory to a custom configuration INI file. If nothing is provided, default (*config/flaryi.ini*) is used ([more information](#initialization)). 

## Method Definition *call*
```php
call(string $endpoint): object
```
Assigns a variable to the view's data object.
### Parameters
**endpoint**  
One of the available [Endpoints](#available-endpoints).

### Return Values
Returns the Endpoint you can then perform one of its associated methods.

## Initialization
You have to provide the client at least two mandatory parameters you can must define in a custom configuration INI file or use the default one.

**apiUrl**  
The URL of your Flarum's API. Usually it is `{YOURFLARUMDOMAIN}/api`.

**apiKey**  
A API key from your Flarum installation. Currently you have to manually create a 40 character long random string and put it directly into your Flarum's databse *api_keys* table *key* column together with an User ID to the *user_id* column. The User ID depends on the actions you want to perform. If you want to use every possible API Call, use an Administrator User. If not, you can create a role in your Flarum's administration area with the prefered rights.

Wheter you use a custom or the default file, the contens have to be:
```ini
[flaryi]
apiUrl = {URLTOYOURFLARUMAPI}
apiKey = {APIKEYFROMYOUFLARUMINSTALLATION}
```
The default filepath is *config/flaryi.ini*. If you want to use a custom filepath, you have to provide it to the [constructor](#constructor-definition) of the client. The path is relative to your project's root directory.

## Available Endpoints
The Flarum API provides some Endpoint you can perform several actions on it. FLARYI covering only some Endpoints and each Endpoint only provides some available methods to perform (actions).

Currently available Endpoints:
- [Discussion](doc/discussion.md)
- [Post](doc/post.md)
- [User](doc/user.md)
- [Tag](doc/tag.md)

## Example
*configuration/config.ini*
```ini
[flaryi]
apiUrl = https://flaryi-flarum.com/api
apiKey = qwe147asd258yxc369rtz123fgh456vbn789ui
```
*src/Controller/UserListController.php*
```php
$client = new \Kiryi\Flaryi\Client('configuration/config.ini');
$userList = $client->call('User')->getAll([
    'username',
    'email',
]);
```
will save an object to `$userList` containing all Users of your Flarum. The User objects containg an ID (always), the requested fields *username* and *email* as well as some other information the API provides. Please keep in mind, that not everything can be filtered with an API Call, but you can use the received User list to perform more filtering and e.g. following API Calls like so:  

*src/Controller/UserGroupController.php*
```php
$user = $client->call('User')->get(5);
if (isset($user->data->relationships->groups->data[0]->id)) {
    $client->call('User')->setGroups(5, [2, 3]);
    echo 'User was added to Group 2 and 3.';
} else {
    echo 'User is already in a Group.';
}
```
This script
- Gets User with ID 5 through an API Call
- Checks if the User has a Group
- If yes, nothing will be changed
- If no, Group 2 and 3 is set to the User through a second API call
