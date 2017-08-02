# FireCrew.us
## A collection of data-management & record-keeping tools for Wildland Firefighters.

[![Build Status](https://travis-ci.org/evanhsu/firecrew.svg?branch=develop)](https://travis-ci.org/evanhsu/firecrew)

### Prerequisites
Your dev machine must have the following installed in order to 'vagrant up' and build the project:

> ### Vagrant Plugins:

>> 1) vagrant-hostmanager: `$ vagrant plugin install vagrant-hostmanager`

>> 2) vagrant-vbguest: `$ vagrant plugin install vagrant-vbguest`

> ### Ansible:
> 
>> You will need ansible >= v2.2.0 to provision the vagrant machine.

### Building the project
This project is packaged with a Vagrantfile and an Ansible playbook to construct a replica of the production server environment.

1) Build the Vagrant machine - this will take about 5 minutes to complete because of the Ansible provisioning

    	$ vagrant up
    	$ vagrant ssh
    	$ sudo -iu firecrew
    	$ cd /home/firecrew/sites/firecrew.us.dev
    	$ composer install
    	$ php artisan key:generate && php artisan migrate

2) You may then run seeders if you want.  Running ALL seeders will include an ETL from an inventory v1.0 database.

        $ php artisan db:seed

3) On your HOST machine, navigate to the project folder and run:

	$ yarn
	$ yarn run watch

	
### Viewing in the browser

After building the project in your vagrant machine, you should be able to view the site in your browser at:

>http://firecrew.us.dev
