<?php	

require_once("../include/files.php");

extract($_REQUEST); 

if(!isset($_SESSION['admin_id']))
{
	header("Location: index.php");
}


if(!isset($SQLWhere))
{
	header("Location: leads.php");
}


$Contact = new Contact();
$Result = $Contact->loadSearchInfo($SQLWhere);


$html .= "
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>";

$style = "<head><style>".file_get_contents(APPROOT.'css/export.css')."</style></head>" ;

$html .= "<body>";

$html .= "
                    
                    	<table class='table table-hover table-mc-light-blue' id='table'>
                    	
                    		<caption>Completed Leads Applications</caption>
                			<thead>
				            <tr>
				                <th>#</th>
				                <th>Unique ID</th>
				                <th>Full Name</th>
				                <th>Email</th>
				                <th>Phone</th>
				                <th>Credit Score</th>
				                <th>Referred By</th>
				                <th>Whom It's Been Assigned</th>
				                <th>Verified Status</th>
				                <th>Deal Status</th>
				                
				            </tr>
				        </thead>
                    	<tbody>";
                    	
?>
                    	<?php

						$count = 1;
						if($Result->TotalResults>0)
						{
							/* Deal Status of Contact */
		                	$affiliateTransaction = new AffiliateTransaction();

							$dealStatus = new DealStatus();
							$dealStatusResult = $dealStatus->loadAllDealStatus();

							for($x = 0; $x < $Result->TotalResults ; $x++)
							{
								$Assigned = DealerPackageFeatures::CheckContactExists($Result->Result[$x]['ContactId']);
								if($Assigned)
		                		{
		                			$dealerpackagefeaturesResultSet = DealerPackageFeatures::LoadFeaturesByContactId($Result->Result[$x]['ContactId'],true);
		                			$AssignedText = $dealerpackagefeaturesResultSet[0]->DealerRelation->DealershipName ;
		                		}
		                		else{
		                			$AssignedText = " - ";
		                		}

		                		$AffiliateCode = AffiliateTransaction::getAffiliateCode($Result->Result[$x]['Id']);
								if($AffiliateCode)
									$ReferredPerson = Affiliate::GetFullName($AffiliateCode);
								else
									$ReferredPerson = " - ";


		                		
							$html .= "
							    <tr>

						                <td>" .  $count . "</td>
						                <td>" .   sprintf('%04d',$Result->Result[$x]['Id']) . "</td>
						                <td>" .    $Result->Result[$x]['FirstName'] . " " . $Result->Result[$x]['LastName'] . "
						                </td>
						                <td>" .    $Result->Result[$x]['Email'] . "</td>
						                <td>" .    $Result->Result[$x]['Phone1'] . "</td>
						                <td>" .    $Result->Result[$x]['CreditScore'] . "</td>
						                <td>" .    $ReferredPerson . "</td>
						                <td>" .    $AssignedText . "</td>
						                <td>" .    Contact::Status($Result->Result[$x]['AccountStatus']) . "
						                </td>
						                <td> ";
						                	

	                                   	$ResultTransaction = $affiliateTransaction->loadTransactionByContactInfo($Result->Result[$x]['Id']);
                                $html .=  "<span><label class='alert alert-success' role='alert' style='width:100%;'>" . DealStatus::getStatusText($ResultTransaction->description) ."</label></span>";
                                        
							$html .= "    

						                </td>
						        </tr>";

						    
						    	$count++;
							}
						}

						
				$html .= "
                       </tbody>

                     </table>   
	                        
	               		

                    <div class='clearfix'></div>
";




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
    
    $mpdf->OutPut();

    
	