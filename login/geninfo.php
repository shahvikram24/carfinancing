<?php	

require_once("../include/files.php");

extract($_REQUEST); 

if(!isset($_SESSION['admin_id']))
  {
    header('Location:index.php?'.$Encrypt->encrypt("MessageType=Error&Message=You must sign in to view your account."));
    exit();
  } 

if(!isset($ContactId))
{
	header("Location: dashboard.php");
}


$Contact = new Contact();
$Contact->loadContact($ContactId);



$html .= "
        <strong>First Name</strong> : " . FormatInitCap($Contact->first_name) . "<br/><br/>
        <strong>Last Name</strong> : " . FormatInitCap($Contact->last_name) . "<br/><br/>
        <strong>Email Address</strong> : " . $Contact->email . "<br/><br/>
        <strong>Phone Number</strong> : " . $Contact->phone . "<br/><br/>
        <strong>Date of Birth</strong> : " . FormatDate($Contact->year_of_birth . "-".$Contact->month_of_birth . "-".$Contact->day_of_birth, 'Y-M-d') . "<br/><br/>
        <strong>SIN</strong> : " . $Contact->sin_number . "<br/><br/>
        <strong>Address</strong> : " . $Contact->address . "<br/><br/>
        <strong>City</strong> : " . $Contact->city . "<br/><br/>
        <strong>Province</strong> : " . FormatInitCap(Contact::GetProvince($Contact->province_id))  . "<br/><br/>
        <strong>Postal Code</strong> : " . $Contact->postal_code . "<br/><br/>
        <strong>Rent or Own?</strong> : " . FormatInitCap($Contact->rent_or_own) . "<br/><br/>
        <strong>Residence Duration</strong> : " . $Contact->residence_years . " years <br/><br/>
        <strong>Monthly Payment</strong> : $" . $Contact->monthly_payment . "<br/><br/>
        <strong>Company Name / Employer</strong> : " . FormatInitCap($Contact->company_name) . "<br/><br/>
        <strong>Job Title / Ocuupation</strong> : " . FormatInitCap($Contact->job_title) . "<br/><br/>
        <strong>Work Phone</strong> : " . $Contact->work_phone . "<br/><br/>
        <strong>Years - Months on Job</strong> : " . $Contact->years_on_job . " years - " . $Contact->months_on_job . " months<br/><br/>
        <strong>Monthly Income</strong> : $" . $Contact->monthly_income . "<br/><br/>
        <strong>Notes</strong> : " . $Contact->notes . "<br/><br/>
		";

	
        if(isset($DealerId))
        {
        	
            $dealeremail = dealership::GetDealerEmail($DealerId);
        	 $mailObj = new Email($dealeremail, "New Lead CarFinancing.Help  ", "Email - ". FormatInitCap(FormatName($Contact->first_name,$Contact->last_name)));
                $mailObj->TextOnly = false;
                $mailObj->Content = $html;
                

                try 
                {

                    
                     if($mailObj->Send())
                     {
                            echo "<br/><br/> ==== 1 <br/>";
                        header("Location:".ADMINAPPROOT . 'new-leads.php?' . $Encrypt->encrypt('Message=Dealer assigned successfully to the contact. Informaion has been sent to dealer.&Success=true'));    	
	    				exit();
                    }

                    else 
                    {
                        echo "<br/><br/> ==== 2 <br/>";
                    	header("Location:".ADMINAPPROOT . 'new-leads.php?' . $Encrypt->encrypt('Message=Something went wrong while sending email.&Success=false'));    	
    	 				exit();
                    }
                }
                catch (Exception $e) {
                    echo 'Caught exception: ',  $e->getMessage(), "\n";
                }
        }//echo "<br/> ======= success";
    