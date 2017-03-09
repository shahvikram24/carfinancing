<?php
class ContactInfo extends BaseClass
{
	
	 public $Id;
	public $FirstName ='';
	public $LastName='';
	public $Address1='';
	public $Address2='';
	public $City='';
	public $Province='';
	public $Postal='';

	public $Country='';
	public $Phone1='';
	public $Email='';
	public $SIN='';
	public $DOB='';	
	public $MaritalStatus='';
	public $Gender='';
	public $ResidenceYears=0;
	public $ResidenceMonths=0;
	public $CreditScore=0;
	public $Notes='';
	public $ArchiveNotes='';
	public $ArchiveNotification='';
	public $Created='';	
	public $Notification=0;
	public $Status=0;
	
	
	
  	public function loadContactInfo($Id, $Condition = false) 
  	{

		$SQL = "SELECT * FROM tblcontactinfo WHERE Id = " . $Id ;
		
		if($Condition) 
		{
			$SQL .= ' AND Status = 1 ';
		}	

		parent::GetDALInstance()->SQLQuery($SQL);
		$row = parent::GetDALInstance()->GetRow(false);


			if($row)
			{
				$this->Id = $row['Id'];
				$this->FirstName = $row['FirstName'];
				$this->LastName = $row['LastName'];
				$this->Address1 = $row['Address1'];
				$this->Address2 = $row['Address2'];
				$this->Postal = $row['Postal'];
				$this->City = $row['City'];
				$this->Province = $row['Province'];
				$this->Country = $row['Country'];
				$this->Phone1 = $row['Phone1'];
				$this->Email = $row['Email'];
				$this->SIN = $row['SIN'];
				$this->DOB = $row['DOB'];
				$this->MaritalStatus = $row['MaritalStatus'];
				$this->Gender = $row['Gender'];
				$this->ResidenceYears = $row['ResidenceYears'];
				$this->ResidenceMonths = $row['ResidenceMonths'];
				$this->CreditScore = $row['CreditScore'];
				$this->Notes = $row['Notes'];
				$this->ArchiveNotes = $row['ArchiveNotes'];
				$this->ArchiveNotification = $row['ArchiveNotification'];
				$this->Created = $row['Created'];
				$this->Notification = $row['Notification'];
				$this->Status = $row['Status'];
				
				
				return $this;
			}
			return false;

	}
		
		
	public function addContactInfo() 
	{
			$SQL = " INSERT INTO tblcontactinfo 
				SET 
					FirstName = '" . $this->FirstName . "', 
					LastName = '" . $this->LastName . "', 
					Address1 = '" . $this->Address1 . "', 
					Address2 = '" . $this->Address2 . "', 
					Postal = '" . $this->Postal . "', 
					City = '" . $this->City . "', 
					Province = '" . $this->Province . "', 
					
					Phone1 = '" . $this->Phone1 . "', 
					Email = '" . $this->Email . "', 
					SIN = '" . $this->SIN . "', 
					DOB = '" . $this->DOB. "', 
					MaritalStatus = '" . $this->MaritalStatus . "', 
					Gender = '" . $this->Gender . "', 
					ResidenceYears = " . $this->ResidenceYears . ", 
					ResidenceMonths = " . $this->ResidenceMonths . ", 
					CreditScore = '" . $this->CreditScore . "', 
					Notes = '" . $this->Notes . "', 
					ArchiveNotes = '" . $this->ArchiveNotes . "', 
					ArchiveNotification = '" . $this->ArchiveNotification . "', 
					Created = '" . $this->Created . "', 
					Notification = " . $this->Notification . ", 
					Status = " . $this->Status . "

					";
			//echo "<br/><br/><br/><br/><br/><br/>".$SQL;		
			$this->Id = parent::GetDALInstance()->SQLQuery($SQL,2);
			return $this->Id;
	}


	public function updateContactInfo() 
	{
		
		$SQL = " UPDATE tblcontactinfo 
		SET 
			FirstName = '" . $this->FirstName . "', 
			LastName = '" . $this->LastName . "', 
			Address1 = '" . $this->Address1 . "', 
			Address2 = '" . $this->Address2 . "', 
			Postal = '" . $this->Postal . "', 
			City = '" . $this->City . "', 
			Province = '" . $this->Province . "', 
			
			Phone1 = '" . $this->Phone1 . "', 
			Email = '" . $this->Email . "', 
			SIN = '" . $this->SIN . "', 
			DOB = '" . $this->DOB. "', 
			MaritalStatus = '" . $this->MaritalStatus . "', 
			Gender = '" . $this->Gender . "', 
			ResidenceYears = " . $this->ResidenceYears . ", 
			ResidenceMonths = " . $this->ResidenceMonths . ", 
			CreditScore = '" . $this->CreditScore . "', 
			Notes = '" . $this->Notes . "', 
			ArchiveNotes = '" . $this->ArchiveNotes . "', 
			ArchiveNotification = '" . $this->ArchiveNotification . "', 
			Created = '" . $this->Created . "', 
			Notification = " . $this->Notification . ", 
			Status=".$this->Status." 
                WHERE Id=".$this->Id;
		
		//echo "<br/><br/><br/><br/><br/><br/>".$SQL;
				
		// echo " <br/> ==> update =  " . $SQL . " <== <br/>";
        parent::GetDALInstance()->SQLQuery($SQL);
        
        return parent::GetDALInstance()->AffectedRows();

	}
	
	public function loadIncompleteApplication($Condition = '') 
  	{
		
				
		$SQL = "SELECT * FROM tblcontactinfo CI
				WHERE CI.Status = 3  ORDER BY Created DESC";

		if($Condition !='')
			$SQL .= $Condition;
		//echo "<br/><br/><br/><br/><br/><br/>".$SQL;

		parent::GetDALInstance()->SQLQuery($SQL);
		$row = parent::GetDALInstance()->GetRow(false);
			
		$ResultSet = new ResultSet();
	    if($ResultSet->LoadResult($SQL))
	        return $ResultSet;

	    
		return false;

	}

	public function loadArchivedApplication($Condition = '') 
  	{
		
				
		$SQL = "SELECT * FROM tblcontactinfo CI
				WHERE CI.Status = 0  ";

		if($Condition !='')
			$SQL .= $Condition;
		//echo "<br/><br/><br/><br/><br/><br/>".$SQL;

		parent::GetDALInstance()->SQLQuery($SQL);
		$row = parent::GetDALInstance()->GetRow(false);
			
		$ResultSet = new ResultSet();
	    if($ResultSet->LoadResult($SQL))
	        return $ResultSet;

	    
		return false;

	}

	public function setNotification($Id,$Notification=0)
	{
		$SQL = "UPDATE tblcontactinfo 
				SET 
					Notification = ". $Notification." 
				WHERE Id IN (" . $Id .")

		";

		parent::GetDALInstance()->SQLQuery($SQL);
        
        return parent::GetDALInstance()->AffectedRows();
	}


	public function deleteApplication($Id)
	{
		$SQL = "DELETE FROM tblcontactinfo 
				WHERE Id IN (" . $Id .")

		";

		parent::GetDALInstance()->SQLQuery($SQL);
        
        return parent::GetDALInstance()->AffectedRows();
	}

	public function GetFullName($Id)
	{
		$SQL = "SELECT FirstName AS 'Fname', LastName AS 'Lname' 
				FROM tblcontactinfo 
				WHERE Id = " . $Id . " AND Status IN (0,1,3)

		";

		//echo  "\n". $SQL . "\n";

		parent::GetDALInstance()->SQLQuery($SQL);
		$row = parent::GetDALInstance()->GetRow();

		return ($row) ? $row["Fname"] . " " . $row["Lname"] : 0;
		
	}

	public function IncompleteCount()
	{
		$SQL = "SELECT count(*) AS 'TotalLeads'
				FROM tblcontactinfo 
				WHERE Status IN (3)

		";

		parent::GetDALInstance()->SQLQuery($SQL);
		$row = parent::GetDALInstance()->GetRow();

		return ($row) ? $row["TotalLeads"] : 0;
	}

	public function UnreadCount()
	{
		$SQL = "SELECT count(*) AS 'TotalLeads'
				FROM tblcontactinfo 
				WHERE Notification IN (1)
					AND Status IN (3) 

		";

		parent::GetDALInstance()->SQLQuery($SQL);
		$row = parent::GetDALInstance()->GetRow();

		return ($row) ? $row["TotalLeads"] : 0;
	}

	public function ArchivedCount()
	{
		$SQL = "SELECT count(*) AS 'TotalLeads'
				FROM tblcontactinfo 
				WHERE Status IN (0)

		";

		parent::GetDALInstance()->SQLQuery($SQL);
		$row = parent::GetDALInstance()->GetRow();

		return ($row) ? $row["TotalLeads"] : 0;
	}

	public function ArchiveNotification($Condition = '') 
  	{
		
				
		$SQL = "SELECT * FROM tblcontactinfo CI
				WHERE CI.Status = 0  AND CI.ArchiveNotification IS NOT NULL ";

		if($Condition !='')
			$SQL .= $Condition;
		//echo "<br/><br/><br/><br/><br/><br/>".$SQL;

		parent::GetDALInstance()->SQLQuery($SQL);
		$row = parent::GetDALInstance()->GetRow(false);
			
		$ResultSet = new ResultSet();
	    if($ResultSet->LoadResult($SQL))
	        return $ResultSet;

	    
		return false;

	}

	public function ConfirmAccount($Email,$Encryption,$Name)
  		{
  				
  				$to = $Email;

  				//define the subject of the email 
				$subject = "Verify Email Address on SupeCarLoans";
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

  				
				//Fetch logo from server for email template
				$logo = APPROOT."img/logo.png";
				$hero = APPROOT."emailTemplates/images/hero-image-receipt.png";
				//get contents of emailTemplates/basetemplate.html File from folder
				$baseStr = file_get_contents(WEBROOT .'emailTemplates/emailverify.html');

				
				//replacing base template with logo
				$baseStr = str_replace("emailTemplate/logo.png",$logo,$baseStr);
				
				$baseStr = str_replace("###approot###",APPROOT,$baseStr);
				$baseStr = str_replace("###NAME###",$Name,$baseStr);
				$baseStr = str_replace("###CONFIRM###",$Encryption,$baseStr);
	

		
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


  		public function SendTemplate($Leads,$Template)
  		{
  				global $Encrypt;
  				
  				
  				if(count($Leads)>0)
				{
					$ContactInfo = new ContactInfo();
					for($x = 0; $x < count($Leads) ; $x++)
					{
							
							$ContactInfo->loadContactInfo($Leads[$x]);


			  				$to = $ContactInfo->Email;

			  				//define the subject of the email 
							$subject = "Oops! Your SupeCarLoans Credit Application is Incomplete";
							//create a boundary string. It must be unique 
							//so we use the MD5 algorithm to generate a random hash 
							$random_hash = md5(date('r', time())); 
							
							

							// To send HTML mail, the Content-type header must be set
							$headers  = 'MIME-Version: 1.0' . "\r\n";
							$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
							$headers .= "From: no-reply@SupeCarLoans.ca" .  "\r\n";
							//add boundary string and mime type specification 
							//$headers .= "\r\nContent-Type: multipart/mixed; boundary=\"PHP-mixed-".$random_hash."\"";

							$Encryption = APPROOT.'application.php?' . $Encrypt->encrypt('ContactInfoId='.$Leads[$x].'&Assigned=true');

			  				ob_start(); //Turn on output buffering

			  				
							//Fetch logo from server for email template
							$logo = APPROOT."img/logo.png";
							$hero = APPROOT."emailTemplates/images/hero-image-receipt.png";
							//get contents of emailTemplates/basetemplate.html File from folder
							$baseStr = file_get_contents(WEBROOT .'emailTemplates/'.Template::getColumn($Template,'Filename'));

							
							//replacing base template with logo
							$baseStr = str_replace("emailTemplate/logo.png",$logo,$baseStr);
							
							$baseStr = str_replace("###approot###",APPROOT,$baseStr);
							$baseStr = str_replace("###NAME###",$ContactInfo->FirstName,$baseStr);
							$baseStr = str_replace("###STEP2LINK###",$Encryption,$baseStr);
				

					
				            ob_get_clean(); 
							$mailObj = new Email($to, NULL, $subject);

					        $mailObj->TextOnly = false;
					        $mailObj->Headers = $headers;

					        $mailObj->Content = $baseStr;

					        if($mailObj->Send())
					        {
					        	$tblmail = new TblMail();
					        	$tblmail->ContactInfoId = $ContactInfo->Id;
					        	$tblmail->TemplateId = Template::getColumn($Template,'Id');
					        	$tblmail->DateSent = date('Y-m-d H:i:s');
					        	$tblmail->Status = 1;
					        	$tblmail->addMail();
					        }
					}
					return true;
				}
				else{
					return false;	
				}				
  		}
	
}
?>