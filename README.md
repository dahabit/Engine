CIBoilerplate
=========

Includes:
---------

[CodeIgniter 2.0.3](http://codeigniter.com/)

[Zend Framework 1.11](http://www.zend.com/)

[Doctrine 2.1](http://www.doctrine-project.org/)

[Twig 1.3](http://twig.sensiolabs.org/)

[MySQL WorkBench Exporter](https://github.com/johmue/mysql-workbench-schema-exporter)

[CI Console](https://bitbucket.org/anatooly/ciconsole)

MySQL WorkBench Exporter Console

Gravatar integration

[Twitter Bootstrap CSS v.1.4](https://github.com/twitter/bootstrap)

[Less v. 1.1.5](http://lesscss.org/)

[HTML IE Support](http://code.google.com/p/html5shim/)

Also used:
--------------

[Zend-CodeIgniter integration](http://www.beyondcoding.com/2008/02/21/using-zend-framework-with-codeigniter/)

[Twig-CodeIgniter integration library](https://github.com/bmatschullat/Twig-Codeigniter) (changed)

[Doctrine-CodeIgniter article](http://wildlyinaccurate.com/integrating-doctrine-2-with-codeigniter-2/) (changed)

[CodeIgniter MailChimp API 1.2](https://github.com/codepotato/codeigniter-mailchimp-api)

DB Installation
============

1. Create a DB in MySQL WorkBench
2. Save it in .mwb format
3. Execute:

	php [annotation|yml] path/to/file.mwb command
	
4. Unzip the archive and copy models to the models folder
5. Execute:

	php doctrine orm:schema-tool:create
	
6. Done, DB installed

Useful
===========
[Doctrine documentation](http://www.doctrine-project.org/docs/orm/2.1)

[Doctrine console documentation](http://www.doctrine-project.org/docs/orm/2.1/en/reference/tools.html)

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

Changes in CodeIgniter Core
============================

No changes yet

ToDo
====

Add Swift Mailer