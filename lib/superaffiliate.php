<?php
class SuperAffiliate extends BaseClass{
	public $superaffiliate_id;
	public $firstname;
	public $lastname;
	public $email;
	public $telephone;
	public $fax;
	public $salt;
	public $HASH;
	public $company;
	public $website;
	public $address_1;
	public $address_2;
	public $city;
	public $postcode;
	public $country_id = 43;
	public $zone_id = 2;
	public $code;
	public $commission;
	public $tax;
	public $payment;
	public $cheque;
	public $paypal;
	public $bank_name;
	public $bank_branch_number;
	public $bank_swift_code;
	public $bank_account_name;
	public $bank_account_number;
	public $ip;
	public $status;
	public $approved;
	public $date_added;
	
	
  	public function loadAffiliate($Id) {
		
				
	$SQL = "SELECT * FROM superaffiliate WHERE superaffiliate_id = " . $Id . " AND status = 1 ";

	//echo "<br/><br/><br/><br/><br/><br/>".$SQL;
	parent::GetDALInstance()->SQLQuery($SQL);
	$row = parent::GetDALInstance()->GetRow(false);
			
			if($row)
			{
				$this->superaffiliate_id = $row['superaffiliate_id'];
				$this->firstname = $row['firstname'];
				$this->lastname = $row['lastname'];
				$this->email = $row['email'];
				$this->telephone = $row['telephone'];
				$this->fax = $row['fax'];
				$this->salt = $row['salt'];
				$this->HASH = $row['HASH'];
				$this->company = $row['company'];
				$this->website = $row['website'];
				$this->address_1 = $row['address_1'];
				$this->address_2 = $row['address_2'];
				$this->city = $row['city'];
				$this->postcode = $row['postcode'];
				$this->country_id = $row['country_id'];
				$this->zone_id = $row['zone_id'];
				$this->code = $row['code'];
				$this->commission = $row['commission'];
				$this->tax = $row['tax'];
				$this->payment = $row['payment'];
				$this->cheque = $row['cheque'];
				$this->paypal = $row['paypal'];
				$this->bank_name = $row['bank_name'];
				$this->bank_branch_number = $row['bank_branch_number'];
				$this->bank_swift_code = $row['bank_swift_code'];
				$this->bank_account_name = $row['bank_account_name'];
				$this->bank_account_number = $row['bank_account_number'];
				$this->ip = $row['ip'];
				$this->status = $row['status'];
				$this->approved = $row['approved'];
				$this->date_added = $row['date_added'];
				
				return $this;
			}
			return false;

		}
		
		
		public function addAffiliate() 
		{
      		$SQL = " INSERT INTO superaffiliate 
					SET firstname = '" . $this->firstname . "', 
						lastname = '" . $this->lastname . "', 
						email = '" . $this->email . "', 
						telephone = '" . $this->telephone . "', 
						fax = '" . $this->fax . "', 
						salt = '" . $this->salt . "', 
						HASH = '" . $this->HASH . "', 
						company = '" . $this->company . "', 
						website = '" . $this->website . "', 
						address_1 = '" . $this->address_1 . "', 
						address_2 = '" . $this->address_2 . "', 
						city = '" . $this->city . "', 
						postcode = '" . $this->postcode . "', 
						country_id = " . $this->country_id . ", 
						zone_id = " . $this->zone_id . ", 
						code = '" . $this->code . "', 
						commission = '5.00', 
						tax = '" . $this->tax . "', 
						payment = '" . $this->payment . "', 
						cheque = '" . $this->cheque . "', 
						paypal = '" . $this->paypal . "', 
						bank_name = '" . $this->bank_name . "', 
						bank_branch_number = '" . $this->bank_branch_number . "', 
						bank_swift_code = '" . $this->bank_swift_code . "', 
						bank_account_name = '" . $this->bank_account_name . "', 
						bank_account_number = '" . $this->bank_account_number . "', 
						status = " . $this->status . ",
						ip = '" . $this->ip . "',
						approved = " . $this->approved . ", 
						date_added = NOW()";
				
				//echo "<br/>".$SQL;

				$this->Id = parent::GetDALInstance()->SQLQuery($SQL, 2);
				return $this->Id;
		}
		
		
		public function Updateaffiliate() 
		{
      			$SQL = " UPDATE superaffiliate 
				SET firstname = '" . $this->firstname . "', 
						lastname = '" . $this->lastname . "', 
						email = '" . $this->email . "', 
						telephone = '" . $this->telephone . "', 
						fax = '" . $this->fax . "', 
						salt = '" . $this->salt . "', 
						HASH = '" . $this->HASH . "', 
						company = '" . $this->company . "', 
						website = '" . $this->website . "', 
						address_1 = '" . $this->address_1 . "', 
						address_2 = '" . $this->address_2 . "', 
						city = '" . $this->city . "', 
						postcode = '" . $this->postcode . "', 
						country_id = " . $this->country_id . ", 
						zone_id = " . $this->zone_id . ", 
						code = '" . $this->code . "', 
						commission = '" . $this->commission . "',
						tax = '" . $this->tax . "', 
						payment = '" . $this->payment . "', 
						cheque = '" . $this->cheque . "', 
						paypal = '" . $this->paypal . "', 
						bank_name = '" . $this->bank_name . "', 
						bank_branch_number = '" . $this->bank_branch_number . "', 
						bank_swift_code = '" . $this->bank_swift_code . "', 
						bank_account_name = '" . $this->bank_account_name . "', 
						bank_account_number = '" . $this->bank_account_number . "', 
						status = " . $this->status . ",
						ip = '" . $this->ip . "',
						approved = " . $this->approved . "
						
						WHERE superaffiliate_id=".$this->superaffiliate_id;
						
						//echo "<br/><br/><br/><br/><br/><br/>".$SQL;
						
				parent::GetDALInstance()->SQLQuery($SQL);
		        return parent::GetDALInstance()->AffectedRows();
		
		}

	public function loadAllaffiliateInfo($Condition = '') 
  	{
		
				
		$SQL = "SELECT * FROM superaffiliate ";

		if($Condition !='')
			$SQL .= ' WHERE '. $Condition;
		//echo "<br/><br/><br/><br/><br/><br/>".$SQL;

		parent::GetDALInstance()->SQLQuery($SQL);
		$row = parent::GetDALInstance()->GetRow(false);
			
		$ResultSet = new ResultSet();
	    if($ResultSet->LoadResult($SQL))
	        return $ResultSet;

	    
		return false;

	}
  		
	public function loadAffiliateByCode($Condition = false) {
		
				
	$SQL = "SELECT * FROM superaffiliate WHERE status = 1  ";
	if($Condition) 
		$SQL .= " AND " . $Condition;
	

	parent::GetDALInstance()->SQLQuery($SQL);
	$row = parent::GetDALInstance()->GetRow(false);

	//echo "<br/><br/><br/><br/><br/><br/>".$SQL;			
			if($row)
			{
				$this->superaffiliate_id = $row['superaffiliate_id'];
				$this->firstname = $row['firstname'];
				$this->lastname = $row['lastname'];
				$this->email = $row['email'];
				$this->telephone = $row['telephone'];
				$this->fax = $row['fax'];
				$this->code = $row['code'];
				$this->salt = $row['salt'];
				$this->HASH = $row['HASH'];
				$this->company = $row['company'];
				$this->website = $row['website'];
				$this->address_1 = $row['address_1'];
				$this->address_2 = $row['address_2'];
				$this->city = $row['city'];
				$this->postcode = $row['postcode'];
				$this->country_id = $row['country_id'];
				$this->zone_id = $row['zone_id'];
				$this->code = $row['code'];
				$this->commission = $row['commission'];
				$this->tax = $row['tax'];
				$this->payment = $row['payment'];
				$this->cheque = $row['cheque'];
				$this->paypal = $row['paypal'];
				$this->bank_name = $row['bank_name'];
				$this->bank_branch_number = $row['bank_branch_number'];
				$this->bank_swift_code = $row['bank_swift_code'];
				$this->bank_account_name = $row['bank_account_name'];
				$this->bank_account_number = $row['bank_account_number'];
				$this->ip = $row['ip'];
				$this->status = $row['status'];
				$this->approved = $row['approved'];
				$this->date_added = $row['date_added'];
				
				return $this;
			}
			return false;

		}
	

	public function affiliateExists($Code)
	{
		$SQL = "SELECT superaffiliate_id 
				FROM superaffiliate 
				WHERE code = '" . $Code . "' AND Status = 1

		";

		parent::GetDALInstance()->SQLQuery($SQL);
		$row = parent::GetDALInstance()->GetRow();

		return ($row) ? true : false;
	}

	public function AffiliateCount()
	{
		$SQL = "SELECT count(*) AS 'Totalsuperaffiliate'
				FROM superaffiliate 
				WHERE status = 1

		";

		parent::GetDALInstance()->SQLQuery($SQL);
		$row = parent::GetDALInstance()->GetRow();

		return ($row) ? $row["Totalsuperaffiliate"] : 0;
	}

	public function GetFullName($Id)
	{
		$SQL = "SELECT firstname AS 'Fname', lastname AS 'Lname' 
				FROM superaffiliate 
				WHERE superaffiliate_id = " . $Id ;

		//echo  "\n". $SQL . "\n";

		parent::GetDALInstance()->SQLQuery($SQL);
		$row = parent::GetDALInstance()->GetRow();

		return ($row) ? $row["Fname"] . " " . $row["Lname"] : 0;
		
	}

  	public function login($email, $password) {
		$superaffiliate_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "superaffiliate WHERE LOWER(email) = '" . $this->db->escape(utf8_strtolower($email)) . "' AND (password = SHA1(CONCAT(salt, SHA1(CONCAT(salt, SHA1('" . $this->db->escape($password) . "'))))) OR password = '" . $this->db->escape(md5($password)) . "') AND status = '1' AND approved = '1'");
		
		if ($superaffiliate_query->num_rows) {
			$this->session->data['superaffiliate_id'] = $superaffiliate_query->row['superaffiliate_id'];	
		    
			$this->superaffiliate_id = $superaffiliate_query->row['superaffiliate_id'];
			$this->firstname = $superaffiliate_query->row['firstname'];
			$this->lastname = $superaffiliate_query->row['lastname'];
			$this->email = $superaffiliate_query->row['email'];
			$this->telephone = $superaffiliate_query->row['telephone'];
			$this->fax = $superaffiliate_query->row['fax'];
      		$this->code = $superaffiliate_query->row['code'];
	  
	  		return true;
    	} else {
      		return false;
    	}
  	}
  	
  	public function logout() {
		unset($this->session->data['superaffiliate_id']);

		$this->superaffiliate_id = '';
		$this->firstname = '';
		$this->lastname = '';
		$this->email = '';
		$this->telephone = '';
		$this->fax = '';
  	}
  
  	public function isLogged() {
    	return $this->superaffiliate_id;
  	}

  	public function getId() {
    	return $this->superaffiliate_id;
  	}
      
  	public function getFirstName() {
		return $this->firstname;
  	}
  
  	public function getLastName() {
		return $this->lastname;
  	}
  
  	public function getEmail() {
		return $this->email;
  	}
  
  	public function getTelephone() {
		return $this->telephone;
  	}
  
  	public function getFax() {
		return $this->fax;
  	}
	
  	public function getCode() {
		return $this->code;
  	}


  	public function sendRecoverPasswordLink($Email,$Encryption)
  		{		
  				 $to = $Email;

  				//define the subject of the email 
				$subject = "Affiliate Password Reset from SupeCarLoans";
				//create a boundary string. It must be unique 
				//so we use the MD5 algorithm to generate a random hash 
				$random_hash = md5(date('r', time())); 
				
				

				// To send HTML mail, the Content-type header must be set
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers .= "From: no-reply@SupeCarLoans.ca" .  "\r\n";
				//add boundary string and mime type specification 
				//$headers .= "\r\nContent-Type: multipart/mixed; boundary=\"PHP-mixed-".$random_hash."\""; 

				

  				ob_start(); //Turn on output buffering

  				//setting reset password link
				$resetPasswordLink = SUPERAFFILIATEURL."emailchangepassword.php?" . $Encryption;

				//Fetch logo from server for email template
				$logo = APPROOT."img/logo.png";

				//get contents of emailTemplates/basetemplate.html File from folder
				$baseStr = file_get_contents(WEBROOT .'emailTemplates/basetemplate.html');

				//get Forgetpassword template file from emailTemplate folder
				$forgetpasswordlinkStr = file_get_contents(WEBROOT .'emailTemplates/forgetpasswordlink.html');

				//replacing base template with logo
				$baseStr = str_replace("emailTemplate/logo.png",$logo,$baseStr);
				$baseStr = str_replace("###approot###",APPROOT,$baseStr);
				$baseStr = str_replace("###affiliate###",SUPERAFFILIATEURL,$baseStr);

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
				$subject = "Password Successfully Reset on SuperCarLoans";
				//create a boundary string. It must be unique 
				//so we use the MD5 algorithm to generate a random hash 
				$random_hash = md5(date('r', time())); 
				
				

				// To send HTML mail, the Content-type header must be set
				// To send HTML mail, the Content-type header must be set
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers .= "From: no-reply@SupeCarLoans.ca" .  "\r\n";
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
				$baseStr = str_replace("###affiliate###",SUPERAFFILIATEURL,$baseStr);

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



  		public function sendActivationKit($superaffiliate_id)
  		{
  				
  				$superaffiliate = new SuperAffiliate();
    			$superaffiliate->loadAffiliate($superaffiliate_id);

  				
  				 $to = $superaffiliate->email;

  				//define the subject of the email 
				$subject = "Account Activation Instruction on SuperCarLoans Affiliate Program";
				//create a boundary string. It must be unique 
				//so we use the MD5 algorithm to generate a random hash 
				$random_hash = md5(date('r', time())); 
				
				

				// To send HTML mail, the Content-type header must be set
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers .= "From: no-reply@SupeCarLoans.ca" .  "\r\n";
				//add boundary string and mime type specification 
				$headers .= "\r\nContent-Type: multipart/mixed; boundary=\"PHP-mixed-".$random_hash."\"";

				

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
									<td colspan='2'>Dear ". $superaffiliate->firstname . " ". $superaffiliate->lastname .", </td>
							    </tr>
							    
							    <tr>
									<td colspan='2'>Congratulations! You are now an Approved SupeCarLoans Referral Affiliate.</td>
							    </tr>
							    
							    <tr>
							    	<td colspan='2'>Weclome to this new and exciting way to earn thousands of dollars in extra income each month.</td>
							    </tr>

							    <tr>
							    	<td colspan='2'>Tell your friends, family and colleagues about SupeCarLoans and get between $500 and $2,500 for each person that successfully make a purchase. Get creative and share through Facebook, on a blog, a tweet ­ your choice or any of your social media pages that permits it.</td>
							    </tr>

							    <tr>
							    	<td colspan='2'>The Pay Plan is as shown below:</td>
							    </tr>

							    <tr>
							    	<td colspan='2'>You will be paid a $100 CAD flat referral fee for every affiliate you send us and they send us a lead. Payments will be submitted within two (2) business days after the deal is completed and funds received from the Lender.</td>
							    </tr>


							    <tr>
							    	<td colspan='2'>Payments shall be made via cheques and mailed to you within 2 business days after full payment has been received from the Financing Bank.</td>
							    </tr>

							    <tr>
							    	<td colspan='2'>You may call our support line at 780­701­1888 if you have any questions. <strong>Bewteen 10am ­ 8pm weekdays </strong>and <strong>10am to 6pm on Saturdays.</strong></td>
							    </tr>

							    <tr>
							    	<td colspan='2'><strong>Your Account Information</strong></td>
							    </tr>

							    <tr>
							    	<td><strong>Username</strong></td>
							    	<td><strong>". $superaffiliate->email . "</strong></td>
							    </tr>

							    <tr>
							    	<td>Password</td>
							    	<td>********</td>
							    </tr>
								
								<tr>
							    	<td><strong>Tracking&nbsp;Link:</strong></td>
							    	<td><strong>". AFFILIATEURL . $superaffiliate->code . "</strong></td>
							    </tr>

							    <tr>
							    	<td colspan='2'>Copy and paste this code to your social media sites and start tracking your referrals from accessing your account.</td>
							    </tr>

								<tr>
							    	<td colspan='2'>To access your account and start managing referrals, please <a href='".SUPERAFFILIATEURL."' target='_blank'> signin here </a></td>
							    </tr>

							    <tr>
							    	<td colspan='2'>We all forget passwords sometimes. If you ever need to reset yours, go here: <a href='".SUPERAFFILIATEURL."' target='_blank'> Reset my password, please! </a> Click on 'Lost your password' and follow instructions to reset it.</td>
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

		        //$mailObj->Send();

		        //debugObj($mailObj);
				//$ok = @mail($to, $subject, $ReturnString, $headers);
				
				
		        //if($ok)
		        if($mailObj->Send())
					return true;
		        else
		        	return false;
  		}


}
?>