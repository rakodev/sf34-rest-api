Offer Projects Api & Admin Panel
===

- [Api Readme](Projects/Api/)
- [Admin Readme](Projects/Admin/)

PHP Offer Demo Code
- Symfony 3.4
- Vagrant
    - [PHP 7.2 php-fpm FastCGI](Vagrant/)
- xDebug
- Mysql

## Quickstart

- Download and **Install Virtualbox**:
https://www.virtualbox.org/wiki/Downloads
- Download and **Install Vagrant**:
https://www.vagrantup.com/downloads.html
- Execute: **vagrant plugin install vagrant-hostsupdater**
- Execute: **git clone https://github.com/rakodev/sf34-rest-api.git**
- Execute: **cd sf34-rest-api/Vagrant/**
- Execute: **vagrant up**
- During the installation vagrant will ask your local root password because it wants to add some lines into your hosts file, it will remove this lines on vagrant destroy
- **That's all!** Now you can open this address on your browser:
    - [http://local.offer.admin/](http://local.offer.admin/)
- API Documentation available here:
    - [http://local.offer.api/](http://local.offer.api/)
    

### Informations
- PhpMyAdmin, You can see the Mysql Database:
    - [http://local.offer.api/phpmyadmin/](http://local.login.webserver/phpmyadmin/)
    - username: **root**
    - password: **vagrant**
- Vagrant destroy (Clear up the box)
    - Execute: vagrant destroy
