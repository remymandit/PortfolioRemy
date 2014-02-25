PortfolioRemy
========================

This project is fully powered by Symfony 2.4

[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/remymandit/PortfolioRemy/badges/quality-score.png?s=9c55b9bccc956b73c2af71e15a59b44e46760721)](https://scrutinizer-ci.com/g/remymandit/PortfolioRemy/)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/0c198ee7-5566-43d4-8168-9daa8174db34/mini.png)](https://insight.sensiolabs.com/projects/0c198ee7-5566-43d4-8168-9daa8174db34)

## My configurations :


* Xampp 1.8.3
* PHP 5.5.3
* Apache 2.4.4
* MySql 5.6.11

Do not forget to configure PHP on your server.

To turn a Symfony2 project you must make the following changes in the php.ini file :

    [Date]
    date.timezone=Europe/Paris

    [intl]
    intl.error_level=E_WARNING
    extension=php_intl.dll


Installation
----------------------------------


### Composer


To install the necessary dependencies, download [Composer](https://getcomposer.org/) 
and run the following command:

    php composer.phar install


### Configuration


Customize your configuration file in the app/config/parameters.yml with your 
database and your smtp settings for sending mail.

To create the database run the following command:

    php app/console doctrine:database:create

Then to generate the tables and schema:

    php app/console doctrine:schema:update --force


### Assetic


The application uses uglifycss and uglify-js libraries, we must 
download [NodeJs](http://nodejs.org/).
And run the command:

    php app/console assetic:dump --env=prod --no-debug


Dependencies
---------------


The application contains the following bundles:

  * **friendsofsymfony/user-bundle** - User Management

  * **winzou/console-bundle** - Access to the console on the server

  * **jms/security-extra-bundle** - Secure access to certain pages with annotations
