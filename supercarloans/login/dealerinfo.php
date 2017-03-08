<?php
    
    require_once("../include/files.php");
    
echo "<script type='text/javascript' src='inc/functions.js'></script> ";



if(!isset($_SESSION['admin_id']))
{
    header("Location: index.php");
}


if(isset($_POST['Finish']) && $_POST['Finish'] == 'Update Dealership')
{
    $dealership = new dealership();
    $dealership->loadDealershipInfo($DealerId);
    $OldPlan = $dealership->DealershipPlan;

    $dealership->DealershipName = ucwords($_POST['DealershipName']); 
    $dealership->DealershipPlan = $Decrypt->decrypt($_POST['DealershipPlan']); 
    $dealership->Address = $_POST['Address']; 
    $dealership->Phone = $_POST['Phone']; 
    $dealership->Email = $_POST['Email']; 
    $dealership->Fax = $_POST['Fax']; 
    $dealership->ContactName = $_POST['ContactName']; 
    $dealership->LicenceNo = $_POST['LicenceNo']; 
    $dealership->Remarks = $_POST['Remarks'];

    $dealership->Approve = 1;
    
    
    $dealership->updateDealershipInfo();

    if($OldPlan != $Decrypt->decrypt($_POST['DealershipPlan']))
    {
        $Id = dealerpackages::GetIdByDealerId($DealerId);
        $dp = new dealerpackages();
        $dp->LoadDealerPackage($Id);
        $dp->Status=0;
        $dp->UpdateDealerPackage();

        $dealerpackages = new dealerpackages();
        $dealerpackages->AddDate = date('Y-m-d H:i:s');
        if($Decrypt->decrypt($_POST['DealershipPlan']) == 1) 
            $dealerpackages->ExpireDate = FormatDate(date('Y-m-d H:i:s', strtotime("+365 days")));
        else
            $dealerpackages->ExpireDate = FormatDate(date('Y-m-d H:i:s', strtotime("+30 days")));

        $dealerpackages->PlanId = $Decrypt->decrypt($_POST['DealershipPlan']);
        $dealerpackages->Term = 0;
        $dealerpackages->DealerId = $_POST['DealerId'];
        $dealerpackages->Timestamp = date('Y-m-d H:i:s');
        $dealerpackages->Status = 1;
        $DealerPackageId = $dealerpackages->InsertDealerPackage();
    }

    header('Location:dealerinfo.php?' . $Encrypt->encrypt("Message=Dealer information has been updated successfully.&Success=true&DealerId=".$DealerId));
    exit();
}

if(isset($_POST['Reject']) && $_POST['Reject'] == 'De-activate Dealer')
{
    $dealership = new dealership();
    $dealership->loadDealershipInfo($DealerId);
    $dealership->Approve = 3;
    $dealership->updateDealershipInfo();

    header('Location:dealerinfo.php?' . $Encrypt->encrypt("Message=Dealer has been de-activated successfully.&Success=true&DealerId=".$DealerId));
    exit();
}

if(isset($_POST['Approve']) && $_POST['Approve'] == 'Activate Dealer')
{

    
    $dealership = new dealership();
    $dealership->loadDealershipInfo($DealerId);
    $dealership->Approve = 1;
    $dealership->DealershipPlan = $Decrypt->decrypt($_POST['DealershipPlan']); 
    $dealership->updateDealershipInfo();

    
    $dealerpackages = new dealerpackages();
    $dealerpackages->AddDate = date('Y-m-d H:i:s');
    if($Decrypt->decrypt($_POST['DealershipPlan']) == 1) 
        $dealerpackages->ExpireDate = FormatDate(date('Y-m-d H:i:s', strtotime("+365 days")));
    else
        $dealerpackages->ExpireDate = FormatDate(date('Y-m-d H:i:s', strtotime("+30 days")));

    $dealerpackages->PlanId = $Decrypt->decrypt($_POST['DealershipPlan']);
    $dealerpackages->Term = 0;
    $dealerpackages->DealerId = $_POST['DealerId'];
    $dealerpackages->Timestamp = date('Y-m-d H:i:s');
    $dealerpackages->Status = 1;
    $dealerpackages->InsertDealerPackage();

    header('Location:dealerinfo.php?' . $Encrypt->encrypt("Message=Dealer activated successfully.&Success=true&DealerId=".$DealerId));
    exit();
}


if(isset($_POST['Apply']) && $_POST['Apply'] == 'Apply')
{
    $dealership = new dealership();
    $Result = $dealership->loadDealershipInfo($_POST['DealerId']);
    $AppsWithPackage = Package::GetApps($Result->DealershipPlan);
    $Positive = dealercredits::CountPositive($Result->Id,dealerpackages::GetIdByDealerId($Result->Id));
    $Negative = dealercredits::CountNegative($Result->Id,dealerpackages::GetIdByDealerId($Result->Id));

    $Total = $Positive - $Negative;

    $Manage = $AppsWithPackage + $Total;
   
   if($_POST['IsQuantityPositive'] == 0)
   {

        if($Manage < $_POST['Quantity'])
        {
            header('Location: dealerinfo.php?' . $Encrypt->encrypt("Message=Debit quantity should not exceeds your limited quantities.&Success=false&DealerId=".$_POST['DealerId']));
            exit();
        }
   }
    $dealercredits = new dealercredits();
    $dealercredits->DealerId = $_POST['DealerId'];
    $dealercredits->DealerPackageId = dealerpackages::GetIdByDealerId($_POST['DealerId']);
    $dealercredits->Quantity = $_POST['Quantity'];
    $dealercredits->Comment = $_POST['Comment'];
    $dealercredits->IsQuantityPositive = $_POST['IsQuantityPositive'];
    $dealercredits->Timestamp = date('Y-m-d H:i:s');
    $dealercredits->Status = 1;
    if($dealercredits->addDealerCredits())
    {
        header('Location: dealerinfo.php?' . $Encrypt->encrypt("Message=Credits applied successfully.&Success=true&DealerId=".$_POST['DealerId']));
        exit();
    }
}


if(!isset($DealerId))
{
    header("Location: dashboard.php");
}


$dealership = new dealership();
$Result = $dealership->loadDealershipInfo($DealerId);

$Package = new Package();
$PackageResultSet = $Package->GetPackages(false,false,' P. Status=1 ');

$dealerpackagesResultset = dealerpackages::GetInfoByDealerId($DealerId);

$DealerPlan = new Package();
$DealerPlan->LoadPackage($Result->DealershipPlan,true);

$DealerPackageFeatures = new DealerPackageFeatures();
$DealerPackageFeaturesResultSet = $DealerPackageFeatures->LoadFeaturesByDealerId($Result->Id,dealerpackages::GetIdByDealerId($Result->Id),true);

//echo "<br/><br/><br/><br/><br/>";
//debugObj(count($DealerPackageFeaturesResultSet));

?>

 

               
<!DOCTYPE html>
<html lang="en">
<?php require_once("inc/title.php"); ?>

<body>
<?php require_once("inc/header.php"); ?>

<form method="post" action="#">
    <input type="hidden" name="DealerId" value="<?= $Result->Id ?>"/>
<div class="content-section-a" id="how-it-works">
<div class="container">
    <div class="row">
        <div class="col-lg-12" id="">
            <legend><?= $Result->DealershipName ?></legend>
            
                
            <?php
                if($Result->Approve != 1)
                    echo '<input type="submit" class="btn btn-success" id="Approve" name="Approve" value="Activate Dealer" />';
                if($Result->Approve == 1)
                    echo '<input type="submit" class="btn btn-danger" id="Reject" name="Reject" value="De-activate Dealer" />';

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
    <li class="active" role="presentation"><a aria-expanded="true" aria-controls="home" data-toggle="tab" role="tab" id="tab1-tab" href="#tab1"><i class="fa fa-home"></i> <label>Dealer&nbsp;Info</label></a></li>
    <li role="presentation"><a aria-expanded="true" aria-controls="home" data-toggle="tab" role="tab" id="tab2-tab" href="#tab2"><i class="fa fa-archive"></i> <label>Current&nbsp;Package&nbsp;Leads&nbsp;History</label></a></li>
    <li role="presentation"><a aria-expanded="true" aria-controls="home" data-toggle="tab" role="tab" id="tab3-tab" href="#tab3"><i class="fa fa-calendar"></i> <label>Plan&nbsp;History</label></a></li>
    <li role="presentation"><a aria-expanded="true" aria-controls="home" data-toggle="tab" role="tab" id="tab4-tab" href="#tab4"><i class="fa fa-cog"></i> <label>Manage&nbsp;Credits</label></a></li>
</ul>


<div class="tab-content" id="myTabContent">
            <div aria-labelledby="tab1-tab" id="tab1" class="tab-pane fade in active" role="tabpanel">
                <p>&nbsp;</p>
                <div id="login-form" class="login-form"> 
                     <h3>Dealership Information</h3>
                        <div class="full">
                            <div class="col-sm-6">
                                <span><label>Dealership&nbsp;Name</label></span>
                                <span><input name="DealershipName" id="DealershipName" type="text" value="<?= $Result->DealershipName ?>" class="textbox" ></span>
                            </div>

                            <div class="col-sm-6">
                                <span><label>Dealership Plan *</label></span>
                                    <span><select id="DealershipPlan" name="DealershipPlan" >
                                    <?php 
                                        for($x = 0; $x < $PackageResultSet->TotalResults ; $x++)
                                        {
                                            if($PackageResultSet->Result[$x]['Id'] == $Result->DealershipPlan)
                                            {
                                                echo "<option value='". $Encrypt->encrypt($PackageResultSet->Result[$x]['Id']) ."' selected >".
                                                        $PackageResultSet->Result[$x]['Name']
                                                  . "</option>";
                                            }
                                            else
                                            {
                                                echo "<option value='". $Encrypt->encrypt($PackageResultSet->Result[$x]['Id']) ."'>".
                                                        $PackageResultSet->Result[$x]['Name']
                                                  . "</option>";
                                            }
                                                
                                        }
                                    ?>                                        
                                </select></span>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-sm-6">
                                <span><label>Dealership&nbsp;Address</label></span>
                                <span><input name="Address" id="Address" type="text" value="<?= $Result->Address ?>" required class="textbox" ></span>
                            </div>

                            
                            <div class="col-sm-6">
                                <span><label>Dealership&nbsp;Phone</label></span>
                                <span><input name="Phone" id="Phone" type="text" value="<?= $Result->Phone ?>" required class="textbox" ></span>
                            </div>

                            <div class="col-sm-6">
                                <span><label>Dealership&nbsp;Email</label></span>
                                <span><input name="Email" id="Email" type="text" value="<?= $Result->Email ?>" required  class="textbox" ></span>
                            </div>
                            
                            <div class="col-sm-6">
                                <span><label>Dealership&nbsp;Fax</label></span>
                                <span><input name="Fax" id="Fax" type="text" value="<?= $Result->Fax ?>" class="textbox" ></span>
                            </div>

                            <div class="col-sm-6">
                                <span><label>Dealership&nbsp;Contact&nbsp;Person</label></span>
                                <span><input name="ContactName" id="ContactName" type="text" value="<?= $Result->ContactName ?>" required class="textbox" ></span>
                            </div>

                            <div class="col-sm-6">
                                <span><label>Dealership&nbsp;Licence&nbsp;No.</label></span>
                                <span><input name="LicenceNo" id="LicenceNo" type="text" value="<?= $Result->LicenceNo ?>" required class="textbox" ></span>
                            </div>

                            <div class="col-sm-12">
                                <span><label>Remarks</label></span>
                                <span>
                                    <textarea name="Remarks" id="Remarks" value="" ><?= $Result->Remarks ?></textarea>                                    
                                </span>
                            </div>

                        <div class="clearfix"></div>
                        </div> <!-- end of toggle div -->
                        <div class="col-sm-9">&nbsp;</div>
                            <div class="col-sm-3">
                                <input type="submit" class="btn btn-info" id="Finish" name="Finish" value="Update Dealership" />
                            </div>
                            <div class="clearfix"></div>
                    </div>
            </div>
            <div aria-labelledby="tab2-tab" id="tab2" class="tab-pane" role="tabpanel">
                <p>&nbsp;</p>
                <?php if($DealerPackageFeaturesResultSet)
                    {
                ?>
               <div id="login-form" class="login-form"> 
                    <h3>Leads History</h3>
                    <div class="full">
                        <div class="col-sm-2 textcolor">
                            <span><label>#</label></span>
                        </div>
                        <div class="col-sm-2 textcolor">
                            <span><label>Contact&nbsp;Firstname</label></span>
                        </div>
                        <div class="col-sm-2 textcolor">
                            <span><label>Contact&nbsp;Phone</label></span>
                        </div>
                        <div class="col-sm-2 textcolor">
                            <span><label>Contact&nbsp;Email</label></span>
                        </div>
                        <div class="col-sm-2 textcolor">
                            <span><label>Sent&nbsp;Date</label></span>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>

                
                <?php 
                    $count =1;
                    for($x = 0; $x < count($DealerPackageFeaturesResultSet) ; $x++)
                    {
                ?>
                        <div class="col-sm-2">
                            <span><label><?= $count ?></label></span>
                        </div>
                        <div class="col-sm-2">
                            <span><label><?= $DealerPackageFeaturesResultSet[$x]->ContactRelation->ContactInfoRelation->FirstName ?></label></span>
                        </div>
                        <div class="col-sm-2">
                            <span><label><?= ($DealerPackageFeaturesResultSet[$x]->ContactRelation->ContactInfoRelation->Phone1) ? $DealerPackageFeaturesResultSet[$x]->ContactRelation->ContactInfoRelation->Phone1 : " N/A " ?></label></span>
                        </div>
                        <div class="col-sm-2">
                            <span><label><?= $DealerPackageFeaturesResultSet[$x]->ContactRelation->ContactInfoRelation->Email ?></label></span>
                        </div>
                        <div class="col-sm-2">
                            <span><label><?= $DealerPackageFeaturesResultSet[$x]->Timestamp ?></label></span>
                        </div>
                        <div class="clearfix"></div>
                <?php
                    $count++;
                    }
                ?>

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
            <div aria-labelledby="tab3-tab" id="tab3" class="tab-pane" role="tabpanel">
                <p>&nbsp;</p>

                <div id="login-form" class="login-form"> 
                    <h3>Current Plan</h3>
                    <div class="full">
                        <div class="col-sm-3">
                            <span><label>Plan Name:</label></span>
                            <span><span><input name="" id="" type="text" value="<?=  $DealerPlan->Name ?>" disabled class="textbox"></span></span>
                        </div>
                        <div class="col-sm-3">
                            <span><label>Description:</label></span>
                            <span><span><input name="" id="" type="text" value="<?=  $DealerPlan->Description ?>" disabled class="textbox"></span></span>
                        </div>
                        <div class="col-sm-3">
                            <span><label>Applications:</label></span>
                            <span><span><input name="" id="" type="text" value="<?=  $DealerPlan->Apps ?>" disabled class="textbox"></span></span>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>

                <div id="login-form" class="login-form"> 
                    <h3>Plan History</h3>
                    <div class="full">
                        <div class="col-sm-3 textcolor">
                            <span><label>#</label></span>
                        </div>
                        <div class="col-sm-3 textcolor">
                            <span><label>Plan&nbsp;Start&nbsp;Date</label></span>
                        </div>
                        <div class="col-sm-3 textcolor">
                            <span><label>Plan&nbsp;End&nbsp;Date</label></span>
                        </div>
                        <div class="col-sm-3 textcolor">
                            <span><label>Package&nbsp;Name</label></span>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>

                <?php 
                    $count =1;
                    for($x = 0; $x < $dealerpackagesResultset->TotalResults ; $x++)
                    {
                ?>
                        <div class="col-sm-3">
                            <span><label><?= $count ?></label></span>
                        </div>
                        <div class="col-sm-3">
                            <span><label><?= $dealerpackagesResultset->Result[$x]['AddDate'] ?></label></span>
                        </div>
                        <div class="col-sm-3">
                            <span><label><?= $dealerpackagesResultset->Result[$x]['ExpireDate'] ?></label></span>
                        </div>
                        <div class="col-sm-3">
                            <span><label><?= Package::GetName($dealerpackagesResultset->Result[$x]['PlanId']) ?></label></span>
                        </div>
                        <div class="clearfix"></div>
                <?php
                    $count++;
                    }
                ?>    
            </div>
            <div aria-labelledby="tab4-tab" id="tab4" class="tab-pane" role="tabpanel">
                <p>&nbsp;</p>
                <div id="login-form" class="login-form"> 
                        <div class="full">
                            <?php 
                                    $AppsWithPackage = Package::GetApps($Result->DealershipPlan);
                                    $Positive = dealercredits::CountPositive($Result->Id,dealerpackages::GetIdByDealerId($Result->Id));
                                    $Negative = dealercredits::CountNegative($Result->Id,dealerpackages::GetIdByDealerId($Result->Id));

                                    $Total = $Positive - $Negative;

                                    $Manage = $AppsWithPackage + $Total;
                                ?>
                            <div class="col-sm-3">
                                <span><label>Applications with the package:</label></span>
                                <span><span><input name="" id="" type="text" value="<?=  $AppsWithPackage ?> "  disabled class="textbox" ></span></span>
                            </div>
                            <div class="col-sm-3">
                                <span><label>Applications debit/credit:</label></span>
                                <span><span><input name="" id="" type="text" value="<?= $Total ?>" disabled class="textbox" ></span></span>
                            </div>
                            <div class="col-sm-3">
                                <span><label>Applications you can manage:</label></span>
                                <span><span><input name="" id="" type="text" value="<?=  $Manage ?> " disabled class="textbox" ></span></span>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-sm-3">
                                <a href="" class="btn btn-success modalcredit" data-id="<?php echo $Result->Id; ?>" data-positive="1" data-toggle="modal" data-target="#exampleModal">Apply&nbsp;Credit</a>
                                <a href="" class="btn btn-danger modaldebit" data-id="<?php echo $Result->Id; ?>" data-positive="0"  data-toggle="modal" data-target="#exampleModal">Apply&nbsp;Debit</a>
                            </div>
                        </div>
                </div>
                            <div class="clearfix"></div>
            </div>
        </div>
                                
       
</form>
<div class="clearfix"></div>
<?php require_once("inc/footer.php"); ?>

<script>
$(document).on("click", ".modalcredit", function () {
    var id= $(this).data('id');
    var positive= $(this).data('positive');
    $("#exampleModal #DealerId").val( id );
    $("#exampleModal #IsQuantityPositive").val( positive );
});
</script>

<script>
$(document).on("click", ".modaldebit", function () {
    var id= $(this).data('id');
    var positive= $(this).data('positive');
    $("#exampleModal #DealerId").val( id );
    $("#exampleModal #IsQuantityPositive").val( positive );
});
</script>

<form method="post" autocomplete="off">
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="exampleModalLabel">How would you like to apply?</h4>
          </div>
          <div class="modal-body">
            
                <input type="hidden" id="DealerId" name="DealerId" value="">
                <input type="hidden" id="IsQuantityPositive" name="IsQuantityPositive" value="">
              <!-- <div class="form-group">
                <input id="applyType1" name="applyType" type="radio" value="Nokia" /> Upload your existing resume
                <input id="applyType2" name="applyType" type="radio" value="Sony" /> Fill our application form and apply
              </div> -->
                <div class="container-fluid">
                  <div class="row">
                    <label for="resume" class="control-label">Enter Numbers:</label>
                    <input type="text" class="form-control" id="Quantity" name="Quantity" placeholder="Please enter integers." autocomplete="off" required>
                  </div>
                  <div class="row">
                    <label for="resume" class="control-label">Remarks:</label>
                    <textarea class="form-control" name="Comment" id="Comment"></textarea>
                  </div>
                </div>
              
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="applyNow">Apply</button>
            <input type="hidden" name="Apply" value="Apply" />
          </div>
        </div>
      </div>
    </div>
</form>