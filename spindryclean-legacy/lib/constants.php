<?php

		

		/*define('APPROOT', 'http://affiliate.vstudiozzz.com/');
		define('SITEURL', 'http://affiliate.vstudiozzz.com/');
		define('WEBROOT', '/var/www/vhosts/vstudiozzz.com/affiliate.vstudiozzz.com/');
		define('SERVERIPADDRESS', '64.13.227.235');
		define('APPLICATIONREQUIREROOT', WEBROOT."lib/");*/

		if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] == "spindryclean.com" || $_SERVER['SERVER_NAME'] == "www.spindryclean.com"))
		{
			define('APPROOT', 'https://www.spindryclean.com/members/');
			define('SITEURL', 'https://www.spindryclean.com/');
			define('WEBROOT', '/var/www/vhosts/spindryclean.com/httpdocs/members/');
			define('SERVERIPADDRESS', '64.13.227.235');
		}

		else if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] == "spindryclean.vstudiozzz.com"))
		{
			define('APPROOT', 'http://spindryclean.vstudiozzz.com/members/');
			define('SITEURL', 'http://spindryclean.vstudiozzz.com/');
			define('WEBROOT', '/var/www/vhosts/vstudiozzz.com/spindryclean.vstudiozzz.com/members/');
			define('SERVERIPADDRESS', '64.13.227.235');
		}
		else
		{
			define('APPROOT', 'http://localhost/spin/spindryclean-legacy/');
			define('SITEURL', 'http://localhost/reg/');
			define('WEBROOT', 'C:/AppServ/www/spin/spindryclean-legacy/');
			define('SERVERIPADDRESS', '192.168.1.75');
		}


		define('APPLICATIONREQUIREROOT', WEBROOT."lib/");
		define('ADMINROOT', APPROOT."login/");
		define('ADMINWEBROOT', WEBROOT."login/");

		//define('ADMINEMAIL', 'janice.w.wong@gmail.com');
		define('ADMINEMAIL', 'shahvikram24@gmail.com');
		
		define("UPLOAD_DIR", WEBROOT."tmp/");
?>
