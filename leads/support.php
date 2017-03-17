<?php 
  require_once("../include/files.php");

  if(!isset($_SESSION['DealerId']))
  {
    header('Location:index.php?'.$Encrypt->encrypt("MessageType=Error&Message=You must sign in to view your account."));
    exit();
  } 
  
  $DealerId = $_SESSION['DealerId'];

    $dealership = new dealership();
    $dealership->loadDealershipInfo($DealerId);

    $login = new Login();
    $login->loadcustomerinfo($DealerId);

  if(isset($_REQUEST['request']) && $_REQUEST['request'] == 'request')
  {
    $name = $dealership->ContactName ;
    $email = $login->EmailId;
    $phone = $dealership->Phone ;
    $business = $dealership->DealershipName ;
    $subject = $_REQUEST['subject'];
    $body = $_REQUEST['message'];


   
    $support = new Support();
    $support->DealerId = $DealerId ;
    $support->Subject = $subject;
    $support->Message = $body;
    $support->SupportStatus = 1;
    $support->DateAdded = date('Y-m-d H:i:s');
    $support->Status = 1;
    $support->addSupport();

    
    
        $headers .= 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= "From: no-reply@carfinancing.help" .  "\r\n";

        $message .= '<html><body>';
        $message .= '<table style="border-color: #666;" cellpadding="10">';
        $message .= "<tr><td style='background: #eee;'><strong>Subject:</strong> </td><td>" . $subject . "</td></tr>";
        $message .= "<tr><td style='background: #eee;'><strong>Dealership Name:</strong> </td><td>" . $business . "</td></tr>";
        $message .= "<tr><td style='background: #eee;'><strong>Name:</strong> </td><td>" . $name . "</td></tr>";
        $message .= "<tr><td style='background: #eee;'><strong>Email:</strong> </td><td>" . $email . "</td></tr>";
        $message .= "<tr><td style='background: #eee;'><strong>Phone Number:</strong> </td><td>" . $phone . "</td></tr>";
        
        $message .= "<tr><td style='background: #eee;'><strong>Message:</strong> </td><td>" . $body . "</td></tr>";
        $message .= "</table>";
        $message .= "</body></html>";

        $mailObj = new Email(ADMINEMAIL, NULL, "Support Request From Dealer");

          $mailObj->TextOnly = false;
          $mailObj->Headers = $headers;

          $mailObj->Content = $message;  


    if($mailObj->Send()) {
 
        header("Location:dashboard.php?" . $Encrypt->encrypt('Message=We have received your support request. One of our team member will contact you shortly.&Success=true'));     
                          exit();
    } else {
        header("Location:dashboard.php?" . $Encrypt->encrypt('Message=Something went wrong while contacting support.&Success=false'));     
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
            <div class="row">
              <div class="col-md-6 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Request Support <small>submit your support request here.</small></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <form class="form-horizontal form-label-left input_mask" method="post" action="#">

                      <div class="col-md-12 form-group has-feedback">
                        <input type="text" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Subject goes here" name="subject" value="" required >
                        <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
                      </div>

                      <div class="col-md-12 form-group has-feedback">
                         <textarea class="resizable_textarea form-control" placeholder="Support request goes here" name="message"></textarea>
                      </div>

                      
                      
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                          <a href='dashboard.php' class="btn btn-primary">Cancel</a>
                          <button type="submit" class="btn btn-success" name="request" value="request">Request Support!</button>
                        </div>
                      </div>

                    </form>
                  </div>
                </div>

              </div>
              
            </div>  

          <div class="clearfix"></div>

              
            <!-- /top tiles -->
        </div>

    <!-- Footer Wrapper -->
    <?php require_once ("inc/footer.php"); ?>  

    <!-- Autosize -->
    <script>
      $(document).ready(function() {
        autosize($('.resizable_textarea'));
      });
    </script>
    <!-- /Autosize -->
</body>
</html>
