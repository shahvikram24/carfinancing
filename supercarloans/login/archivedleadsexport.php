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



$ArchivedContactInfo = new ContactInfo();
$ArchivedResult = $ArchivedContactInfo->loadArchivedApplication($SQLWhere);

$html .= "
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>";

$style = "<head><style>".file_get_contents(APPROOT.'css/export.css')."</style></head>" ;

$html .= "<body>";

$html .= "
                    
                    	<table class='table table-hover table-mc-light-blue' id='table'>
                    	
                    		<caption>Incompleted Leads Applications</caption>
                			<thead>
				            <tr>
				                <th>#</th>
				                <th>Unique ID</th>
				                <th>Full Name</th>
				                <th>Email</th>
				                <th>Phone</th>
				                <th>Referred By</th>
				                <th>Archived Notes</th>
				                
				            </tr>
				        </thead>
                    	<tbody>";
                    	
?>
                    	<?php

						$count = 1;
							if($ArchivedResult->TotalResults>0)
							{
								for($x = 0; $x < $ArchivedResult->TotalResults ; $x++)
								{
									$AffiliateCode = AffiliateTransaction::getAffiliateCode($ArchivedResult->Result[$x]['Id']);
									if($AffiliateCode)
										$ReferredPerson = Affiliate::GetFullName($AffiliateCode);
									else
										$ReferredPerson = " - ";


		                		
							$html .= "
							    <tr>

						                <td>" .  $count . "</td>
						                <td>" .   sprintf('%04d',$ArchivedResult->Result[$x]['Id']) . "</td>
						                <td>" .    $ArchivedResult->Result[$x]['FirstName'] . " " . $ArchivedResult->Result[$x]['LastName'] . "
						                </td>
						                <td>" .    $ArchivedResult->Result[$x]['Email'] . "</td>
						                <td>" .    $ArchivedResult->Result[$x]['Phone1'] . "</td>
						                <td>" .    $ReferredPerson . "</td>
						                <td>" .    $ArchivedResult->Result[$x]['ArchiveNotes'] . "</td>
						                
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

    

	