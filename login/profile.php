<?php 
    require_once("../include/files.php");

    if(!isset($_SESSION['admin_id']))
  {
    header('Location:index.php?'.$Encrypt->encrypt("MessageType=Error&Message=You must sign in to view your account."));
    exit();
  } 

    if(!isset($ContactId))
  {
    header("Location: dashboard.php");
  }

if(isset($Apply) && $Apply == 'Apply')
{
  

  //$DealerId = $Decrypt->decrypt($_POST['DealershipId']);
  $DealerPackageFeatures = new DealerPackageFeatures();
    $DealerPackageFeatures->DealerId = $DealerId;
    $DealerPackageFeatures->DealerPackageId = dealerpackages::GetIdByDealerId($DealerId);
    $DealerPackageFeatures->ContactId = $ContactId;
    $DealerPackageFeatures->Timestamp = date('Y-m-d H:i:s');
    $DealerPackageFeatures->Status = 1;

    $AffiliateCode = AffiliateTransaction::getAffiliateCode($ContactId);
    if($AffiliateCode)
      $ReferredPerson = $AffiliateCode;
    else
      $ReferredPerson = 0;

    $affiliateTransaction = new AffiliateTransaction();
    $affiliateTransaction->affiliateid = $ReferredPerson;
    $affiliateTransaction->contactinfoid = $ContactId;
    $affiliateTransaction->description = 1;
    $affiliateTransaction->amount = 0.00;
    $affiliateTransaction->dateadded = date("Y-m-d H:i:s");
    $affiliateTransaction->status = 1;

        

    $AppsWithPackage = Package::GetApps(dealerpackages::GetPlanId($DealerId));
    $Positive = dealercredits::CountPositive($DealerId,dealerpackages::GetIdByDealerId($DealerId));
    $Negative = dealercredits::CountNegative($DealerId,dealerpackages::GetIdByDealerId($DealerId));

    $Total = $Positive - $Negative;
    $Manage = $AppsWithPackage + $Total;

    $AssignApp = DealerPackageFeatures::CountSentApplications($DealerId,dealerpackages::GetIdByDealerId($DealerId));
    
   

    if($Manage > $AssignApp)
    {

      $DealerPackageFeatures->addDealerpackageFeatures();
      $affiliateTransaction->addTransaction();

      header("Location:".ADMINAPPROOT . 'geninfo.php?' . $Encrypt->encrypt('ContactId='.$ContactId."&DealerId=".$DealerId));

      exit();
    }
    else
    {
       header("Location:".ADMINAPPROOT . 'dealers-management.php?' . $Encrypt->encrypt('Message=Dealer reached his Application limit.&Success=true&ContactId='.$ContactId));      
       exit();
    }
    
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
  $NotesRelations->ContactId = $ContactId;
  $NotesRelations->Status = 1;
  $NotesRelations->InsertRelation();
  
  
  header("Location:profile.php?" . $Encrypt->encrypt('ContactId='.$ContactId));
}


if(isset($_POST['SubmitSearch']) && $_POST['SubmitSearch'] == 'Upload Files')
{
    
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
                        $tblfile->FileName = $_REQUEST["fileType"];
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
                        $fileRelations->ContactId = $ContactId;
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
          header("Location:".ADMINAPPROOT . 'profile.php?' . $Encrypt->encrypt('ContactId='.$ContactId."&Message=".$Message));
          exit;
        }
        

      }//end of for each

          
              header("Location:".ADMINAPPROOT . 'profile.php?' . $Encrypt->encrypt('ContactId='.$ContactId."&Message=".$Message."&Success=true"));
    }
}



    $Contact = new Contact();
    $Contact->loadContact($ContactId);

    //debugObj($Contact);

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
                      <h2>User Profile <small>Primary Lead Profile</small></h2>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                      <div class="col-md-4 col-sm-4 col-xs-12 profile_left">
                          <h3><?= FormatInitCap(FormatName($Contact->first_name,$Contact->last_name)) ?></h3>
                            <ul class="list-unstyled user_data">
                            <li><i class="fa fa-map-marker user-profile-icon"></i> 
                                    <?= 
                                      $Contact->address . " , " .  
                                      $Contact->city . " , " .  
                                      FormatInitCap(Contact::GetProvince($Contact->province_id)) . " , " .  
                                      $Contact->postal_code 
                                    ?>
                                    
                            </li>

                            <li>
                              <i class="fa fa-briefcase user-profile-icon"></i>&nbsp;DOB: <?= FormatDate($Contact->year_of_birth . "-".$Contact->month_of_birth . "-".$Contact->day_of_birth, 'Y-M-d') ?>
                            </li>

                            <li class="m-top-xs">
                              <i class="fa fa-external-link fa fa-phone"></i>&nbsp;Phone: 
                              <?php echo $Contact->phone ?>
                            </li>
                          </ul>
                      </div>

                      <div class="col-md-8 col-sm-8 col-xs-12">
                          <div class="" role="tabpanel" data-example-id="togglable-tabs">
                              <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Notes</a>
                                </li>
                                <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">View Files</a>
                                </li>
                                <li role="presentation" class=""><a href="#tab_content3" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">Profile</a>
                                </li>
                              </ul>

                              <div id="myTabContent" class="tab-content">
                                  <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
                                  <p>&nbsp;</p>
                                    <form method="post" action="#">
                                    <input type="hidden" name="ContactId" value="<?= $Encrypt->encrypt($ContactId) ?>">
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
                                            $NotesResultset = Notes::LoadNotesInfo('ContactId',$ContactId);

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

                                            <?= ($Contact->Notes) ? $Contact->Notes : '' ?>
                                    </div> 


                                    <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">
                                        <h3>Files Section</h3>
                                        <?php

                                              $count = 1;
                                              $FilesResultset = Files::LoadFileInfo($ContactId);
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

                                                  <form name="myform" enctype="multipart/form-data" action="#" method="post">
                                                    <div class="col-sm-5">
                                                        <span><label>Upload Files</label>:&nbsp;</span>
                                                        <span><input type="file" name="myfile[]" multiple="multiple"  class="form-control" ></span>
                                                        <input type ="hidden" name="imageupdate" value="on">
                                                        <input type="hidden" name="mode" value="addimage">
                                                        <input type="hidden" name="ContactId" value="<?= $Encrypt->encrypt($ContactId) ?>">

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

                                    <div role="tabpanel" class="tab-pane fade in" id="tab_content3" aria-labelledby="home-tab">
                                      <h3>Personal Contact Information </h3>

                                          <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                              <label>Contact First Name</label>
                                              <input  type="text" value="<?= FormatInitCap($Contact->first_name) ?>" readonly class="form-control">
                                            </div>

                                          <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                              <label>Contact Last Name</label>
                                              <input  type="text" value="<?= FormatInitCap($Contact->last_name) ?>" readonly class="form-control">
                                            </div>

                                          <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                              <label>Email Address</label>
                                              <input  type="text" value="<?= $Contact->email ?>" readonly class="form-control">
                                            </div>

                                          <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                              <label>Phone Number</label>
                                              <input  type="text" value="<?=  $Contact->phone ?>" readonly class="form-control">
                                            </div>

                                          <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                              <label>Date of Birth</label>
                                              <input  type="text" value="<?= FormatDate($Contact->year_of_birth . "-".$Contact->month_of_birth . "-".$Contact->day_of_birth, 'Y-M-d') ?>" readonly class="form-control">
                                            </div>

                                            <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                              <label>SIN</label>
                                              <input  type="text" value="<?=  $Contact->sin_number ? $Contact->sin_number : 'N/A' ?>" readonly class="form-control">
                                            </div>

                                          <div class="clearfix"></div>
                                          <h3>Address Information</h3>
                                          <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                              <label>Address</label>
                                              <input  type="text" value="<?=  $Contact->address ?>" readonly class="form-control">
                                            </div>

                                            <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                              <label>City</label>
                                              <input  type="text" value="<?=  $Contact->city ?>" readonly class="form-control">
                                            </div>

                                            <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                              <label>Province</label>
                                              <input  type="text" value="<?=  FormatInitCap(Contact::GetProvince($Contact->province_id)) ?>" readonly class="form-control">
                                            </div>

                                            <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                              <label>Postal Code</label>
                                              <input  type="text" value="<?=  $Contact->postal_code ?>" readonly class="form-control">
                                            </div>

                                          <div class="clearfix"></div>
                                          <h3>Home/Mortgage Information</h3>
                                          <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                              <label>Rent or Own</label>
                                              <input  type="text" value="<?=  FormatInitCap($Contact->rent_or_own) ?>" readonly class="form-control">
                                            </div>

                                            <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                              <label>Residence Duration</label>
                                              <input  type="text" value="<?php  echo $Contact->residence_years . ' years' ; ?>" readonly class="form-control">
                                            </div>

                                            <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                              <label>Monthly Payment</label>
                                              <input  type="text" value="$<?= $Contact->monthly_payment ?>" readonly class="form-control">
                                            </div>


                                            <div class="clearfix"></div>
                                          <h3>Employment Information</h3>
                                          <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                              <label>Company Name / Employer</label>
                                              <input  type="text" value="<?=  FormatInitCap($Contact->company_name) ?>" readonly class="form-control">
                                            </div>

                                            <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                              <label>Job Title / Ocuupation</label>
                                              <input  type="text" value="<?=  FormatInitCap($Contact->job_title) ?>" readonly class="form-control">
                                            </div>

                                            <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                              <label>Work Phone</label>
                                              <input  type="text" value="<?=  $Contact->work_phone ?>" readonly class="form-control">
                                            </div>

                                            <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                              <label>Years - Months on Job</label>
                                              <input  type="text" value="<?php echo $Contact->years_on_job . ' years - ' . $Contact->months_on_job . ' months'; ?>" readonly class="form-control">
                                            </div>

                                            <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                              <label>Monthly Income</label>
                                              <input  type="text" value="$<?=  $Contact->monthly_income ?>" readonly class="form-control">
                                            </div>

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