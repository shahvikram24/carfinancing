<?php
    
    require_once("../include/files.php");
    
echo "<script type='text/javascript' src='inc/functions.js'></script> ";

if(!isset($_SESSION['admin_id']))
{
    header("Location: index.php");
}


if(isset($_POST['Finish']) && $_POST['Finish'] == 'Update Personal')
{
    $affiliate = new Affiliate();
    $affiliate->loadAffiliate($affiliate_id);
    
    $affiliate->firstname = $_POST['firstname'];
    $affiliate->lastname = $_POST['lastname'];
    $affiliate->email = $_POST['email'];
    $affiliate->telephone = $_POST['telephone'];
    $affiliate->fax = $_POST['fax'];

    $affiliate->company = $_POST['company'];
    $affiliate->website = $_POST['website'];
    $affiliate->address_1 = $_POST['address_1'];
    $affiliate->address_2 = $_POST['address_2'];
    $affiliate->city = $_POST['city'];
    $affiliate->postcode = $_POST['postcode'];
    $affiliate->UpdateAffiliate();

    header('Location:affiliateinfo.php?' . $Encrypt->encrypt("Message=Affiliate personal information has been updated successfully.&Success=true&affiliate_id=".$affiliate_id));
    exit();
}

if(isset($_POST['Finish']) && $_POST['Finish'] == 'Update Address')
{
    $affiliate = new Affiliate();
    $affiliate->loadAffiliate($affiliate_id);
    
    $affiliate->company = $_POST['company'];
    $affiliate->website = $_POST['website'];
    $affiliate->address_1 = $_POST['address_1'];
    $affiliate->address_2 = $_POST['address_2'];
    $affiliate->city = $_POST['city'];
    $affiliate->postcode = $_POST['postcode'];

    
    $affiliate->UpdateAffiliate();

    header('Location:affiliateinfo.php?' . $Encrypt->encrypt("Message=Affiliate address information has been updated successfully.&Success=true&affiliate_id=".$affiliate_id));
    exit();
}

if(isset($_POST['Finish']) && $_POST['Finish'] == 'Update Payment')
{
    $affiliate = new Affiliate();
    $affiliate->loadAffiliate($affiliate_id);
    
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

    header('Location:affiliateinfo.php?' . $Encrypt->encrypt("Message=Affiliate payment information has been updated successfully.&Success=true&affiliate_id=".$affiliate_id));
    exit();
}

if(isset($_POST['Finish']) && $_POST['Finish'] == 'Update History')
{

    $affiliateTransaction = new AffiliateTransaction();

    for($x=0; $x < count($_POST['affiliatetransactionid']); $x++)
    {
        $affiliateTransaction->loadTransactionId($_POST['affiliatetransactionid'][$x]);
        $affiliateTransaction->description = $Decrypt->decrypt($_POST['description'][$x]);
        $affiliateTransaction->amount = $_POST['amount'][$x];
        $affiliateTransaction->UpdateTransaction();
    }

    $affiliateEmail = Affiliate::GetEmail($affiliateTransaction->affiliateid);
    // To send HTML mail, the Content-type header must be set
                $headers  = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                $headers .= "From: no-reply@supercarloans.ca" .  "\r\n";
            $mailObj = new Email($affiliateEmail, "no-reply@supercarloans.ca", "Affiliate Tracking Information Updated on SuperCarLoans Affiliate Program.");

            $baseStr .= " We have updated some of your referral leads in our system. Please login into your dashboard and see all updates under Tracking History tab." ;
            

            $mailObj->TextOnly = false;
            $mailObj->Headers = $headers;

            $mailObj->Content = $baseStr; 

            $mailObj->Send();


    header('Location:affiliateinfo.php?' . $Encrypt->encrypt("Message=Affiliate referral amount has been added successfully.&Success=true&affiliate_id=".$affiliate_id));
    exit();
}

if(isset($_POST['Reject']) && $_POST['Reject'] == 'De-activate Affiliate')
{
    $affiliate = new Affiliate();
    $affiliate->loadAffiliate($affiliate_id);
    $affiliate->approved = 3;
    $affiliate->UpdateAffiliate();

    header('Location:affiliateinfo.php?' . $Encrypt->encrypt("Message=Affiliate has been de-activated successfully.&Success=true&affiliate_id=".$affiliate_id));
    exit();
}


if(isset($_POST['Approve']) && $_POST['Approve'] == 'Activate Affiliate')
{
    
    $affiliate = new Affiliate();
    $affiliate->loadAffiliate($affiliate_id);
    $affiliate->approved = 1;
    $affiliate->UpdateAffiliate();
    
    header('Location:affiliateinfo.php?' . $Encrypt->encrypt("Message=Affiliate activated successfully.&Success=true&affiliate_id=".$affiliate_id));
    exit();
}

if(isset($_POST['Activation']) && $_POST['Activation'] == 'Send Activation Kit')
{
    
    if(Affiliate::sendActivationKit($affiliate_id))
    {   
        header('Location:affiliateinfo.php?' . $Encrypt->encrypt("Message=Activation instruction sent successfully.&Success=true&affiliate_id=".$affiliate_id));
        exit();
    }
    else
    {
        header('Location:affiliateinfo.php?' . $Encrypt->encrypt("Message=Something went wrong.&Success=false&affiliate_id=".$affiliate_id));
        exit();
    }
}

if( isset($_REQUEST['ResetPwd']) && $_REQUEST['ResetPwd'] == 'Reset Password' )   
{  
    
    if(Affiliate::AffiliateExists($_REQUEST['code'])) 
    {
        $login = new Affiliate();
        $login->loadAffiliateByCode("affiliate_id like ".$affiliate_id);
        $Encryption = $Encrypt->encrypt('affiliate_id=' . $login->affiliate_id . '&ExpireDate=' . date("Y-m-d", mktime(0, 0, 0, date("m") , date("d") + 2, date("Y"))) . '&ResetAccount=true');
        
        if($login->sendRecoverPasswordLink($login->email,$Encryption))
        {
            header("Location:affiliateinfo.php?" . $Encrypt->encrypt("Message=Reset password link has been sent to affiliate via email.&Success=true&affiliate_id=".$affiliate_id));
            exit();
        }
    }
    else{
        header("Location:affiliateinfo.php?" . $Encrypt->encrypt("Message=User does not exist.&Success=false&affiliate_id=".$affiliate_id));
            exit();
    }

}

if(isset($_POST['SubmitSearch']) && $_POST['SubmitSearch'] == 'Upload Files')
{
        //$affiliateId = $Decrypt->decrypt($_POST['affiliateId']);
        
        $Message = 'Files uploaded successfully.';
        $file = isset($_FILES["myfile"])?$_FILES["myfile"]:'';
        $mode = isset($_POST["mode"]) ? addslashes($_POST["mode"]) : '';
        $error = 0;
        $imageupdate = isset($_POST["imageupdate"])?addslashes($_POST["imageupdate"]):'';
        if($imageupdate=="on" && isset($mode) && $mode=="addimage")
        {
            
            foreach($_FILES['myfile']['tmp_name'] as $key => $tmp_name )
            {
                $file_name = $key.$_FILES['myfile']['name'][$key];
                $file_size =$_FILES['myfile']['size'][$key];
                $file_tmp =$_FILES['myfile']['tmp_name'][$key];
                $file_type=$_FILES['myfile']['type'][$key];
            }
         

            $counter=0;
            foreach($_FILES['myfile']['tmp_name'] as $key => $tmp_name )
            {   
                $filename = $_FILES['myfile']['name'][$key];
                
                $file_size =$_FILES['myfile']['size'][$key];
                $file_tmp =$_FILES['myfile']['tmp_name'][$key];
                $file_type=$_FILES['myfile']['type'][$key];
                $imageFileType = pathinfo($filename,PATHINFO_EXTENSION);
                
                //echo $file_tmp. "<br/>";

                if (strlen($filename) > 0)
                {
                    switch($_FILES['myfile']['error'][$key])
                    {
                        case 0:
                            $name = date('YmdHis')."." . $imageFileType;
                            $destdir = '../img/';
                            $destfile = $destdir . $name;
                        
                            if (!file_exists($destfile))
                            {
                                if (move_uploaded_file($file_tmp, $destfile))
                                {
                                    //echo "Picture was successfully uploaded<br/>";
                                    chmod($destfile, 0775);
                                    $imagename = $name;

                                    $tblfile = new Files();
                                    $tblfile->FileName = $name;
                                    $tblfile->FileDescription = '';
                                    $tblfile->FileSize = $file_size;
                                    $tblfile->FileMIME = $file_type;
                                    $tblfile->FileLocation = $name;
                                    $tblfile->Status = 1;
                                    $tblfile->FileVersion = 1;
                                    $tblfile->DownloadCount = 0;
                                    $fileId = $tblfile->InsertFile();

                                    $fileRelations = new FileRelations();
                                    $fileRelations->FileId = $fileId;
                                    $fileRelations->AffiliateId = $affiliate_id;
                                    $fileRelations->Status = 1;
                                    $fileRelations->InsertRelation();
                                }
                                else{
                                    $error = 1;
                                    $Message ="There was an error uploading Picture.&Success=false";
                                }
                                
                             }  
                             
                            break;
                        case 1:
                        case 2:
                            $error = 1;
                            $Message ="Max Size Exceeded, Please Upload a smaller Picture.&Success=false";
                            break;
                        case 3:
                            $error = 1;
                            $Message ="Picture Upload Incomplete! Please Try Again.&Success=false";
                            break;
                        case 4:
                            if($imageupdate=="on")
                                $error = 1;
                            $Message = "No Picture Uploaded.&Success=false";
                            break;
                    }
                }
                else{
                    $error = 1;
                    $Message = "no picture included, process failed.&Success=false";
                    header('Location:affiliateinfo.php?' . $Encrypt->encrypt('affiliate_id='.$affiliate_id."&Message=".$Message));
                    exit;
                }
                

            }//end of for each

                    
                            header('Location:affiliateinfo.php?' . $Encrypt->encrypt('affiliate_id='.$affiliate_id."&Message=".$Message."&Success=true"));
        }
}
if(!isset($affiliate_id) || $_REQUEST['affiliate_id'])
{
    header("Location: dashboard.php");
}


$SQLWhere =' status=1 AND affiliate_id='. $affiliate_id;
$affiliate = new Affiliate();
$Result = $affiliate->loadAllAffiliateInfo($SQLWhere);

$affiliateTransaction = new AffiliateTransaction();
$ResultTransaction = $affiliateTransaction->loadByAffiliate($affiliate_id);

$dealStatus = new DealStatus();
$dealStatusResult = $dealStatus->loadAllDealStatus();

//debugObj($dealStatusResult);

?> 

               
<!DOCTYPE html>
<html lang="en">
<?php require_once("inc/title.php"); ?>

<body>
<?php require_once("inc/header.php"); ?>

<form method="post" action="#" enctype="multipart/form-data" >
    <input type="hidden" name="affiliate_id" value="<?= $affiliate_id ?>"/>
<div class="content-section-a" id="how-it-works">
<div class="container">
    <div class="row">
        <div class="col-lg-12" id="">
            <legend><?= FormatName($Result->Result[0]['firstname'],$Result->Result[0]['lastname']) ?></legend>
            <div class="alert alert-success">
              <strong>Member Since:</strong> <?= FormatDate($Result->Result[0]['date_added'],'M d, Y') ?>
            </div>
                
            <?php
                if($Result->Result[0]['approved'] != 1)
                    echo '<input type="submit" class="btn btn-success" id="Approve" name="Approve" value="Activate Affiliate" />';
                if($Result->Result[0]['approved'] == 1)
                    echo '<input type="submit" class="btn btn-danger" id="Reject" name="Reject" value="De-activate Affiliate" />';


                    echo '&nbsp;&nbsp;';
                    echo '<input type="submit" class="btn btn-success" id="Activation" name="Activation" value="Send Activation Kit" />';
                    echo '&nbsp;&nbsp;';
                    echo '<input type="submit" class="btn btn-warning" id="ResetPwd" name="ResetPwd" value="Reset Password" />';
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
    <!-- <li role="presentation"><a aria-expanded="true" aria-controls="home" data-toggle="tab" role="tab" id="tab2-tab" href="#tab2"><i class="fa fa-home"></i> <label>Address&nbsp;Info</label></a></li> -->
    <li role="presentation"><a aria-expanded="true" aria-controls="home" data-toggle="tab" role="tab" id="tab3-tab" href="#tab3"><i class="fa fa-paypal"></i> <label>Payment&nbsp;Info</label></a></li>
    <li role="presentation"><a aria-expanded="true" aria-controls="home" data-toggle="tab" role="tab" id="tab4-tab" href="#tab4"><i class="fa fa-money"></i> <label>Tracking&nbsp;History</label></a></li>
    <li role="presentation"><a aria-expanded="true" aria-controls="home" data-toggle="tab" role="tab" id="tab5-tab" href="#tab5"><i class="fa fa-calendar"></i> <label>View&nbsp;Files</label></a></li>
    
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
                        
                    </div>

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
                                <span><label>Affiliate&nbsp;City</label></span>
                                <span><input name="city" id="city" type="text" value="<?= $Result->Result[0]['city'] ?>" required class="textbox" ></span>
                            </div>
                            <div class="col-sm-6">
                                <span><label>Affiliate&nbsp;Province</label></span>
                                <span><input name="address_2" id="address_2" type="text" value="<?= $Result->Result[0]['address_2'] ?>"  class="textbox" ></span>
                            </div>
                            <div class="col-sm-6">
                                <span><label>Affiliate&nbsp;Postal&nbsp;Code</label></span>
                                <span><input name="postcode" id="postcode" type="text" value="<?= $Result->Result[0]['postcode'] ?>" required class="textbox" ></span>
                            </div>

                        <div class="clearfix"></div>
                        <div class="col-sm-9">&nbsp;</div>
                            <div class="col-sm-3">
                                <input type="submit" class="btn btn-info" id="Finish" name="Finish" value="Update Personal" />
                            </div>
                            <div class="clearfix"></div>
                </div>
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

                        $ContactId = Contact::GetId($ResultTransaction->Result[$x]['contactinfoid']);
                        $link =  ADMINAPPROOT . 'info.php?' . $Encrypt->encrypt('ContactId='.$ContactId); 
                ?>
                        <input type="hidden" name="affiliatetransactionid[]" value="<?= $ResultTransaction->Result[$x]['affiliatetransactionid'] ?>"/>
                        <div class="col-sm-2">
                            <span><label><?= $count ?></label></span>
                        </div>
                        <div class="col-sm-3">
                            <span><label><a href="<?= $link ?>">
                                            <?= ContactInfo::GetFullName($ResultTransaction->Result[$x]['contactinfoid']) ?>
                                        </a>
                                    </label></span>
                        </div>
                        <div class="col-sm-4">
                            
                                <?php 
                                    
                                        if($ResultTransaction->Result[$x]['description'] == 7)
                                        {
                                            echo "<span><label>" . DealStatus::getStatusText($ResultTransaction->Result[$x]['description']) ."</label></span>";
                                            echo "<input type='hidden' name='description[]' value='". $Encrypt->encrypt($ResultTransaction->Result[$x]['description']) ."'/> ";
                                        }
                                        else
                                        {
                                            echo '<span><select id="description" name="description[]" >';
                                            for($y = 0; $y < $dealStatusResult->TotalResults ; $y++)
                                            {
                                                if($dealStatusResult->Result[$y]['Id'] == $ResultTransaction->Result[$x]['description'])
                                                {
                                                    echo "<option value='". $Encrypt->encrypt($dealStatusResult->Result[$y]['Id']) ."' selected >".
                                                            $dealStatusResult->Result[$y]['StatusText']
                                                      . "</option>";
                                                }
                                                else
                                                {
                                                    echo "<option value='". $Encrypt->encrypt($dealStatusResult->Result[$y]['Id']) ."'>".
                                                            $dealStatusResult->Result[$y]['StatusText']
                                                      . "</option>";
                                                }
                                            }
                                            echo '</select></span>';    
                                        }
                                ?>                                        
                            
                        </div>
                        <div class="col-sm-3">
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

            <div aria-labelledby="tab5-tab" id="tab5" class="tab-pane" role="tabpanel">
                    <p>&nbsp;</p>
                    <!-- Toggle for Files Information starts -->
                    <div id="FilesInformation" class="FilesInformation">

                        <hr/>
                        <h3>Files Section</h3>
                        <?php

                            $count = 1;
                            $FilesResultset = Files::LoadAffiliateFileInfo($affiliate_id);
                            if($FilesResultset->TotalResults>0)
                            {
                        ?>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Filename</th>
                                                <th>Action</th>
                                                <th>&nbsp;</th>
                                            </tr>
                                        </thead>
                                    <tbody>
                        <?php

                                for($x = 0; $x < $FilesResultset->TotalResults ; $x++)
                                {
                        ?>
                                <tr>
                                    <td><?php echo $count; ?></td>
                                
                                    <td><?php echo $FilesResultset->Result[$x]['FileName']; ?></td>
                               
                                    <td>
                                        <?php
                                                echo '<a href="'. APPROOT . 'lib/download.php?f='. $FilesResultset->Result[$x]['FileLocation'] .'">'
                                                .'Click here to download'; 
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                                echo '<a href="'. APPROOT . 'img/'. $FilesResultset->Result[$x]['FileLocation'] .'" target="_blank">'
                                                .'View File'; 
                                        ?>
                                    </td>

                                </tr>
                                
                          <?php
                                    $count++;
                                }
                            ?>
                                     </tbody>
                                </table>
                            </div>
                            <div class="clearfix"></div>
                            <?php

                            }

                            ?>
                            <hr/>

                        
                        
                            <div class="col-sm-3">
                                <span><label>Upload Files</label>:&nbsp;</span>
                                <span><input type="file" name="myfile[]" multiple="multiple" class="btn btn-warning" ></span>
                                <input type ="hidden" name="imageupdate" value="on">
                                <input type="hidden" name="mode" value="addimage">
                                <input type="hidden" name="affiliateId" value="<?= $Encrypt->encrypt($affiliate_id) ?>">

                            </div>
                            <div class="col-sm-3">
                                <span><label>&nbsp;</label></span>
                                <span>
                                    <input type="submit" class="btn btn-primary " id="SubmitSearch" name="SubmitSearch" value="Upload Files" />
                                </span>
                            </div>
                     
                        
                          
                       

                        <div class="clearfix"></div>
                        
                    
                    </div>
                    <div class="clearfix"></div>
        </div>
            
          
       
</form>
<div class="clearfix"></div>
<?php require_once("inc/footer.php"); ?>
