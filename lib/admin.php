
<?php
/*
*
* -------------------------------------------------------
* CLASSNAME:        Admin
* CREATION DATE:    20.07.2015
* CLASS FILE:       class.Admin.php
* FOR MYSQL TABLE:  admin
* FOR MYSQL DB:     apxhotels
* -------------------------------------------------------
*
*/



// **********************
// CLASS DECLARATION
// **********************

class Admin extends BaseClass
{ // class : begin


// **********************
// ATTRIBUTE DECLARATION
// **********************

var $Id;   // KEY ATTR. WITH AUTOINCREMENT

var $id;   // (normal Attribute)
var $username;   // (normal Attribute)
var $email;   // (normal Attribute)
var $SALT;   // (normal Attribute)
var $HASH;   // (normal Attribute)
var $Status;   // (normal Attribute)
// **********************
// CONSTRUCTOR METHOD
// **********************

function __construct()
		{
			parent::__construct();
		}

// **********************
// GETTER METHODS
// **********************


function getid()
{return $this->id; }
function getusername()
{return $this->username; }
function getemail()
{return $this->email; }
function getSALT()
{return $this->SALT; }
function getHASH()
{return $this->HASH; }
function getStatus()
{return $this->Status; }
// **********************
// SETTER METHODS
// **********************


function setid($val)
{
$this->id =  $val;
}

function setusername($val)
{
$this->username =  $val;
}

function setemail($val)
{
$this->email =  $val;
}

function setSALT($val)
{
$this->SALT =  $val;
}

function setHASH($val)
{
$this->HASH =  $val;
}

function setStatus($val)
{
$this->Status =  $val;
}

// **********************
// SELECT METHOD / LOAD
// **********************

function select($id)
{

$sql =  "SELECT * FROM admin WHERE Id = $id;";
$result =  mysql_query($sql);
$row = mysql_fetch_object($result);

$this->id = $row->id;$this->username = $row->username;$this->email = $row->email;$this->SALT = $row->SALT;$this->HASH = $row->HASH;$this->Status = $row->Status;}
// **********************
// DELETE
// **********************

function delete($id)
{
$sql = "DELETE FROM admin WHERE Id = $id;";
$result = mysql_query($sql);

}

// **********************
// INSERT
// **********************

function insert()
{
$this->Id = ""; // clear key for autoincrement

$sql = "INSERT INTO admin ( Id,username,email,SALT,HASH,Status ) VALUES ( '$this->id','$this->username','$this->email','$this->SALT','$this->HASH','$this->Status' )";
$result = mysql_query($sql);
$this->Id = mysql_insert_id();

}

// **********************
// UPDATE
// **********************

function update($id)
{
$sql = " UPDATE admin SET  username = '$this->username',email = '$this->email',SALT = '$this->SALT',HASH = '$this->HASH',Status = '$this->Status' WHERE Id = $id ";
$result = mysql_query($sql);
}

public function LoadInfo($Id) 
	{
			$SQL = "SELECT * FROM admin WHERE Id=".$Id;
			parent::GetDALInstance()->SQLQuery($SQL);
			$row = parent::GetDALInstance()->GetRow(false);
				//echo "<br/><br/><br/><br/><br/><br/>".$SQL;	
			if($row)
			{
				$this->Id = $row['Id'];
				$this->username = $row['username'];
				$this->email = $row['email'];
				$this->SALT = $row['SALT'];
				$this->HASH = $row['HASH'];
				$this->Status = $row['Status'];
				return $this;
			}
			return false;

	}

public function LoadInfoByUsername($UserLogin) 
	{
			$SQL = "SELECT * FROM admin WHERE username='".$UserLogin."' ";
			parent::GetDALInstance()->SQLQuery($SQL);
			$row = parent::GetDALInstance()->GetRow(false);
				//echo "<br/><br/><br/><br/><br/><br/>".$SQL;	
			if($row)
			{
				$this->Id = $row['Id'];
				$this->username = $row['username'];
				$this->email = $row['email'];
				$this->SALT = $row['SALT'];
				$this->HASH = $row['HASH'];
				$this->Status = $row['Status'];
				return $this;
			}
			return false;

	}

public function sendRecoverPasswordLink($Email,$Encryption)
  	{
		 $to = $Email;

		//define the subject of the email 
		$subject = "Password Reset Feature from Car Financing Help";
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

		//emailtemplate for password reset starts here
		
		//setting reset password link
		$resetPasswordLink = ADMINAPPROOT . "change-password.php?" . $Encryption;
		
		//Fetch logo from server for email template
		$logo = APPROOT."images/avatar/logo.png";
		
		//get contents of emailTemplates/basetemplate.html File from folder
		$baseStr = file_get_contents(WEBROOT .'emailTemplates/basetemplate.html');
		
		//get Forgetpassword template file from emailTemplate folder
		$forgetpasswordlinkStr = file_get_contents(WEBROOT .'emailTemplates/forgetpasswordlink.html');
		
		//replacing base template with logo
		$baseStr = str_replace("emailTemplate/logo.png",$logo,$baseStr);
		
		//replacing contents of forgetpassword link Email and activation link
		$forgetpasswordlinkStr = str_replace("resetpasswordlink.html", $resetPasswordLink, $forgetpasswordlinkStr);
		$forgetpasswordlinkStr = str_replace('###Email###', $to, $forgetpasswordlinkStr);
		
		//put forgetpasswrod template in base template
		$baseStr = str_replace("###replaceArea###",$forgetpasswordlinkStr,$baseStr);
		
		//echo $baseStr; die;
	
	
	
	
		//emailtemplate for password reset ends here

		ob_get_clean(); 
			$mailObj = new Email($to, NULL, $subject);

        $mailObj->TextOnly = false;
        $mailObj->Headers = $headers;

        $mailObj->Content = $baseStr;  

        //($mailObj->Send())

		//$ok = @mail($to, $subject, $baseStr, $headers);
		
		
        //if($ok)
        if($mailObj->Send())
			return true;
        else
        	return false;
  	}
} // class : end
?>
