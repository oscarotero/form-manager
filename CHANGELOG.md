# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/)
and this project adheres to [Semantic Versioning](http://semver.org/).

## [6.1.2] - 2021-07-19
### Added
- Added support for PHP 8

## [6.1.1] - 2021-01-13
### Fixed
- Inputs with `multiple` attribute needs to force an array by appending a `[]` to the name [#89]

## [6.1.0] - 2020-11-14
### Added
- Some phpdoc annotations to help IDEs [#81]
- Elements that can contain options (`Select`, `Datalist`) have the `setOptgroups` method to define the optgroups.
- The method `setOptions` can assing other attributes to the options [#83]
  ```php
  $select->setOptions([
    'value1' => [
        'label' => 'Value label',
        'disabled' => true
    ]
  ])
  ```

### Removed
- BREAKING: Ability to add optgroups with the `setOptions` method of select and datalist elements. Use `setOptgroups` instead

### Fixed
- Validate step attribute with decimal values [#87]

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
[#81]: https://github.com/oscarotero/form-manager/issues/81
[#83]: https://github.com/oscarotero/form-manager/issues/83
[#87]: https://github.com/oscarotero/form-manager/issues/87
[#89]: https://github.com/oscarotero/form-manager/issues/89

[6.1.2]: https://github.com/oscarotero/form-manager/compare/v6.1.1...v6.1.2
[6.1.1]: https://github.com/oscarotero/form-manager/compare/v6.1.0...v6.1.1
[6.1.0]: https://github.com/oscarotero/form-manager/compare/v6.0.1...v6.1.0
[6.0.1]: https://github.com/oscarotero/form-manager/compare/v6.0.0...v6.0.1
