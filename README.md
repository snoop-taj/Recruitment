# Croogo: Recruitment Plugin
Web based quiz plugin for **Recruitment** with front-end application form that sits on top of the Croogo content Management System for PHP.

It is powered by [CakePHP](http://cakephp.org) MVC Framework.

## Requirements

    * PHP 5.2 or higher.
    * MySQL 4.1 or higher.
    * Apache with mod_rewrite.

## Installation

#### Web based installer

  * Upload the .zip file through Croogo's extension manager.

#### Manual installation

  * Extract the archive. Upload the content to your Croogo installation in the ./app/Plugins/Recruitment directory.
  * Visit Croogo's extension system to "activate" the Plugin.
  * Database tables will be created after activating the Plugin.
  * You can change Email settings either from the code of RecritmentActivation class. 
```
    $controller->Setting->write('Applications.hr','Enter HR Email Address',array('description' => 'Default hr email address of the applications','editable' => 1));
    $controller->Setting->write('Applications.notification','Enter Notification Email Address',array('description' => 'Default notification email address of the applications','editable' => 1));
    $controller->Setting->write('Applications.websupport','Enter WebSupport Email Address',array('description' => 'Default website support email address of the applications','editable' => 1));
```    
or change it after activation from Recruitment Settings Croogo Backend Admin 

## Links

  * **Downloads**: [https://github.com/snoop-taj/Recruitment](https://github.com/snoop-taj/Recruitment)
  