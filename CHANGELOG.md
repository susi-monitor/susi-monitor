# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased] - 
### Added

### Changed

### Removed

## [1.4.4] - 2020-06-01
### Added
- Possibility to run curl command when sending notifications instead of calling libcurl
### Changed
- Separate proxy configs for checking targets and sending notifications
- Fixed style of success message on Admin page
### Removed

## [1.4.3] - 2020-05-09
### Added

### Changed
- Add missing autoincrement in DB
### Removed

## [1.4.2] - 2020-05-09
### Added
- SQLite DB as default, acting as fallback if other DB is not set
### Changed

### Removed

## [1.4.1] - 2020-05-02
### Added

### Changed
- Fix an error in Microsoft Teams message
- Add susi-config-example.php
### Removed

## [1.4.0] - 2020-04-30
### Added
- Notifications to Microsoft Teams
### Changed
- Fixed missing first point on uptime graphs
- Fixed base_url not being set correctly
### Removed

## [1.3.1] - 2020-04-29
### Added

### Changed
- Fix base_url issue
### Removed

## [1.3.0] - 2020-04-26
### Added
- Option to mark check as failed if target doesn't reply within predefined timeout
- sorting and searching in admin list using DataTables
### Changed
- 401 and 403 HTTP codes don't fail check from now on
- move the custom configuration to `application/config/susi-config.php`
### Removed

## [1.2.0] - 2020-04-16
### Added
- Response time toggle
- Purge data endpoint
### Changed
- New colors indicators for response times
- Move contributing guidelines to `CONTRIBUTING.md`
### Removed

## [1.1.0] - 2020-04-15
### Added
- Keep response times
### Changed
- Fix redundant quotes in URL button
- Change license identifier to SPDX compliant format
- Fix missing path in header when the loaded page is other than main page
- Bring back setup.sql script
### Removed

## [1.0.0] - 2020-04-10
### Added
- Codeigniter 3 framework
### Changed
- Complete rewrite on new framework
- Now only checks from last hour are shown instead of last n checks on main page
### Removed

## [0.3.1] - 2020-03-29
### Added
- Add last 24 hr view
### Changed

### Removed

## [0.3.0] - 2020-03-29
### Added
- Admin link in footer
- Logo and favicons
### Changed
- Header and footer are now reused
- Fixed a bug which created empty categories when editing
- Back to top now uses js scroll instead of reload
### Removed

## [0.2.0] - 2020-03-29
### Added
- Basic admin panel with list/add/edit/remove targets
- Possibility to mark targets with category
- Add filter by category feature
- Basic authentication mechanism

### Changed

### Removed

## [0.1.0] - 2020-03-23
### Added
- Initial release

### Changed

### Removed

