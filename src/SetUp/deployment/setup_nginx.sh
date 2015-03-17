#!/bin/sh

sudo cp server_config/local.app.conf /etc/nginx/sites-available/rendertree.dev
sudo cp server_config/local.app.conf /etc/nginx/sites-enabled/rendertree.dev
sudo /etc/init.d/nginx restart