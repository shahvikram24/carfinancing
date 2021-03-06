<?php 
	require_once("../include/files.php");

	if(!isset($_SESSION['DealerId']))
  {
    header('Location:index.php?'.$Encrypt->encrypt("MessageType=Error&Message=You must sign in to view your account."));
    exit();
  } 


  if( isset($_POST['AssignAffiliate']) && $_POST['AssignAffiliate'] == 'AssignAffiliate' )   
{  
  //debugObj($_REQUEST); die();
  if($_REQUEST['AffiliateId'] !='')
  {
    if(AffiliateTransaction::UpdateConditionally(' affiliateid = '. $_REQUEST['AffiliateId'] , ' contactinfoid =  '. $_REQUEST['ContactId']))
    {
      header('Location:lead-tracking.php?' . $Encrypt->encrypt("Message=Affiliate has been assigned successfully to the lead.&Success=true"));
      exit();
    }
    else{
      header('Location:lead-tracking.php?' . $Encrypt->encrypt("Message=Affiliate has NOT been assigned successfully to the lead.&Success=false"));
      exit();
    }
  }
  else{
    header('Location:lead-tracking.php?' . $Encrypt->encrypt("Message=Select Affiliate first.&Success=false"));
      exit();
  }
    
}

	
	  $DealerId = $_SESSION['DealerId'];
  //$customer = new Customer();
  //$customer->loadcustomer( $_SESSION['affiliate_id']);

    $dealership = new dealership();
    $dealership->loadDealershipInfo($DealerId);

    $DealerPackageFeatures = new DealerPackageFeatures();
    $DealerPackageFeaturesResultSet = $DealerPackageFeatures->LoadFeaturesByDealerId($dealership->Id,dealerpackages::GetIdByDealerId($dealership->Id),true);
	 
    //echo "<br/><br/><br/><br/><br/>";
    //debugObj($DealerPackageFeaturesResultSet);

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
                      <h2>Transaction History <small>Lead Tracking History</small></h2>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                      <?php if($DealerPackageFeaturesResultSet)
                          {
                      ?>
                      
                        <table id="datatable-buttons" class="table table-striped table-bordered">
                          <thead>
                            <tr>
                              <th style="width: 1%">Sr#</th>
                              <th>Contact&nbsp;Name</th>
                              <th>Phone&nbsp;Number</th>
                              <th>Email</th>
                              <th>Referred&nbsp;By</th>
                              <th>Deal&nbsp;Status</th>
                              <th>Date&nbsp;Sent</th>
                              <th>&nbsp;</th>
                            </tr>
                          </thead>


                          <tbody>

                            <?php
                                  
                                  /* Deal Status of Contact */
                                  $affiliateTransaction = new AffiliateTransaction();
                                  $count =1;
                                  for($x = 0; $x < count($DealerPackageFeaturesResultSet) ; $x++)
                                  {
                                      $AffiliateCode = AffiliateTransaction::getAffiliateCode($DealerPackageFeaturesResultSet[$x]->ContactRelation->id);

                                      if($AffiliateCode)
                                        $ReferredPerson = Affiliate::GetFullName($AffiliateCode);
                                      else
                                        $ReferredPerson = '<a class="affiliatereffered btn btn-primary" href="" data-toggle="modal" data-id="'. $DealerPackageFeaturesResultSet[$x]->ContactRelation->id . '" data-target="#AssignAffiliate">Assign Affiliate</a>';
                                      
                                      $ResultTransaction = $affiliateTransaction->loadTransactionByContactInfo($DealerPackageFeaturesResultSet[$x]->ContactRelation->id);

                                      $link =  LEADASSIGNURL . 'profile.php?' . $Encrypt->encrypt('ContactId='.$DealerPackageFeaturesResultSet[$x]->ContactRelation->id);
                                ?>
                                  <tr class="">
                                    
                                    <td><?= $count ?></td>
                                    <td><?= FormatInitCap(FormatName($DealerPackageFeaturesResultSet[$x]->ContactRelation->first_name, $DealerPackageFeaturesResultSet[$x]->ContactRelation->last_name)) ?></td>
                                    <td><?= $DealerPackageFeaturesResultSet[$x]->ContactRelation->phone ?></td>
                                    <td><?= $DealerPackageFeaturesResultSet[$x]->ContactRelation->email ?></td>
                                    <td><?= $ReferredPerson ?></td>
                                    <td><?= DealStatus::getStatusText($ResultTransaction->description) ?></td>
                                    <td><?= FormatDate($DealerPackageFeaturesResultSet[$x]->Timestamp,'Y-m-d h:i A')?></td>
                                    <td>
                                      <a href="<?= $link ?>" class="btn btn-primary btn-xs"><i class="fa fa-folder"></i> View </a>
                                      
                                      <a href="#" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> Hide </a>
                                    </td>
                                  </tr>       
                                <?php 
                                  $count++;
                                }
                                ?>
                              
                          </tbody>
                        </table>
                    </form>
                    <?php } 
                    else{
                        echo '<p class="text-muted font-13 m-b-30">
                        No records found.
                      </p>';
                      }?>
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

    <!-- AssignAffiliate -->
<form method="post" autocomplete="off" action="#">
  <div class="modal fade" id="AssignAffiliate" tabindex="-1" role="dialog" aria-labelledby="AssignAffiliateLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="AssignAffiliateLabel">Please assign an affiliate to the lead.</h4>
        </div>
        <?php
          $Affiliate = new Affiliate();
          $AffiliateResultset = Affiliate::loadAllAffiliateInfo(' status = 1 and approved = 1 ');
          //debugObj($AffiliateResultset);
        ?>
        <div class="modal-body">          
              <div class="container-fluid">
              <div class="row">                
                
                <select id="AffiliateId" name="AffiliateId"  class="form-control" >
                <?php 
                    for($x = 0; $x < $AffiliateResultset->TotalResults ; $x++)
                    {
                          echo "<option value='". $AffiliateResultset->Result[$x]['affiliate_id'] ."'>".
                                    $AffiliateResultset->Result[$x]['firstname'] . " " . $AffiliateResultset->Result[$x]['lastname']
                              . "</option>";
                    }
                ?>
            </select>
              </div>
            </div>
        </div>

        <input type="hidden" id="ContactId" name="ContactId" value="">
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" id="applyNow">Assign&nbsp;Affiliate</button>
          <input type="hidden" name="AssignAffiliate" value="AssignAffiliate" />
        </div>
      </div>
    </div>
  </div>
</form>

<script>
$(document).on("click", ".affiliatereffered", function () {
    var contact= $(this).data('id');
    $("#AssignAffiliate #ContactId").val( contact );
});
</script>


</body>
</html>
