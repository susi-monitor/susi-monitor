# susi-monitor
**SU**per **SI**mple uptime monitor

## What is it?
As name suggests it is a simple uptime monitoring system written in PHP.
The point is to present uptime in a clear form, together with uptime graphs, all while keeping
maximal simplicity of the software. 

For the moment it supports 2 types of checks:
- json - checks if the url presents a valid JSON response
- default - checks if the url is alive and is presenting ANY response

## Installation
1. Rename *settings-example.php* to *settings.php* and fill in your DB details.
2. Execute setup.sql on your DB to create tables and sample target.
3. Setup your cron to execute updateData.php every n minutes.

## Contributing
Only requirement is to keep PSR-12.