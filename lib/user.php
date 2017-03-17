<?php
class Login extends BaseClass{
	public $Id;
	public $Featured;
	public $DealerId;
	public $EmailId;
	public $SALT;
	public $HASH;
	public $Timestamp;
	public $Status;
	

	/*

		Status:
					0:	Activation email sent and waiting to activate 
					1:	Active user					
					3:	Account closed by admin. Only admin can undo. and set account to 1
	*/
	
  	public function loadcustomerinfo($Id) {
		
				
	$SQL = "SELECT * FROM tbllogin WHERE Id = " . $Id . " AND Status = 1";
	parent::GetDALInstance()->SQLQuery($SQL);
	$row = parent::GetDALInstance()->GetRow(false);
			
			if($row)
			{
				$this->Id = $row['Id'];
				$this->Featured = $row['Featured'];
				$this->DealerId = $row['DealerId'];
				$this->EmailId = $row['EmailId'];
				$this->SALT = $row['SALT'];
				$this->HASH = $row['HASH'];
				$this->Timestamp = $row['Timestamp'];
				$this->Status = $row['Status'];
				
				
				return $this;
			}
			return false;

		}
		
		
		public function addCustomerInfo() 
		{
      		$SQL = " INSERT INTO tbllogin 
					SET 
						Featured = " . $this->Featured . ", 
						DealerId = " . $this->DealerId . ", 
						EmailId = '" . $this->EmailId . "', 
						SALT = '" . $this->SALT . "', 
						HASH = '" . $this->HASH . "', 
						Timestamp = null, 
						Status = " . $this->Status . "
						";
				
				//echo "<br/><br/><br/><br/><br/><br/>".$SQL;
				$this->Id = parent::GetDALInstance()->SQLQuery($SQL, 2);
				return $this->Id;
		}
		
		
		public function UpdateCustomerInfo($Id) 
		{
      			$SQL = " UPDATE tbllogin 
				SET 	
						Featured = " . $this->Featured . ", 
						DealerId = " . $this->DealerId . ", 
						EmailId = '" . $this->EmailId . "', 
						SALT = '" . $this->SALT . "', 
						HASH = '" . $this->HASH . "', 
						Timestamp = null, 
						Status = " . $this->Status . "

						WHERE Id=".$Id;
						
						//echo "<br/><br/><br/><br/><br/><br/>".$SQL;
						
				parent::GetDALInstance()->SQLQuery($SQL);
		        return parent::GetDALInstance()->AffectedRows();
		
		}
  		
	public function loadDealerIdInfo($DealerId) {
		
				
	$SQL = "SELECT * FROM tbllogin WHERE DealerId = " . $DealerId ;
	parent::GetDALInstance()->SQLQuery($SQL);
	$row = parent::GetDALInstance()->GetRow(false);
		//echo "<br/><br/><br/><br/><br/><br/>".$SQL;	
			if($row)
			{
				$this->Id = $row['Id'];
				$this->Featured = $row['Featured'];
				$this->DealerId = $row['DealerId'];
				$this->EmailId = $row['EmailId'];
				$this->SALT = $row['SALT'];
				$this->HASH = $row['HASH'];
				$this->Timestamp = $row['Timestamp'];
				$this->Status = $row['Status'];
				
				
				return $this;
			}
			return false;

		}

	public function CheckUserByLogin($UserLogin)
        {
            $SQL = "SELECT DealerId
                    FROM tbllogin 
                    WHERE EmailId='".$UserLogin."'";
                
                parent::GetDALInstance()->SQLQuery($SQL);
				//echo "<br/><br/><br/><br/><br/><br/>".$SQL;	
				$row = parent::GetDALInstance()->GetRow();
				return ($row) ? $row[0] : false;
			

		}

		public function CheckFeaturedRights($DealerId)
        {
            $SQL = "SELECT Featured
                    FROM tbllogin 
                    WHERE DealerId=".$DealerId;
                
                parent::GetDALInstance()->SQLQuery($SQL);
				//echo "<br/><br/><br/><br/><br/><br/>".$SQL;	
				$row = parent::GetDALInstance()->GetRow();
				return ($row[0] == 1) ? true : false;
			

		}
		
  	
  	public function loadAffiliateByCode($Condition = false) {
		
				
	$SQL = "SELECT * FROM tbllogin WHERE status = 1  ";
	if($Condition) 
		$SQL .= " AND " . $Condition;
	

	parent::GetDALInstance()->SQLQuery($SQL);
	$row = parent::GetDALInstance()->GetRow(false);

	//echo "<br/><br/><br/><br/><br/><br/>".$SQL;			
			if($row)
			{
				$this->Id = $row['Id'];
				$this->Featured = $row['Featured'];
				$this->DealerId = $row['DealerId'];
				$this->EmailId = $row['EmailId'];
				$this->SALT = $row['SALT'];
				$this->HASH = $row['HASH'];
				$this->Timestamp = $row['Timestamp'];
				$this->Status = $row['Status'];
				
				
				return $this;
			}
			return false;
	}

	public function sendRecoverPasswordLink($Email,$Encryption)
  		{

  				 $to = $Email;

  				//define the subject of the email 
				$subject = "Password Reset from CarFinancing.Help";
				//create a boundary string. It must be unique 
				//so we use the MD5 algorithm to generate a random hash 
				$random_hash = md5(date('r', time())); 
				
				

				// To send HTML mail, the Content-type header must be set
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers .= "From: no-reply@carfinancing.help" .  "\r\n";
				//add boundary string and mime type specification 
				//$headers .= "\r\nContent-Type: multipart/mixed; boundary=\"PHP-mixed-".$random_hash."\""; 

				

  				ob_start(); //Turn on output buffering

  				//setting reset password link
		$resetPasswordLink = LEADASSIGNURL."emailchangepassword.php?" . $Encryption;

		//Fetch logo from server for email template
		$logo = APPROOT."img/logo.png";

		//get contents of emailTemplates/basetemplate.html File from folder
		$baseStr = file_get_contents(WEBROOT .'emailTemplates/basetemplate.html');

		//get Forgetpassword template file from emailTemplate folder
		$forgetpasswordlinkStr = file_get_contents(WEBROOT .'emailTemplates/forgetpasswordlink.html');

		//replacing base template with logo
		$baseStr = str_replace("emailTemplate/logo.png",$logo,$baseStr);
		$baseStr = str_replace("###approot###",APPROOT,$baseStr);
		$baseStr = str_replace("###affiliate###",LEADASSIGNURL,$baseStr);

		//replacing contents of forgetpassword link Email and activation link
		$forgetpasswordlinkStr = str_replace("###RESETPASSWORDHREF###", $resetPasswordLink, $forgetpasswordlinkStr);
		$forgetpasswordlinkStr = str_replace('###EMAIL###', $Email, $forgetpasswordlinkStr);

		//put forgetpasswrod template in base template
		$baseStr = str_replace("###replaceArea###",$forgetpasswordlinkStr,$baseStr);
		

            ob_get_clean(); 
			$mailObj = new Email($to, NULL, $subject);

	        $mailObj->TextOnly = false;
	        $mailObj->Headers = $headers;

	        $mailObj->Content = $baseStr;  

		        //$mailObj->Send();

		        //debugObj($mailObj);
				//$ok = @mail($to, $subject, $ReturnString, $headers);
				
				
		        //if($ok)
		        if($mailObj->Send())
					return true;
		        else
		        	return false;
		}

	public function sendConfirmedRecoveredPassword($Email)
  		{
  				 $to = $Email;

  				//define the subject of the email 
				$subject = "Password Successfully Reset on CarFinancing.Help";
				//create a boundary string. It must be unique 
				//so we use the MD5 algorithm to generate a random hash 
				$random_hash = md5(date('r', time())); 
				
				

				// To send HTML mail, the Content-type header must be set
				// To send HTML mail, the Content-type header must be set
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers .= "From: no-reply@carfinancing.help" .  "\r\n";
				//add boundary string and mime type specification 
				//$headers .= "\r\nContent-Type: multipart/mixed; boundary=\"PHP-mixed-".$random_hash."\""; 

				

  				ob_start(); //Turn on output buffering

  				
		//Fetch logo from server for email template
		$logo = APPROOT."img/logo.png";

		//get contents of emailTemplates/basetemplate.html File from folder
		$baseStr = file_get_contents(WEBROOT .'emailTemplates/basetemplate.html');

		//get Forgetpassword template file from emailTemplate folder
		$forgetpasswordlinkStr = file_get_contents(WEBROOT .'emailTemplates/successfullyReset.html');

		//replacing base template with logo
		$baseStr = str_replace("emailTemplate/logo.png",$logo,$baseStr);
		$baseStr = str_replace("###approot###",APPROOT,$baseStr);
		$baseStr = str_replace("###affiliate###",LEADASSIGNURL,$baseStr);

		//replacing contents of forgetpassword link Email and activation link
		$forgetpasswordlinkStr = str_replace("###EMAIL###", $Email, $forgetpasswordlinkStr);
		

		//put forgetpasswrod template in base template
		$baseStr = str_replace("###replaceArea###",$forgetpasswordlinkStr,$baseStr);
		

            ob_get_clean(); 
			$mailObj = new Email($to, NULL, $subject);

	        $mailObj->TextOnly = false;
	        $mailObj->Headers = $headers;

	        $mailObj->Content = $baseStr;  

		        //$mailObj->Send();

		        //debugObj($mailObj);
				//$ok = @mail($to, $subject, $ReturnString, $headers);
				
				
		        //if($ok)
		        if($mailObj->Send())
					return true;
		        else
		        	return false;
  		}



  		public function sendEmailDealer($DealerId,$Password)
  		{
  				
				$Login = new Login();
				$Login->loadDealerIdInfo($DealerId);

  				 $to = $Login->EmailId;

  				//define the subject of the email 
				$subject = "CarFinancing.Help New User Registered!";
				//create a boundary string. It must be unique 
				//so we use the MD5 algorithm to generate a random hash 
				$random_hash = md5(date('r', time())); 
				
				

				// To send HTML mail, the Content-type header must be set
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers .= "From: no-reply@carfinancing.help" .  "\r\n";
				//add boundary string and mime type specification 
				//$headers .= "\r\nContent-Type: multipart/mixed; boundary=\"PHP-mixed-".$random_hash."\"".  "\r\n"; 

				

  				ob_start(); //Turn on output buffering

		$ReturnString = "
						<!DOCTYPE html>
						<html lang='en'>
						<head>
								<meta charset='utf-8'>
						</head>
						<body id='page2'>
							<table cellpadding='3' cellspacing='7' border='0' style='font-family:Verdana, Arial, Helvetica, sans-serif;  font-size:16px;'>
								<tr>
									<td colspan='2'></td>
							        </tr>
								<tr>
									<td colspan='2'>Hello User, </td>
							    </tr>
							    
							    <tr>
									<td colspan='2'>Here are your account details:</td>
							    </tr>
								<tr>
									<td align='right'>Login Email:</td><td>".$Login->EmailId."</td>
							    </tr>
							    <tr>
									<td align='right'>Password:</td><td>".$Password."</td>
							    </tr>
							    
								
							</table>
							</body>
							</html>

		";

					

                   ob_get_clean(); 
					
				
				$mailObj = new Email($to, NULL, $subject);

	        $mailObj->TextOnly = false;
	        $mailObj->Headers = $headers;

	        $mailObj->Content = $ReturnString;  


		        //if($ok)
		        if($mailObj->Send())
					return true;
		        else
		        	return false;
  		}

}

?>