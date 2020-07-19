# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [2.0.4] - 2020-07-19
### Fixed
- `CacheHandler` always empty result due to a bug in tag gambit negation.

## [2.0.3] - 2020-07-08
### Added
- `footer.tpl` new service *CONVYI* to *Tools*.

## [2.0.2] - 2020-06-15
### Fixed
- `CacheHandler` excluded tags *anno* and *rule*.

## [2.0.1] - 2020-06-15
### Removed
- `callCacheVerification.js` no more part of caching mechanism.
- `head.tpl` AJAX call from old caching mechanism.

## [2.0.0] - 2020-06-15
### Changed
- `RecordListController` cache call (method name).
- `CacheHandler` complete refactoring of caching mechanism.
- Textual improvements.

### Removed
- `CacheUpdateCaller` no more part of caching mechanism.

## [1.0.4] - 2020-06-01
### Changed
- `filter.json` filter configuration.
- `FilterHandler` new filter group added.

## [1.0.3] - 2020-05-23
### Fixed
- Improved texts.

## [1.0.2] - 2020-05-17
### Changed
- Updated to PAGYI 1.0.2.

## [1.0.1] - 2020-05-17
### Changed
- `recordList.tpl` target of proof link to _blank.

## [1.0.0] - 2020-05-17
### Added
- `HomeController` renders the home page using PAGYI.
- `FilterListController` renders the filter list.
- `RecordListController` renders the record list.
- `CacheHandler` reads, writes and updates the cache file.
- `FilterHandler` handles the selected filters.
- `FilterListReader` reads the filter list configuration.
- `TagListReader` reads the tag list configuration.
- `CacheUpdateCaller` called by AJAX to verify cache lifetime.
- `Record` represents a record entry.
- `Bootstrap` bootstraps the page.
- `head.tpl` HTML head element.
- `header.tpl` header section with main start.
- `filterList.tpl` filter list layout.
- `recordList.tpl` record list layout.
- `content.tpl` content section with main end.
- `footer.tpl` shared footer used on most MONZTAnetwork pages.
- `callCacheVerification.js` AJAX call to update cache.
