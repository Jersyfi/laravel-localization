# Changelog

All notable changes to `laravel-localization` will be documented in this file

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