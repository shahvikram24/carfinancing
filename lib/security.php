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

    function AuthorizeDealer($UserLogin, $Password) {
        $SQL = "SELECT Id, DealerId, SALT, HASH FROM tbllogin WHERE EmailId='$UserLogin' AND status=1 ";
        
        parent::GetDALInstance()->SQLQuery($SQL);
        
        $Result = parent::GetDALInstance()->GetRow();

        $returnValue = false;
        //debugObj(GenerateHASH($Result['SALT'], $Password));
        //debugObj($Result['HASH']);
        
        if($Result) {
            if(GenerateHASH($Result['SALT'], $Password) == $Result['HASH']) {
                    Security::DestroyCookie();
                  $_SESSION['DealerId'] = $Result['DealerId'];
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


   function AuthorizeAffiliate($UserLogin, $Password) {
        $SQL = "SELECT affiliate_id, SALT, HASH FROM affiliate WHERE email='$UserLogin' AND status=1 AND approved=1 ";
        //echo "<br/><br/><br/><br/><br/><br/>".$SQL;
        
        parent::GetDALInstance()->SQLQuery($SQL);
        
        $Result = parent::GetDALInstance()->GetRow();

        $returnValue = false;

        if($Result) {
            if(GenerateHASH($Result['SALT'], $Password) == $Result['HASH']) {
                global $affiliate;

                if(!isset($affiliate))
                    $affiliate = new Affiliate();

                $affiliate->loadAffiliate($Result['affiliate_id']);

                /*if($RememberMe)
                    Security::CreateCookie($User->UserLogin);
                else
                    Security::DestroyCookie();*/

                  $_SESSION['affiliate_id'] = $Result['affiliate_id'];
                 Security::CreateCookie($affiliate->email);
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

   function ChangeLeadsPassword($UserId, $OldPassword, $NewPassword)
   {
            if(NumberCheck($UserId))
            {
                // we have to check the user entered correct old passowrd or not
                $SQL = "SELECT DealerId, SALT, HASH FROM tbllogin WHERE DealerId=".$UserId." AND status=1";
                parent::GetDALInstance()->SQLQuery($SQL);
                $Result = parent::GetDALInstance()->GetRow();

                if($Result)
                {
                    $Salt = $Result['SALT'];

                    $Hash = GenerateHASH($Salt, $NewPassword);
                    $SQL = "UPDATE tbllogin SET HASH='".$Hash."' WHERE DealerId=".$UserId." AND status=1";


                        parent::GetDALInstance()->SQLQuery($SQL);

                        return parent::GetDALInstance()->AffectedRows();
                  
                }
            }

            return false;
   }
    
	function ChangeUserPassword($UserId, $OldPassword, $NewPassword)
        {
            if(NumberCheck($UserId))
            {
                // we have to check the user entered correct old passowrd or not
                $SQL = "SELECT affiliate_id, salt, HASH FROM affiliate WHERE affiliate_id=".$UserId." AND status=1";
                parent::GetDALInstance()->SQLQuery($SQL);
                $Result = parent::GetDALInstance()->GetRow();

                if($Result)
                {
                    $Salt = $Result['salt'];

                    
                        $Hash = GenerateHASH($Salt, $NewPassword);
                        $SQL = "UPDATE affiliate SET HASH='".$Hash."' WHERE affiliate_id=".$UserId." AND status=1";
                        parent::GetDALInstance()->SQLQuery($SQL);

                        return parent::GetDALInstance()->AffectedRows();
                  
                }
            }

            return false;
        }

       
	
        function ChangeAdminPassword($UserId, $NewPassword, $OldPassword='')
        {
            if(NumberCheck($UserId))
            {
                
                $SQL = "SELECT  Id, SALT, HASH FROM admin WHERE Id=".$UserId." AND Status=1";
                parent::GetDALInstance()->SQLQuery($SQL);
                $Result = parent::GetDALInstance()->GetRow();

                
                if($Result)
                {
                    
                    if(isset($OldPassword) && $OldPassword!='')
                    {
                         if(GenerateHASH($Result['SALT'], $OldPassword) == $Result['HASH']) 
                         {
                            $Salt = $Result['SALT'];                    
                            $Hash = GenerateHASH($Salt, $NewPassword);
                            $SQL = "UPDATE admin SET HASH='".$Hash."' WHERE Id=".$UserId." AND Status=1";
                            parent::GetDALInstance()->SQLQuery($SQL);

                            return true;   
                         }
                         else
                         {
                            return false;
                         }
                    }
                    else{
                        $Salt = $Result['SALT'];                    
                        $Hash = GenerateHASH($Salt, $NewPassword);
                        $SQL = "UPDATE admin SET HASH='".$Hash."' WHERE Id=".$UserId." AND Status=1";
                        parent::GetDALInstance()->SQLQuery($SQL);

                        return true;    
                    }
                }
            }

            return false;
        }
        

        

        public function AuthorizeInventoryAccess($Password) {
        $SQL = "SELECT Id, SALT, HASH FROM inventoryaccess WHERE Id=1";
        

        parent::GetDALInstance()->SQLQuery($SQL);
        
        $Result = parent::GetDALInstance()->GetRow();

        $returnValue = false;
        /*
        debugObj($Result); 

        echo "<br/>Passowrd: " . $Password . "<br/>";
        echo "<br/>SALT: " . $Result['SALT'] . "<br/>";
        echo "<br/>HASH: " . $Result['HASH'] . "<br/>";
        echo "<br/>Generated: " . GenerateHASH($Result['SALT'], $Password) . "<br/>";
        */

        if($Result) {
            if(GenerateHASH($Result['SALT'], $Password) == $Result['HASH']) {
                $_SESSION['InventoryAuthority'] = date('Y-m-d');
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


    function CheckUserExistsByLogin($UserLogin, $Condition='')
        {
            
            /*

                Status:
                            0:  Activation email sent and waiting to activate 
                            1:  Active user                 
                            3:  Account closed by admin. Only admin can undo. and set account to 1
            */

            $SQL = "SELECT affiliate_id, salt , HASH 
                    FROM affiliate 
                    WHERE email like '".$UserLogin."' ". $Condition;
                
                parent::GetDALInstance()->SQLQuery($SQL);
                //echo $SQL;
                //echo parent::GetDALInstance()->RowCount();

                if(parent::GetDALInstance()->RowCount() == 1)
                    return true;
                else
                    return false;
            
        }

       

        function CheckLeadsExist($UserLogin, $Condition='')
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
        @setcookie(COOKIENAME, "$UserLogin", time() + COOKIEEXPIRE, '/', "", false);
    }

    function DestroyCookie() {
        @setcookie(COOKIENAME, "", time() - 1, '/', "", false);
    }

    function Logout() {
        session_unset();
        session_destroy();       
    }
    
}
?>
