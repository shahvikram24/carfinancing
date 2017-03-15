
<?php
/*
*
* -------------------------------------------------------
* CLASSNAME:        dealership
* CREATION DATE:    07.08.2015
* CLASS FILE:       class.dealership.php
* FOR MYSQL TABLE:  tbldealership
* FOR MYSQL DB:     SuperCarLoans
* -------------------------------------------------------
*
*/



// **********************
// CLASS DECLARATION
// **********************

class dealership extends BaseClass
{ // class : begin


// **********************
// ATTRIBUTE DECLARATION
// **********************

var $Id;   // KEY ATTR. WITH AUTOINCREMENT

var $DealershipName;   // (normal Attribute)
var $DealershipPlan;   // (normal Attribute)
var $Address;   // (normal Attribute)
var $Phone;   // (normal Attribute)
var $Email;   // (normal Attribute)
var $Fax;   // (normal Attribute)
var $ContactName;   // (normal Attribute)
var $LicenceNo = '';   // (normal Attribute)
var $Remarks;   // (normal Attribute)
var $CreatedDate;   // (normal Attribute)
var $Approve;   // (normal Attribute)
var $Status;   // (normal Attribute)
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
function getDealershipName()
{return $this->DealershipName; }
function getDealershipPlan()
{return $this->DealershipPlan; }
function getAddress()
{return $this->Address; }
function getPhone()
{return $this->Phone; }

function getFax()
{return $this->Fax; }
function getContactName()
{return $this->ContactName; }
function getLicenceNo()
{return $this->LicenceNo; }
function getRemarks()
{return $this->Remarks; }
function getCreatedDate()
{return $this->CreatedDate; }
function getStatus()
{return $this->Status; }
// **********************
// SETTER METHODS
// **********************


function setId($val)
{
$this->Id =  $val;
}

function setDealershipName($val)
{
$this->DealershipName =  $val;
}

function setDealershipPlan($val)
{
$this->DealershipPlan =  $val;
}

function setAddress($val)
{
$this->Address =  $val;
}

function setPhone($val)
{
$this->Phone =  $val;
}


function setFax($val)
{
$this->Fax =  $val;
}

function setContactName($val)
{
$this->ContactName =  $val;
}

function setLicenceNo($val)
{
$this->LicenceNo =  $val;
}

function setRemarks($val)
{
$this->Remarks =  $val;
}

function setCreatedDate($val)
{
$this->CreatedDate =  $val;
}

function setStatus($val)
{
$this->Status =  $val;
}



public function addDealershipInfo() 
{

	$SQL = " INSERT INTO tbldealership 
				SET 
					DealershipName = '" . $this->DealershipName . "', 
					DealershipPlan = " . $this->DealershipPlan . ", 
					Address = '" . $this->Address . "', 
					Phone = '" . $this->Phone . "', 
					Fax = '" . $this->Fax . "', 
					ContactName = '" . $this->ContactName . "', 
					
					LicenceNo = '" . $this->LicenceNo . "', 
					Remarks = '" . $this->Remarks . "', 
					CreatedDate = '" . $this->CreatedDate . "', 
					Approve = " . $this->Approve . ", 
					Status = " . $this->Status . "

					";
			//echo "<br/><br/><br/><br/><br/><br/>".$SQL;		
			$this->Id = parent::GetDALInstance()->SQLQuery($SQL,2);
			return $this->Id;
}


public function updateDealershipInfo() 
	{
		
		$SQL = " UPDATE tbldealership 
		SET 
			DealershipName = '" . $this->DealershipName . "', 
			DealershipPlan = " . $this->DealershipPlan . ", 
			Address = '" . $this->Address . "', 
			Phone = '" . $this->Phone . "', 
			Fax = '" . $this->Fax . "', 
			ContactName = '" . $this->ContactName . "', 
			
			LicenceNo = '" . $this->LicenceNo . "', 
			Remarks = '" . $this->Remarks . "', 
			CreatedDate = '" . $this->CreatedDate . "', 
			Approve = " . $this->Approve . ", 
			Status = " . $this->Status . "

        WHERE Id=".$this->Id;
		
		//echo "<br/><br/><br/><br/><br/><br/>".$SQL;
				
		// echo " <br/> ==> update =  " . $SQL . " <== <br/>";
        parent::GetDALInstance()->SQLQuery($SQL);
        
        return parent::GetDALInstance()->AffectedRows();

	}


public function loadDealershipInfo($Id, $Condition = false) 
  	{

		$SQL = "SELECT * FROM tbldealership WHERE Id = " . $Id ;
		
		if($Condition) 
		{
			$SQL .= ' AND Status = 1 ';
		}	

		parent::GetDALInstance()->SQLQuery($SQL);
		$row = parent::GetDALInstance()->GetRow(false);


			if($row)
			{
				$this->Id = $row['Id'];
				$this->DealershipName = $row['DealershipName'];
				$this->DealershipPlan = $row['DealershipPlan'];
				$this->Address = $row['Address'];
				$this->Phone = $row['Phone'];
				$this->Fax = $row['Fax'];
				$this->ContactName = $row['ContactName'];
				$this->LicenceNo = $row['LicenceNo'];
				$this->Remarks = $row['Remarks'];
				$this->CreatedDate = $row['CreatedDate'];
				$this->Approve = $row['Approve'];
				$this->Status = $row['Status'];
				
				
				return $this;
			}
			return false;

	}


	public function loadAllDealershipInfo($Condition = '') 
  	{
		
				
		$SQL = "SELECT * FROM tbldealership D ";

		if($Condition !='')
			$SQL .= ' WHERE '. $Condition;
		//echo "<br/><br/><br/><br/><br/><br/>".$SQL;

		parent::GetDALInstance()->SQLQuery($SQL);
		$row = parent::GetDALInstance()->GetRow(false);
			
		$ResultSet = new ResultSet();
	    if($ResultSet->LoadResult($SQL))
	        return $ResultSet;

	    
		return false;

	}

	public function DealershipCount()
	{
		$SQL = "SELECT count(*) AS 'TotalDealership'
				FROM tbldealership 
				WHERE Status = 1

		";

		parent::GetDALInstance()->SQLQuery($SQL);
		$row = parent::GetDALInstance()->GetRow();

		return ($row) ? $row["TotalDealership"] : 0;
	}



} // class : end
?>
