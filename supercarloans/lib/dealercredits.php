
<?php
/*
*
* -------------------------------------------------------
* CLASSNAME:        dealercredits
* CREATION DATE:    12.08.2015
* CLASS FILE:       class.dealercredits.php
* FOR MYSQL TABLE:  tbldealercredits
* FOR MYSQL DB:     SuperCarLoans
* -------------------------------------------------------
*
*/



// **********************
// CLASS DECLARATION
// **********************

class dealercredits extends BaseClass
{ // class : begin


// **********************
// ATTRIBUTE DECLARATION
// **********************

var $Id;   // KEY ATTR. WITH AUTOINCREMENT

var $DealerId;   // (normal Attribute)
var $DealerPackageId;   // (normal Attribute)
var $Quantity;   // (normal Attribute)
var $Comment;   // (normal Attribute)
var $IsQuantityPositive;   // (normal Attribute)
var $Timestamp;   // (normal Attribute)
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
function getDealerId()
{return $this->DealerId; }
function getDealerPackageId()
{return $this->DealerPackageId; }
function getQuantity()
{return $this->Quantity; }
function getComment()
{return $this->Comment; }
function getIsQuantityPositive()
{return $this->IsQuantityPositive; }
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

function setDealerId($val)
{
$this->DealerId =  $val;
}

function setDealerPackageId($val)
{
$this->DealerPackageId =  $val;
}

function setQuantity($val)
{
$this->Quantity =  $val;
}

function setComment($val)
{
$this->Comment =  $val;
}

function setIsQuantityPositive($val)
{
$this->IsQuantityPositive =  $val;
}

function setTimestamp($val)
{
$this->Timestamp =  $val;
}

function setStatus($val)
{
$this->Status =  $val;
}

// **********************
// SELECT METHOD / LOAD
// **********************

function select($id)
{

$sql =  "SELECT * FROM tbldealercredits WHERE Id = $id;";
$result =  mysql_query($sql);
$row = mysql_fetch_object($result);

$this->Id = $row->Id;$this->DealerId = $row->DealerId;$this->DealerPackageId = $row->DealerPackageId;$this->Quantity = $row->Quantity;$this->Comment = $row->Comment;$this->IsQuantityPositive = $row->IsQuantityPositive;$this->Timestamp = $row->Timestamp;$this->Status = $row->Status;}
// **********************
// DELETE
// **********************

function delete($id)
{
$sql = "DELETE FROM tbldealercredits WHERE Id = $id;";
$result = mysql_query($sql);

}

// **********************
// INSERT
// **********************

function insert()
{
$this->Id = ""; // clear key for autoincrement

$sql = "INSERT INTO tbldealercredits ( DealerId,DealerPackageId,Quantity,Comment,IsQuantityPositive,Timestamp,Status ) VALUES ( '$this->DealerId','$this->DealerPackageId','$this->Quantity','$this->Comment','$this->IsQuantityPositive','$this->Timestamp','$this->Status' )";
$result = mysql_query($sql);
$this->Id = mysql_insert_id();

}

// **********************
// UPDATE
// **********************

function update($id)
{
$sql = " UPDATE tbldealercredits SET  DealerId = '$this->DealerId',DealerPackageId = '$this->DealerPackageId',Quantity = '$this->Quantity',Comment = '$this->Comment',IsQuantityPositive = '$this->IsQuantityPositive',Timestamp = '$this->Timestamp',Status = '$this->Status' WHERE Id = $id ";
$result = mysql_query($sql);
}


public function addDealerCredits() 
{

	$SQL = " INSERT INTO tbldealercredits 
				SET 
					DealerId = " . $this->DealerId . ", 
					DealerPackageId = " . $this->DealerPackageId . ", 
					Quantity = " . $this->Quantity . ", 
					Comment = '" . $this->Comment . "', 
					IsQuantityPositive = " . $this->IsQuantityPositive . ", 
					Timestamp = '" . $this->Timestamp . "', 
					Status = " . $this->Status . "

					";
			//echo "<br/><br/><br/><br/><br/><br/>".$SQL;		
			
			$this->Id = parent::GetDALInstance()->SQLQuery($SQL,2);
			return $this->Id;
}

public function updateDealerCredits() 
	{
		
		$SQL = " UPDATE tbldealercredits 
		SET 
			DealerId = " . $this->DealerId . ", 
			DealerPackageId = " . $this->DealerPackageId . ", 
			Quantity = " . $this->Quantity . ", 
			Comment = '" . $this->Comment . "', 
			IsQuantityPositive = " . $this->IsQuantityPositive . ", 
			Timestamp = '" . $this->Timestamp . "', 
			Status = " . $this->Status  . "

        WHERE Id=".$this->Id;
		
		//echo "<br/><br/><br/><br/><br/><br/>".$SQL;
				
		// echo " <br/> ==> update =  " . $SQL . " <== <br/>";
        parent::GetDALInstance()->SQLQuery($SQL);
        
        return parent::GetDALInstance()->AffectedRows();

	}

function LoadCredits($Id, $GetChildren = false)
		{
			if(NumberCheck($Id))
			{
				$SQL = "SELECT * FROM tbldealercredits WHERE Id=".$Id;
				parent::GetDALInstance()->SQLQuery($SQL);

				$row = parent::GetDALInstance()->GetRow(false);
				if($row)
				{
					$this->Id = $row['Id'];
					$this->DealerId = $row['DealerId'];
					$this->DealerPackageId = $row['DealerPackageId'];
					$this->Quantity = $row['Quantity'];
					$this->Comment = $row['Comment'];
					$this->IsQuantityPositive = $row['IsQuantityPositive'];
					$this->Timestamp = $row['Timestamp'];
					$this->Status = $row['Status'];

					return true;
				}
			}

			return false;
		}

public function CountPositive($DealerId,$DealerPackageId )
	{
		$SQL = "SELECT sum(Quantity) AS 'Positive' 
				FROM tbldealercredits 
				WHERE Status = 1 AND IsQuantityPositive=1 AND DealerId=" . $DealerId . " AND DealerPackageId =" . $DealerPackageId 
				
		;

		//echo  "\n". $SQL . "\n";

		parent::GetDALInstance()->SQLQuery($SQL);
		$row = parent::GetDALInstance()->GetRow();

		return ($row) ? $row["Positive"] : 0;
	}


public function CountNegative($DealerId,$DealerPackageId )
	{
		$SQL = "SELECT sum(Quantity) AS 'Negative' 
				FROM tbldealercredits 
				WHERE Status = 1 AND IsQuantityPositive=0 AND DealerId=" . $DealerId . " AND DealerPackageId =" . $DealerPackageId 
				
		;

		//echo  "\n". $SQL . "\n";

		parent::GetDALInstance()->SQLQuery($SQL);
		$row = parent::GetDALInstance()->GetRow();

		return ($row) ? $row["Negative"] : 0;
	}




} // class : end
?>
