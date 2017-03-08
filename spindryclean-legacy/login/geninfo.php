<?php
	
require_once("../include/files.php");

	if(!isset($_SESSION['admin_id']))
	{
		header('Location:index.php?'.$Encrypt->encrypt("MessageType=Error&Message=You must sign in to view your account."));
		exit();
	}

extract($_REQUEST); 

if(!isset($OrderId))
{
	header("Location: dashboard.php");
}


//$Order = new Order();
//$Order->loadorder($OrderId);

$Order = new Order();
$OrderResult =  $Order->GetInfoById($OrderId);

$Invoice = new Invoice();
$Invoice->loadInvoice(' OrderId = '. $OrderId);

$html .= "
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>";

$style = "<head><style>".file_get_contents(APPROOT.'build/css/invoiceprint.css').  "</style></head>" ;

$html .= "<body>";

$html .= '
			<div class="">
	          
          <div class="clearfix"></div>

          <div class="row">
            <div class="col-md-12">
              <div class="x_panel">
                <div class="x_content">

                  <section class="content invoice">

                    <div class="row">
                      <div class="col-xs-12 table">
                        <table class="table table-striped" style="font-size:22px;">
                          <thead>
                            <tr>
                              <th style="width:35%;"><img src="http://www.spindryclean.com/images/logo.png" class="img-responsive" alt="SPIN"/></th>
                              <th style="width:35%;">&nbsp;</th>
                              <th style="width:30%;">Date: '. $Invoice->Timestamp.'</th>
                            </tr>
                          </thead>
                          <tbody>
                          <tr><td style="width:100%;padding:50px;">&nbsp;</td></tr>
                          <tr>
                              <th>
                                  From
                                  <br/><strong>SPIN</strong>
                                  <br/>15379 Castle Downs Road NW, 
                                  <br/>Suite 102
                                  <br/>Edmonton, AB, T5X 3Y7
                                  <br/>Phone: 587-782-5266
                                  <br/>Email: info@spindryclean.com
                              </th>
                          
                              <th>
                                    To
                                      <br/>
                                        <strong>'.$OrderResult->Result[0]['FirstName']. ' ' .  $OrderResult->Result[0]['LastName'] 
                                        .'</strong>
                                        <br/>'.$OrderResult->Result[0]['Address1']. 
                                        '<br/>' .  $OrderResult->Result[0]['Address2'] .'
                                        <br/>'.$OrderResult->Result[0]['City']. ' ' .  $OrderResult->Result[0]['Province'] 
                                        . ' ' .  $OrderResult->Result[0]['Postalcode'] .'
                                        <br/>' .  $OrderResult->Result[0]['Cellphone'] .'
                                        <br/>' .  $OrderResult->Result[0]['EmailId'] .'
                              </th>
                          
                            <th>
                              <b>Invoice # '. $Invoice->InvoiceNumber.'</b>
                              <br>
                              <br>
                              <b>Order ID:</b> ' .  $OrderResult->Result[0]['OrderId'] .'
                              <br>
                              <b>Payment Due:</b> '. $Invoice->DueDate.'
                            </th>
                          </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>  
                    <!-- Table row -->
                    <div class="row">
                      <div class="col-xs-12 table">
                        <table class="table table-striped">
                          <thead>
                            <tr>
                              <th style="width:10%;">Qty</th>
                              <th style="width:50%;">Product</th>
                              <th style="width:20%;">Price</th>
                              <th style="width:20%;">Subtotal</th>
                            </tr>
                          </thead>
                          <tbody>
';

                          $Subtotal = 0;
                          $InvoiceProducts = new InvoiceProducts();
                          $Result = $InvoiceProducts->GetProductsList($Invoice->Id);
                          if($Result->TotalResults>0)
                          {
                            for($x = 0; $x < $Result->TotalResults ; $x++)
                            {
                              $html .= '
                                        <tr>
                                          <td>'.($x+1).'</td>
                                          <td>'. $Result->Result[$x]['ProductName'].'</td>
                                          <td>'. $Result->Result[$x]['Price'].'</td>
                                          <td>'. $Result->Result[$x]['Totalprice'].'</td>
                                        </tr>';
                              $Subtotal += $Result->Result[$x]['Price'];
                            }
                          }

                            
$html .= '                           
                          </tbody>
                        </table>
                      </div>
                      <!-- /.col -->
                    </div>
                    <!-- /.row -->

                    <div class="row">
                     
                      <div class="col-lg-12">
                        <p class="lead pull-right" style="text-align:right;margin-right:50px;">Payment Due: '. $Invoice->DueDate.'</p>
                        <div class="table-responsive">
                          <table class="table table-striped">
                            <tbody>
                              <tr>
                                <td style="width:60%;">Notes: <br/>
                                  '. $Invoice->Notes.'
                                </td>
                                <td style="width:40%;">
                                    <table class="table table-striped" style="height:50px;vertical-align:center;">
                                      <tbody>
                                        <tr>
                                          <th>Subtotal:</th>
                                          <td>$'.$Subtotal.'</td>
                                        </tr>
                                        <tr>
                                          <th>GST (5%)</th>
                                          <td>$'. number_format(($Invoice->TotalPrice - $Subtotal),2).'</td>
                                        </tr>
                                        <tr>
                                          <th>Total:</th>
                                          <td>$'. $Invoice->TotalPrice.'</td>
                                        </tr>
                                      </tbody>
                                    </table>
                                  </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                      <!-- /.col -->

                      

                    </div>
                    <!-- /.row -->

                    
                  </section>
                </div>
              </div>
            </div>
          </div>
        </div>

';



 $fileError = false;

                    if (!is_dir('../tmp/')) {
                        if(!mkdir ('../tmp/'))
                            $fileError = true;
                    }


	
    $String = $html;
    
    $String = str_replace('"', "'", $String); 

    
    require_once("../lib/MPDF561/mpdf.php");
    $mpdf=new mPDF('c','Letter','','' , 0 , 0 , 0 , 0 , 0 , 0); 
    $mpdf->WriteHTML($style,1);
    $mpdf->WriteHTML($String,2);
    
    

	$TemporaryFileName = date('YmdHis').'.pdf';
        
    $pdfres =  $mpdf->Output($TemporaryFileName,'S');


	if (!$fp = fopen(WEBROOT.'tmp/'.$TemporaryFileName, 'w'))
	$fileError = true;	

	if (!fputs($fp, $pdfres))
	$fileError = true;

	
	fclose($fp);
	chmod(WEBROOT.'tmp/'.$TemporaryFileName, 0777);
    
		$tblfile = new Files();
        $tblfile->FileName = $TemporaryFileName;
        $tblfile->FileDescription = '';
        $tblfile->FileSize = filesize(UPLOAD_DIR.$TemporaryFileName);
        $tblfile->FileMIME = 'application/pdf';
        $tblfile->FileLocation = $TemporaryFileName;
        $tblfile->Status = 1;
        $tblfile->FileVersion = 1;
        $tblfile->DownloadCount = 0;
        $fileId = $tblfile->InsertFile();

        $fileRelations = new FileRelations();
		$fileRelations->FileId = $fileId;
		$fileRelations->OrderId = $OrderId;
		$fileRelations->Status = 1;
		$fileRelations->InsertRelation();

	if(!$fileError)
    {
		header('Location:collectedorders.php?'.$Encrypt->encrypt("Success=True&Message=Success: You have successfully created new invoice!"));
		exit();
    }
    else
	{
		header('Location:generate-invoice.php?'.$Encrypt->encrypt("Success=False&Message=Failure: Something went wrong while creating invoice.!&Id=".$Id));
		exit();
	}	