# Search Filter Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/) and this project adheres to [Semantic Versioning](http://semver.org/).

## 1.0.6 - 2020-03-15
- Default category element search to and operator
- Passed pre-filter variables in the setup template.

## 1.0.5.1 - 2020-03-02
- Removed with variants to allow getVariants call to different siteIds.

## 1.0.5 - 2020-02-29
- Created item event hook that allows plugin customization to modify the search and item results from ajax.

## 1.0.4 - 2020-02-25
- Fixed issue cannot find included templates after super filter twig function is called by adding close twig function.

## 1.0.3 - 2020-02-25
- Added support for multi-site by filtering items based on the current site.

## 1.0.2.1 - 2020-02-23
- Fixed product element getting wrong sort options

## 1.0.2 - 2020-02-22
- Allows setup template to input pre defined filtered items to display, by adding `craft.superFilter.setup` 
second parameter to get pre filtered items on the item list display.

## 1.0.0 - 2020-02-19
### Added
- Initial release






