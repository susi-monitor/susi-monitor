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
Rename settings-example.php to settings.php and fill in your DB details.
Execute setup.sql on your DB to create tables and sample target.
Setup your cron to execute updateData.php every n minutes.