Covoiturage-libre.fr
####################

covoiturage-libre is an open source carpooling website in PHP.

Getting started
===============

To install the website, just clone this repository on your computer and point
your webserver to it.

Then, you will need to edit `Connections/covoiturette.php.default` with your
configuration options and save it to `Connections/covoiturette.php`

Create the database::

    mysql --user youruser --password
    mysql> CREATE DATABASE covoiturette

... and import the tables::

    mysql --user root --password -p covoiturette < ../trajets.sql
    mysql --user root --password -p covoiturette < ../villes.sql
    mysql --user root --password -p covoiturette < ../trajets_ws.sql
    mysql --user root --password -p covoiturette < ../villes_ws.sql

Make it run
===========

You can also import them manually into PHPMyAdmin if you want to.

Make it run on NGINX, for instance, by doing it like this::

    # /etc/nginx/sites-enabled/coivoiturage-libre.fr 
    server {
        server_name covoiturage-libre.local;
        set $path /home/alexis/dev/php/covoiturage-libre/;
        root   $path;

        location / {
            index  index.php;
        }

        location ~* ^.+.(jpg|jpeg|gif|css|png|js|ico|xml)$ {
          access_log        off;
          expires           30d;
        }

        location ~ .php$ {
            fastcgi_param  SCRIPT_FILENAME  $path$fastcgi_script_name;
            fastcgi_pass   php_backend;
            include fastcgi_params;
        }

    }
    upstream php_backend {
            server 127.0.0.1:9000;
    }
