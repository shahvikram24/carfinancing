Changes: 
=========================
	- config/db.php:5 (changed database name to carfinancing);
	- config/web.php:53 ( changed rules to use the affiliate code in urls );
	- created: models/AffiliateTransaction.php
	- created: models/Affiliate.php;
	- created: models/Contact.php;
	- changed models/Application.php:44 to use the table contact for admin;
	- changed controllers/SiteController.php
	- changed tabase structure: carfinancing.sql

Remove 'web/' from url
============================
 	- in your hosting cpanel you have to set the root directory to the web folder and this will solve your problem;
 	- installing Yii2 on shared hosting is a problem and you can check few examples if will work for you: 
 		 - http://www.yiiframework.com/wiki/827/how-to-install-yii-2-advanced-on-a-shared-hosting-environment/;
 		 - http://www.yiiframework.com/doc-2.0/guide-tutorial-shared-hosting.html;
 		 - https://yii2-framework.readthedocs.io/en/stable/guide/tutorial-shared-hosting/;
