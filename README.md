# WP Bootstrap Nav Walker

A WordPress Nav Walker to implement Bootstrap navbars.

* * *

## Requirements

* PHP 5.4+
* WordPress 4.4+

## Installation

Easy installation with [Composer](https://getcomposer.org/).

````
composer require indigotree/wp-bootstrap-nav-walker
````

## Usage (Bootstrap 3)

Update `wp_nav_menu()` to use the `IndigoTree\BootstrapNavWalker\Three\WalkerNavMenu` walker. For example:

````
<?php

wp_nav_menu([
    'theme_location' => 'primary',
    'depth' => 2,
    'container' => 'div',
    'container_class' => 'collapse navbar-collapse',
    'container_id' => 'primary-navbar-collapse'
    'menu_class' => 'nav navbar-nav',
    'fallback_cb' => '__return_empty_string',
    'walker' => new \IndigoTree\BootstrapNavWalker\Three\WalkerNavMenu()
]);
````

## Usage (Bootstrap 4)

Update `wp_nav_menu()` to use the `IndigoTree\BootstrapNavWalker\Four\WalkerNavMenu` walker. For example:

````
<?php

wp_nav_menu([
    'theme_location' => 'primary',
    'depth' => 2,
    'container' => 'div',
    'container_class' => 'collapse navbar-collapse',
    'container_id' => 'primary-navbar-collapse'
    'menu_class' => 'navbar-nav',
    'fallback_cb' => '__return_empty_string',
    'walker' => new \IndigoTree\BootstrapNavWalker\Four\WalkerNavMenu()
]);
````

## License

The MIT [License](LICENSE.md) (MIT).
