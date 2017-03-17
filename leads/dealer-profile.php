<?php 
	require_once("../include/files.php");

	if(!isset($_SESSION['DealerId']))
  {
    header('Location:index.php?'.$Encrypt->encrypt("MessageType=Error&Message=You must sign in to view your account."));
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
        header('Location: dealer-profile.php?' . $Encrypt->encrypt("Message=Credits applied successfully.&Success=true&DealerId=".$_POST['DealerId']));
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
                      <h2>Dealer Profile <small>Primary Dealer Profile</small></h2>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                      <div class="col-md-4 col-sm-4 col-xs-12 profile_left">
                          <h3><?= FormatInitCap($Result->ContactName) ?></h3>
                            <ul class="list-unstyled user_data">
                            <li><i class="fa fa-map-marker user-profile-icon"></i> 
                                    <?= $Result->DealershipName ?>                                    
                            </li>
                            <li><i class="fa fa-map-marker user-profile-icon"></i> 
                                    <?= $Result->Address ?>                                    
                            </li>

                            <li>
                              <i class="fa fa-briefcase user-profile-icon"></i>&nbsp;AMVIC #: <?= $Result->LicenceNo ?>
                            </li>

                            <li class="m-top-xs">
                              <i class="fa fa-external-link fa fa-phone"></i>&nbsp;Phone: 
                              <?php echo $Result->Phone ?>
                            </li>
                          </ul>
                      </div>

                      <div class="col-md-8 col-sm-8 col-xs-12">
                          <div class="" role="tabpanel" data-example-id="togglable-tabs">
                              <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Leads History</a>
                                </li>
                                <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Plan History</a>
                                </li>
                                <li role="presentation" class=""><a href="#tab_content3" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">Manage Credits</a>
                                </li>
                              </ul>

                              <div id="myTabContent" class="tab-content">
                                  <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
                                  <p>&nbsp;</p>
                                  <?php if($DealerPackageFeaturesResultSet)
                                      {
                                  ?>
                                    
                                            <table id="datatable-buttons" class="table table-striped table-bordered">
                                                <thead>
                                                  <tr>
                                                    <th style="width: 1%">Sr#</th>
                                                    <th>Contact&nbsp;Name</th>
                                                    <th>Contact&nbsp;Phone</th>
                                                    <th>Contact&nbsp;Email</th>
                                                    <th>Sent&nbsp;Date</th>
                                                  </tr>
                                                </thead>


                                                <tbody>
                                                    <?php 
                                                        $count =1;
                                                        for($x = 0; $x < count($DealerPackageFeaturesResultSet) ; $x++)
                                                        {
                                                    ?>
                                    
                                                    <tr class="">
                                                        <td><?php echo $count; ?></td>
                                                    
                                                        <td><?= FormatInitCap(FormatName($DealerPackageFeaturesResultSet[$x]->ContactRelation->first_name, $DealerPackageFeaturesResultSet[$x]->ContactRelation->last_name)) ?></td>
                                                        <td><?= ($DealerPackageFeaturesResultSet[$x]->ContactRelation->phone) ? $DealerPackageFeaturesResultSet[$x]->ContactRelation->phone : " N/A " ?></td>

                                                        <td><?= $DealerPackageFeaturesResultSet[$x]->ContactRelation->email ?></td>
                                                        <td><?= $DealerPackageFeaturesResultSet[$x]->Timestamp ?></td>
                                                   
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
                                        <h3>Current Plan</h3>
                                        <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
                                              <label>Plan Name</label>
                                              <input  type="text" value="<?=  $DealerPlan->Name ?>" readonly class="form-control">
                                            </div>

                                        <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
                                              <label>Description</label>
                                              <input  type="text" value="<?= $DealerPlan->Description ?>" readonly class="form-control">
                                            </div>

                                        <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
                                              <label>Applications</label>
                                              <input  type="text" value="<?=  $DealerPlan->Apps ?>" readonly class="form-control">
                                            </div>


                                        <h3>Plan History</h3>
                                        <table id="datatable-buttons" class="table table-striped table-bordered">
                                                <thead>
                                                  <tr>
                                                    <th style="width: 1%">Sr#</th>
                                                    <th>Plan&nbsp;Start&nbsp;Date</th>
                                                    <th>Plan&nbsp;End&nbsp;Date</th>
                                                    <th>Package&nbsp;Name</th>
                                                  </tr>
                                                </thead>


                                                <tbody>
                                                <?php 
                                                        $count =1;
                                                        for($x = 0; $x < $dealerpackagesResultset->TotalResults ; $x++)
                                                        {
                                                    ?>
                                    
                                                    <tr class="">
                                                        <td><?php echo $count; ?></td>
                                                    
                                                        <td><?= $dealerpackagesResultset->Result[$x]['AddDate'] ?></td>

                                                        <td><?= $dealerpackagesResultset->Result[$x]['ExpireDate'] ?></td>

                                                        <td><?echo Package::GetName($dealerpackagesResultset->Result[$x]['PlanId']) ." - " . Package::GetApps($dealerpackagesResultset->Result[$x]['PlanId']) . " credit apps."; ?></td>
                                                        
                                                   
                                                    </tr>
                                                <?php 
                                                  $count++;
                                                } 
                                                        ?>
                                                        </tbody>
                                              </table>

                                    </div>

                                    <div role="tabpanel" class="tab-pane fade in" id="tab_content3" aria-labelledby="home-tab">
                                      <h3>&nbsp; </h3>
                                      <?php 
                                          $AppsWithPackage = Package::GetApps($Result->DealershipPlan);
                                          $Positive = dealercredits::CountPositive($Result->Id,dealerpackages::GetIdByDealerId($Result->Id));
                                          $Negative = dealercredits::CountNegative($Result->Id,dealerpackages::GetIdByDealerId($Result->Id));

                                          $Total = $Positive - $Negative;

                                          $Manage = $AppsWithPackage + $Total;
                                      ?>

                                      <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
                                              <label>Credit Apps with the package</label>
                                              <input  type="text" value="<?=  $AppsWithPackage ?>" readonly class="form-control">
                                            </div>

                                        <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
                                              <label>Applications debit/credit</label>
                                              <input  type="text" value="<?= $Total ?>" readonly class="form-control">
                                            </div>

                                        <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
                                              <label>Applications you can manage</label>
                                              <input  type="text" value="<?=  $Manage ?>" readonly class="form-control">
                                            </div>

                                            <div class="clearfix"></div>
                                            <div class="col-sm-3">
                                                <a href="" class="btn btn-success btn-xs modalcredit" data-id="<?php echo $Result->Id; ?>" data-positive="1" data-toggle="modal" data-target="#exampleModal">Apply&nbsp;Credit</a>
                                                <a href="" class="btn btn-danger btn-xs modaldebit" data-id="<?php echo $Result->Id; ?>" data-positive="0"  data-toggle="modal" data-target="#exampleModal">Apply&nbsp;Debit</a>
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


</body>
</html>
