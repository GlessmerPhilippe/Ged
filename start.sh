#!/bin/bash

# Va dans le dossier du projet Symfony
cd /var/www/html/app

# Lancer le serveur web PHP en exposant sur 0.0.0.0:8000
php -S 0.0.0.0:8000 -t public
y
