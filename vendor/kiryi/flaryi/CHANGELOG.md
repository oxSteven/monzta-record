# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [1.1.0] - 2020-05-03
### Fixed
- `Endpoint` pagination setter.
- `User` pagination added to really get all Users.
- `Discussion` pagination added to really get all Discussions.
- `Post` pagination added to really get all Posts.
- Therefore response of getAll() changed from object to array.

## [1.0.0] - 2020-04-24
### Added
- `Client` starting point. Initialization and endpoint call.
- `Endpoint` abstract class all endpoints inherit from. Provides several general endpoint functions.
- `User` the User endpoint.
- `Discussion` the Discussion endpoint.
- `Post` the Post endpoint.
- `Tag` the Tag endpoint.
- `data.json` the JSON body of the typical data object.
- `discussionCreate.json` the JSON body of the create Discussion action.
- `postCreate.json` the JSON body of the create Post action.
- `userSetGroups.json` the JSON body of the setGroup User action.
