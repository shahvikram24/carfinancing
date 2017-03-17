<?php 
	require_once("../include/files.php");

	if(!isset($_SESSION['DealerId']))
  {
    header('Location:index.php?'.$Encrypt->encrypt("MessageType=Error&Message=You must sign in to view your account."));
    exit();
  } 

	
	  $DealerId = $_SESSION['DealerId'];
  //$customer = new Customer();
  //$customer->loadcustomer( $_SESSION['affiliate_id']);

    $dealership = new dealership();
    $dealership->loadDealershipInfo($DealerId);

    $Contact = new Contact();
    $Result = $Contact->loadSearchInfo();

    //debugObj($Result); die();

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
                      <h2>New Leads History <small>New Leads which are not assigned yet</small></h2>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                      <?php if($Result->TotalResults>0)
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
                              <th>Assigned&nbsp;Dealer</th>
                              <th>Date&nbsp;Created</th>
                              <th>&nbsp;</th>
                            </tr>
                          </thead>


                          <tbody>

                            <?php
                                  
                                  /* Deal Status of Contact */
                                  $affiliateTransaction = new AffiliateTransaction();
                                  $count =1;
                                  for($x = 0; $x < $Result->TotalResults ; $x++)
                                  {
                                      $AffiliateCode = AffiliateTransaction::getAffiliateCode($Result->Result[$x]['id']);

                                      if($AffiliateCode)
                                        $ReferredPerson = Affiliate::GetFullName($AffiliateCode);
                                      else
                                        $ReferredPerson = 'N/A';
                                      
                                      $ResultTransaction = $affiliateTransaction->loadTransactionByContactInfo($Result->Result[$x]['id']);

                                      $link =  LEADASSIGNURL . 'profile.php?' . $Encrypt->encrypt('ContactId='.$Result->Result[$x]['id']);

                                      $AssignedText = '<a class="btn btn-info btn-xs" href="dealers-management.php?' . $Encrypt->encrypt('ContactId='.$Result->Result[$x]['id'].'&Assigned=true') . '">Assign and Email to Dealer </a>';


                                ?>
                                  <tr class="">
                                    
                                    <td><?= $count ?></td>
                                    <td><?= FormatInitCap(FormatName($Result->Result[$x]['first_name'], $Result->Result[$x]['last_name'])) ?></td>
                                    <td><?= $Result->Result[$x]['phone'] ?></td>
                                    <td><?= $Result->Result[$x]['email'] ?></td>
                                    <td><?= $ReferredPerson ?></td>
                                    <td><?= $AssignedText ?></td>
                                    <td><?= FormatDate($Result->Result[$x]['created'],'Y-m-d h:i A')?></td>
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

    

</body>
</html>
