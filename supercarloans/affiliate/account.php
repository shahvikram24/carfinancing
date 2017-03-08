<?php
    
    require_once("../include/files.php");
    
echo "<script type='text/javascript' src='inc/functions.js'></script> ";



if(!isset($_SESSION['affiliate_id']))
{
    header("Location: index.php");
}

if(isset($_POST['Finish']) && $_POST['Finish'] == 'Update Personal')
{
    $affiliate = new Affiliate();
    $affiliate->loadAffiliate($_SESSION['affiliate_id']);
    
    $affiliate->firstname = $_POST['firstname'];
    $affiliate->lastname = $_POST['lastname'];
    $affiliate->email = $_POST['email'];
    $affiliate->telephone = $_POST['telephone'];
    $affiliate->fax = $_POST['fax'];

    
    $affiliate->UpdateAffiliate();

    header('Location:account.php?' . $Encrypt->encrypt("Message=Affiliate personal information has been updated successfully.&Success=true&affiliate_id=".$_SESSION['affiliate_id']));
    exit();
}

if(isset($_POST['Finish']) && $_POST['Finish'] == 'Update Address')
{
    $affiliate = new Affiliate();
    $affiliate->loadAffiliate($_SESSION['affiliate_id']);
    
    $affiliate->company = $_POST['company'];
    $affiliate->website = $_POST['website'];
    $affiliate->address_1 = $_POST['address_1'];
    $affiliate->address_2 = $_POST['address_2'];
    $affiliate->city = $_POST['city'];
    $affiliate->postcode = $_POST['postcode'];

    
    $affiliate->UpdateAffiliate();

    header('Location:account.php?' . $Encrypt->encrypt("Message=Affiliate address information has been updated successfully.&Success=true&affiliate_id=".$_SESSION['affiliate_id']));
    exit();
}

if(isset($_POST['Finish']) && $_POST['Finish'] == 'Update Payment')
{
    $affiliate = new Affiliate();
    $affiliate->loadAffiliate($_SESSION['affiliate_id']);
    
    //$affiliate->tax = $_POST['tax'];
    $affiliate->payment = $_POST['payment'];
    $affiliate->cheque = $_POST['cheque'];
    /*$affiliate->paypal = $_POST['paypal'];
    $affiliate->bank_name = $_POST['bank_name'];
    $affiliate->bank_branch_number = $_POST['bank_branch_number'];
    $affiliate->bank_swift_code = $_POST['bank_swift_code'];
    $affiliate->bank_account_name = $_POST['bank_account_name'];
    $affiliate->bank_account_number = $_POST['bank_account_number'];*/

    
    $affiliate->UpdateAffiliate();

    header('Location:account.php?' . $Encrypt->encrypt("Message=Affiliate payment information has been updated successfully.&Success=true&affiliate_id=".$_SESSION['affiliate_id']));
    exit();
}

if(isset($_POST['Finish']) && $_POST['Finish'] == 'Send Manual Lead')
{

    $ContactInfo = new ContactInfo();
    $ContactInfo->FirstName = $_POST['FirstName'];
     $ContactInfo->LastName = $_POST['LastName'];
     $ContactInfo->Email = $_POST['EmailAddress'] ;
     $ContactInfo->Phone1 = $_POST['Phone'];
     $ContactInfo->Created = date('Y-m-d H:i:s');
     $ContactInfo->Notes = $_POST['Notes'];
     $ContactInfo->Notification = 1;
     $ContactInfo->Status = 3;
     $ContactInfoId = $ContactInfo->addContactInfo();

        $affiliateTransaction = new AffiliateTransaction();
        $affiliateTransaction->affiliateid = $_SESSION['affiliate_id'];
        $affiliateTransaction->contactinfoid = $ContactInfoId;
        $affiliateTransaction->description = 1;
        $affiliateTransaction->amount = 0.00;
        $affiliateTransaction->dateadded = date("Y-m-d H:i:s");
        $affiliateTransaction->status = 3;

        $affiliateTransaction->addTransaction();
        header('Location:account.php?' . $Encrypt->encrypt("Message=Lead information has been sent to our team.&Success=true&affiliate_id=".$_SESSION['affiliate_id']));
    exit();

}
if(isset($_POST['Finish']) && $_POST['Finish'] == 'Change Password')
{
    $Result = Security::ChangeUserPassword($_SESSION['affiliate_id'], NULL, $_POST['newpwd']);
        
        if($Result)
        {
            Security::Logout();
            header("Location: index.php?".$Encrypt->encrypt("Success=true&Message=We changed password. Please login again."));
            exit;
        }
        else
        {
             header("Location: account.php?".$Encrypt->encrypt("Success=false&Message=Please do not use same password."));
        }

}

    $affiliate = new Affiliate();
    $affiliate->loadAffiliate( $_SESSION['affiliate_id']);

    $affiliateTransaction = new AffiliateTransaction();
    $ResultTransaction = $affiliateTransaction->loadByAffiliate($_SESSION['affiliate_id']);


?>

 

               
<!DOCTYPE html>
<html lang="en">
<?php require_once("inc/title.php"); ?>

<body>
<?php require_once("inc/header.php"); ?>

<form method="post" action="#">
    <input type="hidden" name="affiliate_id" value="<?= $_SESSION['affiliate_id'] ?>"/>
<div class="content-section-a" id="how-it-works">
<div class="container">
    <div class="row">
        <div class="col-lg-12" id="">
            <legend><?= FormatName($affiliate->firstname,$affiliate->lastname) ?></legend>
        </div>
        <?php   
                                    
            if( isset ($Message) && $Message != "" ) 
            { 
                if($Success && $Success == 'true')
                    echo '<div class="col-sm-12" style="color:green;">'.  $Message . '</div>';
                else
                    echo '<div class="col-sm-12" style="color:red;">'.  $Message . '</div>';
            }
         ?>

    </div>
</div>
</div>

<ul role="tablist" class="nav nav-tabs bs-adaptive-tabs" id="myTab">
    <li class="active" role="presentation"><a aria-expanded="true" aria-controls="home" data-toggle="tab" role="tab" id="tab1-tab" href="#tab1"><i class="fa fa-user"></i> <label>Personal&nbsp;Info</label></a></li>
    <li role="presentation"><a aria-expanded="true" aria-controls="home" data-toggle="tab" role="tab" id="tab2-tab" href="#tab2"><i class="fa fa-home"></i> <label>Address&nbsp;Info</label></a></li>
    <li role="presentation"><a aria-expanded="true" aria-controls="home" data-toggle="tab" role="tab" id="tab3-tab" href="#tab3"><i class="fa fa-paypal"></i> <label>Payment&nbsp;Preference</label></a></li>
    <li role="presentation"><a aria-expanded="true" aria-controls="home" data-toggle="tab" role="tab" id="tab4-tab" href="#tab4"><i class="fa fa-code"></i> <label>Referral&nbsp;Code</label></a></li>
    <li role="presentation"><a aria-expanded="true" aria-controls="home" data-toggle="tab" role="tab" id="tab5-tab" href="#tab5"><i class="fa fa-money"></i> <label>Lead&nbsp;Tracking</label></a></li>
    <li role="presentation"><a aria-expanded="true" aria-controls="home" data-toggle="tab" role="tab" id="tab6-tab" href="#tab6"><i class="fa fa-money"></i> <label>Send&nbsp;Leads&nbsp;Manually</label></a></li>
    <li role="presentation"><a aria-expanded="true" aria-controls="home" data-toggle="tab" role="tab" id="tab7-tab" href="#tab7"><i class="fa fa-cog"></i> <label>
    Change&nbsp;Password</label></a></li>
    
</ul>


        <div class="tab-content" id="myTabContent">
            <div aria-labelledby="tab1-tab" id="tab1" class="tab-pane fade in active" role="tabpanel">
                <p>&nbsp;</p>
                <div id="login-form" class="login-form"> 
                     <h3>Personal&nbsp;Info</h3>
                        <div class="full">
                            <div class="col-sm-6">
                                <span><label>First&nbsp;Name</label></span>
                                <span><input name="firstname" id="firstname" type="text" value="<?= $affiliate->firstname ?>" class="textbox" ></span>
                            </div>

                            <div class="col-sm-6">
                                <span><label>Last&nbsp;Name</label></span>
                                <span><input name="lastname" id="lastname" type="text" value="<?= $affiliate->lastname ?>" class="textbox" ></span>
                            </div>

                            
                            <div class="col-sm-6">
                                <span><label>Phone</label></span>
                                <span><input name="telephone" id="telephone" type="text" value="<?= $affiliate->telephone ?>" required class="textbox" ></span>
                            </div>

                            <div class="col-sm-6">
                                <span><label>Email</label></span>
                                <span><input name="email" id="email" type="text" value="<?= $affiliate->email ?>" required  class="textbox" ></span>
                            </div>
                            
                            <div class="col-sm-6">
                                <span><label>Fax</label></span>
                                <span><input name="fax" id="fax" type="text" value="<?= $affiliate->fax ?>" class="textbox" ></span>
                            </div>

                        <div class="clearfix"></div>
                        </div> <!-- end of toggle div -->
                        <div class="col-sm-9">&nbsp;</div>
                            <div class="col-sm-3">
                                <input type="submit" class="btn btn-info" id="Finish" name="Finish" value="Update Personal" />
                            </div>
                            <div class="clearfix"></div>
                </div>
            </div>
            <div aria-labelledby="tab2-tab" id="tab2" class="tab-pane" role="tabpanel">
                <p>&nbsp;</p>
                <p>&nbsp;</p>
                <div id="login-form" class="login-form"> 
                     <h3>Address&nbsp;Info</h3>
                        <div class="full">
                            <div class="col-sm-6">
                                <span><label>Company&nbsp;Name</label></span>
                                <span><input name="company" id="company" type="text" value="<?= $affiliate->company ?>" class="textbox" ></span>
                            </div>

                            <div class="col-sm-6">
                                <span><label>Website</label></span>
                                <span><input name="website" id="website" type="text" value="<?= $affiliate->website ?>" class="textbox" ></span>
                            </div>

                            
                            <div class="col-sm-6">
                                <span><label>Adrdress1</label></span>
                                <span><input name="address_1" id="address_1" type="text" value="<?= $affiliate->address_1 ?>" required class="textbox" ></span>
                            </div>

                            <div class="col-sm-6">
                                <span><label>Address2</label></span>
                                <span><input name="address_2" id="address_2" type="text" value="<?= $affiliate->address_2 ?>"  class="textbox" ></span>
                            </div>
                            
                            <div class="col-sm-6">
                                <span><label>City</label></span>
                                <span><input name="city" id="city" type="text" value="<?= $affiliate->city ?>" required class="textbox" ></span>
                            </div>
                            <div class="col-sm-6">
                                <span><label>Postal&nbsp;Code</label></span>
                                <span><input name="postcode" id="postcode" type="text" value="<?= $affiliate->postcode ?>" required class="textbox" ></span>
                            </div>

                        <div class="clearfix"></div>
                        </div> <!-- end of toggle div -->
                        <div class="col-sm-9">&nbsp;</div>
                            <div class="col-sm-3">
                                <input type="submit" class="btn btn-info" id="Finish" name="Finish" value="Update Address" />
                            </div>
                            <div class="clearfix"></div>
                    </div>

            </div>

            <div aria-labelledby="tab3-tab" id="tab3" class="tab-pane" role="tabpanel">
                <p>&nbsp;</p>
                <p>&nbsp;</p>
                <div id="login-form" class="login-form"> 
                     <h3>Payment&nbsp;Information</h3>
                        <div class="full">
                            <!-- <div class="col-sm-6">
                                <span><label>Tax&nbsp;ID</label></span>
                                <span><input name="tax" id="tax" type="text" value="<?= $affiliate->tax ?>" class="textbox" ></span>
                            </div> -->

                            <div class="col-sm-6">
                                <span><label>Affiliate&nbsp;Payment&nbsp;Method</label></span>
                                <!-- <span>
                                    <ul class="form-menu-main">
                                        <li class="no-border-top">
                                            <label for="cheque"><input type="radio" name="payment" value="cheque" id="cheque" <?= ($affiliate->payment == 'cheque') ? 'checked' : '' ?> />Cheque</label>  
                                    
                                            <label for="paypal"><input type="radio" name="payment" value="paypal" id="paypal" <?= ($affiliate->payment == 'paypal') ? 'checked' : '' ?> />PayPal</label>
                                    
                                            <label for="bank"><input type="radio" name="payment" value="bank" id="bank" <?= ($affiliate->payment == 'bank') ? 'checked' : '' ?> />Bank Transfer</label>
                                        </li>
                                    </ul>
                                </span> -->
                                <span><input name="payment" id="payment" type="text" value="cheque" class="textbox" readonly></span>
                            </div>

                            <div id="payment-cheque" class="payment">
                                <div class="col-sm-6">
                                    <span><label>Cheque&nbsp;Payee&nbsp;Name</label></span>
                                    <span><input name="cheque" id="cheque" type="text" value="<?= $affiliate->cheque ?>" class="textbox" ></span>
                                </div>
                            </div>
                            <!-- <div id="payment-paypal" class="payment">
                                <div class="col-sm-6">
                                    <span><label>Paypal&nbsp;Email&nbsp;Address</label></span>
                                    <span><input name="paypal" id="paypal" type="text" value="<?= $affiliate->paypal ?>" class="textbox" ></span>
                                </div>
                            </div>

                            <div id="payment-bank" class="payment">
                                <div class="col-sm-6">
                                    <span><label>Bank&nbsp;Name</label></span>
                                    <span><input name="bank_name" id="bank_name" type="text" value="<?= $affiliate->bank_name ?>" class="textbox" ></span>
                                </div>
                            
                                <div class="col-sm-6">
                                    <span><label>ABA/BSB&nbsp;number(Branch&nbsp;Number)</label></span>
                                    <span><input name="bank_branch_number" id="bank_branch_number" type="text" value="<?= $affiliate->bank_branch_number ?>" class="textbox" ></span>
                                </div>

                                <div class="col-sm-6">
                                    <span><label>SWIFT&nbsp;Code</label></span>
                                    <span><input name="bank_swift_code" id="paypal" type="text" value="<?= $affiliate->bank_swift_code ?>" class="textbox" ></span>
                                </div>

                                <div class="col-sm-6">
                                    <span><label>Account&nbsp;Name</label></span>
                                    <span><input name="bank_account_name" id="paypal" type="text" value="<?= $affiliate->bank_account_name ?>" class="textbox" ></span>
                                </div>

                                <div class="col-sm-6">
                                    <span><label>Account&nbsp;Number</label></span>
                                    <span><input name="bank_account_number" id="paypal" type="text" value="<?= $affiliate->bank_account_number ?>" class="textbox" ></span>
                                </div>
                            </div> -->

                            
                            

                        <div class="clearfix"></div>
                        </div> <!-- end of toggle div -->
                        <div class="col-sm-9">&nbsp;</div>
                            <div class="col-sm-3">
                                <input type="submit" class="btn btn-info" id="Finish" name="Finish" value="Update Payment" />
                            </div>
                            <div class="clearfix"></div>
                        </div> <!-- end of toggle div -->
                        
            </div>

            <div aria-labelledby="tab4-tab" id="tab4" class="tab-pane" role="tabpanel">
                <p>&nbsp;</p>
                <div id="login-form" class="login-form"> 
                     <h3>Referral&nbsp;Code</h3>
                        <div class="full">
                            <div class="col-lg-6">
                                <h3>Your&nbsp;Tracking&nbsp;Code</h3>
                                <span><input name="code" id="code" type="text" value="<?= $affiliate->code ?>" class="textbox" readonly></span>
                            </div>

                            <div class="col-lg-6">
                                <h3>Tracking&nbsp;Link - Works very well with Facebook, Google+ and Twitter</h3>
                                <h5>You can begin to distribute this link to social media websites such as Twitter and Facebook. Just copy and paste this code to social media websites.</h5>
                                <span>                                
                                    <input class="textbox" type="text" id="trackingcode" name="trackingcode" readonly value="<?= APPROOT .  $affiliate->code ?>" readonly/>
                                </span>
                            </div>

                            <div class="clearfix"></div>
                        </div> 


                        <h3>Banner&nbsp;Tracking</h3>
                        <div class="full">
                            <div class="col-lg-6">
                                <h3>200x200 Banner</h3>
                                <h5>You can begin to distribute this banner code to a Banner Advertising Sites. Just copy and paste this code to the websites.</h5>
                                <span><img class="img-responsive" src="<?= APPROOT ?>img/banners/200x200.png" alt="200x200 Banner"></span>
                                <span><textarea id="" readonly>
                                            <?php echo "<a href='". APPROOT . $affiliate->code . "' style='background-color: transparent;' target='_blank' title='" . $affiliate->firstname . "'><img src='". APPROOT . "img/banners/200x200.png' border='0' alt='Referral Banner' /></a>"; ?>
                                        </textarea>
                                </span>

                            </div>

                            <div class="col-lg-6">
                                <h3>300x250 Banner</h3>
                                <h5>You can begin to distribute this banner code to a Banner Advertising Sites. Just copy and paste this code to the websites.</h5>
                                <span><img class="img-responsive" src="<?= APPROOT ?>img/banners/300x250.png" alt="300x250 Banner"></span>
                                <span><textarea id="" readonly>
                                            <?php echo "<a href='". APPROOT . $affiliate->code . "' style='background-color: transparent;' target='_blank' title='" . $affiliate->firstname . "'><img src='". APPROOT . "img/banners/300x250.png' border='0' alt='Referral Banner' /></a>"; ?>
                                        </textarea>
                                </span>
                            </div>

                            <div class="clearfix"></div>

                            <div class="col-lg-6">
                                <h3>728x90 Banner</h3>
                                <h5>You can begin to distribute this banner code to a Banner Advertising Sites. Just copy and paste this code to the websites.</h5>
                                <span><img class="img-responsive" src="<?= APPROOT ?>img/banners/728x90.png" alt="728x90 Banner"></span>
                                <span><textarea id="" readonly>
                                            <?php echo "<a href='". APPROOT . $affiliate->code . "' style='background-color: transparent;' target='_blank' title='" . $affiliate->firstname . "'><img src='". APPROOT . "img/banners/728x90.png' border='0' alt='Referral Banner' /></a>"; ?>
                                        </textarea>
                                </span>
                            </div>

                            <div class="col-lg-6">
                                <h3>970x90 Banner</h3>
                                <h5>You can begin to distribute this banner code to a Banner Advertising Sites. Just copy and paste this code to the websites.</h5>
                                <span><img class="img-responsive" src="<?= APPROOT ?>img/banners/970x90.png" alt="970x90 Banner"></span>
                                <span><textarea id="" readonly>
                                            <?php echo "<a href='". APPROOT . $affiliate->code . "' style='background-color: transparent;' target='_blank' title='" . $affiliate->firstname . "'><img src='". APPROOT . "img/banners/970x90.png' border='0' alt='Referral Banner' /></a>"; ?>
                                        </textarea>
                                </span>
                            </div>

                            <div class="clearfix"></div>

                            <div class="col-lg-6">
                                <h3>300x600 Banner</h3>
                                <h5>You can begin to distribute this banner code to a Banner Advertising Sites. Just copy and paste this code to the websites.</h5>
                                <span><img class="img-responsive" src="<?= APPROOT ?>img/banners/300x600.png" alt="300x600 Banner"></span>
                                <span><textarea id="" readonly>
                                            <?php echo "<a href='". APPROOT . $affiliate->code . "' style='background-color: transparent;' target='_blank' title='" .  $affiliate->firstname . "'><img src='". APPROOT . "img/banners/300x600.png' border='0' alt='Referral Banner' /></a>"; ?>
                                        </textarea>
                                </span>
                            </div>

                            <div class="clearfix"></div>
                        </div> 
                </div>

            </div>

            <div aria-labelledby="tab5-tab" id="tab5" class="tab-pane" role="tabpanel">

                <p>&nbsp;</p>
                <?php if($ResultTransaction)
                    {
                ?>
               <div id="login-form" class="login-form"> 
                    <h3>Transaction History</h3>
                    <div class="full">
                        <div class="col-sm-2 textcolor">
                            <span><label>#</label></span>
                        </div>
                        <div class="col-sm-3 textcolor">
                            <span><label>Contact&nbsp;Name</label></span>
                        </div>
                        <div class="col-sm-4 textcolor">
                            <span><label>Description</label></span>
                        </div>
                        <div class="col-sm-3 textcolor">
                            <span><label>Referal&nbsp;Amount</label></span>
                        </div>
                        
                        <div class="clearfix"></div>
                    </div>
                </div> <!-- end of login div-->
                    <?php 
                    $count =1;
                    for($x = 0; $x < $ResultTransaction->TotalResults ; $x++)
                    {
                ?>
                        <input type="hidden" name="affiliatetransactionid[]" value="<?= $ResultTransaction->Result[$x]['affiliatetransactionid'] ?>"/>
                        <div class="col-sm-2">
                            <span><label><?= $count ?></label></span>
                        </div>
                        <div class="col-sm-3">
                            <span><label><?= ContactInfo::GetFullName($ResultTransaction->Result[$x]['contactinfoid']) ?></label></span>
                        </div>
                        <div class="col-sm-4">
                            <span><label><?= DealStatus::getStatusText($ResultTransaction->Result[$x]['description']) ?></label></span>
                        </div>
                        <div class="col-sm-3">
                            <span><label><?= $ResultTransaction->Result[$x]['amount'] ?></label></span>
                            
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-sm-12">&nbsp;</div>
                <?php
                    $count++;
                    }
                ?>
                        
                       <div class="clearfix"></div>
                <?php
                    }
                    else{
                        echo '
                            <div class="col-sm-10" style="text-align: center;">
                                <span><label >No records found.</label></span>
                            </div>
                        ';
                    }
                ?>
            
            </div>

            <div aria-labelledby="tab6-tab" id="tab6" class="tab-pane" role="tabpanel">
                <p>&nbsp;</p>
                <div id="login-form" class="login-form"> 
                     <h3>Lead&nbsp;Information</h3>
                        <div class="full">
                            <div class="col-sm-6">
                                <span><label>First&nbsp;Name*</label></span>
                                <span><input name="FirstName" id="FirstName" type="text" value="" class="textbox" ></span>
                            </div>

                            <div class="col-sm-6">
                                <span><label>Last&nbsp;Name*</label></span>
                                <span><input name="LastName" id="LastName" type="text" value="" class="textbox" ></span>
                            </div>

                            
                            <div class="col-sm-6">
                                <span><label>Phone*</label></span>
                                <span><input name="Phone" id="Phone" type="text" value="" class="textbox" ></span>
                            </div>

                            <div class="col-sm-6">
                                <span><label>Email</label></span>
                                <span><input name="EmailAddress" id="EmailAddress" type="email" value=""  class="textbox" ></span>
                            </div>

                            <div class="col-sm-12">
                                <span><label>Notes</label></span>
                                <span>
                                    <textarea name="Notes" id="Notes" placeholder="Provide notes to the admin"></textarea>
                                </span>
                            </div>

                        <div class="clearfix"></div>
                        </div> <!-- end of toggle div -->
                        <div class="col-sm-9">&nbsp;</div>
                            <div class="col-sm-3">
                                <input type="submit" class="btn btn-info" id="Finish" name="Finish" value="Send Manual Lead" />
                            </div>
                            <div class="clearfix"></div>
                </div>
            </div>

            <div aria-labelledby="tab7-tab" id="tab7" class="tab-pane" role="tabpanel">

                <p>&nbsp;</p>
               <div id="login-form" class="login-form"> 
                    <h3>Change Password</h3>
                    <div class="full">
                        <div class="col-sm-2 textcolor">
                            <span><label>New Password</label></span>
                            <span><input name="newpwd" id="newpwd" type="password" value="" class="textbox"></span>
                        </div>
                        <div class="col-sm-3 textcolor">
                            <span><label>Confirm Password</label></span>
                            <span><input name="confnewpwd" id="confnewpwd" type="password" value="" class="textbox"></span>
                        </div>
                        
                        
                        <div class="clearfix"></div>
                        </div> <!-- end of toggle div -->
                        <div class="col-sm-9">&nbsp;</div>
                            <div class="col-sm-3">
                                <input type="submit" class="btn btn-info" id="Finish" name="Finish" value="Change Password"  onclick="return confirmPass()" />
                            </div>
                            <div class="clearfix"></div>
                </div>
            
            </div> <!-- end of login div-->


    	</div>

</form>
<div class="clearfix"></div>
<?php require_once("inc/footer.php"); ?>

            <script type="text/javascript"><!--
	                <!--
	                $('input[name=\'payment\']').bind('change', function() {
	                    $('.payment').hide();
	                    
	                    $('#payment-' + this.value).show();
	                });

	                $('input[name=\'payment\']:checked').trigger('change');
	                //-->
	        </script>

        <script type="text/javascript">
		    function confirmPass() {
		        var pass = document.getElementById("newpwd").value;
		        var confPass = document.getElementById("confnewpwd").value;

		        if(pass == '')
		        {
		            alert('Please enter new password !');
		            document.getElementById("newpwd").focus();
		            return false;
		        }
		        if(confPass == '')
		        {
		            alert('Please enter confirm password !');
		            document.getElementById("newpwd").focus();
		            return false;
		        }

		        if(pass != confPass) {
		            alert('Password did not match. Please confirm your password !');
		            document.getElementById("confnewpwd").focus();
		            return false;
		        }

		        return true;
		    }
		</script> 