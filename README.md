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

Do not forget to configure PHP on your computer.

To turn a Symfony2 project you must make the following changes in the php.ini file :

    [Date]
    date.timezone=Europe/Paris

    [intl]
    intl.error_level=E_WARNING
    extension=php_intl.dll


And for PHP >=5.5.0 you must enable and configurate OPcache by adding this code to php.ini

    [OPcache]
    zend_extension = "C:\xampp\php\ext\php_opcache.dll"
    opcache.memory_consumption=128
    opcache.interned_strings_buffer=8
    opcache.max_accelerated_files=4000
    opcache.revalidate_freq=60
    opcache.fast_shutdown=1
    opcache.enable_cli=1