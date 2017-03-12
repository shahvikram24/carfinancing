<?php 
	require_once("../include/files.php");

	if(!isset($_SESSION['affiliate_id']))
  {
      header('Location:login.php?'.$Encrypt->encrypt("MessageType=Error&Message=You must sign in to view your account."));
      exit();
  }
	
	  $affiliate = new Affiliate();
    $affiliate->loadAffiliate( $_SESSION['affiliate_id']);

    $affiliateTransaction = new AffiliateTransaction();
    $ResultTransaction = $affiliateTransaction->loadByAffiliate($_SESSION['affiliate_id']);
	
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

                      <?php if($ResultTransaction)
                          {
                      ?>
                      
                        <table id="datatable-buttons" class="table table-striped table-bordered">
                          <thead>
                            <tr>
                              <th>Sr#</th>
                              <th>Contact&nbsp;Name</th>
                              <th>Description</th>
                              <th>Referal&nbsp;Amount</th>
                              <th>Date&nbsp;Send</th>
                            </tr>
                          </thead>


                          <tbody>

                            <?php

                  $count = 1;
                  
                  for($x = 0; $x < $ResultTransaction->TotalResults ; $x++)
                  {
                  ?>
                    <tr class="">
                      
                      <td><?= $count ?></td>
                      <td><?= Contact::GetFullName($ResultTransaction->Result[$x]['contactinfoid']) ?></td>
                      <td><?= DealStatus::getStatusText($ResultTransaction->Result[$x]['description']) ?></td>
                      <td><?= $ResultTransaction->Result[$x]['amount'] ?></td>
                      <td><?= FormatDate($ResultTransaction->Result[$x]['dateadded'],'Y-m-d h:i A')?></td>
                    </tr>       
                  <?php 
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
