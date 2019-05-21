#!/bin/bash

echo "Host configuration"
echo -n "Host url: "
read host_url
echo -n "Admin email: "
read email_admin

echo "Database configuration"
echo -n "Database name: "
read db_name
echo -n "Database username: "
read db_username
echo -n "Database password: "
read db_password
echo -n "Database host: "
read db_host

mysql -u $db_username -h $db_host --password=$db_password $db_name < wordpress.sql

apt-get install wget tar nano
wget https://wordpress.org/wordpress-5.1.1.tar.gz
tar -xvzf wordpress-5.1.1.tar.gz
rm wordpress-5.1.1.tar.gz
mv -n wordpress/* ./

# Config part
echo "<?php
define('DB_NAME', '$db_name');
define('DB_USER', '$db_username');
define('DB_PASSWORD', '$db_password');
define('DB_HOST', '$db_host');
define('DB_CHARSET', 'utf8');
define('DB_COLLATE', '');" >> wp-config.php
wget -O - https://api.wordpress.org/secret-key/1.1/salt/ >> wp-config.php
echo "\$table_prefix = 'wp_';" >> wp-config.php
echo "define('WP_DEBUG', false);" >> wp-config.php
echo "if ( "'!'"defined('ABSPATH') )" >> wp-config.php
echo "    define('ABSPATH', dirname(__FILE__) . '/');" >> wp-config.php
echo "require_once(ABSPATH . 'wp-settings.php');" >> wp-config.php


mysql -u $db_username -h $db_host --password=$db_password $db_name --execute="UPDATE wp_options SET option_value = '$host_url' WHERE option_name = 'siteurl' OR option_name = 'home';"
mysql -u $db_username -h $db_host --password=$db_password $db_name --execute="UPDATE wp_options SET option_value = '$email_admin' WHERE option_name = 'admin_email' OR option_name = 'new_admin_email';"
