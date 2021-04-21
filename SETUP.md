# Set Up
This document explains the initial set up of Marathon in a technical context.

These instructions assume you are on Ubuntu Linux, but the steps will be extremely similar on other Linux distributions.

1. Install Apache if you haven't already.
    - `sudo apt install apache2`
2. Install PHP if you haven't already.
    - `sudo apt install php7.4`
3. If the PHP isn't automatically enabled, enable it.
    - `sudo a2enmod php7.4`
4. Restart Apache to ensure changes are applied appropriately.
    - `sudo apache2ctl restart`
5. Download Marathon, and copy it to you the root of your web server.
    - `mv ~/Downloads/marathon /var/www/html/`
6. Optionally, unblock Apache on your firewall.
    - `sudo ufw allow 80; sudo ufw allow 443`
7. At this point, you should be able to load Marathon by loading `http://localhost/marathon` in your browser.
