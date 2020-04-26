[![Latest release](https://img.shields.io/github/v/release/greg-olszewski/susi-monitor.svg?sort=semver)](https://github.com/greg-olszewski/susi-monitor/releases)
[![License](https://img.shields.io/github/license/greg-olszewski/susi-monitor.svg)](https://github.com/greg-olszewski/susi-monitor)

# susi-monitor
**SU**per **SI**mple uptime monitor

## What does it do?
As name suggests it is a simple uptime monitoring system written in PHP.
The point is to present uptime in a clear form, together with uptime graphs, all while keeping
maximal simplicity of the software. 

For the moment it supports 2 types of checks:
- json - checks if the url presents a valid JSON response
- default - checks if the url is alive and is presenting ANY response

## Installation
1. Rename `application/config/database-example.php` to `application/config/database.php` and fill in your DB details.
2. Execute `setup.sql` on your DB to create tables and sample target.
3. Setup your cron to call `https://YOUR_URL/data/update` every n minutes.
4. (optional) Customizations (like custom title, User-Agent or proxy data) in `config/susi-config.php`

## Administration
Admin panel link in footer. Default password is **admin**

---
Notes on used libraries etc. - see `LEGAL.md` file.