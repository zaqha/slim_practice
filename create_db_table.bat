@echo off
php vendor/bin/phoenix cleanup
php vendor/bin/phoenix migrate 
pause