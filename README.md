# Ravel

#### STATUS: UNDER DEVELOPMENT

## CMS Package for Laravel 4

### How to Install

- Install L4 App from Github ( Watch this if you need to know how : http://net.tutsplus.com/tutorials/php/how-to-setup-laravel-4/)
- Modify Laravel 4 App Composer.json file as below

```php
{
	"require": {
		"laravel/framework": "4.0.*",
		"raftalks/ravel": "*"
	},
	"autoload": {
		"classmap": [
			"app/commands",
			"app/controllers",
			"app/models",
			"app/database/migrations",
			"app/database/seeds",
			"app/tests/TestCase.php"
		]
	},
	"minimum-stability": "dev"
}

```

- Add Ravel Service Provider to the app/config/app.php file under the array key "providers" as shown below

```php

'providers' => array(
		
		'Raftalks\Ravel\RavelServiceProvider',

)

```
- Configure your database settings in the L4 app/config/database.php file
- Open your terminal in the L4 App root directory and run composer update command
- And run the following command in the terminal to start installing the CMS package

```
 php artisan ravel:install
```

- The above command will publish all the assets and run the migration and seeds
- Before installing Ravel CMS, you may want to do some configuration changes like setup a username and password, look inside Vendor/Raftalks/Ravel/src/config/app.php file, by default the username is admin and password is ravel.

- By default the CMS admin panel is available on http://www.domain.com/admin and you can change the base url to admin panel by changing the app config file of the package.

Documentation will be updated soon