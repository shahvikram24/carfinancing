<?php 
	require_once("../include/files.php");

	if(!isset($_SESSION['admin_id']))
  {
    header('Location:index.php?'.$Encrypt->encrypt("MessageType=Error&Message=You must sign in to view your account."));
    exit();
  } 

if(!isset($affiliate_id))
  {
    header("Location: dashboard.php");
  }


if(isset($_POST['SubmitSearch']) && $_POST['SubmitSearch'] == 'Post Notes')
{
  //debugObj($_REQUEST); die();
  $Notes = new Notes();
  $Notes->Notes = TextScrubber($_REQUEST['Notes']);
  $Notes->DatePosted = date('Y-m-d H:i:s');
  $Notes->Status = 1;
  $NotesId = $Notes->InsertNotes();


  $NotesRelations = new NotesRelations();
  $NotesRelations->NotesId = $NotesId;
  $NotesRelations->AffiliateId = $affiliate_id;
  $NotesRelations->Status = 1;
  $NotesRelations->InsertRelation();
  
  
  header("Location:affiliateinfo.php?" . $Encrypt->encrypt('affiliate_id='.$affiliate_id));
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
                $headers .= "From: no-reply@carfinancing.help" .  "\r\n";
            $mailObj = new Email($affiliateEmail, "no-reply@carfinancing.help", "Affiliate Tracking Information Updated on Car Financing Affiliate Program.");

            $baseStr .= " We have updated some of your referral leads in our system. Please login into your dashboard and see all updates under Lead Tracking tab." ;
            

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

//debugObj($ResultTransaction);


?>  

<!DOCTYPE html>
<html lang="en">
<?php require_once ("inc/title.php"); ?>

<body class="nav-md">

    <div class="container body">
      <div class="main_container">

			<!-- Header Wrapper -->
			<?php require_once ("inc/header.php"); ?>  
			

			<!-- page content -->
			<div class="right_col" role="main">  
            <?php                   
              if( isset ($Message) && $Message != "" ) 
              { 
                  if($Success && $Success == 'true')
                      echo '<div class="col-sm-12" style="color:green;">'.  $Message . '</div>';
                  else
                      echo '<div class="col-sm-12" style="color:red;">'.  $Message . '</div>';
              }
            ?>

		        <div class="row">
              <div class="col-md-12 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Affiliate Profile <small>Primary Affiliate Profile</small></h2>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                    
                      <div class="col-md-4 col-sm-4 col-xs-12 profile_left">
                        <form method="post" action="#" enctype="multipart/form-data" >
                        <input type="hidden" name="affiliate_id" value="<?= $affiliate_id ?>"/>
                        <input type="hidden" name="code" value="<?= $Result->Result[0]['code'] ?>"/>

                          <h3><?= FormatInitCap(FormatName($Result->Result[0]['firstname'],$Result->Result[0]['lastname'])) ?></h3>
                            <ul class="list-unstyled user_data">
                            <li><i class="fa fa-calendar user-profile-icon"></i> 
                                    Member Since:</strong> <?= FormatDate($Result->Result[0]['date_added'],'M d, Y') ?>
                                    
                            </li>

                            <li>
                              <?php
                                if($Result->Result[0]['approved'] != 1)
                                    echo '<input type="submit" class="btn btn-success  btn-xs" id="Approve" name="Approve" value="Activate Affiliate" />';
                                if($Result->Result[0]['approved'] == 1)
                                    echo '<input type="submit" class="btn btn-danger  btn-xs" id="Reject" name="Reject" value="De-activate Affiliate" />';
                              ?>                      
                              <input type="submit" class="btn btn-success  btn-xs" id="Activation" name="Activation" value="Send Activation Kit" />
                            
                              <input type="submit" class="btn btn-warning  btn-xs" id="ResetPwd" name="ResetPwd" value="Reset Password" />
                            </li>

                          </ul>
                          </form>
                      </div>
                      
                      <div class="col-md-8 col-sm-8 col-xs-12">
                          <div class="" role="tabpanel" data-example-id="togglable-tabs">
                              <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Notes</a>
                                </li>
                                <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">View Files</a>
                                </li>
                                <li role="presentation" class=""><a href="#tab_content3" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">Tracking&nbsp;History</a>
                                </li>
                                <li role="presentation" class=""><a href="#tab_content4" role="tab" id="profile-tab3" data-toggle="tab" aria-expanded="false">Personal&nbsp;Info</a>
                                </li>
                              </ul>

                              <div id="myTabContent" class="tab-content">
                                  <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
                                  <p>&nbsp;</p>
                                    <form method="post" action="#">
                                    <input type="hidden" name="AffiliateId" value="<?= $Encrypt->encrypt($affiliate_id) ?>">
                                    <h3>Notes</h3>
                                    <div class="col-sm-8">
                                        <span>
                                          <input type="text" name="Notes" id="messageNotes" placeholder="Please type your notes" required class="form-control" />
                                        </span>
                                    </div>
                                    <div class="col-sm-4">
                                        <span>
                                          <input type="submit" class="btn btn-primary " id="SubmitSearch" name="SubmitSearch" value="Post Notes"/>
                                        </span>
                                    </div>
                                    </form>
                                    <br/><br/>
                                    <?php

                                            $count = 1;
                                            $NotesResultset = Notes::LoadNotesInfo('AffiliateId',$affiliate_id);

                                            if($NotesResultset->TotalResults>0)
                                            {

                                    ?>
                                            <table id="datatable-buttons" class="table table-striped table-bordered">
                                                <thead>
                                                  <tr>
                                                    <th style="width: 1%">Sr#</th>
                                                    <th style="width: 75%">Notes</th>
                                                    <th>Date&nbsp;Posted</th>
                                                  </tr>
                                                </thead>


                                                <tbody>


                                            <?php
                                              for($x = 0; $x < $NotesResultset->TotalResults ; $x++)
                                              {
                                            ?>
                                    
                                                    <tr class="">
                                                        <td><?php echo $count; ?></td>
                                                    
                                                        <td><?php echo $NotesResultset->Result[$x]['Notes']; ?></td>
                                                        <td><?php echo $NotesResultset->Result[$x]['DatePosted']; ?></td>
                                                   
                                                    </tr>
                                                <?php 
                                                  $count++;
                                                } 
                                                        ?>
                                                        </tbody>
                                              </table>

                                          <?php } 
                                          else{
                                              echo '<p class="text-muted font-13 m-b-30">
                                              No records found.
                                            </p>';
                                            }?>

                                            
                                    </div> 


                                    <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">
                                        <form method="post" action="#" enctype="multipart/form-data" >
                                        <h3>Files Section</h3>
                                        <?php

                                              $count = 1;
                                              $FilesResultset = Files::LoadAffiliateFileInfo($affiliate_id);
                                              if($FilesResultset->TotalResults>0)
                                              {
                                        ?>
                                                <table id="datatable-buttons" class="table table-striped table-bordered">
                                                <thead>
                                                  <tr>
                                                    <th style="width: 1%">Sr#</th>
                                                    <th style="width: 60%">Filename</th>
                                                    <th>Action</th>
                                                    <th>&nbsp;</th>
                                                  </tr>
                                                </thead>


                                                <tbody>
                                                  <?php
                                                    for($x = 0; $x < $FilesResultset->TotalResults ; $x++)
                                                    {
                                                  ?>
                                    
                                                      <tr class="">
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

                                                <?php } 
                                                else{
                                                    echo '<p class="text-muted font-13 m-b-30">
                                                    No records found.
                                                  </p>';
                                                  }?>

                                                  
                                                    <div class="col-sm-5">
                                                        <span><label>Upload Files</label>:&nbsp;</span>
                                                        <span><input type="file" name="myfile[]" multiple="multiple"  class="form-control" ></span>
                                                        <input type ="hidden" name="imageupdate" value="on">
                                                        <input type="hidden" name="mode" value="addimage">
                                                        <input type="hidden" name="AffiliateId" value="<?= $Encrypt->encrypt($affiliate_id) ?>">

                                                    </div>

                                                    <div class="col-sm-4">
                                                        <span><label>File Type:</label></span>
                                                        <span>
                                                          <select name="fileType" class="form-control">
                                                            <option>Driver Licence</option>
                                                            <option>Credit Report</option>
                                                            <option>Contract Docs</option>
                                                            <option>Credit App</option>
                                                            <option>Bill of Sale</option>
                                                            <option>Other</option>
                                                          </select>
                                                        </span>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <span><label>&nbsp;</label></span>
                                                        <span>
                                                          <input type="submit" class="form-control btn btn-success" id="SubmitSearch" name="SubmitSearch" value="Upload Files" />
                                                        </span>
                                                    </div>
                                        </form>
                                    </div>

                                    <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="profile-tab">
                                    <form method="post" action="#" enctype="multipart/form-data" >
                                        <h3>Affiliate Referral Tracking</h3>
                                        <?php

                                              $count = 1;
                                              
                                              if($ResultTransaction)
                                              {
                                        ?>
                                                <table id="datatable-buttons" class="table table-striped table-bordered">
                                                <thead>
                                                  <tr>
                                                    <th style="width: 1%">Sr#</th>
                                                    <th>Contact&nbsp;Name</th>
                                                    <th>Description</th>
                                                    <th>Referal&nbsp;Amount</th>
                                                  </tr>
                                                </thead>


                                                <tbody>
                                                  <?php
                                                    for($x = 0; $x < $ResultTransaction->TotalResults ; $x++)
                                                    {
                                                            $ContactId = $ResultTransaction->Result[$x]['contactinfoid'];
                                                            $link =  ADMINAPPROOT . 'profile.php?' . $Encrypt->encrypt('ContactId='.$ContactId); 
                                                  ?>
                                                    <input type="hidden" name="affiliatetransactionid[]" value="<?= $ResultTransaction->Result[$x]['affiliatetransactionid'] ?>"/>
                                                      <tr class="">
                                                          <td><?php echo $count; ?></td>           
                                                          <td><a href="<?= $link ?>">
                                                                    <?= Contact::GetFullName($ResultTransaction->Result[$x]['contactinfoid']) ?>
                                                                </a></td>
                                                          <td>
                                                          <?php 
                                    
                                                                if($ResultTransaction->Result[$x]['description'] == 7)
                                                                {
                                                                    echo "<span><label>" . DealStatus::getStatusText($ResultTransaction->Result[$x]['description']) ."</label></span>";
                                                                    echo "<input type='hidden' name='description[]' value='". $Encrypt->encrypt($ResultTransaction->Result[$x]['description']) ."'/> ";
                                                                }
                                                                else
                                                                {
                                                                    echo '<span><select id="description" name="description[]" class="form-control" >';
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
                                                          </td>
                                                          <td>
                                                            <input name="amount[]" id="amount" type="text" value="<?=  $ResultTransaction->Result[$x]['amount'] ?> "  class="form-control" >
                                                          </td>
                                                     
                                                        </tr>
                                                      <?php 
                                                        $count++;
                                                      } 
                                                              ?>
                                                              </tbody>
                                                    </table>

                                                <?php } 
                                                else{
                                                    echo '<p class="text-muted font-13 m-b-30">
                                                    No records found.
                                                  </p>';
                                                  }?>

                                                  <div class="clearfix"></div>
                                                    <div class="col-sm-4">
                                                        <span>
                                                          <input type="submit" class="btn btn-primary " id="Finish" name="Finish" value="Update History"/>
                                                        </span>
                                                    </div>

                                        </form>          
                                    </div>

                                    <div role="tabpanel" class="tab-pane fade in" id="tab_content4" aria-labelledby="home-tab">
                                    <form method="post" action="#" enctype="multipart/form-data" >
                                      <h3>Personal Contact Information </h3>

                                          <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                              <label>Contact First Name</label>
                                              <input  type="text" value="<?= FormatInitCap($Result->Result[0]['firstname']) ?>" readonly class="form-control">
                                            </div>

                                          <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                              <label>Contact Last Name</label>
                                              <input  type="text" value="<?= FormatInitCap($Result->Result[0]['lastname']) ?>" readonly class="form-control">
                                            </div>

                                          <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                              <label>Email Address</label>
                                              <input  type="text" value="<?= $Result->Result[0]['email'] ?>" readonly class="form-control">
                                            </div>

                                          <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                              <label>Phone Number</label>
                                              <input  type="text" value="<?=  $Result->Result[0]['telephone'] ?>" readonly class="form-control">
                                            </div>

                                          <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                              <label>Fax#</label>
                                              <input  type="text" value="<?= $Result->Result[0]['fax'] ?>" readonly class="form-control">
                                            </div>

                                            <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                              <label>Affiliate&nbsp;Code</label>
                                              <input  type="text" value="<?=  $Result->Result[0]['code'] ?>" readonly class="form-control">
                                            </div>

                                          <div class="clearfix"></div>
                                          <h3>Address Information</h3>
                                          <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                              <label>Company&nbsp;Name</label>
                                              <input  type="text" value="<?=  $Result->Result[0]['company'] ?>" readonly class="form-control">
                                            </div>

                                          <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                              <label>Website</label>
                                              <input  type="text" value="<?=  $Result->Result[0]['website']  ?>" readonly class="form-control">
                                            </div>

                                            <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                              <label>Address</label>
                                              <input  type="text" value="<?=  $Result->Result[0]['address_1']  ?>" readonly class="form-control">
                                            </div>

                                            <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                              <label>City</label>
                                              <input  type="text" value="<?= $Result->Result[0]['city'] ?>" readonly class="form-control">
                                            </div>

                                            <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                              <label>Province</label>
                                              <input  type="text" value="<?=  FormatInitCap($Result->Result[0]['address_2']) ?>" readonly class="form-control">
                                            </div>

                                            <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                              <label>Postal Code</label>
                                              <input  type="text" value="<?=  $Result->Result[0]['postcode'] ?>" readonly class="form-control">
                                            </div>

                                          <div class="clearfix"></div>
                                          <h3>Employment Information</h3>
                                          <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                              <label>Payment&nbsp;Method</label>
                                              <input  type="text" value="cheque" readonly class="form-control">
                                            </div>

                                             <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                              <label>Cheque&nbsp;Name</label>
                                              <input  type="text" value="<?= $Result->Result[0]['cheque'] ?>" readonly class="form-control">
                                            </div>

                                            
                                            <div class="clearfix"></div>
                                            <div class="col-sm-4">
                                                <span>
                                                  <input type="submit" class="btn btn-primary " id="Finish" name="Finish" value="Update Personal"/>
                                                </span>
                                            </div>
                                        </form>
                                    </div>
                          </div>
                      </div>
                      
                    </div>
                  </div>
              </div>

          <div class="clearfix"></div>
                </div>

              </div>
              
            </div>	

		    	<div class="clearfix"></div>

		          
          	<!-- /top tiles -->
	    	</div>

		<!-- Footer Wrapper -->
		<?php require_once ("inc/footer.php"); ?>  
<script>
      $(document).ready(function() {
        var handleDataTableButtons = function() {
          if ($("#datatable-buttons").length) {
            $("#datatable-buttons").DataTable({
              dom: "Bfrtip",
              buttons: [
                {
                  extend: "copy",
                  className: "btn-sm"
                },
                {
                  extend: "csv",
                  className: "btn-sm"
                },
                {
                  extend: "excel",
                  className: "btn-sm"
                },
                {
                  extend: "pdfHtml5",
                  className: "btn-sm"
                },
                {
                  extend: "print",
                  className: "btn-sm"
                },
              ],
              responsive: true
            });
          }
        };

        TableManageButtons = function() {
          "use strict";
          return {
            init: function() {
              handleDataTableButtons();
            }
          };
        }();

        $('#datatable').dataTable();
        $('#datatable-keytable').DataTable({
          keys: true
        });

        $('#datatable-responsive').DataTable();

        $('#datatable-scroller').DataTable({
          ajax: "js/datatables/json/scroller-demo.json",
          deferRender: true,
          scrollY: 380,
          scrollCollapse: true,
          scroller: true
        });

        var table = $('#datatable-fixed-header').DataTable({
          fixedHeader: true
        });

        TableManageButtons.init();
      });
    </script>
    <!-- /Datatables -->
</body>
</html>
