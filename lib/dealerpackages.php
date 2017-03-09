
<?php
/*
*
* -------------------------------------------------------
* CLASSNAME:        dealerpackages
* CREATION DATE:    07.08.2015
* CLASS FILE:       class.dealerpackages.php
* FOR MYSQL TABLE:  tbldealerpackages
* FOR MYSQL DB:     SuperCarLoans
* -------------------------------------------------------
*
*/



// **********************
// CLASS DECLARATION
// **********************

class dealerpackages extends BaseClass
{ // class : begin


// **********************
// ATTRIBUTE DECLARATION
// **********************

var $Id;   // KEY ATTR. WITH AUTOINCREMENT

var $AddDate;   // (normal Attribute)
var $ExpireDate;   // (normal Attribute)
var $PlanId;
var $Term;   // (normal Attribute)
var $DealerId;   // (normal Attribute)
var $Timestamp;   // (normal Attribute)
var $Status = 0;   // (normal Attribute)
// **********************
// CONSTRUCTOR METHOD
// **********************

function __construct()
		{
			parent::__construct();
		}
// **********************
// GETTER METHODS
// **********************


function getId()
{return $this->Id; }
function getAddDate()
{return $this->AddDate; }
function getExpireDate()
{return $this->ExpireDate; }
function getTerm()
{return $this->Term; }
function getDealerId()
{return $this->DealerId; }
function getTimestamp()
{return $this->Timestamp; }
function getStatus()
{return $this->Status; }
// **********************
// SETTER METHODS
// **********************


function setId($val)
{
$this->Id =  $val;
}

function setAddDate($val)
{
$this->AddDate =  $val;
}

function setExpireDate($val)
{
$this->ExpireDate =  $val;
}

function setTerm($val)
{
$this->Term =  $val;
}

function setDealerId($val)
{
$this->DealerId =  $val;
}

function setTimestamp($val)
{
$this->Timestamp =  $val;
}

function setStatus($val)
{
$this->Status =  $val;
}



function InsertDealerPackage()
		{

			

			$SQL = "INSERT INTO tbldealerpackages 
					SET 
						AddDate='".$this->AddDate."', 
						ExpireDate='".$this->ExpireDate."', 
						PlanId=".$this->PlanId.", 
						DealerId=".$this->DealerId.", 
						Timestamp='".$this->Timestamp."', 
						Status=".$this->Status;

			//echo '<br />------  SQL = '. $SQL .'<br />';

			$this->Id = parent::GetDALInstance()->SQLQuery($SQL, 2);
			return $this->Id;
		}

function UpdateDealerPackage()
		{		

			$SQL = " UPDATE tbldealerpackages 
				SET 
						AddDate='".$this->AddDate."', 
						ExpireDate='".$this->ExpireDate."', 
						PlanId=".$this->PlanId.", 
						DealerId=".$this->DealerId.", 
						Timestamp='".$this->Timestamp."', 
						Status=".$this->Status. "

        WHERE Id=".$this->Id;
		
		//echo "<br/><br/><br/><br/><br/><br/>".$SQL;
				
		// echo " <br/> ==> update =  " . $SQL . " <== <br/>";
        parent::GetDALInstance()->SQLQuery($SQL);
        
        return parent::GetDALInstance()->AffectedRows();
		}



public function UpdateDealerPackageTerm($DealerPackageId, $Term)
		{
			
			
			$SQL = "UPDATE tbldealerpackages SET Term=".$Term." 
					Where Id = " . $DealerPackageId . " AND status = 1" ;
			
			//echo '<br />------ update term ----1----<br />';

			return parent::GetDALInstance()->SQLQuery($SQL);
		}

function LoadDealerPackage($Id, $GetChildren = false)
		{
			if(NumberCheck($Id))
			{
				$SQL = "SELECT * FROM tbldealerpackages WHERE Id=".$Id;
				parent::GetDALInstance()->SQLQuery($SQL);
				$row = parent::GetDALInstance()->GetRow(false);

				if($row)
				{
					$this->Id = $row['Id'];
					$this->AddDate = $row['AddDate'];
					$this->ExpireDate = $row['ExpireDate'];
					$this->PlanId = $row['PlanId'];
					$this->Term = $row['Term'];
					$this->DealerId = $row['DealerId'];
					$this->Timestamp = $row['Timestamp'];
					$this->Status = $row['Status'];

					return true;
				}
			}

			return false;
		}

static function GetPreAuthorizeDetails()
		{
			
				$SQL = "SELECT DP.*
						FROM tbldealerpackages DP 
						WHERE DP.Status=1 AND DP.Term=1  
						";
				//echo  "\n". $SQL . "\n";
				$ResultSet = new ResultSet();
				if($ResultSet->LoadResult($SQL))
					return $ResultSet;
			
			return false;
		}

function LoadDealerPackageByDealerId($DealerId, $GetChildren = false)
		{
			if(NumberCheck($DealerId))
			{
				$SQL = "SELECT * FROM tbldealerpackages WHERE Status = 1 AND DealerId=".$DealerId;
				parent::GetDALInstance()->SQLQuery($SQL);
				$row = parent::GetDALInstance()->GetRow(false);

				//echo  "\n". $SQL . "\n";
				if($row)
				{
					$this->Id = $row['Id'];
					$this->AddDate = $row['AddDate'];
					$this->ExpireDate = $row['ExpireDate'];
					$this->PlanId = $row['PlanId'];
					$this->Term = $row['Term'];
					$this->DealerId = $row['DealerId'];
					$this->Timestamp = $row['Timestamp'];
					$this->Status = $row['Status'];

					return $this;
				}
			}

			return false;
		}

public function GetInfoByDealerId($DealerId, $SQLWhere = '')
		{
			
				$SQL = "SELECT DP.*
						FROM tbldealerpackages DP 
						WHERE DealerId = " . $DealerId 
							  . $SQLWhere 
							  . " ORDER BY Id DESC "
					;
				//echo  "\n". $SQL . "\n";
				$ResultSet = new ResultSet();
				if($ResultSet->LoadResult($SQL))
					return $ResultSet;
			
			return false;
		}


public function GetIdByDealerId($DealerId)
	{
		$SQL = "SELECT Id AS 'DealerPackageId'
				FROM tbldealerpackages 
				WHERE Status = 1

		";

		//echo  "\n". $SQL . "\n";

		parent::GetDALInstance()->SQLQuery($SQL);
		$row = parent::GetDALInstance()->GetRow();

		return ($row) ? $row["DealerPackageId"] : 0;
	}

public function GetPlanId($DealerId)
	{
		$SQL = "SELECT PlanId AS 'PlanId'
				FROM tbldealerpackages 
				WHERE Status = 1

		";

		//echo  "\n". $SQL . "\n";

		parent::GetDALInstance()->SQLQuery($SQL);
		$row = parent::GetDALInstance()->GetRow();

		return ($row) ? $row["PlanId"] : 0;
	}

} // class : end
?>
