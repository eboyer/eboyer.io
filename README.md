## madcity.gg

This repo serves as the Vagrantfile, WordPress installation and contains all the theme files as well as plugins for the Mad City website.

### Environment Setup

Download [Vagrant](https://www.vagrantup.com/downloads.html)

Download [Virtual Box](https://www.virtualbox.org/wiki/Downloads)

We're using [Scotch Box](http://box.scotch.io/) for the fully configured Vagrant box. The first thing you're going to do is set that up.

```bash
$ cd [SITE DIRECTORY]
$ git clone git@github.com:madcitygg/madcity.gg.git
$ cd madcity.gg
$ vagrant up
```

### If you get the error:

The box 'scotch/box' could not be found or
could not be accessed in the remote catalog. If this is a private
box on HashiCorp's Atlas, please verify you're logged in via
`vagrant login`. Also, please double-check the name. The expanded
URL and error message are shown below:

*Try this* (don't do the `vagrant login` as it describes):
[http://stackoverflow.com/questions/40473943/vagrant-box-could-not-be-found-or-could-not-be-accessed-in-the-remote-catalog](http://stackoverflow.com/questions/40473943/vagrant-box-could-not-be-found-or-could-not-be-accessed-in-the-remote-catalog)

### Local MySQL Database Access

You'll need to access the MySQL DB in the Vagrant Machine. The easiest way to connect, add, and manage databases is to use [Sequel Pro](https://www.sequelpro.com/)

```
| Database Name | [Create One] |
| Database User | root |
| Database Password | root |
| Database Host | localhost |
| SSH Host | 192.168.33.15 |
| SSH User | vagrant |
| SSH Password | vagrant |
```

*The other key item that you'll need in order to contribute to the Mad City DB is our WP Table Prefix. For security reasons, this will be hidden from the public repo.
