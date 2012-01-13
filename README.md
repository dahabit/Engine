CZitDB
=========

Includes:
---------

[CodeIgniter 2.1.0](http://codeigniter.com/)

[Zend Framework 1.11](http://www.zend.com/)

[Doctrine 2.1](http://www.doctrine-project.org/)

[Twig 1.5.1](http://twig.sensiolabs.org/)

[MySQL WorkBench Exporter](https://github.com/johmue/mysql-workbench-schema-exporter)

[CI Console](https://bitbucket.org/anatooly/ciconsole)

[Twitter Bootstrap CSS v.1.4](https://github.com/twitter/bootstrap)

[Less v. 1.1.5](http://lesscss.org/)

[Twitter Bootstrap](http://twitter.github.com/bootstrap/)

[html5boilerplate](http://html5boilerplate.com)

[Modernizr](http://www.modernizr.com/)

[Google Prettify](http://code.google.com/p/google-code-prettify/)

MySQL WorkBench Exporter Console

Gravatar integration


Also used:
--------------

[Zend-CodeIgniter integration](http://www.beyondcoding.com/2008/02/21/using-zend-framework-with-codeigniter/)

[Twig-CodeIgniter integration library](https://github.com/bmatschullat/Twig-Codeigniter) (changed)

[Doctrine-CodeIgniter integration](http://wildlyinaccurate.com/integrating-doctrine-2-with-codeigniter-2/) (changed)

Documentation
===========

[Codeigniter Documentation](http://codeigniter.com/user_guide/)

[Zend Documentation](http://framework.zend.com/manual/en/)

[Doctrine documentation](http://www.doctrine-project.org/docs/orm/2.1)

[Doctrine console documentation](http://www.doctrine-project.org/docs/orm/2.1/en/reference/tools.html)

[Twig Documentation](http://twig.sensiolabs.org/)

CI Console Documentation
========================

[] — required, {} — optional, also paths can be used in names (e.g. layouts/header creates directory and view from the template).

Generate files from templates
------------------------------

	php ci create application {applicationName}

	php ci create controller [controllerName] {actionName1} {actionName2}…

	php ci create model [controllerName] {functionName1} {functionName2}…

	php ci create view [viewName1] {viewName2} {viewName3}

	php ci create helper [helperName]

Remove files
------------

	php ci remove controller [controllerName]

	php ci remove model [controllerName]

	php ci remove view [viewName]

	php ci remove helper [helperName]

Install bundles
----------------

	php ci install tankauth-1.0.9

	php ci install zend-1.11.10

	php ci bundle install hmvc

Uninstall bundles
-----------------

	php ci uninstall tankauth-1.0.9

	php ci uninstall zend-1.11.10

	php ci bundle uninstall hmvc

Bundles available
-----------------

	php ci list

	php ci bundle list

Appendix
--------

	php ci help / php ci? (read documentation)

	php readme hmvc (read a bundle readme)

	php bundle readme hmvc (read a bundle readme)
	
MySQL Workbench Console Documentation
===================================

	php mwbexport [annotation | yml] [path/to/file.mwb]


Database Installation
============

1. Create a database in MySQL WorkBench
2. Save it in .mwb format
3. Execute:

	php mwbexport [annotation|yml] path/to/file.mwb command

4. Unzip the archive and copy models to the models folder
5. Execute:

	php doctrine orm:schema-tool:create

6. Done, DB installed

License
========
Each third-party part of this software distributes under its license.
Everything else here is unlicensed.
For more information, please refer to [unilicense.org](http://unlicense.org/)

ToDo
====

Add Swift Mailer