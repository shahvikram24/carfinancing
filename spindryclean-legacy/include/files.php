<?php 
		session_start();

		if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] == "spindryclean.com" || $_SERVER['SERVER_NAME'] == "www.spindryclean.com"))
			require_once("/var/www/vhosts/spindryclean.com/httpdocs/members/lib/constants.php");
		else if(isset($_SERVER['SERVER_NAME']) && $_SERVER['SERVER_NAME'] == "spindryclean.vstudiozzz.com")
			require_once("/var/www/vhosts/vstudiozzz.com/spindryclean.vstudiozzz.com/members/lib/constants.php");
		else
			require_once("C:/AppServ/www/spin/spindryclean-legacy/lib/constants.php");


		/*echo date('Y-m-d', strtotime('next tuesday'));
		echo "<br/>".date('Y-m-d', strtotime("16 Mar 2014 +3 sunday"));
		echo "<br/>".date('Y-m-d',strtotime(date('Y-m-d').' +1 days'));*/
		
		//require_once("C:/AppServ/www/reg/lib/constants.php");		
		require_once(APPLICATIONREQUIREROOT."baseclass.php");
		
	    require_once(APPLICATIONREQUIREROOT."encryption.php");
	    require_once(APPLICATIONREQUIREROOT."stripe.php");
	    
		require_once(APPLICATIONREQUIREROOT."customer.php");
		require_once(APPLICATIONREQUIREROOT."user.php");
		require_once(APPLICATIONREQUIREROOT."order.php");
		require_once(APPLICATIONREQUIREROOT."postal.php");
		require_once(APPLICATIONREQUIREROOT."often.php");
		require_once(APPLICATIONREQUIREROOT."occurance.php");
		
		
		require_once(APPLICATIONREQUIREROOT."security.php");
		require_once(APPLICATIONREQUIREROOT."errorclass.php");
		require_once(APPLICATIONREQUIREROOT."dal.php");
		
		require_once(APPLICATIONREQUIREROOT."common.php");
		require_once(APPLICATIONREQUIREROOT."resultset.php");
		require_once(APPLICATIONREQUIREROOT."files.php");
		require_once(APPLICATIONREQUIREROOT."filerelations.php");
		


		require_once(APPLICATIONREQUIREROOT."package.php");
		require_once(APPLICATIONREQUIREROOT."recurring.php");
		require_once(APPLICATIONREQUIREROOT."coupon.php");
		require_once(APPLICATIONREQUIREROOT."customertransactions.php");
		require_once(APPLICATIONREQUIREROOT."support.php");
		require_once(APPLICATIONREQUIREROOT."products.php");
		require_once(APPLICATIONREQUIREROOT."invoice.php");
		require_once(APPLICATIONREQUIREROOT."invoiceproducts.php");
		require_once(APPLICATIONREQUIREROOT."invoicetransactions.php");
		
		

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