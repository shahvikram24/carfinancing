<?php
class Affiliate extends BaseClass{
	public $affiliate_id;
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
		
				
	$SQL = "SELECT * FROM affiliate WHERE affiliate_id = " . $Id . " AND status = 1 ";

	//echo "<br/><br/><br/><br/><br/><br/>".$SQL;
	parent::GetDALInstance()->SQLQuery($SQL);
	$row = parent::GetDALInstance()->GetRow(false);
			
			if($row)
			{
				$this->affiliate_id = $row['affiliate_id'];
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
      		$SQL = " INSERT INTO affiliate 
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
				
				echo "<br/><br/><br/><br/>".$SQL;

				$this->Id = parent::GetDALInstance()->SQLQuery($SQL, 2);
				return $this->Id;
		}
		
		
		public function UpdateAffiliate() 
		{
      			$SQL = " UPDATE affiliate 
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
						
						WHERE affiliate_id=".$this->affiliate_id;
						
						//echo "<br/><br/><br/><br/><br/><br/>".$SQL;
						
				parent::GetDALInstance()->SQLQuery($SQL);
		        return parent::GetDALInstance()->AffectedRows();
		
		}

	public function loadAllAffiliateInfo($Condition = '') 
  	{
		
				
		$SQL = "SELECT * FROM affiliate ";

		if($Condition !='')
			$SQL .= ' WHERE '. $Condition;

			$SQL .= ' ORDER BY date_added DESC ';
		//echo "<br/><br/><br/><br/><br/><br/>".$SQL;

		parent::GetDALInstance()->SQLQuery($SQL);
		$row = parent::GetDALInstance()->GetRow(false);
			
		$ResultSet = new ResultSet();
	    if($ResultSet->LoadResult($SQL))
	        return $ResultSet;

	    
		return false;

	}
  		
	public function loadAffiliateByCode($Condition = false) {
		
				
	$SQL = "SELECT * FROM affiliate WHERE status = 1  ";
	if($Condition) 
		$SQL .= " AND " . $Condition;
	

	parent::GetDALInstance()->SQLQuery($SQL);
	$row = parent::GetDALInstance()->GetRow(false);

	//echo "<br/><br/><br/><br/><br/><br/>".$SQL;			
			if($row)
			{
				$this->affiliate_id = $row['affiliate_id'];
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
	

	public function AffiliateExists($Code)
	{
		$SQL = "SELECT affiliate_id 
				FROM affiliate 
				WHERE code = '" . $Code . "' AND Status = 1

		";

		parent::GetDALInstance()->SQLQuery($SQL);
		$row = parent::GetDALInstance()->GetRow();

		return ($row) ? true : false;
	}

	public function AffiliateCount()
	{
		$SQL = "SELECT count(*) AS 'TotalAffiliate'
				FROM affiliate 
				WHERE status = 1

		";

		parent::GetDALInstance()->SQLQuery($SQL);
		$row = parent::GetDALInstance()->GetRow();

		return ($row) ? $row["TotalAffiliate"] : 0;
	}

	public function PendingCount()
	{
		$SQL = "SELECT count(*) AS 'TotalAffiliate'
				FROM affiliate 
				WHERE approved = 2

		";

		parent::GetDALInstance()->SQLQuery($SQL);
		$row = parent::GetDALInstance()->GetRow();

		return ($row) ? $row["TotalAffiliate"] : 0;
	}

	public function GetFullName($Id)
	{
		$SQL = "SELECT firstname AS 'Fname', lastname AS 'Lname' 
				FROM affiliate 
				WHERE affiliate_id = " . $Id ;

		//echo  "\n". $SQL . "\n";

		parent::GetDALInstance()->SQLQuery($SQL);
		$row = parent::GetDALInstance()->GetRow();

		return ($row) ? $row["Fname"] . " " . $row["Lname"] : 0;
		
	}

	public function GetPhone($Id)
	{
		$SQL = "SELECT telephone  
				FROM affiliate 
				WHERE affiliate_id = " . $Id ;

		//echo  "\n". $SQL . "\n";

		parent::GetDALInstance()->SQLQuery($SQL);
		$row = parent::GetDALInstance()->GetRow();

		return ($row) ? $row["telephone"]  : 0;
		
	}

	public function GetEmail($Id)
	{
		$SQL = "SELECT email  
				FROM affiliate 
				WHERE affiliate_id = " . $Id ;

		//echo  "\n". $SQL . "\n";

		parent::GetDALInstance()->SQLQuery($SQL);
		$row = parent::GetDALInstance()->GetRow();

		return ($row) ? $row["email"] : 0;
		
	}

  	public function login($email, $password) {
		$affiliate_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "affiliate WHERE LOWER(email) = '" . $this->db->escape(utf8_strtolower($email)) . "' AND (password = SHA1(CONCAT(salt, SHA1(CONCAT(salt, SHA1('" . $this->db->escape($password) . "'))))) OR password = '" . $this->db->escape(md5($password)) . "') AND status = '1' AND approved = '1'");
		
		if ($affiliate_query->num_rows) {
			$this->session->data['affiliate_id'] = $affiliate_query->row['affiliate_id'];	
		    
			$this->affiliate_id = $affiliate_query->row['affiliate_id'];
			$this->firstname = $affiliate_query->row['firstname'];
			$this->lastname = $affiliate_query->row['lastname'];
			$this->email = $affiliate_query->row['email'];
			$this->telephone = $affiliate_query->row['telephone'];
			$this->fax = $affiliate_query->row['fax'];
      		$this->code = $affiliate_query->row['code'];
	  
	  		return true;
    	} else {
      		return false;
    	}
  	}
  	
  	public function logout() {
		unset($this->session->data['affiliate_id']);

		$this->affiliate_id = '';
		$this->firstname = '';
		$this->lastname = '';
		$this->email = '';
		$this->telephone = '';
		$this->fax = '';
  	}
  
  	


  	public function sendRecoverPasswordLink($Email,$Encryption)
  		{

  				 $to = $Email;

  				//define the subject of the email 
				$subject = "Affiliate Password Reset from Car Financing";
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
		$resetPasswordLink = AFFILIATEURL."emailchangepassword.php?" . $Encryption;

		//Fetch logo from server for email template
		$logo = APPROOT."img/logo.png";

		//get contents of emailTemplates/basetemplate.html File from folder
		$baseStr = file_get_contents(WEBROOT .'emailTemplates/basetemplate.html');

		//get Forgetpassword template file from emailTemplate folder
		$forgetpasswordlinkStr = file_get_contents(WEBROOT .'emailTemplates/forgetpasswordlink.html');

		//replacing base template with logo
		$baseStr = str_replace("emailTemplate/logo.png",$logo,$baseStr);
		$baseStr = str_replace("###approot###",APPROOT,$baseStr);
		$baseStr = str_replace("###affiliate###",AFFILIATEURL,$baseStr);

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
				$subject = "Password Successfully Reset on Car Financing";
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
		$baseStr = str_replace("###affiliate###",AFFILIATEURL,$baseStr);

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



  		public function sendActivationKit($affiliate_id)
  		{
  				
  				$affiliate = new Affiliate();
    			$affiliate->loadAffiliate($affiliate_id);

  				
  				 $to = $affiliate->email;

  				//define the subject of the email 
				$subject = "Account Activation Instruction on Car Financing Affiliate Program";
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

  				
				//Fetch logo from server for email template
				$logo = APPROOT."img/logo.png";
				$hero = APPROOT."emailTemplates/images/hero-image-receipt.png";
				//get contents of emailTemplates/basetemplate.html File from folder
				$baseStr = file_get_contents(WEBROOT .'emailTemplates/affiliateactivationkit.html');

				
				//replacing base template with logo
				$baseStr = str_replace("emailTemplate/logo.png",$logo,$baseStr);
				$baseStr = str_replace("images/hero-image-receipt.png",$hero,$baseStr);
				$baseStr = str_replace("###approot###",APPROOT,$baseStr);
				$baseStr = str_replace("###NAME###",$affiliate->firstname . " ". $affiliate->lastname,$baseStr);
				$baseStr = str_replace("###AFFILIATEEMAIL###",$affiliate->email,$baseStr);
				$baseStr = str_replace("###AFFILIATECODE###",APPROOT . $affiliate->code,$baseStr);

		

		
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

}
?>