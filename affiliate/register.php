<?php
    
    require_once("../include/files.php");
    $path_info = parse_path();
        
        /*echo "<br/><br/><br/><br/><br/>";
        debugObj($path_info['query']);
        debugObj($Decrypt->decrypt($path_info['query']));*/

    
    if(isset($_POST['signup']) && $_POST['signup'] == 'Register')
    {
                
                $affiliate = new Affiliate();
                $affiliate->firstname = $_POST['fname'];
                $affiliate->lastname = $_POST['lname'];
                $affiliate->email = $_POST['email'];
                $affiliate->telephone = $_POST['phone'];
                $affiliate->fax = $_POST['fax'];
                $affiliate->code = uniqid();
                
                $Salt = GenerateSALT();
                $affiliate->salt = $Salt;
                $affiliate->HASH = GenerateHASH($Salt, $_POST['password']);
                
                $affiliate->company = $_POST['company'];
                $affiliate->website = $_POST['website'];
                $affiliate->address_1 = $_POST['address1'];
                $affiliate->address_2 = $_POST['address2'];
                $affiliate->city = $_POST['city'];
                $affiliate->postcode = $_POST['postalcode'];
                $affiliate->payment = $_POST['payment'];
                $affiliate->cheque = $_POST['cheque'];
                $affiliate->ip = $_SERVER['REMOTE_ADDR'];
                $affiliate->status = 1;
                $affiliate->approved = 2;
                $affiliateId = $affiliate->addAffiliate();


                 $subscribe = new subscribers();
                 $subscribe->name = $_POST['fname'] . " " . $_POST['lname'];
                 $subscribe->email = $_POST['email'];
                 $subscribe->status = 1;
                 $subscribe->insert();

                    header("Location:".AFFILIATEURL . 'index.php?' . $Encrypt->encrypt("Message=We have received your application.One of our team member will contact you to verify your information.&Success=true"));
                    exit();
                

    }


?>

 

               
<!DOCTYPE html>
<html lang="en">
<?php require_once("../include/title.php"); ?>

<body>

<!-- Header -->
    <div class="content-section-a">

        <div class="container">
            <form method="post" action="#">
                            <legend>AFFILIATE REGISTRATION FORM</legend>
                            <div id="login-form" class="login-form">
                                
                                 <h3>Personal&nbsp;Info</h3>
                                    <div class="full">
                                        <div class="col-sm-6">
                                            <span><label>First&nbsp;Name</label></span>
                                            <span><input name="fname" id="fname" type="text" value="" class="textbox" required></span>
                                        </div>

                                        <div class="col-sm-6">
                                            <span><label>Last&nbsp;Name</label></span>
                                            <span><input name="lname" id="lname" type="text" value="" class="textbox"  required></span>
                                        </div>

                                        
                                        <div class="col-sm-6">
                                            <span><label>Phone</label></span>
                                            <span><input name="phone" id="phone" type="text" value="" required class="textbox" ></span>
                                        </div>

                                        <div class="col-sm-6">
                                            <span><label>Email</label></span>
                                            <span><input name="email" id="email" type="text" value="" required  class="textbox" ></span>
                                        </div>
                                        
                                        <div class="col-sm-6">
                                            <span><label>Fax</label></span>
                                            <span><input name="fax" id="fax" type="text" value="" class="textbox" ></span>
                                        </div>

                                    <div class="clearfix"></div>
                                    </div> <!-- end of toggle div -->

                                    <h3>Address&nbsp;Info</h3>
                                    <div class="full">
                                        <div class="col-sm-6">
                                            <span><label>Company&nbsp;Name</label></span>
                                            <span><input name="company" id="company" type="text" value="" class="textbox" ></span>
                                        </div>

                                        <div class="col-sm-6">
                                            <span><label>Website</label></span>
                                            <span><input name="website" id="website" type="text" value="" class="textbox" ></span>
                                        </div>

                                        
                                        <div class="col-sm-6">
                                            <span><label>Adrdress1</label></span>
                                            <span><input name="address1" id="address1" type="text" value="" required class="textbox" ></span>
                                        </div>

                                        
                                        
                                        <div class="col-sm-6">
                                            <span><label>City</label></span>
                                            <span><input name="city" id="city" type="text" value="" required class="textbox" ></span>
                                        </div>
                                        <div class="col-sm-6">
                                            <span><label>Province/State</label></span>
                                            <span><input name="address2" id="address2" type="text" value=""  class="textbox" ></span>
                                        </div>
                                        
                                        <div class="col-sm-6">
                                            <span><label>Postal&nbsp;Code</label></span>
                                            <span><input name="postalcode" id="postalcode" type="text" value="" required class="textbox" ></span>
                                        </div>

                                    <div class="clearfix"></div>
                                    </div> <!-- end of toggle div -->

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
                                                <span><input name="cheque" id="cheque" type="text" value="" class="textbox"  required></span>
                                            </div>
                                        </div>
                                        <!-- <div id="payment-paypal" class="payment">
                                            <div class="col-sm-6">
                                                <span><label>Paypal&nbsp;Email&nbsp;Address</label></span>
                                                <span><input name="paypal" id="paypal" type="text" value="" class="textbox" ></span>
                                            </div>
                                        </div>

                                        <div id="payment-bank" class="payment">
                                            <div class="col-sm-6">
                                                <span><label>Bank&nbsp;Name</label></span>
                                                <span><input name="bank_name" id="bank_name" type="text" value="" class="textbox" ></span>
                                            </div>
                                        
                                            <div class="col-sm-6">
                                                <span><label>ABA/BSB&nbsp;number(Branch&nbsp;Number)</label></span>
                                                <span><input name="bank_branch_number" id="bank_branch_number" type="text" value="" class="textbox" ></span>
                                            </div>

                                            <div class="col-sm-6">
                                                <span><label>SWIFT&nbsp;Code</label></span>
                                                <span><input name="bank_swift_code" id="paypal" type="text" value="" class="textbox" ></span>
                                            </div>

                                            <div class="col-sm-6">
                                                <span><label>Account&nbsp;Name</label></span>
                                                <span><input name="bank_account_name" id="paypal" type="text" value="" class="textbox" ></span>
                                            </div>

                                            <div class="col-sm-6">
                                                <span><label>Account&nbsp;Number</label></span>
                                                <span><input name="bank_account_number" id="paypal" type="text" value="" class="textbox" ></span>
                                            </div>
                                        </div> -->

                                        
                                        

                                    <div class="clearfix"></div>
                                    </div> <!-- end of toggle div -->


                                    <h3>Password&nbsp;Info</h3>
                                    <div class="full">
                                        <div class="col-sm-6">
                                            <span><label>Password</label></span>
                                            <span><input name="password" id="password" type="password" value="" class="textbox"  required></span>
                                        </div>

                                        <div class="col-sm-6">
                                            <span><label>Confirm&nbsp;Password</label></span>
                                            <span><input name="confirmpassword" id="confirmpassword" type="password" value="" class="textbox"  required></span>
                                        </div>

                                        
                                    <div class="clearfix"></div>
                                    </div> <!-- end of toggle div -->
                                    <div class="col-sm-12">
                                        <span>
                                            <input type="checkbox" id="AgreeTerms" checked readonly/> By clicking Register, you agree to our <a href="" class="" data-toggle="modal" data-target="#TermsandConditions">Terms and Conditions</a>
                                        </span>

                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="col-sm-3"><input type="submit" class="btn btn-info" id="" name="" value="Back&nbsp;to&nbsp;Login" onclick="location.href='index.php';"/></div>
                                    <div class="col-sm-3"><input name="submit" type="submit" value="Back Home" onclick="javascript:location.href='../affiliate.php'"/></div>
                                    <div class="col-sm-3">&nbsp;</div>
                                        <div class="col-sm-3">
                                            <input type="submit" class="btn btn-info" id="signup" name="signup" value="Register" />
                                        </div>
                                        <div class="clearfix"></div>
                            </div>
                       
            </form>
            <div class="clearfix"></div>
        </div>
    </div>

    <div class="modal fade" id="TermsandConditions" tabindex="-1" role="dialog" aria-labelledby="TermsandConditionsLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="TermsandConditionsLabel">Terms and Conditions
            </h4>
          </div>
          <div class="modal-body">
                <p>ADVANCED PAID LEAD REFERRAL PROGRAM FOR SupeCarLoans</p>
                <div class="row">
                    <div class="col-lg-12">1. SERVICES TO BE PROVIDED. The Affiliate will generate and submit sales leads for individuals who want to purchase motor vehicles. The Affiliate works independently and is NOT an employee of SupeCarLoans. 
                    </div>

                    <div class="clearfix"></div>
                    <div class="col-lg-12">&nbsp;</div>
                    <div class="clearfix"></div>

                    <div class="col-lg-12">
                    2. COMPENSATION. The Affiliate will be paid a $500 CAD flat referral fee for every lead that he/she supplies that results in a vehicle purchase. Payment will be submitted within two (2) business days after the deal is completed and funds received from the In addition to the $500 referral fee per deal, the Affiliate will receive monthly bonuses as outlined below, for deals accumulated withing the same calendar month: 
                    
                    <ul style="list-style:disc;padding:20px;">
                        <li class="no-border-top">5th Deal within a calendar month pays an additional $500</li>
                        <li class="no-border-top">10th Deal within a calendar month pays and additional 1000</li>
                        <li class="no-border-top">15th Deal within a calendar month the months pays and additional $500</li>
                        <li class="no-border-top">20th Deal within a calendar month pays and additional $2000</li>
                    </ul>

                    Payment(s) shall be made via cheques and either mailed or deposited into the bank account specified by, and in the name of the Affiliate.

                    </div>

                    <div class="clearfix"></div>
                    <div class="col-lg-12">&nbsp;</div>
                    <div class="clearfix"></div>

                    <div class="col-lg-12">
                    3. INDEMNIFICATION. Each Party hereby indemnifies and holds harmless either Party for any damages, actions, suits, claims or other costs (including reasonable legal fees) for which either Party may be held liable, arising out of conducting any business set forth within this Understanding. 

                    </div>

                    <div class="clearfix"></div>
                    <div class="col-lg-12">&nbsp;</div>
                    <div class="clearfix"></div>

                    <div class="col-lg-12">
                    4. TAXES. The Affiliate is responsible for calculating, collecting, reporting, and remitting all applicable sales / income taxes and statutory deductions arising from the provision of the Services under this Understanding. SupeCarLoans shall NOT be responsible for calculating, reporting, or remitting any taxes, statutory deductions or related documentation on behalf of the Affiliate.

                    </div>

                    <div class="clearfix"></div>
                    <div class="col-lg-12">&nbsp;</div>
                    <div class="clearfix"></div>
                    
                    <div class="col-lg-12">
                    5. GENERAL PROVISIONS. The Affiliate warrants that the Services shall be completed in a professional and ethical manner, and if applicable, in compliance with all the law and regulation that exist in the Affiliate’s jurisdiction.

                    </div>

                </div>
            </div>
          
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

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
                var pass = document.getElementById("password").value;
                var confPass = document.getElementById("confirmpassword").value;

                if(pass == '')
                {
                    alert('Please enter new password !');
                    document.getElementById("password").focus();
                    return false;
                }
                if(confPass == '')
                {
                    alert('Please enter confirm password !');
                    document.getElementById("confirmpassword").focus();
                    return false;
                }

                if(pass != confPass) {
                    alert('Password did not match. Please confirm your password !');
                    document.getElementById("confirmpassword").focus();
                    return false;
                }

                return true;
            }
        </script> 