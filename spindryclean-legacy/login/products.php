<?php 
	require_once("../include/files.php");

	if(!isset($_SESSION['admin_id']))
	{
		header('Location:index.php?'.$Encrypt->encrypt("MessageType=Error&Message=You must sign in to view your account."));
		exit();
	}	

	if(isset($_POST['AddTitle']) && $_POST['AddTitle'] == 'AddIt')
	{
		
		$products = new Products();
		$products->ProductName = ucfirst($_POST['PName']);
		$products->Price = str_replace("$", "",$_POST['PPrice']);
		$products->Status = 1;
		if($products->addProducts())
		{
			header('Location:products.php?' . $Encrypt->encrypt("Message=Product added successfully.&Success=true"));
			exit();
		}
	}

	if(isset($_POST['edit']) && $_POST['edit'] == 'edit')
  	{
  		
  		$products = new Products();
  		$products->loadProducts('Id = '. $_REQUEST['productId']);
		$products->ProductName = ucfirst($_POST['PAName']);
		$products->Price = str_replace("$", "",$_POST['PAPrice']);
		$products->Status = 1;
		if($products->updateProducts())
		{
			header('Location:products.php?' . $Encrypt->encrypt("Message=Product updated successfully.&Success=true"));
			exit();
		}
  	}


	$act = isset($_REQUEST["act"])?trim($_REQUEST["act"]):"";
	if($act == "action")
	{
		
		$IdArray = implode($_REQUEST['selected'],",");
		if(Products::archiveProducts($IdArray))
		{
			header('Location:products.php?'.$Encrypt->encrypt("Success=True&Message=Success: You have modified products!"));
			exit();
		}
		else
		{
			header('Location:products.php?'.$Encrypt->encrypt("Success=False&Message=Failure: Something went wrong!"));
			exit();
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<?php require_once ("../include/title.php"); ?>  
<body class="nav-md">
    <div class="container body">
      <div class="main_container">

			<!-- Header Wrapper -->
			<?php require_once ("include/header.php"); ?>  
			
			<!-- page content -->
			<div class="right_col" role="main">               
		         <div class="col-md-12 col-sm-12 col-xs-12">
	                <div class="x_panel">
		                  <div class="x_title">
		                  	<?php 
						        if(isset($Message) && $Message !='')
						        {
						        	if($Success && $Success == 'true')
						        	{
								?> 
									<div class="alert alert-success alert-dismissible fade in" role="alert">
					                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
					                    </button>
					                    <strong><?= $Message ?></strong>
					                  </div>

		                  <?
								}  	else {
						   ?>
										<div class="alert alert-success alert-dismissible fade in" role="alert">
					                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
					                    </button>
					                    <strong><?= $Message ?></strong>
					                  </div>
							<?php
						        }
						      }
						    ?>
							<div class="clearfix"></div>	
		                    <h2> Products List <small>Manage all your products here</small></h2>
		                    <div class="pull-right">
		                      <a href="" data-toggle="modal" title="Add New" class="btn btn-primary"  data-toggle="modal" data-target="#newTitle"><i class="fa fa-plus"></i></a>

		                      
		                      <button type="button" data-toggle="tooltip" title="Delete" class="btn btn-danger" onclick="confirm('Are you sure?') ? $('#form-coupon').submit() : false;"><i class="fa fa-trash-o"></i></button>
		                      
		                    </div>
		                    <div class="clearfix"></div>
		                  </div>
	                  <div class="x_content">
	                    <p class="text-muted font-13 m-b-30">
	                       it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.
	                    </p>
	                    <?php
							$Result = Products::GetProductsList();
							if($Result->TotalResults>0)
							{
						?>
						<form name="form-coupon" method="post" action="products.php?act=action" id="form-coupon" enctype="multipart/form-data" >
		                    <table id="datatable-buttons" class="table table-hover table-striped table-bordered">
		                      <thead>
		                        <tr>
		                          <th><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td></th>
		                          <th>Name</th>
		                          <th>Price</th>
		                          <th>Action</th>
		                        </tr>
		                      </thead>


		                      <tbody>

		                        <?php

									$count = 1;
				
									for($x = 0; $x < $Result->TotalResults ; $x++)
									{
									?>

										<tr class="">
											<td><input type="checkbox" name="selected[]" value="<?php echo $Result->Result[$x]['Id']; ?>" /></td>
											<td><?php echo $Result->Result[$x]['ProductName']; ?></td>
											<td><?php echo "$ ". $Result->Result[$x]['Price']; ?></td>
											<td><a href="" id="modaledit" data-toggle="modal" data-id="<?= $Result->Result[$x]['Id'] ?>" data-pname="<?= $Result->Result[$x]['ProductName'] ?>" data-pprice="<?= $Result->Result[$x]['Price'] ?>" data-target="#exampleModal" title="Edit" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td>

											
                                <p>
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
		                		echo '<p class="text-muted font-13 m-b-30">You have no products right now!</p>';
		                	}?>
	                  </div>
	                </div>
	            </div>

			    <div class="clearfix"></div>

		    
          <!-- /top tiles -->
	    	</div>

		<!-- Footer Wrapper -->
		<?php require_once ("include/footer.php"); ?>  

			<!-- Datatables -->
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

		function toggleDelete(check)
		{
			check = parseInt(check) - parseInt("1");
			//alert(check);

			chkvaluer=document.DeleteFrm.elements['approve[]'];
			chkvaluedel=document.DeleteFrm.elements['delreason[]'];

					if(chkvaluer[check].disabled)
					{
						chkvaluer[check].disabled = false;
						chkvaluedel[check].disabled = true;
					}	
					else
					{
						chkvaluer[check].disabled = true;
						chkvaluedel[check].disabled = false;

					}	
		}



    </script>
    <!-- /Datatables -->

    <script>
	        $(document).on("click", "#modaledit", function () {
	            $("#exampleModal #productId").val( $(this).data('id') );
	            $("#exampleModal #PAName").val( $(this).data('pname') );
	            $("#exampleModal #PAPrice").val( $(this).data('pprice') );
	        });
        </script>

    <form method="post" autocomplete="off" action="#">
		<div class="modal fade" id="newTitle" tabindex="-1" role="dialog" aria-labelledby="newTitleLabel">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="newTitleLabel">Add Product Here</h4>
		      </div>
		      <div class="modal-body">	        
		          	<div class="form-group">
			          	<label for="resume" class="control-label">Product Name:</label>
			            <input type="text" class="form-control" id="PName" name="PName" placeholder="Enter Product Name Here" autocomplete="off" required>
			          </div>

			          <div class="form-group">
			          	<label for="resume" class="control-label">Product Price:</label>
			            <input type="text" class="form-control" id="PPrice" name="PPrice" placeholder="Enter Product Price Here" autocomplete="off" required>
			          </div>	          

		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		        <button type="submit" class="btn btn-primary" id="applyNow" name="AddTitle" value="AddIt">Add&nbsp;Product</button>
		      </div>
		    </div>
		  </div>
		</div>
	 </form>

		


<form method="post" autocomplete="off" action="#">
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Edit Product Here</h4>
              </div>
              <div class="modal-body">
                
                  <input type="hidden" id="productId" name="productId">                  
                    
                   <div class="form-group">
                    <input type="text" name="PAName" class="form-control required" id="PAName" placeholder="Product Name*" required="">
                  </div>

                  <div class="form-group">
                    <input type="text" name="PAPrice" class="form-control required" id="PAPrice" placeholder="Product Price*" required="">
                  </div>

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="edit" name="edit" value="edit">Edit Product</button>
              </div>
            </div>
          </div>
        </div>
      </form>
</body>
</html>
