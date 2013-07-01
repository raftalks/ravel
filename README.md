# Ravel

#### STATUS: UNDER DEVELOPMENT

### RavelCMS Ver 1 is getting ready to be released.
- I am planning to change the whole design of the admin panel soon.
- Here is a preview of the new design.
![Screenshot](http://screencloud.net/img/screenshots/4a01c549ab3d3854e26eba0888fc2e2d.png)

## CMS Package for Laravel 4

![Screenshot](http://screencloud.net/img/screenshots/307e79230eeb5085677d7fc260dfc05f.png)

### How to Install

- Install L4 App from Github ( Watch this if you need to know how : http://net.tutsplus.com/tutorials/php/how-to-setup-laravel-4/)
- In your app composer.json file, add:

```php
	"require": {
		"raftalks/ravel": "*"
	}
```

- Configure your database settings in the L4 app/config/database.php file
- Open your terminal in the L4 App root directory and run `php composer.phar update` command
- Add Ravel Service Provider to the app/config/app.php file under the array key "providers" as shown below

```php

'providers' => array(
		
		'Raftalks\Ravel\RavelServiceProvider',

)

```
- And run the following command in the terminal to start installing the CMS package

```
 php artisan ravel:install
```

- The above command will publish all the assets and run the migration and seeds
- Before using Ravel CMS, you may want to do some configuration changes like setup a username and password, look inside vendor/raftalks/ravel/src/config/app.php file, by default the username is "admin" and password is "ravel".

### How to update the package
- Use the following composer update command to download the updates 
```
php composer.phar update
```
- and after downloading the updates, run the following artisan command to make sure migrations and package assets gets updated
```
php artisan ravel:update
```

### Setting up custom fields to Post and Page
- Check the config file under the package path app/config/packages/raftalks/ravel/content.php
```php
'custom_fields' => array(

			//'example'
			//'post'		=> array(
							// 		"{metakey}" => array('label'=>'{name}','type'=>'{text}', 'attr'=>array(), 'options'=>array())
							// )

			'post'			=> array(
								'somefield' => array('label'=>'custom field','type'=>'input_checkbox'),
								'custom_field3' => array('label'=>'custom field','type'=>'ng_datepicker'),
								'custom_field2' => array('label'=>'custom field2','type'=>'select','options'=>array(1=>'test',2=>'two',3=>'three',4=>'four'))
								),

			'page'			=> array(),

			'attachement'	=> array(),

		),
```

### Admin Panel
- By default the CMS admin panel is available on http://www.domain.com/admin and you can change the base url to admin panel by changing the app config file of the package.

Documentation will be updated soon
