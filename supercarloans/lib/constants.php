<?php

		if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] == "supercarloans.ca" || $_SERVER['SERVER_NAME'] == "www.supercarloans.ca"))
		{
			define('APPROOT', 'http://www.supercarloans.ca/');
			define('SITEURL', 'http://www.supercarloans.ca/');
			define('WEBROOT', '/var/www/vhosts/supercarloans.ca/httpdocs/');
			define('SERVERIPADDRESS', '64.13.227.235');
		}
		else if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] == "supercarloans.vstudiozzz.com"))
		{
			define('APPROOT', 'http://supercarloans.vstudiozzz.com/');
			define('SITEURL', 'http://supercarloans.vstudiozzz.com/');
			define('WEBROOT', '/var/www/vhosts/vstudiozzz.com/supercarloans.vstudiozzz.com/');
			define('SERVERIPADDRESS', '64.13.227.235');
		}
		else
		{
			define('APPROOT', 'http://localhost/supercarloans/');
			define('SITEURL', 'http://localhost/supercarloans/');
			define('WEBROOT', 'C:/AppServ/www/supercarloans/');
			define('SERVERIPADDRESS', '192.168.1.79');
		}

		define('APPLICATIONREQUIREROOT', WEBROOT."lib/");
		define('ADMINAPPROOT', APPROOT."login/");

		define('AFFILIATEURL', APPROOT."affiliate/");
		define('SUPERAFFILIATEURL', APPROOT."superaffiliate/");
		define('SUPERAFFILIATETRACKURL', APPROOT."affiliate.php?");
		

		define('ADMINEMAIL', 'simonsaysapproved@gmail.com');
		define('UPLOAD_DIR', WEBROOT. 'applications/');
?>