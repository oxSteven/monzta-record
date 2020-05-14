# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [1.0.2] - 2020-04-24
### Fixed
- Added interface's namespace to manual for easier implementation.

## [1.0.1] - 2020-04-05
### Fixed
- `EndpointSearcher` missing inheritance of Exception class.
- `UriPathGetter` missing inheritance of Exception class.

## [1.0.0] - 2020-04-04
### Added
- `Router` main point of process. 
- `EndpointInterface` has to be implemented by all endpoint classes.
- `EndpointSearcher` helper class to search in routing table.
- `UriPathGetter` helper class to retrieve the URI path.
