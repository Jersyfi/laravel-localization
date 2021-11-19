# Changelog

All notable changes to `laravel-localization` will be documented in this file

## 2.1.0 - 2021-11-19
- Added query string to the localized route
- Changed documentation

## 2.0.1 - 2021-11-04

- Fixed wrong migration file path in service provider
- Fixed wrong namespace in middleware

## 2.0.0 - 2021-11-04

- Added middleware to save changing language to users database table
- Added Function to check if the users database table is corrupted
- Changed Service provider to push middleware
- Changed documentation

## 1.8.2 - 2021-03-03

- Suggest to use spatie/laravel-translatable

## 1.8.1 - 2021-03-03

- `Localization::currentRouteURL()` minimized by calling `Localization::currentRouteLocaleURL`

## 1.8.0 - 2021-03-03

- `Localization::currentRouteURL()` to get the current route url
- changed private functions to protected
- changed function descirptions

## 1.7.1 - 2021-02-23

- Edited the docuemntation helper functions with useful examples
- Dreamed of falling back to the year 2020 in here

## 1.7.0 - 2021-02-19

- Added `Localization::getLocalesWithoutCurrent` for language switcher
- Edited the Docuemntation

## 1.6.0 - 2021-02-18

- Added `Localization::getLocaleSlug` to replace seperator

## 1.5.1 - 2021-02-18

- Edited `composer.json` invalid version constraint

## 1.5.0 - 2021-02-18

- Added config value `localization.redirect_default`
- Edited `Localization::localeIsValid()` to pass multiple locales at once
- Edited `Localization::localesHasDefaultLocale()`
- Edited Middleware `Locale` to redirect default locale when requested locale not found

## 1.4.0 - 2021-02-18

- Removed HasExceptions
- Added `default_locale` to config localization
- Added `Localization::getLocalesWithoutDefault()`
- Added `Localization::currentRouteDefaultLocaleURL()`
- Edited Exceptions UnsupportedLocale and LocalesNotDefined
- Edited `Localization::getDefaultLocale()`
- Edited `Localization::configHasLocales()` to private function
- Edited `Localization::localesHasDefaultLocale()` to private function

## 1.3.0 - 2021-02-17

- Removed Installation Commands
- Removed Exceptions from Service Provider
- Added Exceptions to Localization
- Added Functions to Localization
- Edited Middleware

## 1.2.1 - 2021-02-16

- Added Installation command
- Exception fix

## 1.1.0 - 2021-02-16

- Added Facade `Localization`
- Added Exceptions for checking `configHasLocales` and `LocaleInLocales`

## 1.0.0 - 2021-02-16

- Initial release
