
<?php
/*
*
* -------------------------------------------------------
* CLASSNAME:        DealerPackageFeatures
* CREATION DATE:    12.08.2015
* CLASS FILE:       class.DealerPackageFeatures.php
* FOR MYSQL TABLE:  tbldealerpackagefeatures
* FOR MYSQL DB:     SuperCarLoans
* -------------------------------------------------------
*
*/



// **********************
// CLASS DECLARATION
// **********************

class DealerPackageFeatures extends BaseClass
{ // class : begin


// **********************
// ATTRIBUTE DECLARATION
// **********************

var $Id;   // KEY ATTR. WITH AUTOINCREMENT


var $DealerId;   // (normal Attribute)
var $DealerPackageId;   // (normal Attribute)
var $ContactId;   // (normal Attribute)
var $Timestamp;   // (normal Attribute)
var $Status;   // (normal Attribute)
public $DealerRelation = false;
public $DealerPackageRelation = false;
public $ContactRelation = false;

// **********************
// CONSTRUCTOR METHOD
// **********************

function __construct()
		{
			parent::__construct();
		}


public function addDealerpackageFeatures() 
{

	$SQL = " INSERT INTO tbldealerpackagefeatures 
				SET 
					DealerId = '" . $this->DealerId . "', 
					DealerPackageId = " . $this->DealerPackageId . ", 
					ContactId = " . $this->ContactId . ", 
					Timestamp = '" . $this->Timestamp . "', 
					Status = " . $this->Status . "

					";
			//echo "<br/><br/><br/><br/><br/><br/>".$SQL;		
			$this->Id = parent::GetDALInstance()->SQLQuery($SQL,2);
			return $this->Id;
}

public function updateDealerpackageFeatures() 
	{
		
		$SQL = " UPDATE tbldealerpackagefeatures 
		SET 
			DealerId = '" . $this->DealerId . "', 
			DealerPackageId = " . $this->DealerPackageId . ", 
			ContactId = " . $this->ContactId . ", 
			Timestamp = '" . $this->Timestamp . "', 
			Status = " . $this->Status . "

        WHERE Id=".$this->Id;
		
		//echo "<br/><br/><br/><br/><br/><br/>".$SQL;
				
		// echo " <br/> ==> update =  " . $SQL . " <== <br/>";
        parent::GetDALInstance()->SQLQuery($SQL);
        
        return parent::GetDALInstance()->AffectedRows();

	}

function LoadFeaturesByDealerId($DealerId, $DealerPackageId, $GetChildren = false)
{
			
				$SQL = "SELECT * FROM tbldealerpackagefeatures 
						WHERE 	DealerId=" . $DealerId 
								. " AND DealerPackageId =" . $DealerPackageId;
				parent::GetDALInstance()->SQLQuery($SQL);

				//echo "<br/><br/><br/><br/><br/><br/>".$SQL;

            	$Result = parent::GetDALInstance()->GetArray(false);
				if($Result) 
				{
					$ReturnArray = array();
                	$ResultLength = count($Result);

					for($x = 0; $x < $ResultLength ; $x++) 
                	{
                		$DealerPackageFeatures = new DealerPackageFeatures();
                		$DealerPackageFeatures->Id = $Result[$x]['Id'];
						$DealerPackageFeatures->DealerId = $Result[$x]['DealerId'];
						$DealerPackageFeatures->DealerPackageId = $Result[$x]['DealerPackageId'];
						$DealerPackageFeatures->ContactId = $Result[$x]['ContactId'];
						$DealerPackageFeatures->Timestamp = $Result[$x]['Timestamp'];
						$DealerPackageFeatures->Status = $Result[$x]['Status'];

						if($GetChildren)
						{
							$DealerPackageFeatures->DealerRelation = new dealership();
							if(!$DealerPackageFeatures->DealerRelation->loadDealershipInfo($DealerPackageFeatures->DealerId,true))
								$DealerPackageFeatures->DealerRelation = false;

							$DealerPackageFeatures->DealerPackageRelation = new dealerpackages();
							if(!$DealerPackageFeatures->DealerPackageRelation->LoadDealerPackageByDealerId($DealerPackageFeatures->DealerId))
								$DealerPackageFeatures->DealerPackageRelation = false;

							$DealerPackageFeatures->ContactRelation = new Contact();
							if(!$DealerPackageFeatures->ContactRelation->loadContact($DealerPackageFeatures->ContactId))
								$DealerPackageFeatures->ContactRelation = false;

							
						}

						$ReturnArray[] = $DealerPackageFeatures;

					}
                 
                return $ReturnArray;
            }
	    
		return false;

	}
	

function LoadFeatures($Id, $GetChildren = false)
		{
			if(NumberCheck($Id))
			{
				$SQL = "SELECT * FROM tbldealerpackagefeatures WHERE Id=".$Id;

				parent::GetDALInstance()->SQLQuery($SQL);

				//echo "<br/><br/><br/><br/><br/><br/>".$SQL;

				$row = parent::GetDALInstance()->GetRow(false);
				if($row)
				{
					$this->Id = $row['Id'];
					$this->DealerId = $row['DealerId'];
					$this->DealerPackageId = $row['DealerPackageId'];
					$this->ContactId = $row['ContactId'];
					$this->Timestamp = $row['Timestamp'];
					$this->Status = $row['Status'];

					if($GetChildren)
					{
						$this->DealerRelation = new dealership();
						if(!$this->DealerRelation->loadDealershipInfo($this->DealerId,true))
							$this->DealerRelation = false;

						$this->DealerPackageRelation = new dealerpackages();
						if(!$this->DealerPackageRelation->LoadDealerPackageByDealerId($this->DealerId))
							$this->DealerPackageRelation = false;

						$this->ContactRelation = new Contact();
						if(!$this->ContactRelation->loadContact($this->ContactId))
							$this->ContactRelation = false;

						
					}

					return true;
				}
			}

			return false;
		}


public function CountSentApplications($DealerId,$DealerPackageId,$Date='' )
	{
		$SQL = "SELECT count(Id) AS 'Id' 
				FROM tbldealerpackagefeatures 
				WHERE Status = 1 AND DealerId=" . $DealerId . " AND DealerPackageId =" . $DealerPackageId 
				
		;

		if($Date)
		{
			$SQL .= " AND Timestamp like '%" . $Date . "%'";
		}
		//echo  "\n". $SQL . "\n";

		parent::GetDALInstance()->SQLQuery($SQL);
		$row = parent::GetDALInstance()->GetRow();

		return ($row) ? $row["Id"] : 0;
	}

function LoadFeaturesByContactId($ContactId, $GetChildren = false)
{
			
				$SQL = "SELECT * FROM tbldealerpackagefeatures 
						WHERE 	Status=1 AND ContactId=" . $ContactId 
						;
				parent::GetDALInstance()->SQLQuery($SQL);

				//echo "<br/><br/><br/><br/><br/><br/>".$SQL;

            	$Result = parent::GetDALInstance()->GetArray(false);
				if($Result) 
				{
					$ReturnArray = array();
                	$ResultLength = count($Result);

					for($x = 0; $x < $ResultLength ; $x++) 
                	{
                		$DealerPackageFeatures = new DealerPackageFeatures();
                		$DealerPackageFeatures->Id = $Result[$x]['Id'];
						$DealerPackageFeatures->DealerId = $Result[$x]['DealerId'];
						$DealerPackageFeatures->DealerPackageId = $Result[$x]['DealerPackageId'];
						$DealerPackageFeatures->ContactId = $Result[$x]['ContactId'];
						$DealerPackageFeatures->Timestamp = $Result[$x]['Timestamp'];
						$DealerPackageFeatures->Status = $Result[$x]['Status'];

						if($GetChildren)
						{
							$DealerPackageFeatures->DealerRelation = new dealership();
							if(!$DealerPackageFeatures->DealerRelation->loadDealershipInfo($DealerPackageFeatures->DealerId,true))
								$DealerPackageFeatures->DealerRelation = false;

							$DealerPackageFeatures->DealerPackageRelation = new dealerpackages();
							if(!$DealerPackageFeatures->DealerPackageRelation->LoadDealerPackageByDealerId($DealerPackageFeatures->DealerId))
								$DealerPackageFeatures->DealerPackageRelation = false;

							$DealerPackageFeatures->ContactRelation = new Contact();
							if(!$DealerPackageFeatures->ContactRelation->loadContact($DealerPackageFeatures->ContactId))
								$DealerPackageFeatures->ContactRelation = false;

							
						}

						$ReturnArray[] = $DealerPackageFeatures;

					}
                 
                return $ReturnArray;
            }
	    
		return false;

	}


public function CheckContactExists($ContactId )
	{
		$SQL = "SELECT Id  
				FROM tbldealerpackagefeatures 
				WHERE Status = 1 AND ContactId=" . $ContactId  
				
		;

		//echo  "\n". $SQL . "\n";

		parent::GetDALInstance()->SQLQuery($SQL);
		$row = parent::GetDALInstance()->GetRow();

		return ($row) ? true : false;
	}



} // class : end
?>
