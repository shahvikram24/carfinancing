<?php

		if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] == "carfinancing.help" || $_SERVER['SERVER_NAME'] == "www.carfinancing.help"))
		{
			define('APPROOT', 'http://www.carfinancing.help/');
			define('SITEURL', 'http://www.carfinancing.help/');
			define('WEBROOT', '/var/www/vhosts/carfinancing/httpdocs/');
			define('SERVERIPADDRESS', '64.13.227.235');
		}
		else if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] == "carfinancing.vstudiozzz.com"))
		{
			define('APPROOT', 'http://carfinancing.vstudiozzz.com/');
			define('SITEURL', 'http://carfinancing.vstudiozzz.com/');
			define('WEBROOT', '/var/www/vhosts/vstudiozzz.com/carfinancing.vstudiozzz.com/');
			define('SERVERIPADDRESS', '64.13.227.235');
		}
		else
		{
			define('APPROOT', 'http://localhost/carfinancing/');
			define('SITEURL', 'http://localhost/carfinancing/');
			define('WEBROOT', 'C:/AppServ/www/carfinancing/');
			define('SERVERIPADDRESS', '192.168.1.79');
		}

		define('APPLICATIONREQUIREROOT', WEBROOT."lib/");
		define('ADMINAPPROOT', APPROOT."login/");

		define('AFFILIATEURL', APPROOT."affiliate/");
		define('LEADASSIGNURL', APPROOT."leads/");
		define('SALESURL', APPROOT."sales/");
		

		define('ADMINEMAIL', 'shahvikram24@gmail.com');
		define('UPLOAD_DIR', WEBROOT. 'applications/');
?>