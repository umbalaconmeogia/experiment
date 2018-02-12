# Install Vagrant box CentOS7

## Initialize CentOS 7 Vagrant box

```shell
$ mkdir centos7
$ cd centos7
$ vagrant init centos/7
$ vagrant up
```

## Install vagrant-vbguest so that it can sync between the VM and windows.

[Reference](https://stackoverflow.com/questions/46318456/files-created-in-vagrant-centos-7-do-not-appear-in-windows)

## ssh into the box
```shell
$ vagrant ssh
```

## Reload provision

After update provision in Vagrantfile, reload it.

```shell
$ vagrant provision
```
