# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/) 
and this project adheres to [Semantic Versioning](http://semver.org/).

## [6.0.1] - 2019-03-24
### Fixed
- Error on throw `InvalidArgumentException` inside other namespace [#79]
- Added php7.3 to travis

## 6.0.0 - 2018-12-24
This library was rewritten and a lot of breaking changes were included.

### Added
- This changelog

### Changed
- Minimum requirement is `php >= 7.1`
- Use of `symfony/validator` to validate the values
- Removed a lot of logic and html features. Focus only in inputs and data structure.
- Better error messages and easy to customize and translate
- Replaced jQuery inspired API for a DOM inspired API. For example, use `$input->getAttribute()` and `$input->setAttribute()` instead `$input->attr()`.
- Removed magic methods to add attributes in benefit of magic properties. For example, instead `$input->required()`, use `$input->required = true` or `$input->setAttribute('required', true)`.
- Added the ability of define label and properties in the input constructors. For example: `F::text('Write your name', ['required'])` instead `F::text()->label('Write your name')->required()`

[#79]: https://github.com/oscarotero/form-manager/issues/79

[6.0.1]: https://github.com/oscarotero/form-manager/compare/v6.0.0...v6.0.1
