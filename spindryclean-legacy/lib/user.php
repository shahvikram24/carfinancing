<?php
class Login extends BaseClass{
	public $Id;
	public $CustomerId;
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
				$this->CustomerId = $row['CustomerId'];
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
					SET Id = '" . $this->Id . "', 
						CustomerId = " . $this->CustomerId . ", 
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
				SET Id = '" . $this->Id . "',
						CustomerId = " . $this->CustomerId . ", 
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
  		
	public function loadcustomerinfobycustomerid($CustomerId) {
		
				
	$SQL = "SELECT * FROM tbllogin WHERE CustomerId = " . $CustomerId ;
	parent::GetDALInstance()->SQLQuery($SQL);
	$row = parent::GetDALInstance()->GetRow(false);
		//echo "<br/><br/><br/><br/><br/><br/>".$SQL;	
			if($row)
			{
				$this->Id = $row['Id'];
				$this->CustomerId = $row['CustomerId'];
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
            $SQL = "SELECT CustomerId
                    FROM tbllogin 
                    WHERE EmailId='".$UserLogin."'";
                
                parent::GetDALInstance()->SQLQuery($SQL);
				//echo "<br/><br/><br/><br/><br/><br/>".$SQL;	
				$row = parent::GetDALInstance()->GetRow();
				return ($row) ? $row[0] : false;
			

		}
		

	public function GetName($CustomerId)
	{
		$SQL = "SELECT EmailId 
				FROM tbllogin 
				WHERE Status = 1 AND CustomerId=" . $CustomerId 
				
		;

		//echo  "\n". $SQL . "\n";

		parent::GetDALInstance()->SQLQuery($SQL);
		$row = parent::GetDALInstance()->GetRow();

		return ($row) ? $row["EmailId"] : 0;
	}

  		/*public function sendEmailActivation($Email)
  		{

  					$Root = WEBROOT . "templates/activationlink.html";
                    $str = implode("\n",file($Root));
                    $fp=fopen($Root,'w');

                    //replace something in the file string - this is a VERY simple example
                    //$str=str_replace( "<!--EMAILID-->", $Email,$str);
                    $str=str_replace( "<!--ACTIVATIONLINK-->", APPROOT . "login.php?" . $Encrypt->encrypt('CustomerId=' . $customerId . "&ExpireDate=" . date("Y-m-d", mktime(0, 0, 0, date("m") , date("d") + 2, date("Y"))) . "&ActivateAccount=true"),$str);
                      
                     
                    //now, TOTALLY rewrite the file
                    fwrite($fp,$str,strlen($str));
                    fclose($fp);
                    
					 $file = fopen($Root, 'rb');
					$data = fread($file, filesize($Root));


                    $headers = "From: no-reply@spindryclean.com";
                    $to = $Email;

                   
					
					$subject = "SPIN Account Created - Activate and Explore your new account now!";
					$ok = @mail($to, $subject, $data, $headers);
					
					
		            if($ok)
		            	return true;
		            else
		            	return false;

		           fclose($file);
  		}*/

  		public function sendEmailActivation($CustomerId,$Encryption)
  		{
  				
  				$Customer = new Customer();
				$Customer->loadcustomer($CustomerId,true);

				$Login = new Login();
				$Login->loadcustomerinfobycustomerid($CustomerId);

  				 $to = $Login->EmailId;

  				//define the subject of the email 
				$subject = "SPIN Account Created - Activate and Explore your new account!";
				//create a boundary string. It must be unique 
				//so we use the MD5 algorithm to generate a random hash 
				$random_hash = md5(date('r', time())); 
				
				

				// To send HTML mail, the Content-type header must be set
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers .= "From: no-reply@spindryclean.com" .  "\r\n";
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
									<td colspan='2'>Hi ".$Customer->FirstName.", </td>
							    </tr>
							    <tr>
									<td colspan='2'>Thank you for joining SPIN!</td>
							    </tr>
							    <tr>
									<td colspan='2'>Here are your account details:</td>
							    </tr>
								
								<tr>
									<td align='right'>Login Email:</td><td>".$Login->EmailId."</td>
							    </tr>
							    <tr>
									<td align='right'>Work Address:</td><td>".$Customer->Address1 
														."<br/>" . (($Customer->Address2 ) ? 'Apt: '.$Customer->Address2 : '')
														."<br/>" . $Customer->City 
														."<br/>" . $Customer->Province  
														." " . $Customer->PostalCode  
														."</td>
							    </tr>
							    <tr>
									<td align='right'>Cellphone Number:</td><td>".$Customer->Cellphone."</td>
							    </tr>

								<tr>
									<td align='right'>Activation link:</td><td>
										<a href='http://spindryclean.com/members/index.php?" . $Encryption
										."' target='_blank'>Activate here </a></td>
							    </tr>
							     <tr>
									<td colspan='2'>Simply log into your account to make any changes or to schedule your first pickup.</td>
							    </tr>
							    <tr>
									<td colspan='2'>We look forward to seeing you shortly!</td>
							    </tr>
							    <tr>
									<td colspan='2'>SPIN 
									<br/> Professional Dry Cleaning
									<br/> and Laundry Delivery
									</td>
							    </tr>
							     
								
								
							</table>
							</body>
							</html>

		";

					

                   ob_get_clean(); 
					
					
					$ok = @mail($to, $subject, $ReturnString, $headers);
					
					
		            if($ok)
						return true;
		            else
		            	return false;
  		}


  		public function sendRecoverPasswordLink($Email,$Encryption)
  		{
  				
  				

  				
  				 $to = $Email;

  				//define the subject of the email 
				$subject = "Password Reset Feature from SPIN";
				//create a boundary string. It must be unique 
				//so we use the MD5 algorithm to generate a random hash 
				$random_hash = md5(date('r', time())); 
				
				

				// To send HTML mail, the Content-type header must be set
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers .= "From: no-reply@spindryclean.com" .  "\r\n";
				//add boundary string and mime type specification 
				//$headers .= "\r\nContent-Type: multipart/mixed; boundary=\"PHP-mixed-".$random_hash."\""; 

				

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
									<td colspan='2'>Dear Customer, </td>
							    </tr>
							    
							    <tr>
									<td colspan='2'>To reset your password, simply click the link below. That will take you to a web page where you can create a new password.</td>
							    </tr>
							    

								<tr>
									<td colspan='2'>Your account details are: </td>
							    </tr>
								
								<tr>
									<td align='right'>Emailid for login:</td><td>".$Email."</td>
							    </tr>
								<tr>
									<td align='right'>Reset Password link:</td><td>
										<a href='http://spindryclean.com/emailchangepassword.php?" . $Encryption
										."' target='_blank'>Reset Password </a></td>
							    </tr>
							     <tr>
									<td colspan='2'>If you weren't trying to reset your password, don't worry – your account is still secure and no one has been given access to it. Most likely, someone just mistyped their email address while trying to reset their own password.</td>
							    </tr>
							    <tr>
									<td colspan='2'>Simply ignore this email and use your current password to login <a href='http://spindryclean.com/members/index.php' target='_blank'>here</a> and place your next order. </td>
							    </tr>
							    <tr>
									<td colspan='2'>Please <a href='http://spindryclean.com/contact.php' target='_blank'>contact us </a> should you have any questions or need further assistance. </td>
							    </tr>
							    <tr>
									<td colspan='2'>Thank you for shopping with us! </td>
							    </tr>   
							    <tr>
									<td colspan='2'>SPIN....  All your cleaning needs</td>
							    </tr>
							     
								
								
							</table>
							</body>
							</html>

		";

					

                   ob_get_clean(); 
					
					
					$ok = @mail($to, $subject, $ReturnString, $headers);
					
					
		            if($ok)
						return true;
		            else
		            	return false;
  		}

  		public function sendConfirmedRecoveredPassword($Email)
  		{
  				
  				

  				
  				 $to = $Email;

  				//define the subject of the email 
				$subject = "Password Successfully Reset on SPIN";
				//create a boundary string. It must be unique 
				//so we use the MD5 algorithm to generate a random hash 
				$random_hash = md5(date('r', time())); 
				
				

				// To send HTML mail, the Content-type header must be set
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers .= "From: no-reply@spindryclean.com" .  "\r\n";
				//add boundary string and mime type specification 
				//$headers .= "\r\nContent-Type: multipart/mixed; boundary=\"PHP-mixed-".$random_hash."\"";

				

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
									<td colspan='2'>Dear Customer, </td>
							    </tr>
							    
							    <tr>
									<td colspan='2'>The password for the username ".$Email." has been successfully reset.</td>
							    </tr>
							    

								
							     <tr>
									<td colspan='2'>If you believe you have received this email in error, or that an unauthorized person has accessed your account, please go to 
											<a href='http://spindryclean.com/members/#signup' target='_blank'> Recover Password </a> to reset your password immediately. </td>
							    </tr>
							    
							    <tr>
									<td colspan='2'>Please <a href='http://spindryclean.com/contact.php' target='_blank'>contact us </a> should you have any questions or need further assistance. </td>
							    </tr>
							    <tr>
									<td colspan='2'>Thank you for shopping with us! </td>
							    </tr>   
							    <tr>
									<td colspan='2'>SPIN....  All your cleaning needs</td>
							    </tr>
							     
								
								
							</table>
							</body>
							</html>

		";

					

                   ob_get_clean(); 
					
					
					$ok = @mail($to, $subject, $ReturnString, $headers);
					
					
		            if($ok)
						return true;
		            else
		            	return false;
  		}


public function ComingSoon($Email,$Encryption)
  		{
  				
  				
  				 $to = $Email;

  				//define the subject of the email 
				$subject = "SPIN DryCleaning Account Created!";
				//create a boundary string. It must be unique 
				//so we use the MD5 algorithm to generate a random hash 
				$random_hash = md5(date('r', time())); 
				
				

				// To send HTML mail, the Content-type header must be set
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers .= "From: no-reply@spindryclean.com" .  "\r\n";
				//add boundary string and mime type specification 
				//$headers .= "\r\nContent-Type: multipart/mixed; boundary=\"PHP-mixed-".$random_hash."\"";

				

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
									<td colspan='2'>Dear Customer, </td>
							    </tr>
							    <tr>
									<td colspan='2'>Greetings from SPINing and Laundry Services!</td>
							    </tr>
							    <tr>
									<td colspan='2'>We've created a new SPIN account for you. A SPIN account gives you a personalized garments dry cleaned in the most convenient way there is.</td>
							    </tr>
							    

								<tr>
									<td colspan='2'>Your account details are: </td>
							    </tr>
								
								<tr>
									<td align='right'>Emailid for login:</td><td>".$Email."</td>
							    </tr>
								
							     <tr>
									<td colspan='2'>We look forward to take care of your dry cleaning needs, giving you the time to enjoy the more important things in life. </td>
							    </tr>
							    <tr>
									<td colspan='2'>Please contact us on service@spindryclean.com should you have any questions or need further assistance. </td>
							    </tr>
							      
							    <tr>
									<td colspan='2'>SPINing and Laundry Services....</td>
							    </tr>
							     
								
								
							</table>
							</body>
							</html>

		";

					

                   ob_get_clean(); 
					
					
					$ok = @mail($to, $subject, $ReturnString, $headers);
					
					
		            if($ok)
						return true;
		            else
		            	return false;
  		}

	public function NewRegistration($customerId,$Email)
  		{
  				$customer = new Customer();
  				$customer->loadcustomerCheck($customerId);
  				
  				 $to = "service@spindryclean.com";

  				//define the subject of the email 
				$subject = "SPIN DryCleaning New Registration!";
				//create a boundary string. It must be unique 
				//so we use the MD5 algorithm to generate a random hash 
				$random_hash = md5(date('r', time())); 
				
				

				// To send HTML mail, the Content-type header must be set
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers .= "From: no-reply@spindryclean.com" .  "\r\n";
				//add boundary string and mime type specification 
				//$headers .= "\r\nContent-Type: multipart/mixed; boundary=\"PHP-mixed-".$random_hash."\""; 

				

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
									<td colspan='2'>Dear Admin, </td>
							    </tr>
							    <tr>
									<td colspan='2'>New Registered user information:</td>
							    </tr>
							    
								<tr>
									<td align='right'>Business Name:</td><td>".$customer->BusinessName."</td>
							    </tr>
								
							    <tr>
									<td align='right'>Name:</td><td>".$customer->FirstName. " " . $customer->LastName ."</td>
							    </tr>
							    <tr>
									<td align='right'>Phone:</td><td>".$customer->Cellphone."</td>
							    </tr>
							     <tr>
									<td align='right'>Email:</td><td>".$Email."</td>
							    </tr>
								
							</table>
							</body>
							</html>

		";

					

                   ob_get_clean(); 
					
					
					$ok = @mail($to, $subject, $ReturnString, $headers);
					
					
		            if($ok)
						return true;
		            else
		            	return false;
  		}

  	public function NewOrder($OrderId)
  		{
  				$Info = Order::GetInfoById($OrderId);
  				
  				 $to = "service@spindryclean.com";

  				//define the subject of the email 
				$subject = "SPIN New Order!";
				//create a boundary string. It must be unique 
				//so we use the MD5 algorithm to generate a random hash 
				$random_hash = md5(date('r', time())); 
				
				

				// To send HTML mail, the Content-type header must be set
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers .= "From: no-reply@spindryclean.com" .  "\r\n";
				//add boundary string and mime type specification 
				//$headers .= "\r\nContent-Type: multipart/mixed; boundary=\"PHP-mixed-".$random_hash."\""; 

				

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
									<td colspan='2'>Dear Admin, </td>
							    </tr>
							    <tr>
									<td colspan='2'>New order information:</td>
							    </tr>
							    
								<tr>
									<td align='right'>Oder Number:</td><td>". $Info->Result[0]['OrderId']."</td>
							    </tr>
							    <tr>
									<td align='right'>Pickup Date:</td><td>".$Info->Result[0]['PickupDate']."</td>
							    </tr>
								
							     <tr>
									<td align='right'>Email:</td><td>".$Info->Result[0]['EmailId']."</td>
							    </tr>
								
							</table>
							</body>
							</html>

		";

					

                   ob_get_clean(); 
					
					
					$ok = @mail($to, $subject, $ReturnString, $headers);
					
					
		            if($ok)
						return true;
		            else
		            	return false;
  		}


	public function AcceptOrderConfirmation($OrderId)
  		{
  				$Info = Order::GetInfoById($OrderId);
  				
  				
  				 $to = $Info->Result[0]['EmailId'];

  				//define the subject of the email 
				$subject = "SPIN Order Confirmation!";
				//create a boundary string. It must be unique 
				//so we use the MD5 algorithm to generate a random hash 
				$random_hash = md5(date('r', time())); 
				
				

				// To send HTML mail, the Content-type header must be set
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers .= "From: no-reply@spindryclean.com" .  "\r\n" . "Reply-To: help@spindryclean.com" . "\r\n" ;
				//add boundary string and mime type specification 
				//$headers .= "\r\nContent-Type: multipart/mixed; boundary=\"PHP-mixed-".$random_hash."\""; 

				

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
									<td colspan='2'>Hi ". $Info->Result[0]['FirstName'] .", </td>
							    </tr>
							    <tr>
									<td colspan='2'>Your most recent  order: <strong>" .  $Info->Result[0]['OrderId']  ." </strong> has been confirmed for <strong> " .  $Info->Result[0]['PickupDate']  ." </strong> </td>
							    </tr>
							    
								<tr>
									<td colspan='2'>One of our valets may contact you should we require any further information.</td>
							    </tr>
							    <tr>
									<td colspan='2'>Thanks for using SPIN!</td>
							    </tr>
								
							</table>
							</body>
							</html>

		";

					

                   ob_get_clean(); 
					
					
					$ok = @mail($to, $subject, $ReturnString, $headers);
					
		            if($ok)
						return true;
		            else
		            	return false;
  		}

	public function RejectOrderConfirmation($OrderId)
	{
	  				$Info = Order::GetInfoById($OrderId);
	  				
	  				
	  				 $to = $Info->Result[0]['EmailId'];

	  				//define the subject of the email 
					$subject = "SPIN Order Rejection!";
					//create a boundary string. It must be unique 
					//so we use the MD5 algorithm to generate a random hash 
					$random_hash = md5(date('r', time())); 
					
					

					// To send HTML mail, the Content-type header must be set
					$headers  = 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
					$headers .= "From: no-reply@spindryclean.com" .  "\r\n" . "Reply-To: help@spindryclean.com" . "\r\n" ;
					//add boundary string and mime type specification 
					//$headers .= "\r\nContent-Type: multipart/mixed; boundary=\"PHP-mixed-".$random_hash."\""; 

					

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
										<td colspan='2'>Hi ". $Info->Result[0]['FirstName'] .", </td>
								    </tr>
								    <tr>
										<td colspan='2'>Unfortunately, we are unable to pickup your order for the following reason:</td>
								    </tr>
								    
									<tr>
										<td colspan='2' style='color:#F23016'>". $Info->Result[0]['RejectReason'] ."</td>
								    </tr>
								    <tr>
										<td colspan='2'>Please feel free to contact us at <strong> 1 888 990 6886 </strong> or by email, should you have further questions.</td>
								    </tr>
									
								</table>
								</body>
								</html>

			";

						

	                   ob_get_clean(); 
						
						
						$ok = @mail($to, $subject, $ReturnString, $headers);
						
			            if($ok)
							return true;
			            else
			            	return false;
  	}

  	public function sendEmailAdmin($CustomerId)
  		{
  				
  				$Customer = new Customer();
				$Customer->loadcustomer($CustomerId,true);

				$Login = new Login();
				$Login->loadcustomerinfobycustomerid($CustomerId);

  				 $to = ADMINEMAIL;

  				//define the subject of the email 
				$subject = "SPIN New User Registered!";
				//create a boundary string. It must be unique 
				//so we use the MD5 algorithm to generate a random hash 
				$random_hash = md5(date('r', time())); 
				
				

				// To send HTML mail, the Content-type header must be set
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers .= "From: no-reply@spindryclean.com" .  "\r\n";
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
									<td colspan='2'>Hi ".$Customer->FirstName.", </td>
							    </tr>
							    
							    <tr>
									<td colspan='2'>Here are your account details:</td>
							    </tr>
								<tr>
									<td align='right'>Full Name:</td><td>".$Customer->FirstName . " ". $Customer->LastName ."</td>
							    </tr>
								<tr>
									<td align='right'>Login Email:</td><td>".$Login->EmailId."</td>
							    </tr>
							    <tr>
									<td align='right'>Work Address:</td><td>".$Customer->Address1 
														."<br/>" . (($Customer->Address2 ) ? 'Apt: '.$Customer->Address2 : '')
														."<br/>" . $Customer->City 
														."<br/>" . $Customer->Province  
														." " . $Customer->PostalCode  
														."</td>
							    </tr>
							    <tr>
									<td align='right'>Cellphone Number:</td><td>".$Customer->Cellphone."</td>
							    </tr>

							    <tr>
									<td colspan='2'>SPIN 
									<br/> Professional Dry Cleaning
									<br/> and Laundry Delivery
									</td>
							    </tr>
							     
								
								
							</table>
							</body>
							</html>

		";

					

                   ob_get_clean(); 
					
					
					$ok = @mail($to, $subject, $ReturnString, $headers);
					
					
		            if($ok)
						return true;
		            else
		            	return false;
  		}
}

?>