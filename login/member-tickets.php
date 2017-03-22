<?php 
	require_once("../include/files.php");

	if(!isset($_SESSION['admin_id']))
  {
    header('Location:index.php?'.$Encrypt->encrypt("MessageType=Error&Message=You must sign in to view your account."));
    exit();
  } 
  
  $AdminId = $_SESSION['admin_id'];
$Support = new Support();
  if( isset($_POST['submitstatus']) && $_POST['submitstatus'] == 'submitstatus' )   
  {
    
    for($x=0; $x < count($_REQUEST['Id']) ; $x++)
    {
      $Id = '';
      $Id = $Decrypt->decrypt($_POST['Id'][$x]);
      $Support->loadSupport("Id = ".$Id);
      $Support->SupportStatus = $_POST['SupportStatus'][$x];
      $Support->UpdateSupport();
    }

    
    header("Location:member-tickets.php?".$Encrypt->encrypt("Message=Your choice has been successfully selected.&Success=true"));
          exit();
  }

  $act = isset($_REQUEST["act"])?trim($_REQUEST["act"]):"";
  if($act == "action")
  {
    
    $IdArray = implode($_REQUEST['selected'],",");
    if(Support::archiveSupport($IdArray))
    {
      header('Location:member-tickets.php?'.$Encrypt->encrypt("Success=True&Message=Success: You have modified support tickets!"));
      exit();
    }
    else
    {
      header('Location:member-tickets.php?'.$Encrypt->encrypt("Success=False&Message=Failure: Something went wrong!"));
      exit();
    }
  }

  
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
                      <h2> Support Tickets List <small>Manage all your support tickets here</small></h2>
                      <div class="pull-right">
                          
                          
                          <button type="button" data-toggle="tooltip" title="Delete" class="btn btn-danger" onclick="confirm('Are you sure?') ? $('#form-coupon').submit() : false;"><i class="fa fa-trash-o"></i></button>
                          
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                      <?php
                          $Result = Support::GetDealerSupportList();
                          
                          if($Result->TotalResults>0)
                          {               
                            
                        ?>
                      
                        <form name="form-coupon" method="post" action="support-tickets.php?act=action" id="form-coupon" enctype="multipart/form-data" >
                        <table id="datatable-buttons" class="table table-hover table-striped table-bordered">
                          <thead>
                            <tr>
                              <th><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td></th>
                              <th>Name</th>
                              <th>Phone Number</th>
                              <th>Dealership Name</th>
                              <th>Subject</th>
                              <th>Message</th>
                              <th>DateAdded</th>
                              <th>Support Status</th>
                              <th>Action</th>
                            </tr>
                          </thead>


                          <tbody>
                            <?php

                  $count = 1;
        
                  for($x = 0; $x < $Result->TotalResults ; $x++)
                  {
                    echo '<input type="text" style="display:none;" name="Id[]" value="'. $Encrypt->encrypt($Result->Result[$x]['Id'])  .'" />';
                    $Dealer = new dealership();
                    $Dealer->loadDealershipInfo($Result->Result[$x]['DealerId']);
                  ?>
                    
                    <tr class="">
                      <td><input type="checkbox" name="selected[]" value="<?php echo $Result->Result[$x]['Id']; ?>" /></td>
                      <td><?= $Dealer->ContactName; ?></td>
                      <td><?= $Dealer->Phone; ?></td>
                      <td><?= $Dealer->DealershipName; ?></td>
                      <td><?php echo $Result->Result[$x]['Subject']; ?></td>
                      
                      <td><?php echo $Result->Result[$x]['Message']; ?></td>
                      <td><?php echo FormatDate($Result->Result[$x]['DateAdded'],'Y-m-d h:i A'); ?></td>
                      <td>
                        <?php   if($Result->Result[$x]['SupportStatus'] == 2)
                              echo "Closed";
                            else
                              echo "Open";
                               ?>
                            
                      </td>
                      <td> <select name="SupportStatus[]" class="form-control" required>
                          <option value="1" <?php if($Result->Result[$x]['SupportStatus'] == 1) echo "selected=selected"; ?> >Open</option>
                          <option value="2" <?php if($Result->Result[$x]['SupportStatus'] == 2) echo "selected=selected"; ?> >Close</option>                        
                         </select>
                      </td>
                    </tr>       
                  <?php 
                  $count++;
                  }
                  ?>
                              
                          </tbody>
                        </table>
                        <table id="" class="table table-striped table-bordered">
                          <tr class="">
                  <td colspan="4" align="right">
                    <button type="submit" class="btn btn-success" name="submitstatus" value="submitstatus" >Change Status</button>
                  </td>
                </tr> 
                        </table>
                    </form>
                    <?php } 
                    else{
                        echo '<p class="text-muted font-13 m-b-30">You have no support tickets right now!</p>';
                      }?>
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
