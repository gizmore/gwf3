sudo chmod a+x "$(pwd)/www"
sudo sudo chmod -R 0777 "$(pwd)"
sudo rm -rf /var/www/html
sudo ln -s "$(pwd)/www" /var/www/html
sudo a2enmod rewrite
echo 'error_reporting=0' | sudo tee /usr/local/etc/php/conf.d/no-warn.ini
sudo cp /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini
# add exec,system,passthru,pcntl_exec,proc_open,shell_exec,popen,link to disable_functions
sudo sed -i 's/disable_functions =/disable_functions = exec,system,passthru,pcntl_exec,proc_open,shell_exec,popen,link/g' /usr/local/etc/php/php.ini
sudo apache2ctl start