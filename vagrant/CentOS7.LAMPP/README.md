# Install Vagrant box CentOS7

## Overview
This is Vagrant file to

* Create a CentOS 7 machine with Apache, MySQL, Postgres, PHP installed.
* Make the /vagrant directory on the CentOS guest synchronize with the Vagrant directory on the Windows host.
* Set the port forwarding so that you can access to Apache web server on the CentOS guest from the Windows host (by access to http://localhost:8080 for example)
* On the CentOS guest, make the apache web root directory (`/var/www/html`) link to `/vagrant` so that you can easily update the web content by modify file on Windows host.

Other note

* This file is tested on Windows 10 host with Oracle Virtual Box.
* To make CentOS 7 box synchronize with Windows, you need install plugin vagrant-vbguest.
* In this document, command run on Windows is started with `>`, and command run on CentOS is started with `$`.

## Create CentOS 7 Vagrant box

* Download [Vagrantfile](./Vagrantfile), save it into a directory.
* Go to that directory and install vagrant-vbguest plugin.
```shell
> vagrant plugin install vagrant-vbguest
```
* Vagrant up. This will create the Vagrant box and install LAMP.
```shell
> vagrant up
```

## Disable SELinux

* ssh into Vagrant box, configure `SELINUX=disabled` in the `/etc/selinux/config` file.
```shell
> vagrant ssh
```
* Reboot your system by logout the Vagrant box and run
```shell
> vagrant reload
```
* After reboot, ssh into Vagrant box, confirm that the `getenforce` command returns `Disabled`.
```shell
> vagrant ssh
$ getenforce
Disabled
```

## Reset MySQL password

* Get the temporary password of `root@localhost` account
```shell
$ sudo grep 'temporary password' /var/log/mysqld.log
```
* Use this password to login to MySQL
```shell
$ mysql -u root -p
```
* Change root password
```
> ALTER USER 'root'@'localhost' IDENTIFIED BY 'MyNewPass4!';
```
* Clear root password <aside class="warning">(use this for development environment only)</aside>
```
> UNINSTALL PLUGIN validate_password;
> ALTER USER 'root'@'localhost' IDENTIFIED BY '';
```

## Another command

### ssh into the Vagrant box
```shell
> vagrant ssh
```

### Reload provision (when update provision in Vagrantfile)
```shell
> vagrant provision
```