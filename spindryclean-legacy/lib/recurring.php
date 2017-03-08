
<?php
/*
*
* -------------------------------------------------------
* CLASSNAME:        Recurring
* CREATION DATE:    07.08.2015
* CLASS FILE:       class.Recurring.php
* FOR MYSQL TABLE:  tblrecurring
* FOR MYSQL DB:     supercarloans
* -------------------------------------------------------
*
*/



// **********************
// CLASS DECLARATION
// **********************

class Recurring extends BaseClass
{ // class : begin


// **********************
// ATTRIBUTE DECLARATION
// **********************

var $Id;   // KEY ATTR. WITH AUTOINCREMENT

var $Name;   // (normal Attribute)
var $Status;   // (normal Attribute)
// **********************
// CONSTRUCTOR METHOD
// **********************

function Recurring()
{
}


function __construct()
		{
			parent::__construct();
		}

// **********************
// GETTER METHODS
// **********************


function getId()
{return $this->Id; }
function getName()
{return $this->Name; }
function getStatus()
{return $this->Status; }
// **********************
// SETTER METHODS
// **********************


function setId($val)
{
$this->Id =  $val;
}

function setName($val)
{
$this->Name =  $val;
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

$sql =  "SELECT * FROM tblrecurring WHERE Id = $id;";
$result =  mysql_query($sql);
$row = mysql_fetch_object($result);

$this->Id = $row->Id;$this->Name = $row->Name;$this->Status = $row->Status;}
// **********************
// DELETE
// **********************

function delete($id)
{
$sql = "DELETE FROM tblrecurring WHERE Id = $id;";
$result = mysql_query($sql);

}

// **********************
// INSERT
// **********************

function insert()
{
$this->Id = ""; // clear key for autoincrement

$sql = "INSERT INTO tblrecurring ( Name,Status ) VALUES ( '$this->Name','$this->Status' )";
$result = mysql_query($sql);
$this->Id = mysql_insert_id();

}

// **********************
// UPDATE
// **********************

function update($id)
{
$sql = " UPDATE tblrecurring SET  Name = '$this->Name',Status = '$this->Status' WHERE Id = $id ";
$result = mysql_query($sql);
}


function LoadRecurrance($Id)
		{
			if(NumberCheck($Id))
			{
				$SQL = "SELECT * FROM tblrecurring WHERE Id=".$Id;

				parent::GetDALInstance()->SQLQuery($SQL);

				$row = parent::GetDALInstance()->GetRow(false);

				if($row)
				{
					$this->Id = $row['Id'];
					$this->Name = $row['Name'];
					$this->Status = $row['Status'];

					return true;
				}
			}

			return false;
		}

	

} // class : end
?>
