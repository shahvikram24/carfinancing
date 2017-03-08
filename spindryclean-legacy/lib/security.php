<?php

class Security extends BaseClass {
    
    static function CreateUserSession($UserObject) {
        //global $User;
        //$User = $UserObject;
        $_SESSION[WEBUSER] = serialize($UserObject);
        $_SESSION[PREVIOUS_HTTP_USER_AGENT] = $_SERVER['HTTP_USER_AGENT'];
        $_SESSION[HTTP_USER_AGENT] = md5($_SERVER['HTTP_USER_AGENT'].HIJACKKEY);
        $_SESSION[ISMOBILE] = serialize(IsMobile(true));
    }  


    function Authorize($UserLogin, $Password) {
        $SQL = "SELECT Id, CustomerId, SALT, HASH FROM tbllogin WHERE EmailId='$UserLogin' AND status=1";
		
        parent::GetDALInstance()->SQLQuery($SQL);
		
        $Result = parent::GetDALInstance()->GetRow();

        $returnValue = false;
        //debugObj(GenerateHASH($Result['SALT'], $Password));
        //debugObj($Result['HASH']);
        
        if($Result) {
            if(GenerateHASH($Result['SALT'], $Password) == $Result['HASH']) {
                $affiliate = new Customer();

                $affiliate->loadcustomer($Result['CustomerId']);
                
                /*if($RememberMe)
                    Security::CreateCookie($User->UserLogin);
                else
                    Security::DestroyCookie();*/

                    Security::DestroyCookie();
				  $_SESSION['customer_id'] = $affiliate->Id;
				 Security::CreateCookie($UserLogin);
                $returnValue = true;
            }
            else {
                $returnValue = false;
            }
        }
        else {
            $returnValue = false;
        }

        return $returnValue;
    }

    public function AuthorizeAdmin($UserLogin, $Password) {
        $SQL = "SELECT id, username, SALT, HASH FROM admin WHERE username='$UserLogin' AND status=1";
        
        parent::GetDALInstance()->SQLQuery($SQL);
        
        $Result = parent::GetDALInstance()->GetRow();

        $returnValue = false;
        
       
        if($Result) {
            if(GenerateHASH($Result['SALT'], $Password) == $Result['HASH']) {
                $_SESSION['admin_id'] = $Result['id'];
                $returnValue = true;
            }
            else {
                    $returnValue = false;
                }
        }
        else {
            $returnValue = false;
        }

        return $returnValue;
    }
    
	function ChangeUserPassword($UserId, $OldPassword, $NewPassword)
		{
			if(NumberCheck($UserId))
			{
				
				$SQL = "SELECT  Id, CustomerId, SALT, HASH FROM tbllogin WHERE Id=".$UserId." AND Status=1";
				parent::GetDALInstance()->SQLQuery($SQL);
				$Result = parent::GetDALInstance()->GetRow();

                
				if($Result)
				{
					$Salt = $Result['SALT'];

					
						$Hash = GenerateHASH($Salt, $NewPassword);
						$SQL = "UPDATE tbllogin SET HASH='".$Hash."' WHERE Id=".$UserId." AND Status=1";
						parent::GetDALInstance()->SQLQuery($SQL);

                        return true;
					
				}
			}

			return false;
		}
		
	

    function CheckUserExistsByLogin($UserLogin, $Condition='')
        {
            
            /*

                Status:
                            0:  Activation email sent and waiting to activate 
                            1:  Active user                 
                            3:  Account closed by admin. Only admin can undo. and set account to 1
            */

            $SQL = "SELECT Id, SALT , HASH 
                    FROM tbllogin 
                    WHERE EmailId='".$UserLogin."' ". $Condition;
                
                parent::GetDALInstance()->SQLQuery($SQL);
                //echo $SQL;
                //echo parent::GetDALInstance()->RowCount();

                if(parent::GetDALInstance()->RowCount() == 1)
                    return true;
                else
                    return false;
            
        }



    function CreateCookie($UserLogin) {
        setcookie("UserLogin", $UserLogin, strtotime( '+30 days' ), '/', "", FALSE);
    }

    function DestroyCookie() {
        setcookie("UserLogin", "", strtotime( '-5 days' ), '/');
    }

    function Logout() {
        Security::DestroyCookie();  
        unset($_SESSION["customer_id"]);
        session_unset();
        session_destroy();
         
    }
    
}
?>
