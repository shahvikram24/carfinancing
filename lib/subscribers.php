
<?php

// **********************
// CLASS DECLARATION
// **********************

class subscribers extends BaseClass
{ // class : begin


// **********************
// ATTRIBUTE DECLARATION
// **********************

var $id;   // KEY ATTR. WITH AUTOINCREMENT

var $name;   // (normal Attribute)
var $email;   // (normal Attribute)
var $status;   // (normal Attribute)
// **********************
// CONSTRUCTOR METHOD
// **********************

function __construct()
{
			
}


// **********************
// INSERT
// **********************

function insert()
{
		$this->id = ""; // clear key for autoincrement

		$SQL = " INSERT INTO tblsubscribers 
						SET 
							`name` = '" . $this->name . "', 
							`email` = '" . $this->email . "', 
							`status` = " . $this->status . "
							";

			//echo "<br/><br/><br/><br/><br/><br/>".$sql;		
			$this->id = parent::GetDALInstance()->SQLQuery($SQL,2);
			return $this->id;

}

// **********************
// UPDATE
// **********************

function update()
{
		$SQL = " UPDATE tblsubscribers 
				SET 
					`name` = '" . $this->name . "', 
					`email` = '" . $this->email . "', 
					`status` = " . $this->status ." 
                WHERE id=".$this->id;
		
		//echo "<br/><br/><br/><br/><br/><br/>".$SQL;
				
		// echo " <br/> ==> update =  " . $SQL . " <== <br/>";
        parent::GetDALInstance()->SQLQuery($SQL);
        
        return parent::GetDALInstance()->AffectedRows();
}

public function load($Condition = '') 
  	{
		
				
		$SQL = "SELECT * FROM tblsubscribers ";

		if($Condition !='')
			$SQL .= " WHERE " . $Condition;
		//echo "<br/><br/><br/><br/><br/><br/>".$SQL;

		parent::GetDALInstance()->SQLQuery($SQL);
		$row = parent::GetDALInstance()->GetRow(false);
			
		$ResultSet = new ResultSet();
	    if($ResultSet->LoadResult($SQL))
	        return $ResultSet;

	    
		return false;

	}

	public function unSubscribe($id,$value)
	{
		$SQL = " UPDATE tblsubscribers 
				SET 					
					`status` = " . $value ." 
                WHERE id=".$id;
		
		//echo "<br/><br/><br/><br/><br/><br/>".$SQL;
				
		// echo " <br/> ==> update =  " . $SQL . " <== <br/>";
        parent::GetDALInstance()->SQLQuery($SQL);
        
        return parent::GetDALInstance()->AffectedRows();
	}

public function sendNewsletter($filename,$subject)
  		{
  				global $Encrypt;

  				$subscribers = new subscribers();
    			$subscriberResult = $subscribers->load(' status = 1 ');

    			

  				if($subscriberResult->TotalResults>0)
				{
						
					for($x = 0; $x < $subscriberResult->TotalResults ; $x++)
					{

							//create a boundary string. It must be unique 
							//so we use the MD5 algorithm to generate a random hash 
							$random_hash = md5(date('r', time())); 
							
							$unsubscribe = APPROOT . "unsubscribe.php?" . $Encrypt->encrypt("subscriberId=".$subscriberResult->Result[$x]['id']."&Unsubscribe=true");
							

							// To send HTML mail, the Content-type header must be set
							$headers  = 'MIME-Version: 1.0' . "\r\n";
							$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
							$headers .= "From: no-reply@SupeCarLoans.ca" .  "\r\n";
							//add boundary string and mime type specification 
							//$headers .= "\r\nContent-Type: multipart/mixed; boundary=\"PHP-mixed-".$random_hash."\"";

						

			  				ob_start(); //Turn on output buffering

			  				
							//Fetch logo from server for email template
							$logo = APPROOT."img/logo.png";
							$hero = APPROOT."emailTemplates/images/600x500.png";
							//get contents of emailTemplates/basetemplate.html File from folder
							$baseStr = file_get_contents(WEBROOT .'emailTemplates/'.$filename);

							
							//replacing base template with logo
							$baseStr = str_replace("emailTemplate/logo.png",$logo,$baseStr);
							$baseStr = str_replace("images/hero-image-receipt.png",$hero,$baseStr);
							$baseStr = str_replace("###approot###",APPROOT,$baseStr);
							$baseStr = str_replace("###UNSUBSCRIBE###",$unsubscribe,$baseStr);
							

							$to = $subscriberResult->Result[$x]['email'];

					
				            ob_get_clean(); 
							$mailObj = new Email($to, NULL, $subject);

					        $mailObj->TextOnly = false;
					        $mailObj->Headers = $headers;
					        $mailObj->Content = $baseStr;

		        
						
							
							$mailObj->Send();
					}
						
						$Message = "Newsletter has been sent successfully";


					}
					else
					{
						$Message = "No subscribers for the newsletter";
					}
				
				return $Message;
  		}

} // class : end
?>
