
<?php
/*
*
* -------------------------------------------------------
* CLASSNAME:        Package
* CREATION DATE:    07.08.2015
* CLASS FILE:       class.Package.php
* FOR MYSQL TABLE:  tblpackage
* FOR MYSQL DB:     SuperCarLoans
* -------------------------------------------------------
*
*/



// **********************
// CLASS DECLARATION
// **********************

class Package extends BaseClass
{ // class : begin


// **********************
// ATTRIBUTE DECLARATION
// **********************

var $Id;   // KEY ATTR. WITH AUTOINCREMENT

var $Name;   // (normal Attribute)
var $Description;   // (normal Attribute)
var $Price;   // (normal Attribute)
var $Apps;   // (normal Attribute)
var $RecurringId;   // (normal Attribute)
var $Rank;   // (normal Attribute)
var $Status;   // (normal Attribute)
public $RecurringRelation = false;
// **********************
// CONSTRUCTOR METHOD
// **********************


function __construct()
		{
			parent::__construct();
		}



// **********************
// SELECT METHOD / LOAD
// **********************

function select($id)
{

$sql =  "SELECT * FROM tblpackage WHERE Id = $id;";
$result =  mysql_query($sql);
$row = mysql_fetch_object($result);

$this->Id = $row->Id;$this->Name = $row->Name;$this->Description = $row->Description;$this->Price = $row->Price;$this->Apps = $row->Apps;$this->RecurringId = $row->RecurringId;$this->Rank = $row->Rank;$this->Status = $row->Status;}
// **********************
// DELETE
// **********************

function delete($id)
{
$sql = "DELETE FROM tblpackage WHERE Id = $id;";
$result = mysql_query($sql);

}

// **********************
// INSERT
// **********************

function insert()
{
$this->Id = ""; // clear key for autoincrement

$sql = "INSERT INTO tblpackage ( Name,Description,Price,Apps,RecurringId,Rank,Status ) VALUES ( '$this->Name','$this->Description','$this->Price','$this->Apps','$this->RecurringId','$this->Rank','$this->Status' )";
$result = mysql_query($sql);
$this->Id = mysql_insert_id();

}

// **********************
// UPDATE
// **********************

function update($id)
{
$sql = " UPDATE tblpackage SET  Name = '$this->Name',Description = '$this->Description',Price = '$this->Price',Apps = '$this->Apps',RecurringId = '$this->RecurringId',Rank = '$this->Rank',Status = '$this->Status' WHERE Id = $id ";
$result = mysql_query($sql);
}


function LoadPackage($Id, $GetChildren = false)
		{
			if(NumberCheck($Id))
			{
				$SQL = "SELECT * FROM tblpackage WHERE Id=".$Id;
				parent::GetDALInstance()->SQLQuery($SQL);

				$row = parent::GetDALInstance()->GetRow(false);
				if($row)
				{
					$this->Id = $row['Id'];
					$this->Name = $row['Name'];
					$this->Description = $row['Description'];
					$this->Price = $row['Price'];
					$this->Apps = $row['Apps'];
					$this->RecurringId = $row['RecurringId'];
					$this->Rank = $row['Rank'];
					$this->Status = $row['Status'];

					if($GetChildren)
					{
						$this->RecurringRelation = new Recurring();
						if(!$this->RecurringRelation->LoadRecurrance($this->RecurringId))
							$this->RecurringRelation = false;
					}

					return true;
				}
			}

			return false;
		}


static function GetPackages($PackageId = false , $IncludeFreeAccount = false, $SQLWhere = '')
		{
			$SQL = "SELECT P.*, R.Name AS Recurring FROM tblpackage P 
					JOIN tblrecurring R ON P.RecurringId=R.Id 
					WHERE ".$SQLWhere." ORDER BY P.Rank ASC";

			//echo '<br />------  SQL = '. $SQL .'<br />';

			$ResultSet = new ResultSet();
			if($ResultSet->LoadResult($SQL))
				return $ResultSet;
		}


public function GetName($Id)
	{
		$SQL = "SELECT Name 
				FROM tblpackage 
				WHERE Status = 1 AND Id=" . $Id 
				
		;

		//echo  "\n". $SQL . "\n";

		parent::GetDALInstance()->SQLQuery($SQL);
		$row = parent::GetDALInstance()->GetRow();

		return ($row) ? $row["Name"] : 0;
	}


public function GetApps($Id)
	{
		$SQL = "SELECT Apps 
				FROM tblpackage 
				WHERE Status = 1 AND Id=" . $Id 
				
		;

		//echo  "\n". $SQL . "\n";

		parent::GetDALInstance()->SQLQuery($SQL);
		$row = parent::GetDALInstance()->GetRow();

		return ($row) ? $row["Apps"] : 0;
	}

} // class : end
?>
