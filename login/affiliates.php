<?php 
	require_once("../include/files.php");

  $SQLWhere =' Approve=1 AND Status=1 ';

	if(!isset($_SESSION['admin_id']))
  {
    header('Location:index.php?'.$Encrypt->encrypt("MessageType=Error&Message=You must sign in to view your account."));
    exit();
  } 

   $affiliate = new Affiliate();
$ResultApproved = $affiliate->loadAllAffiliateInfo(' approved=1 AND status=1 ');

$ResultPending = $affiliate->loadAllAffiliateInfo(' approved=2 AND status=1 ');

$ResultRejected = $affiliate->loadAllAffiliateInfo(' approved=3 AND status=1 ');


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
                      <h2>Affiliate Management<small>List of all affiliates which are in the system</small></h2>
                      <div class="pull-right">
                          <a href="" data-toggle="modal" title="Add New" class="btn btn-primary"  data-toggle="modal" data-target="#newTitle"><i class="fa fa-plus"></i></a>
                          
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                    <form name="form-coupon" method="post" action="dealers-management.php?act=action" id="form-coupon" enctype="multipart/form-data" >
                        <table id="datatable-buttons" class="table table-striped table-bordered">
                          <thead>
                            <tr>
                                <th>#</th>
                                <th>Affiliate&nbsp;Full&nbsp;Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Date Signup</th>
                                <th>Status</th>
                            </tr>
                          </thead>


                          <tbody>

                            <?php
                              if($ResultPending || $ResultApproved || $ResultRejected)
                              {
                                  $count = 1;
                                  if($ResultPending->TotalResults>0)
                                  {
                                    for($x = 0; $x < $ResultPending->TotalResults ; $x++)
                                    { 
                                      $affiliate_id = $ResultPending->Result[$x]['affiliate_id'];
                            ?>
                                  <tr>
                        <?php $link =  ADMINAPPROOT . 'affiliateinfo.php?' . $Encrypt->encrypt('affiliate_id='.$affiliate_id); ?>
                        
                              <td><?php echo $count; ?></td>
                              <td>
                                <a href="<?= $link ?>">
                                  <?php echo $ResultPending->Result[$x]['firstname'] . " " . $ResultPending->Result[$x]['lastname'] ; ?>
                                </a>
                              </td>
                              <td><?php echo $ResultPending->Result[$x]['email']; ?></td>
                              <td><?php echo $ResultPending->Result[$x]['telephone']; ?></td>
                              <td><?php echo FormatDate($ResultPending->Result[$x]['date_added'],'M d, Y'); ?></td>
                              <td><i class="fa fa-exclamation-triangle" aria-hidden="true" title="Awaiting"></i></td>
                          </tr>
                  <?php
                    $count++;
                }
              }
              

              if($ResultApproved->TotalResults>0)
              {
                for($x = 0; $x < $ResultApproved->TotalResults ; $x++)
                { 
                  $affiliate_id = $ResultApproved->Result[$x]['affiliate_id'];
                ?>
                    <tr>
                        <?php $link =  ADMINAPPROOT . 'affiliateinfo.php?' . $Encrypt->encrypt('affiliate_id='.$affiliate_id); ?>
                        <?php $affcount = AffiliateTransaction::Count($affiliate_id); ?>
                              <td><?php echo $count; ?></td>
                              <td>
                                <a href="<?= $link ?>">
                                  <?php echo $ResultApproved->Result[$x]['firstname'] . " " . $ResultApproved->Result[$x]['lastname']. " (". $affcount . ")"; ?>
                                </a>
                              </td>
                              <td><?php echo $ResultApproved->Result[$x]['email']; ?></td>
                              <td><?php echo $ResultApproved->Result[$x]['telephone']; ?></td>
                              <td><?php echo FormatDate($ResultApproved->Result[$x]['date_added'],'M d, Y'); ?></td>
                              <td><i class="fa fa-check" aria-hidden="true" title="Approved"></i></td>
                          </tr>
                  <?php
                    $count++;
                }
              }
              
              if($ResultRejected->TotalResults>0)
              {
                for($x = 0; $x < $ResultRejected->TotalResults ; $x++)
                { 
                  $affiliate_id = $ResultRejected->Result[$x]['affiliate_id'];
                ?>
                    <tr>
                        <?php $link =  ADMINAPPROOT . 'affiliateinfo.php?' . $Encrypt->encrypt('affiliate_id='.$affiliate_id); ?>
                              <td><?php echo $count; ?></td>
                              <td>
                                <a href="<?= $link ?>">
                                  <?php echo $ResultRejected->Result[$x]['firstname'] . " " . $ResultRejected->Result[$x]['lastname']; ?>
                                </a>
                              </td>
                              <td><?php echo $ResultRejected->Result[$x]['email']; ?></td>
                              <td><?php echo $ResultRejected->Result[$x]['telephone']; ?></td>
                              <td><?php echo FormatDate($ResultRejected->Result[$x]['date_added'],'M d, Y'); ?></td>
                              <td><i class="fa fa-close" aria-hidden="true" title="Rejected"></i></td>
                          </tr>
                  <?php
                    $count++;
                }
              }
          }
          else
          {
            echo "<tr><td colspan='6'>&nbsp;</td></tr>";
            echo "<tr><td colspan='6' style='text-align:center;'>No Results found</td></tr>";
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
                <div class="row">
                  <div class="col-md-6">        
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
                  </div>
                  <div class="col-md-6">        
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

                          <div class="form-group">
                            <label>Allowed to assign leads?</label>
                            <p>
                              Yes
                              <input type="radio" class="flat" name="Featured" id="FeaturedY" value="1"  required /> 
                              No
                              <input type="radio" class="flat" name="Featured" id="FeaturedN" value="0" checked=""/>
                            </p>
                          </div>
                  </div>
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
