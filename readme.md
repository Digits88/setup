# CoreApp Setup

This requires some conventions noted below.

Pull it in via composer

~~~
composer require alfred-nutile-inc/setup
~~~

Then add it to your Kernel

~~~
	protected $commands = [
		'App\Console\Commands\Inspire',
		'AlfredNutileInc\CoreApp\SetUp\SetupCommand'
	];

~~~


Then

## Setup

Git clone the repo to your homestead

The conventions for this setup is simple

Your local domain is the same as the repo name. If the repo is foo then `foo.dev`

The Command is

~~~
php artisan core-app:setup reponame
~~~


This will

  * setup the db as the name of the reponame
  * setup nginx and restart it as the domain name says above. **You need to udpate you machine hosts file**
  * copies .env.example to .env update it as needed.
  * sets up testing stub db for sqlite
  * composer install and dump-autoload
  * migrates
  * bower install
  * npm install


You can limit what to run like this

~~~
php artisan core-app:setup reponame --run=SetupServerConfig --run=SetupFrontEnd
~~~

## Conventions

Your local env is named after the repo name and .dev so repo foo is foo.dev local

SSL is always default. https://github.com/alfred-nutile-inc/internal_practices/blob/master/ssl.md for help on this.




## Adding to the package

Just add your step to `app/SetUp/SetupCommand.php:93`
~~~
        SetupDeploymentScripts::fire($this);
        SetupEnv::fire($this);
        SetupDb::fire($this);
        RunMigrations::fire($this);
        SetupTesting::fire($this);
        SetupFrontEnd::fire($this);
        SetupServerConfig::fire($this);
~~~


## RoadMap

  * Flags to run only some/one of the steps `php artisan core-app:setup reponame --SetupEnv --SetupDevelopmentScripts`
  * Plugin steps that are part of the project and not part of this repo.
  * One command to setup Ec2, RDS etc
  * S3 setup
  * Setup git repo dev, prod, staging and delete master
 

