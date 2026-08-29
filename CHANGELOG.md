# Changelog

All notable changes to this package are documented here.

## [0.1.0] - 2026-08-29

Initial release.

### Added

- Migration overview dashboard — status, file, and type at a glance.
- Multi-connection support — track migrations across more than one database connection.
- Run migrations from the dashboard, individually or all pending at once.
- Automatic sync job (every 30 minutes) plus an on-demand sync endpoint.
- Migration lifecycle tracking via Laravel's native migration events.
- Gate-based access control (`viewStrat`) for the dashboard routes.
