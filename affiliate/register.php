<?php
    
    require_once("../include/files.php");
    
    if(isset($_POST['signup']) && $_POST['signup'] == 'Register')
    {
                
                $affiliate = new Affiliate();
                $affiliate->firstname = $_POST['fname'];
                $affiliate->lastname = $_POST['lname'];
                $affiliate->email = $_POST['email'];
                $affiliate->telephone = $_POST['phone'];
                $affiliate->fax = '';
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
                $affiliate->approved = 1;
                $affiliateId = $affiliate->addAffiliate();


                    header("Location:".AFFILIATEURL . 'login.php?' . $Encrypt->encrypt("Message=We have received your application.One of our team member will contact you to verify your information.&Success=true"));
                    exit();
                

    }


?>

<!DOCTYPE html>
<html lang="en">
<?php require_once ("inc/title.php"); ?>

<body class="nav-md">
    <div class="container body">
      <div class="main_container">

            <!-- Header Wrapper -->
            <?php require_once ("inc/sidebar.php"); ?>  
            
      

            <!-- page content -->
            <div class="right_col" role="main">  
                <div class="row">
              <div class="col-md-6 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Registration Form</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <form class="form-horizontal form-label-left input_mask" method="post" action="#">

                      <div class="form-group">
                        <label class="control-label col-md-6" for="first-name">First Name<span class="required">*</span>
                        </label>
                        <div class="col-md-6">
                          <input type="text" class="form-control" id="inputSuccess4" placeholder="Please Enter First Name" name="fname" value="" required>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-6" for="first-name">Last Name<span class="required">*</span>
                        </label>
                        <div class="col-md-6">
                          <input type="text" class="form-control" id="inputSuccess4" placeholder="Please Enter Last Name" name="lname" value="" required>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-6" for="first-name">Phone Number<span class="required">*</span>
                        </label>
                        <div class="col-md-6">
                          <input type="text" class="form-control" id="inputSuccess4" placeholder="Please Enter Phone Number" name="phone" value="" required  data-inputmask="'mask' : '(999) 999-9999'">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-6" for="first-name">Email Address<span class="required">*</span>
                        </label>
                        <div class="col-md-6">
                          <input type="text" class="form-control" id="inputSuccess4" placeholder="Please Enter Email Address" name="email" value="" required>
                        </div>
                      </div>

                      
                      <div class="clearfix"></div>
                      <div class="x_title">
                        <h2>Address&nbsp;Info</h2>
                        <div class="clearfix"></div>
                      </div>
                      <div class="clearfix"></div>

                      <div class="form-group">
                        <label class="control-label col-md-6" for="first-name">Business Name
                        </label>
                        <div class="col-md-6">
                          <input type="text" class="form-control" id="inputSuccess4" placeholder="Please Enter Business Name" name="company" value="">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-6" for="first-name">Website Name
                        </label>
                        <div class="col-md-6">
                          <input type="text" class="form-control" id="inputSuccess4" placeholder="Please Enter Website Name" name="website" value="" >
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-6" for="first-name">Address<span class="required">*</span>
                        </label>
                        <div class="col-md-6">
                          <input type="text" class="form-control" id="inputSuccess4" placeholder="Please Enter Address" name="address1" value="" required>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-6" for="first-name">City<span class="required">*</span>
                        </label>
                        <div class="col-md-6">
                          <input type="text" class="form-control" id="inputSuccess4" placeholder="Please Enter City" name="city" value="" required>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-6" for="first-name">Province<span class="required">*</span>
                        </label>
                        <div class="col-md-6">
                          <input type="text" class="form-control" id="inputSuccess4" placeholder="Please Enter Province" name="address2" value="" required>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-6" for="first-name">Postal Code<span class="required">*</span>
                        </label>
                        <div class="col-md-6">
                          <input type="text" class="form-control" id="inputSuccess4" placeholder="Please Enter Postal Code" name="postalcode" value="" required>
                        </div>
                      </div>
                      
                     
                      <div class="clearfix"></div>
                      <div class="x_title">
                        <h2>Payment Information <small>Cheque Payee Name</small></h2>
                        <div class="clearfix"></div>
                      </div>
                      <div class="clearfix"></div>

                      <div class="form-group">
                        <label class="control-label col-md-6" for="first-name">Affiliate Payment Method: Cheque <span class="required">*</span>
                        </label>
                        <div class="col-md-6">
                          <input type="text" class="form-control" id="inputSuccess4" placeholder="Cheque Payee Name" name="cheque" value="" required>
                        </div>
                      </div>

                      <div class="clearfix"></div>
                      <div class="x_title">
                        <h2>Login Credentials <small>Enter Passowrd Information</small></h2>
                        <div class="clearfix"></div>
                      </div>
                      <div class="clearfix"></div>

                      <div class="form-group">
                        <label class="control-label col-md-6" for="first-name">Password<span class="required">*</span>
                        </label>
                        <div class="col-md-6">
                          <input type="password" class="form-control" id="inputSuccess4" placeholder="Please Enter Password" name="password" value="" required>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-6" for="first-name">Confirm Password<span class="required">*</span>
                        </label>
                        <div class="col-md-6">
                          <input type="password" class="form-control" id="inputSuccess4" placeholder="Please Confirm Password" name="confirmpassword" value="" required>
                        </div>
                      </div>



                      <div class="clearfix"></div>
                      <h2><input type="checkbox" id="AgreeTerms" checked readonly disabled="" /> By Signing up, you agree to our <a href="" class="" data-toggle="modal" data-target="#TermsandConditions">Terms and Conditions</a></h2>
                      <div class="clearfix"></div>


                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                          <a href='index.php' class="btn btn-primary">Cancel</a>
                          <button type="submit" class="btn btn-success" name="signup" value="Register">Submit Form</button>
                        </div>
                      </div>

                    </form>
                  </div>
                </div>

              </div>
              
            </div>  

                <div class="clearfix"></div>

                  
            <!-- /top tiles -->
            </div>

        <!-- Footer Wrapper -->
        <?php require_once ("inc/footer.php"); ?>  

    <div class="modal fade" id="TermsandConditions" tabindex="-1" role="dialog" aria-labelledby="TermsandConditionsLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="TermsandConditionsLabel">Terms and Conditions
            </h4>
          </div>
          <div class="modal-body">
                <p>ADVANCED PAID LEAD REFERRAL PROGRAM FOR Car Financing</p>
                <div class="row">
                    <div class="col-lg-12">1. SERVICES TO BE PROVIDED. The Affiliate will generate and submit sales leads for individuals who want to purchase motor vehicles. The Affiliate works independently and is NOT an employee of Car Financing. 
                    </div>

                    <div class="clearfix"></div>
                    <div class="col-lg-12">&nbsp;</div>
                    <div class="clearfix"></div>

                    <div class="col-lg-12">
                    2. COMPENSATION. The Affiliate will be paid upto $500 CAD referral fee for every lead that he/she supplies that results in a vehicle purchase. Payment will be submitted within two (2) business days after the deal is completed and funds received from the bank. Payment(s) shall be made via cheques and either mailed or deposited into the bank account specified by, and in the name of the Affiliate.

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
                    4. TAXES. The Affiliate is responsible for calculating, collecting, reporting, and remitting all applicable sales / income taxes and statutory deductions arising from the provision of the Services under this Understanding. Car Financing shall NOT be responsible for calculating, reporting, or remitting any taxes, statutory deductions or related documentation on behalf of the Affiliate.

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

        <!-- input_mask -->
          <script>
            $(document).ready(function() {
              $(":input").inputmask();
            });
          </script>
          <!-- /input mask -->


</body>
</html>
