# Read Book

## Prerequisites
Have a machine with Git, PHP and a MySQL database installed. 
The current system has been tested with PHP 7.0.33 and MariaDB 10.2.23.         
For the manual installation you also need package `wget` and `tar`.  To install them (on debian/ubuntu):
```
apt-get install wget tar nano
```

## Install
Clone repository and launch install script:
```
git clone https://github.com/areynoua/readbooks.git
cd readbooks/
sudo bash install.sh
```


## Manual Installation
These instructions were written to be able to be executed on an ubuntu machine. Commands should be 
equivalent for similar distributions, such as Debian.

- Clone git repository to implement own code          
    ```
    git clone https://github.com/areynoua/readbooks.git
    cd readbook
    ```
- Download and uncompress WordPress 5.1.1            
    ```
    wget https://wordpress.org/wordpress-5.1.1.tar.gz
    tar -xvzf wordpress-5.1.1.tar.gz
    ```
- Move WordPress code to custom code folder
    ```
    mv -n wordpress/* ./
    ```
- Copy `wp-config-sample.php` to `wp-config.php` and edit it to store the different 
    connection information to your database.           
    ```
    cp wp-config-sample.php wp-config.php
    nano wp-config.php
    ```
    You need to use custom salt that you can generate here: https://api.wordpress.org/secret-key/1.1/salt/
- Import saved database to your own database
    ```
    mysql -u <username> -p <database name> < wordpress.sql
    ```
- You must change some parameters in the database.
    * The webiste url:
    ```SQL
    UPDATE wp_options 
    SET option_value = '<host>'
    WHERE option_name = 'siteurl' OR option_name = 'home';

    UPDATE wp_posts 
    SET guid = REPLACE(meta_value, 'http://readbook.ddns.net', '$host_url');

    UPDATE wp_postmeta 
    SET meta_value = REPLACE(meta_value, 'http://readbook.ddns.net', '$host_url');
    ```
    * The owner email address
    ```SQL
    UPDATE wp_options 
    SET option_value = '<admin email>' 
    WHERE option_name = 'admin_email' OR option_name = 'new_admin_email';
    ```
    * The ReCaptcha key (check here: https://www.google.com/recaptcha/admin/ )
    ```SQL
    UPDATE wp_options
    SET option_value = '<site key>'
    WHERE option_name = 'user_registration_integration_setting_recaptcha_site_key';

    UPDATE wp_options
    SET option_value = '<secret key>'
    WHERE option_name = 'user_registration_integration_setting_recaptcha_site_secret';
    ```