<?php
    
    require_once("../include/files.php");
    
echo "<script type='text/javascript' src='inc/functions.js'></script> ";



if(!isset($_SESSION['admin_id']))
{
    header("Location: index.php");
}



if(isset($_POST['Finish']) && $_POST['Finish'] == 'Update Personal')
{
    $affiliate = new SuperAffiliate();
    $affiliate->loadAffiliate($superaffiliate_id);
    
    $affiliate->firstname = $_POST['firstname'];
    $affiliate->lastname = $_POST['lastname'];
    $affiliate->email = $_POST['email'];
    $affiliate->telephone = $_POST['telephone'];
    $affiliate->fax = $_POST['fax'];

    
    $affiliate->UpdateAffiliate();

    header('Location:superaffiliateinfo.php?' . $Encrypt->encrypt("Message=Affiliate personal information has been updated successfully.&Success=true&superaffiliate_id=".$superaffiliate_id));
    exit();
}

if(isset($_POST['Finish']) && $_POST['Finish'] == 'Update Address')
{
    $affiliate = new SuperAffiliate();
    $affiliate->loadAffiliate($superaffiliate_id);
    
    $affiliate->company = $_POST['company'];
    $affiliate->website = $_POST['website'];
    $affiliate->address_1 = $_POST['address_1'];
    $affiliate->address_2 = $_POST['address_2'];
    $affiliate->city = $_POST['city'];
    $affiliate->postcode = $_POST['postcode'];

    
    $affiliate->UpdateAffiliate();

    header('Location:superaffiliateinfo.php?' . $Encrypt->encrypt("Message=Affiliate address information has been updated successfully.&Success=true&superaffiliate_id=".$superaffiliate_id));
    exit();
}

if(isset($_POST['Finish']) && $_POST['Finish'] == 'Update Payment')
{
    $affiliate = new SuperAffiliate();
    $affiliate->loadAffiliate($superaffiliate_id);
    
    //$affiliate->tax = $_POST['tax'];
    $affiliate->payment = $_POST['payment'];
    $affiliate->cheque = $_POST['cheque'];
    /*$affiliate->paypal = $_POST['paypal'];
    $affiliate->bank_name = $_POST['bank_name'];
    $affiliate->bank_branch_number = $_POST['bank_branch_number'];
    $affiliate->bank_swift_code = $_POST['bank_swift_code'];
    $affiliate->bank_account_name = $_POST['bank_account_name'];
    $affiliate->bank_account_number = $_POST['bank_account_number'];
*/
    
    $affiliate->UpdateAffiliate();

    header('Location:superaffiliateinfo.php?' . $Encrypt->encrypt("Message=Affiliate payment information has been updated successfully.&Success=true&superaffiliate_id=".$superaffiliate_id));
    exit();
}

if(isset($_POST['Finish']) && $_POST['Finish'] == 'Update History')
{
    $affiliateTransaction = new SuperAffiliateTransaction();

    for($x=0; $x < count($_POST['superaffiliatetransactionid']); $x++)
    {
        $affiliateTransaction->loadTransactionId($_POST['superaffiliatetransactionid'][$x]);
        $affiliateTransaction->amount = $_POST['amount'][$x];
        $affiliateTransaction->UpdateTransaction();
    }

    header('Location:superaffiliateinfo.php?' . $Encrypt->encrypt("Message=Affiliate referral amount has been added successfully.&Success=true&superaffiliate_id=".$superaffiliate_id));
    exit();
}



if(isset($_POST['Reject']) && $_POST['Reject'] == 'De-activate Affiliate')
{
    $affiliate = new SuperAffiliate();
    $affiliate->loadAffiliate($superaffiliate_id);
    $affiliate->approved = 3;
    $affiliate->UpdateAffiliate();

    header('Location:superaffiliateinfo.php?' . $Encrypt->encrypt("Message=Affiliate has been de-activated successfully.&Success=true&superaffiliate_id=".$superaffiliate_id));
    exit();
}


if(isset($_POST['Approve']) && $_POST['Approve'] == 'Activate Affiliate')
{
    
    $affiliate = new SuperAffiliate();
    $affiliate->loadAffiliate($superaffiliate_id);
    $affiliate->approved = 1;
    $affiliate->UpdateAffiliate();
    
    header('Location:superaffiliateinfo.php?' . $Encrypt->encrypt("Message=Affiliate activated successfully.&Success=true&superaffiliate_id=".$superaffiliate_id));
    exit();
}
if(isset($_POST['Activation']) && $_POST['Activation'] == 'Send Activation Kit')
{
    
    if(SuperAffiliate::sendActivationKit($superaffiliate_id))
    {   
        header('Location:superaffiliateinfo.php?' . $Encrypt->encrypt("Message=Activation instruction sent successfully.&Success=true&superaffiliate_id=".$superaffiliate_id));
        exit();
    }
    else
    {
        header('Location:superaffiliateinfo.php?' . $Encrypt->encrypt("Message=Something went wrong.&Success=false&superaffiliate_id=".$superaffiliate_id));
        exit();
    }
}


if(!isset($superaffiliate_id))
{
    header("Location: dashboard.php");
}


$SQLWhere =' status=1 AND superaffiliate_id='. $superaffiliate_id;
$affiliate = new SuperAffiliate();
$Result = $affiliate->loadAllAffiliateInfo($SQLWhere);

$affiliateTransaction = new SuperAffiliateTransaction();
$ResultTransaction = $affiliateTransaction->loadByAffiliate($superaffiliate_id);

$dealStatus = new DealStatus();
$dealStatusResult = $dealStatus->loadAllDealStatus();

//debugObj($ResultTransaction->Result);

?>

 

               
<!DOCTYPE html>
<html lang="en">
<?php require_once("inc/title.php"); ?>

<body>
<?php require_once("inc/header.php"); ?>

<form method="post" action="#" enctype="multipart/form-data" >
    <input type="hidden" name="superaffiliate_id" value="<?= $superaffiliate_id ?>"/>
<div class="content-section-a" id="how-it-works">
<div class="container">
    <div class="row">
        <div class="col-lg-12" id="">
            <legend><?= FormatName($Result->Result[0]['firstname'],$Result->Result[0]['lastname']) ?></legend>
            
                
            <?php
                if($Result->Result[0]['approved'] != 1)
                    echo '<input type="submit" class="btn btn-success" id="Approve" name="Approve" value="Activate Affiliate" />';
                if($Result->Result[0]['approved'] == 1)
                    echo '<input type="submit" class="btn btn-danger" id="Reject" name="Reject" value="De-activate Affiliate" />';


                    echo '&nbsp;&nbsp;';
                    echo '<input type="submit" class="btn btn-success" id="Activation" name="Activation" value="Send Activation Kit" />';
            ?>  
            
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
    <li role="presentation"><a aria-expanded="true" aria-controls="home" data-toggle="tab" role="tab" id="tab3-tab" href="#tab3"><i class="fa fa-paypal"></i> <label>Payment&nbsp;Info</label></a></li>
    <li role="presentation"><a aria-expanded="true" aria-controls="home" data-toggle="tab" role="tab" id="tab4-tab" href="#tab4"><i class="fa fa-money"></i> <label>Tracking&nbsp;History</label></a></li>
    
</ul>


        <div class="tab-content" id="myTabContent">
            <div aria-labelledby="tab1-tab" id="tab1" class="tab-pane fade in active" role="tabpanel">
                <p>&nbsp;</p>
                <div id="login-form" class="login-form"> 
                     <h3>Personal&nbsp;Info</h3>
                        <div class="full">
                            <div class="col-sm-6">
                                <span><label>Affiliate&nbsp;First&nbsp;Name</label></span>
                                <span><input name="firstname" id="firstname" type="text" value="<?= $Result->Result[0]['firstname'] ?>" class="textbox" ></span>
                            </div>

                            <div class="col-sm-6">
                                <span><label>Affiliate&nbsp;Last&nbsp;Name</label></span>
                                <span><input name="lastname" id="lastname" type="text" value="<?= $Result->Result[0]['lastname'] ?>" class="textbox" ></span>
                            </div>

                            
                            <div class="col-sm-6">
                                <span><label>Affiliate&nbsp;Phone</label></span>
                                <span><input name="telephone" id="telephone" type="text" value="<?= $Result->Result[0]['telephone'] ?>" required class="textbox" ></span>
                            </div>

                            <div class="col-sm-6">
                                <span><label>Affiliate&nbsp;Email</label></span>
                                <span><input name="email" id="email" type="text" value="<?= $Result->Result[0]['email'] ?>" required  class="textbox" ></span>
                            </div>
                            
                            <div class="col-sm-6">
                                <span><label>Affiliate&nbsp;Fax</label></span>
                                <span><input name="fax" id="fax" type="text" value="<?= $Result->Result[0]['fax'] ?>" class="textbox" ></span>
                            </div>

                            <div class="col-sm-6">
                                <span><label>Affiliate&nbsp;Code</label></span>
                                <span><input name="code" id="code" type="text" value="<?= $Result->Result[0]['code'] ?>" required class="textbox" readonly></span>
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
                                <span><label>Affiliate&nbsp;Company&nbsp;Name</label></span>
                                <span><input name="company" id="company" type="text" value="<?= $Result->Result[0]['company'] ?>" class="textbox" ></span>
                            </div>

                            <div class="col-sm-6">
                                <span><label>Affiliate&nbsp;Website</label></span>
                                <span><input name="website" id="website" type="text" value="<?= $Result->Result[0]['website'] ?>" class="textbox" ></span>
                            </div>

                            
                            <div class="col-sm-6">
                                <span><label>Affiliate&nbsp;Adrdress1</label></span>
                                <span><input name="address_1" id="address_1" type="text" value="<?= $Result->Result[0]['address_1'] ?>" required class="textbox" ></span>
                            </div>

                            <div class="col-sm-6">
                                <span><label>Affiliate&nbsp;Address2</label></span>
                                <span><input name="address_2" id="address_2" type="text" value="<?= $Result->Result[0]['address_2'] ?>"  class="textbox" ></span>
                            </div>
                            
                            <div class="col-sm-6">
                                <span><label>Affiliate&nbsp;City</label></span>
                                <span><input name="city" id="city" type="text" value="<?= $Result->Result[0]['city'] ?>" required class="textbox" ></span>
                            </div>
                            <div class="col-sm-6">
                                <span><label>Affiliate&nbsp;Postal&nbsp;Code</label></span>
                                <span><input name="postcode" id="postcode" type="text" value="<?= $Result->Result[0]['postcode'] ?>" required class="textbox" ></span>
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
                                <span><input name="tax" id="tax" type="text" value="<?= $Result->Result[0]['tax'] ?>" class="textbox" ></span>
                            </div> -->

                            <div class="col-sm-6">
                                <span><label>Affiliate&nbsp;Payment&nbsp;Method</label></span>
                                <!-- <span>
                                    <ul class="form-menu-main">
                                        <li class="no-border-top">
                                            <label for="cheque"><input type="radio" name="payment" value="cheque" id="cheque" <?= ($Result->Result[0]['payment'] == 'cheque') ? 'checked' : '' ?> />Cheque</label>  
                                    
                                            <label for="paypal"><input type="radio" name="payment" value="paypal" id="paypal" <?= ($Result->Result[0]['payment'] == 'paypal') ? 'checked' : '' ?> />PayPal</label>
                                    
                                            <label for="bank"><input type="radio" name="payment" value="bank" id="bank" <?= ($Result->Result[0]['payment'] == 'bank') ? 'checked' : '' ?> />Bank Transfer</label>
                                        </li>
                                    </ul>
                                </span> -->
                                <span><input name="payment" id="payment" type="text" value="cheque" class="textbox" readonly></span>
                            </div>

                            <div class="col-sm-6">
                                <span><label>Cheque&nbsp;Name</label></span>
                                <span><input name="cheque" id="cheque" type="text" value="<?= $Result->Result[0]['cheque'] ?>" class="textbox" ></span>
                            </div>

                            <!-- <div class="col-sm-6">
                                <span><label>Paypal&nbsp;Email&nbsp;Address</label></span>
                                <span><input name="paypal" id="paypal" type="text" value="<?= $Result->Result[0]['paypal'] ?>" class="textbox" ></span>
                            </div>

                            <div class="col-sm-6">
                                <span><label>Bank&nbsp;Name</label></span>
                                <span><input name="bank_name" id="bank_name" type="text" value="<?= $Result->Result[0]['bank_name'] ?>" class="textbox" ></span>
                            </div>

                            <div class="col-sm-6">
                                <span><label>ABA/BSB&nbsp;number(Branch&nbsp;Number)</label></span>
                                <span><input name="bank_branch_number" id="bank_branch_number" type="text" value="<?= $Result->Result[0]['bank_branch_number'] ?>" class="textbox" ></span>
                            </div>

                            <div class="col-sm-6">
                                <span><label>SWIFT&nbsp;Code</label></span>
                                <span><input name="bank_swift_code" id="paypal" type="text" value="<?= $Result->Result[0]['bank_swift_code'] ?>" class="textbox" ></span>
                            </div>

                            <div class="col-sm-6">
                                <span><label>Account&nbsp;Name</label></span>
                                <span><input name="bank_account_name" id="paypal" type="text" value="<?= $Result->Result[0]['bank_account_name'] ?>" class="textbox" ></span>
                            </div>

                            <div class="col-sm-6">
                                <span><label>Account&nbsp;Number</label></span>
                                <span><input name="bank_account_number" id="paypal" type="text" value="<?= $Result->Result[0]['bank_account_number'] ?>" class="textbox" ></span>
                            </div>

                             -->
                            

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
                <?php if($ResultTransaction)
                    {
                ?>
               <div id="login-form" class="login-form"> 
                    <h3>Transaction History</h3>
                    <div class="full">
                        <div class="col-sm-1 textcolor">
                            <span><label>#</label></span>
                        </div>
                        <div class="col-sm-3 textcolor">
                            <span><label>Affiliate&nbsp;Name</label></span>
                        </div>
                        <div class="col-sm-3 textcolor">
                            <span><label>Contact&nbsp;Name</label></span>
                        </div>
                        <div class="col-sm-3 textcolor">
                            <span><label>Description</label></span>
                        </div>
                        <div class="col-sm-2 textcolor">
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
                        <input type="hidden" name="superaffiliatetransactionid[]" value="<?= $ResultTransaction->Result[$x]['superaffiliatetransactionid'] ?>"/>
                        <div class="col-sm-1">
                            <span><label><?= $count ?></label></span>
                        </div>
                        <div class="col-sm-3">
                            <span><label><?= Affiliate::GetFullName($ResultTransaction->Result[$x]['affiliateid']) ?></label></span>
                        </div>
                        <div class="col-sm-3">
                            <span><label><?= ContactInfo::GetFullName($ResultTransaction->Result[$x]['contactinfoid']) ?></label></span>
                        </div>
                        <div class="col-sm-3">
                            <span><label><?= DealStatus::getStatusText($ResultTransaction->Result[$x]['description']) ?></label></span>
                        </div>
                            
                        
                        <div class="col-sm-2">
                            <span><input name="amount[]" id="amount" type="text" value="<?=  $ResultTransaction->Result[$x]['amount'] ?> "  class="textbox" ></span>
                            
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-sm-12">&nbsp;</div>
                <?php
                    $count++;
                    }
                ?>
                        
                        <div class="col-sm-12">&nbsp;</div>
                        <div class="clearfix"></div>
                        <div class="col-sm-9">&nbsp;</div>
                        <div class="col-sm-3">
                            <input type="submit" class="btn btn-info" id="Finish" name="Finish" value="Update History" />
                        </div>
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

            
        </div>
            
          
       
</form>
<div class="clearfix"></div>
<?php require_once("inc/footer.php"); ?>
