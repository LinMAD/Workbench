## Summary
Vagrant-symfony3 is created out of php7dev [Vagrant image](https://atlas.hashicorp.com/rasmus/boxes/php7dev) and was modified to setup Symfony3.

## Installation

Download and install [Virtualbox](https://www.virtualbox.org/wiki/Downloads)

Download and install [Vagrant](https://www.vagrantup.com/downloads.html)

If you are on Windows, download and install [Git](https://git-scm.com/download/win)

```
$ git clone https://seqq86@bitbucket.org/seqq86/vagrant-symfony3.git
...
$ cd vagrant-symfony3
...
$ vagrant up
...
$ vagrant ssh
...
$ newphp 70
...
cd /vagrant/scripts/ && sudo ./create-symfony3-app.sh php7symfony
```

Add this to your hosts file:

```
192.168.7.7 php7symfony
```

At this point you should be able to point your  browser at:

```
http://php7symfony/app_dev.php
```
