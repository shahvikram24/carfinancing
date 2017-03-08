<?php


class CustomerTransactions extends BaseClass{
	public $Id;
	public $CustomerId;
	public $PackageId;
	public $Amount;
	public $DateAdded;
	public $Status;
	
	
	
  	public function loadTransactions($Condition = '') {
		
				
	$SQL = "SELECT * FROM tblcustomertransactions ";

	if($Condition) 
			$SQL .= " WHERE " . $Condition;

		//echo "<br/><br/><br/><br/><br/><br/>".$SQL;
	parent::GetDALInstance()->SQLQuery($SQL);
		$row = parent::GetDALInstance()->GetRow(false);
			
			if($row)
			{
				$this->Id = $row['Id'];
				$this->CustomerId = $row['CustomerId'];
				$this->PackageId = $row['PackageId'];
				$this->Amount = $row['Amount'];
				$this->DateAdded = $row['DateAdded'];
				$this->Status = $row['Status'];
				
				
				return $this;
			}
			return false;

	}
		
		
		public function addTransactions() 
		{
      		$SQL = " INSERT INTO tblcustomertransactions 
				SET 
					CustomerId = " . $this->CustomerId . ", 
					PackageId = " . $this->PackageId . ", 
					Amount = " . $this->Amount . ", 
					DateAdded = '" . $this->DateAdded . "', 
					Status = " . $this->Status . "
					";
			//echo "<br/><br/><br/><br/><br/><br/>".$SQL;		
			$this->Id = parent::GetDALInstance()->SQLQuery($SQL,2);
			return $this->Id;
		}
		
		
		public function UpdateTransactions() 
		{
      			$SQL = " UPDATE tblcustomertransactions 
				SET 
					CustomerId = " . $this->CustomerId . ", 
					PackageId = " . $this->PackageId . ", 
					Amount = " . $this->Amount . ", 
					DateAdded = '" . $this->DateAdded . "', 
					Status = " . $this->Status . " 
					WHERE Id=".$this->Id;
			//echo "<br/><br/><br/><br/><br/><br/>".$SQL;		
			return parent::GetDALInstance()->SQLQuery($SQL);
		
		}

		public function GetTransactionList()
		{
			
				$SQL = "SELECT * FROM tblcustomertransactions C
						WHERE C.Status IN (1) 
						Order By DateStart
						";

					//echo "<br/>" . $SQL;

				$ResultSet = new ResultSet();
				if($ResultSet->LoadResult($SQL))
					return $ResultSet;
				else
					return false;
		}

		public function GetField($Field, $Field2, $Id)
		{
			$SQL = "SELECT " . $Field . " 
					FROM tblcustomertransactions 
					WHERE Status = 1 AND " . $Field2 . "=" . $Id 
					
			;

			//echo  "\n". $SQL . "\n";

			parent::GetDALInstance()->SQLQuery($SQL);
			$row = parent::GetDALInstance()->GetRow();

			return ($row) ? $row[$Field] : 0;
		}

		public function GetPrevious($Field, $Field2, $Id)
		{
			$SQL = "SELECT sum(" . $Field . ") AS 'Total'
					FROM tblcustomertransactions 
					WHERE " . $Field2 . "=" . $Id 
					
			;

			//echo  "\n". $SQL . "\n";

			parent::GetDALInstance()->SQLQuery($SQL);
			$row = parent::GetDALInstance()->GetRow();

			return ($row) ? $row['Total'] : 0;
		}
  		
}
?>