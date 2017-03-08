<?php 
		// Report all PHP errors
		error_reporting(-1);
		
		session_start();

		if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] == "supercarloans.ca" || $_SERVER['SERVER_NAME'] == "www.supercarloans.ca"))
			require_once("/var/www/vhosts/supercarloans.ca/httpdocs/lib/constants.php");
		else if(isset($_SERVER['SERVER_NAME']) && $_SERVER['SERVER_NAME'] == "supercarloans.vstudiozzz.com")
			require_once("/var/www/vhosts/vstudiozzz.com/supercarloans.vstudiozzz.com/lib/constants.php");
		else
			require_once("C:/AppServ/www/supercarloans/lib/constants.php");

		
		require_once(APPLICATIONREQUIREROOT."baseclass.php");
	    require_once(APPLICATIONREQUIREROOT."encryption.php");

		
		require_once(APPLICATIONREQUIREROOT."security.php");
		require_once(APPLICATIONREQUIREROOT."errorclass.php");
		require_once(APPLICATIONREQUIREROOT."dal.php");
		require_once(APPLICATIONREQUIREROOT."common.php");
		require_once(APPLICATIONREQUIREROOT."resultset.php");
		require_once(APPLICATIONREQUIREROOT."emogrifier.php");



		require_once(APPLICATIONREQUIREROOT."emptype.php");
		require_once(APPLICATIONREQUIREROOT."empstatus.php");
		require_once(APPLICATIONREQUIREROOT."dealstatus.php");
		require_once(APPLICATIONREQUIREROOT."frequency.php");
		require_once(APPLICATIONREQUIREROOT."otherincometype.php");
		
		
		require_once(APPLICATIONREQUIREROOT."contactinfo.php");


		require_once(APPLICATIONREQUIREROOT."employment.php");
		require_once(APPLICATIONREQUIREROOT."previousemployment.php");
		require_once(APPLICATIONREQUIREROOT."mortgage.php");
		require_once(APPLICATIONREQUIREROOT."coapplicant.php");
		require_once(APPLICATIONREQUIREROOT."contact.php");
		
		require_once(APPLICATIONREQUIREROOT."files.php");
		require_once(APPLICATIONREQUIREROOT."filerelations.php");

		require_once(APPLICATIONREQUIREROOT."notes.php");
		require_once(APPLICATIONREQUIREROOT."notesrelation.php");

		require_once(APPLICATIONREQUIREROOT."package.php");
		require_once(APPLICATIONREQUIREROOT."recurring.php");
		require_once(APPLICATIONREQUIREROOT."dealership.php");
		require_once(APPLICATIONREQUIREROOT."dealerpackages.php");
		require_once(APPLICATIONREQUIREROOT."dealerpackagefeatures.php");
		require_once(APPLICATIONREQUIREROOT."dealercredits.php");

		require_once(APPLICATIONREQUIREROOT."affiliate.php");
		require_once(APPLICATIONREQUIREROOT."affiliatetransaction.php");

		require_once(APPLICATIONREQUIREROOT."superaffiliate.php");
		require_once(APPLICATIONREQUIREROOT."superaffiliatetransaction.php");

		require_once(APPLICATIONREQUIREROOT."mail.php");
		require_once(APPLICATIONREQUIREROOT."admin.php");
		
		require_once(APPLICATIONREQUIREROOT."subscribers.php");
		require_once(APPLICATIONREQUIREROOT."template.php");
		require_once(APPLICATIONREQUIREROOT."tblmail.php");

		$Encrypt = new Encryption();
		$Decrypt = new Encryption();
		$Errors = new ErrorClass();
		
		$DAL = new DAL();
		
		

		if($_SERVER['QUERY_STRING'] != "")
		{
			$UrlString = explode("&", $_SERVER['QUERY_STRING']);

			if(count($UrlString) > 1)
			{
				$DecryptedString = $Decrypt->decrypt($UrlString[0]);
				unset($UrlString[0]);
				$DecryptedString = explode("&", $DecryptedString);
				$Result = array_merge($UrlString, $DecryptedString);
				parse_str(implode("&", $Result));
			}
			else
			{
				$UrlString = $Decrypt->decrypt($UrlString[0]);
				parse_str($UrlString);
			}

			$QueryStringParsed = true;
		}
		
	
?>
