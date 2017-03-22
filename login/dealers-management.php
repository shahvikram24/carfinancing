<?php 
	require_once("../include/files.php");

  $SQLWhere =' Approve=1 AND Status=1 ';

	if(!isset($_SESSION['admin_id']))
  {
    header('Location:index.php?'.$Encrypt->encrypt("MessageType=Error&Message=You must sign in to view your account."));
    exit();
  } 

   if(isset($_POST['AddIt']) && $_POST['AddIt'] == 'AddIt')
  {
        if(Security::CheckLeadsExist($_POST['Email']))
        {
          header('Location:dealers-management.php?' . $Encrypt->encrypt("Message=Email is already registered in the system.&Success=false"));
          exit();
        }
        else{
              $dealership = new dealership();
              $dealership->DealershipName = FormatInitCap($_POST['DealershipName']); 
              $dealership->DealershipPlan = 5; 
              $dealership->Address = $_POST['Address']; 
              $dealership->Phone = $_POST['Phone']; 
              $dealership->Email = $_POST['Email']; 
              $dealership->Fax = $_POST['Fax']; 
              $dealership->ContactName = $_POST['ContactName']; 
              $dealership->LicenceNo = FormatInitCap($_POST['LicenceNo']); 
              $dealership->Remarks = $_POST['Remarks']; 
              $dealership->CreatedDate  = date('Y-m-d H:i:s');
              $dealership->Approve = 1; 
              $dealership->Status = 1; 
              $dealerId = $dealership->addDealershipInfo();

              $dealerpackages = new dealerpackages();
              $dealerpackages->AddDate = date('Y-m-d H:i:s');
              $dealerpackages->ExpireDate = FormatDate(date('Y-m-d H:i:s', strtotime("+30 days")));
              $dealerpackages->PlanId = 5;
              $dealerpackages->Term = 0;
              $dealerpackages->DealerId = $dealerId;
              $dealerpackages->Timestamp = date('Y-m-d H:i:s');
              $dealerpackages->Status = 1;
              $DealerPackageId = $dealerpackages->InsertDealerPackage();

              $login = new Login();
              $Salt = GenerateSALT();
              $Password = uniqid();

              $login->Featured = 0; 
              $login->DealerId = $dealerId;
              $login->EmailId = $_POST['Email'];
              $login->SALT = $Salt;
              $login->HASH = GenerateHASH($Salt, $Password);
              $login->Status = 1;
              $login->addCustomerInfo();

              $login->sendEmailDealer($dealerId,$Password);

          header('Location:dealers-management.php?' . $Encrypt->encrypt("Message=New user has been created successfully.&Success=true"));
          exit();
        }
  }


  $act = isset($_REQUEST["act"])?trim($_REQUEST["act"]):"";
  if($act == "action")
  {
    if(isset($_REQUEST['selected']) && $_REQUEST['selected']!='')
    {
      $IdArray = implode($_REQUEST['selected'],",");
    }
    else{
          header('Location:dealers-management.php?'.$Encrypt->encrypt("Success=false&Message=Failure: Select atleast one field to proceed!"));
          exit();
    }
    
    if(dealership::archiveDealers($IdArray))
    {
      header('Location:dealers-management.php?'.$Encrypt->encrypt("Success=true&Message=Success: You have successfullly revoked access!"));
      exit();
    }
    else
    {
      header('Location:dealers-management.php?'.$Encrypt->encrypt("Success=false&Message=Failure: Something went wrong!"));
      exit();
    }
  }

  $dealership = new dealership();
  $Result = $dealership->loadAllDealershipInfo($SQLWhere);


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
                      <h2>Dealers Management<small>List of all dealers which are in the system</small></h2>
                      <div class="pull-right">
                          <a href="" data-toggle="modal" title="Add New" class="btn btn-primary"  data-toggle="modal" data-target="#newTitle"><i class="fa fa-plus"></i></a>

                          
                          <button type="button" data-toggle="tooltip" title="Delete" class="btn btn-danger" onclick="confirm('Are you sure?') ? $('#form-coupon').submit() : false;"><i class="fa fa-trash-o"></i></button>
                          
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                    <form name="form-coupon" method="post" action="dealers-management.php?act=action" id="form-coupon" enctype="multipart/form-data" >
                        <table id="datatable-buttons" class="table table-striped table-bordered">
                          <thead>
                            <tr>
                              <th style="width: 1%"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></th>
                              <th>Sr#</th>
                              <th>Name</th>
                              <th>Plan</th>
                              <th>Today's&nbsp;Apps</th>
                              <th>Total&nbsp;Apps&nbsp;Delivered</th>
                              <th>Balance&nbsp;Remaining</th>
                              <th>Plan&nbsp;Start&nbsp;Date</th>
                              <th>Plan&nbsp;End&nbsp;Date</th>
                              <th>&nbsp;</th>
                            </tr>
                          </thead>


                          <tbody>

                            <?php

                              $count = 1;
                              if($Result->TotalResults>0)
                              {
                                for($x = 0; $x < $Result->TotalResults ; $x++)
                                { 
                                  $DealerId = $Result->Result[$x]['Id'];
                                  $DealerPackageId = dealerpackages::GetIdByDealerId($DealerId);
                                  $AppsWithPackage = Package::GetApps($Result->Result[$x]['DealershipPlan']);
                                                $Positive = dealercredits::CountPositive($DealerId,$DealerPackageId);
                                                $Negative = dealercredits::CountNegative($DealerId,$DealerPackageId);

                                                $Total = $Positive - $Negative;

                                                $Manage = $AppsWithPackage + $Total;

                                                $TodaysApp = DealerPackageFeatures::CountSentApplications($DealerId,$DealerPackageId,date("Y-m-d"));
                                                $Delivered = DealerPackageFeatures::CountSentApplications($DealerId,$DealerPackageId);

                                                $dealerpackages = new dealerpackages();
                                                $dealerpackages->LoadDealerPackageByDealerId($DealerId);
                                ?>
                                  <tr class="">
                                    
                                    <td><input type="checkbox" name="selected[]" value="<?php echo $Result->Result[$x]['Id']; ?>" /></td>
                                    <td><?php echo $count; ?></td>
                                    <td><?php echo $Result->Result[$x]['ContactName'] . "<br/> - " . $Result->Result[$x]['DealershipName']; ?></td>
                                    <td><?= Package::GetName($Result->Result[$x]['DealershipPlan']) ?></td>
                                    <td><?php echo $TodaysApp; ?></td>
                                    <td><?php echo $Delivered; ?></td>
                                    <td><?php echo ($Manage - $Delivered); ?></td>
                                    <td><?php echo $dealerpackages->AddDate; ?></td>
                                    <td><?php echo $dealerpackages->ExpireDate; ?></td>

                                    <td><?php 

                                      if($Assigned)
                                      {
                                        $link =  ADMINAPPROOT . 'profile.php?' . $Encrypt->encrypt('DealerId='.$DealerId.'&Apply=Apply&ContactId='.$ContactId);
                                        echo '
                                          <a class="btn btn-success" href="'.$link.'">Assign</a>
                                        ';
                                      }
                                      else{
                                          $link =  ADMINAPPROOT . 'dealer-profile.php?' . $Encrypt->encrypt('DealerId='.$DealerId);

                                          echo '<a href="'.$link.'" class="btn btn-primary btn-xs"><i class="fa fa-folder"></i> View </a>';
                                      }
                                    ?></td>
                                    
                                  </tr>       
                                <?php 
                                  $count++;
                                }
                              }
                              else
                              {
                                echo "<tr><td colspan='9'>&nbsp;</td></tr>";
                                echo "<tr><td colspan='9' style='text-align:center;'>No Results found</td></tr>";
                              }

                              ?>
                              
                          </tbody>
                        </table>
                    
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

    <form method="post" autocomplete="off" action="#">
    <div class="modal fade" id="newTitle" tabindex="-1" role="dialog" aria-labelledby="newTitleLabel">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="newTitleLabel">Add New Dealer Here</h4>
          </div>
          <div class="modal-body">          
                        
                          <div class="form-group">
                            <label>Contact Name*</label>
                            <input name="ContactName" id="ContactName" type="text" value="" required class="form-control">
                          </div>

                          <div class="form-group">
                            <label>Email Address*</label>
                            <input name="Email" id="Email" type="text" value="" required class="form-control" >
                          </div>

                          <div class="form-group">
                            <label>Fax Number</label>
                            <input name="Fax" id="Fax" type="text" value="" class="form-control" placeholder="Enter Fax Number" data-inputmask="'mask' : '1-999-999-9999'">
                          </div>

                          <div class="form-group">
                            <label>Dealership Name*</label>
                            <input name="DealershipName" id="DealershipName" type="text" value="" required class="form-control" placeholder="Enter Working Dealership Name">
                          </div>
                      
                          <div class="form-group">
                            <label>Dealership Address*</label>
                            <input name="Address" id="Address" type="text" value="" required class="form-control" placeholder="Enter Working Dealership Address">
                          </div>
                          <div class="form-group">
                            <label>Phone Number*</label>
                            <input name="Phone" id="Phone" type="text" value="" required class="form-control" placeholder="Phone number to contact" data-inputmask="'mask' : '(999) 999-9999'">
                          </div>

                          <div class="form-group">
                            <label>AMVIC Licence No.*</label>
                            <input name="LicenceNo" id="LicenceNo" type="text" value="" required class="form-control" placeholder="AMVIC Registeration Number" data-inputmask="'mask' : 'a999999'">
                          </div>


                           

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="applyNow" name="AddIt" value="AddIt">Add&nbsp;New&nbsp;Dealer</button>
          </div>
        </div>
      </div>
    </div>
   </form>

   <!-- input_mask -->
          <script>
            $(document).ready(function() {
              $(":input").inputmask();
            });
          </script>
          <!-- /input mask -->


</body>
</html>
