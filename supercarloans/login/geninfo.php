<?php	

require_once("../include/files.php");

extract($_REQUEST); 

if(!isset($_SESSION['admin_id']))
{
	header("Location: index.php");
}


if(!isset($ContactId))
{
	header("Location: dashboard.php");
}


$Contact = new Contact();
$Contact->loadContact($ContactId);

//debugObj($Contact->ContactInfoRelation);

$CoApplicant = new CoApplicant();
$CoApplicant->loadCoApplicantByRelationContactId($ContactId) ;



$html .= "
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>";

$style = "<head><style>".file_get_contents(APPROOT.'css/pdftable.css')."</style></head>" ;

$html .= "<body>";

$html .= "
                    
                    	<table class='flat-table'>
                    	
                    	<tr>
                    		<th colspan='4'>Primary Applicant Information</th>
                		</tr>
                    	<tbody>
                    	<tr>
	                        <td  >Full Name:&nbsp;</td>
	                        <td >" . $Contact->ContactInfoRelation->FirstName . " " .  $Contact->ContactInfoRelation->LastName. "</td>
	                        
                            <td  >Credit Score:&nbsp;</td>
                        	<td >" . $Contact->ContactInfoRelation->CreditScore . "</td>
                        </tr>
                        
                        
                        <tr class=''>
                        	<td  >Social Insurance Number:&nbsp;</td>
                        	<td >" . (($Contact->ContactInfoRelation->SIN) ? $Contact->ContactInfoRelation->SIN : 'N/A') . "</td>
                       		
                       		<td  >Date of Birth:&nbsp;</td>
                       		<td >" . (($Contact->ContactInfoRelation->DOB) ? $Contact->ContactInfoRelation->DOB : 'N/A') . "</td>
                        </tr>

                        
                        <tr>
                        	<td  >Date of Birth:&nbsp;</td>
                        	<td >" . (($Contact->ContactInfoRelation->DOB) ? $Contact->ContactInfoRelation->DOB : 'N/A') . "</td>
                       		
                       		<td  >Marital Status:&nbsp;</td>
                       		<td >" . (($Contact->ContactInfoRelation->MaritalStatus) ? $Contact->ContactInfoRelation->MaritalStatus : 'N/A') . "</td>
                        </tr>

                        
                        <tr>
                        	<td  >Gender:&nbsp;</td>
                        	<td >" . (($Contact->ContactInfoRelation->Gender) ? $Contact->ContactInfoRelation->Gender : 'N/A') . "</td>
                       		
                       		<td  >Length of Residence:&nbsp;</td>
                       		<td >" . (($Contact->ContactInfoRelation->ResidenceYears) ? $Contact->ContactInfoRelation->ResidenceYears . ' Year(s) ' : 'N/A') . "
                                " . (($Contact->ContactInfoRelation->ResidenceMonths) ? $Contact->ContactInfoRelation->ResidenceMonths . ' Months ' : ' 0 Months') . "</td>
                        </tr>

                        
                        <tr>
                        	
	                        <td  >Address:&nbsp;</td>
	                        <td>" 
	                        			. $Contact->ContactInfoRelation->Address1 . " " 
	                            		. $Contact->ContactInfoRelation->City . " "	
	                            		. $Contact->ContactInfoRelation->Province . "<br/> " 
	                            		. $Contact->ContactInfoRelation->Postal 
	                            	. "
                            </td>
                            <td>Phone &amp;&nbsp;Email&nbsp;</td>
                            <td>"	. $Contact->ContactInfoRelation->Phone1 . " " 
	                            	. $Contact->ContactInfoRelation->Email 
	                        . "</td>

                        </tr>

                       </tbody>

                     </table>   
	                        
	               		

                    <div class='clearfix'></div>
";


if($Contact->MortgageRelation)
{
	$html .= "

				<table class='flat-table'>
                    	
                    	<tr>
                    		<th colspan='4'>Mortgage Information</th>
                		</tr>
                    	<tbody>
                    	<tr>
	                        <td  >Mortgage Type:&nbsp;</td>
	                        <td >" . (($Contact->MortgageRelation->MortgageType) ? $Contact->MortgageRelation->MortgageType : 'N/A'). "</td>
	                        
	                        <td  >Mortgage Payment:&nbsp;</td>
	                        <td >" 
	                        			. (($Contact->MortgageRelation->MortgagePayment) ? '$ '.$Contact->MortgageRelation->MortgagePayment : 'N/A')
	                            	. "
                            </td>
                        </tr>
                        
                        

                        <tr>
	                        <td  >Mortgage Amount:&nbsp;</td>
	                        <td >" . (($Contact->MortgageRelation->MortgageAmount) ? '$ ' .$Contact->MortgageRelation->MortgageAmount : 'N/A'). "</td>
	                        
	                        <td  >Mortgage Holder:&nbsp;</td>
	                        <td >" 
	                        			. (($Contact->MortgageRelation->MortgageHolder) ? $Contact->MortgageRelation->MortgageHolder : 'N/A' )
	                            	. "
                            </td>
                        </tr>
                        
                        


                        <tr>
	                        <td  >Market Value:&nbsp;</td>
	                        <td >" . (($Contact->MortgageRelation->MarketValue) ? FormatMoney($Contact->MortgageRelation->MarketValue,' $ ') : 'N/A'). "</td>
	                        
	                        
                        </tr>
                        
                        </tbody>

                     </table>   
	                        
	               		

                    <div class='clearfix'></div>

	";
}


if($Contact->EmploymentRelation)         
{
	$html .= "

				<table class='flat-table'>
                    	
                    	<tr>
                    		<th colspan='4'>Employment Information</th>
                		</tr>
                    	<tbody>
                    	<tr>
	                        <td  >Organization Name:&nbsp;</td>
	                        <td >" .(($Contact->EmploymentRelation->OrganizationName) ? $Contact->EmploymentRelation->OrganizationName : 'N/A'). "</td>
	                        
	                        <td  >Employment Status:&nbsp;</td>
	                        <td >" 
	                        			. (($Contact->EmploymentRelation->EmpStatusId) ? EmpStatus::getStatusText($Contact->EmploymentRelation->EmpStatusId) : 'N/A') 
	                            	. "
                            </td>
                        </tr>
                        
                        

                        <tr>
	                        <td  >Employment Type:&nbsp;</td>
	                        <td >" . (($Contact->EmploymentRelation->EmpTypeId) ? EmpType::getType($Contact->EmploymentRelation->EmpTypeId) : 'N/A' ). "</td>
	                        
	                        <td  >Job Title:&nbsp;</td>
	                        <td >" 
	                        			. (($Contact->EmploymentRelation->JobTitle) ? $Contact->EmploymentRelation->JobTitle : 'N/A')
	                            	. "
                            </td>
                        </tr>
                        
                       


                        <tr>
	                        
	                        <td  >Work Place Address:&nbsp;</td>
	                        <td colspan='3'>" 
	                        		. 	$Contact->EmploymentRelation->Address1 . " " 
                                    .   $Contact->EmploymentRelation->City . " "  
                                    .	$Contact->EmploymentRelation->Province . " " 
                                    .   $Contact->EmploymentRelation->Postal . " " 
                                    .   $Contact->EmploymentRelation->Phone1 . " " 
                                    .   $Contact->EmploymentRelation->Email 
	                            	. "
                            </td>
                        </tr>
                        

                        <tr>
	                        <td  >Length of Employment:&nbsp;</td>
	                        <td >" . (($Contact->EmploymentRelation->EmpYears) ? $Contact->EmploymentRelation->EmpYears . 'Year(s) ' : ' 0 Years') . "
                                " . (($Contact->EmploymentRelation->EmpMonths) ? $Contact->EmploymentRelation->EmpMonths . ' Months ' : ' 0 Months'). "</td>
	                        
	                        <td  >Gross Income:&nbsp;</td>
	                        <td >" 
	                        			. (($Contact->EmploymentRelation->GrossIncome) ? $Contact->EmploymentRelation->GrossIncome : 'N/A') 
	                            	. "
                            </td>
                        </tr>
                        
                        

                        <tr>
	                        <td  >Other Income:&nbsp;</td>
	                        <td >" . (($Contact->EmploymentRelation->OtherIncome) ? $Contact->EmploymentRelation->OtherIncome : 'N/A' ). "</td>
	                        
	                        <td  >Frequency:&nbsp;</td>
	                        <td >" 
	                        			. (($Contact->EmploymentRelation->FrequencyId) ? Frequency::getFrequency($Contact->EmploymentRelation->FrequencyId) : 'N/A')
	                            	. "
                            </td>
                        </tr>
                        
                       

                        <tr>
	                        <td  >Other Income Type:&nbsp;</td>
	                        <td >" . (($Contact->EmploymentRelation->OtherIncomeTypeId) ? OtherIncomeType::getIncomeType($Contact->EmploymentRelation->OtherIncomeTypeId): 'N/A'). "</td>
	                        
	                        
                        </tr>
                        
                        
                    ";

                 	if($Contact->PreviousEmpRelation)
                    { 

                   		$html .= "
                   					<tr>
				                        <td  >Previous Organization Name:&nbsp;</td>
				                        <td >" . (($Contact->PreviousEmpRelation->Name) ? $Contact->PreviousEmpRelation->Name : 'N/A'). "</td>

				                        <td  >Previous Length of Employment:&nbsp;</td>
				                        <td >" . (($Contact->PreviousEmpRelation->PrevEmpYears) ? $Contact->PreviousEmpRelation->PrevEmpYears . ' Year(s) ' : ' 0 Years') . "
                                        " . (($Contact->PreviousEmpRelation->PrevEmpMonths) ? $Contact->PreviousEmpRelation->PrevEmpMonths . ' Months ' : ' 0 Months' ). "</td>			                        
				                        
			                        </tr>";
			        }
                    
                    $html .= "    </tbody>

                     </table>   
	                        
	               		

                    <div class='clearfix'></div>

	";
}

if($CoApplicant->Id !=0)
{

	$html .= "

				<table class='flat-table'>
                    	<tr>
                    		<th colspan='4'>Co-Applicant Information</th>
                		</tr>
                    	
                    	<tbody>
                    	<tr>
	                        <td  >Full Name:&nbsp;</td>
	                        <td >" .$CoApplicant->ContactInfoRelation->FirstName . " " .  $CoApplicant->ContactInfoRelation->LastName. "</td>
	                        
	                        <td  >Address:&nbsp;</td>
	                        <td >" 
	                        			. $CoApplicant->ContactInfoRelation->Address1 . "<br/>" 
                                    .   $CoApplicant->ContactInfoRelation->City . " , " .$CoApplicant->ContactInfoRelation->Province . "<br/>" 
                                    .   $CoApplicant->ContactInfoRelation->Postal . "<br/>" 
                                    .   $CoApplicant->ContactInfoRelation->Phone1 . "<br/>" 
                                    .   $CoApplicant->ContactInfoRelation->Email
	                            	. "
                            </td>
                        </tr>
                        
                        

                        <tr>
	                        <td  >Social Insurance Number:&nbsp;</td>
	                        <td >" .(($CoApplicant->ContactInfoRelation->SIN) ? $CoApplicant->ContactInfoRelation->SIN : 'N/A'). "</td>
	                        
	                        <td  >Date of Birth:&nbsp;</td>
	                        <td >" 
	                        			. (($CoApplicant->ContactInfoRelation->DOB) ? $CoApplicant->ContactInfoRelation->DOB : 'N/A')
	                            	. "
                            </td>
                        </tr>
                        
                        

                        <tr>
	                        <td  >Marital Status:&nbsp;</td>
	                        <td >" .(($CoApplicant->ContactInfoRelation->MaritalStatus) ? $CoApplicant->ContactInfoRelation->MaritalStatus : 'N/A'). "</td>
	                        
	                        <td  >Gender:&nbsp;</td>
	                        <td >" 
	                        			. (($CoApplicant->ContactInfoRelation->Gender) ? $CoApplicant->ContactInfoRelation->Gender : 'N/A')
	                            	. "</td>
                        </tr>
                        
                        

                        <tr>
	                        <td  >Length of Residence:&nbsp;</td>
	                        <td >" .(($CoApplicant->ContactInfoRelation->ResidenceYears) ? $CoApplicant->ContactInfoRelation->ResidenceYears . ' Year(s) '  : 'N/A' ). "
                                " . (($CoApplicant->ContactInfoRelation->ResidenceMonths) ? $CoApplicant->ContactInfoRelation->ResidenceMonths . ' Months ' : ' 0 Months'). "</td>
                        </tr>



                        </tbody>

                     </table>   
	                        
	               		

                    <div class='clearfix'></div>

	";

	if($CoApplicant->EmploymentRelation)
	{
		$html .= "

					<table class='flat-table'>
	                    	<tr>
	                    		<th colspan='4'>Employment Information</th>
	                		</tr>
	                    	
	                    	<tbody>
	                    	<tr>
		                        <td  >Organization Name:&nbsp;</td>
		                        <td >" .(($CoApplicant->EmploymentRelation->OrganizationName) ? $CoApplicant->EmploymentRelation->OrganizationName : 'N/A'). "</td>
		                        
		                        <td  >Employment Status:&nbsp;</td>
		                        <td >" 
		                        			. (($CoApplicant->EmploymentRelation->EmpStatusId) ? EmpStatus::getStatusText($CoApplicant->EmploymentRelation->EmpStatusId) : 'N/A')
		                            	. "
	                            </td>
	                        </tr>
	                        
	                        

	                        <tr>
		                        <td  >Employment Type:&nbsp;</td>
		                        <td >" .(($CoApplicant->EmploymentRelation->EmpTypeId) ? EmpType::getType($CoApplicant->EmploymentRelation->EmpTypeId) : 'N/A'). "</td>
		                        
		                        <td  >Job Title:&nbsp;</td>
		                        <td >" 
		                        			. (($CoApplicant->EmploymentRelation->JobTitle) ? $CoApplicant->EmploymentRelation->JobTitle : 'N/A')
		                            	. "
	                            </td>
	                        </tr>
	                        
	                        

	                        <tr>
		                        <td  >Address:&nbsp;</td>
		                        <td >" .$CoApplicant->EmploymentRelation->Address1 . "<br/>" 
	                                    .   $CoApplicant->EmploymentRelation->City . " , "  .$CoApplicant->EmploymentRelation->Province . "<br/>" 
	                                    .   $CoApplicant->EmploymentRelation->Postal . "<br/>" 
	                                    .   $CoApplicant->EmploymentRelation->Phone1 . "<br/>" 
	                                    .   $CoApplicant->EmploymentRelation->Email. "</td>
		                        
		                        <td  >Length of Employment:&nbsp;</td>
		                        <td >" 
		                        			. (($CoApplicant->EmploymentRelation->EmpYears) ? $CoApplicant->EmploymentRelation->EmpYears . ' Year(s) ' : ' 0 Years') . "
	                                " . (($CoApplicant->EmploymentRelation->ResidenceMonths) ? $CoApplicant->EmploymentRelation->ResidenceMonths . ' Months ' : ' 0 Months')
		                            	. "
	                            </td>
	                        </tr>
	                        
	                        

	                        <tr>
		                        <td  >Gross Income:&nbsp;</td>
		                        <td >" .(($CoApplicant->EmploymentRelation->GrossIncome) ? $CoApplicant->EmploymentRelation->GrossIncome : 'N/A'). "</td>
		                        
		                        <td  >Other Income:&nbsp;</td>
		                        <td >" 
		                        			. (($CoApplicant->EmploymentRelation->OtherIncome) ? $CoApplicant->EmploymentRelation->OtherIncome : 'N/A' )
		                            	. "
	                            </td>
	                        </tr>
	                        
	                        

	                        <tr>
		                        <td  >Frequency:&nbsp;</td>
		                        <td >" .(($CoApplicant->EmploymentRelation->FrequencyId) ? Frequency::getFrequency($CoApplicant->EmploymentRelation->FrequencyId) : 'N/A'). "</td>
		                        
		                        <td  >Other Income Type:&nbsp;</td>
		                        <td >" 
		                        			. (($CoApplicant->EmploymentRelation->OtherIncomeTypeId) ? OtherIncomeType::getIncomeType($CoApplicant->EmploymentRelation->OtherIncomeTypeId) : 'N/A' )
		                            	. "
	                            </td>
	                        </tr>
	                        
	                        
	                        ";

	                 	if($CoApplicant->PreviousEmpRelation)
	                    { 

	                   		$html .= "
	                   					<tr>
					                        <td  >Previous Organization Name:&nbsp;</td>
					                        <td >" . (($CoApplicant->PreviousEmpRelation->Name) ? $CoApplicant->PreviousEmpRelation->Name : 'N/A'). "</td>

					                        <td  >Previous Length of Employment:&nbsp;</td>
					                        <td >" . (($CoApplicant->PreviousEmpRelation->PrevEmpYears) ? $CoApplicant->PreviousEmpRelation->PrevEmpYears . " Year(s) " : ' 0 Years' ) . "
	                                        " . (($CoApplicant->PreviousEmpRelation->PrevEmpMonths) ? $CoApplicant->PreviousEmpRelation->PrevEmpMonths . " Months " : ' 0 Months'). "</td>			                        
					                        
				                        </tr>";
				        }
	                    
	                    $html .= "

	                        </tbody>

	                     </table>   
		                        
		               		

	                    <div class='clearfix'></div>

		";
	}


}



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
    
    if(!isset($DealerId))
        $mpdf->OutPut();

    

	$TemporaryFileName = date('YmdHis').'.pdf';
        
    $pdfres =  $mpdf->Output($TemporaryFileName,'S');


	if (!$fp = fopen(WEBROOT.'tmp/'.$TemporaryFileName, 'w'))
	$fileError = true;
	
	

	if (!fputs($fp, $pdfres))
	$fileError = true;

	
	fclose($fp);
	chmod(WEBROOT.'tmp/'.$TemporaryFileName, 0777);
    

	if(!$fileError)
    {
        
        if(isset($DealerId))
        {
        	
            $dealeremail = dealership::GetDealerEmail($DealerId);
        	 $mailObj = new Email($dealeremail, " SuperCarLoans ", "SuperCarLoans - New Lead. ");
                $mailObj->TextOnly = false;
                $mailObj->Content = "Please find the leads info in the form of attachment. ";
                $mailObj->Attach(WEBROOT . "tmp/" . $TemporaryFileName, "application/pdf", "SuperCarLoans - New Lead.pdf");

                $FilesResultset = Files::LoadFileInfo($ContactId);

                if($FilesResultset->TotalResults>0)
                {
                    for($x = 0; $x < $FilesResultset->TotalResults ; $x++)
                    {
                        $mailObj->Attach(WEBROOT . "img/" . $FilesResultset->Result[$x]['FileLocation'], "application/pdf", $FilesResultset->Result[$x]['FileName']);
                    }
                }
                try 
                {

                    
                     if($mailObj->Send())
                     {
                        header("Location:".ADMINAPPROOT . 'info.php?' . $Encrypt->encrypt('Message=Dealer assigned successfully to the contact.Informaion has been sent to dealer.&Success=true&ContactId='.$ContactId));    	
	    				exit();
                    }

                    else 
                    {
                    	header("Location:".ADMINAPPROOT . 'info.php?' . $Encrypt->encrypt('Message=Something went wrong while sending email.&Success=false&ContactId='.$ContactId));    	
    	 				exit();
                    }
                }
                catch (Exception $e) {
                    echo 'Caught exception: ',  $e->getMessage(), "\n";
                }
        }//echo "<br/> ======= success";
    }
    else{
    	//echo "<br/> ======= failure";
    }
