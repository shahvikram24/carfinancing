<?php


class InvoiceTransactions extends BaseClass {
	public $Id;
	public $OrderId;
	public $Amount;
	public $DateAdded;
	public $Status;
	
	
	
  	public function loadTransactions($Condition = '') {
		
				
	$SQL = "SELECT * FROM tblinvoicetransactions ";

	if($Condition) 
			$SQL .= " WHERE " . $Condition;

		//echo "<br/><br/><br/><br/><br/><br/>".$SQL;
	parent::GetDALInstance()->SQLQuery($SQL);
		$row = parent::GetDALInstance()->GetRow(false);
			
			if($row)
			{
				$this->Id = $row['Id'];
				$this->OrderId = $row['OrderId'];
				$this->Amount = $row['Amount'];
				$this->DateAdded = $row['DateAdded'];
				$this->Status = $row['Status'];
				
				
				return $this;
			}
			return false;

	}
		
		
		public function addTransactions() 
		{
      		$SQL = " INSERT INTO tblinvoicetransactions 
				SET 
					OrderId = " . $this->OrderId . ", 
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
      			$SQL = " UPDATE tblinvoicetransactions 
				SET 
					OrderId = " . $this->OrderId . ", 
					Amount = " . $this->Amount . ", 
					DateAdded = '" . $this->DateAdded . "', 
					Status = " . $this->Status . " 
					WHERE Id=".$this->Id;
			//echo "<br/><br/><br/><br/><br/><br/>".$SQL;		
			return parent::GetDALInstance()->SQLQuery($SQL);
		
		}

		public function GetTransactionList()
		{
			
				$SQL = "SELECT * FROM tblinvoicetransactions IT
						WHERE IT.Status IN (1) 
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
					FROM tblinvoicetransactions 
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
					FROM tblinvoicetransactions 
					WHERE " . $Field2 . "=" . $Id 
					
			;

			//echo  "\n". $SQL . "\n";

			parent::GetDALInstance()->SQLQuery($SQL);
			$row = parent::GetDALInstance()->GetRow();

			return ($row) ? $row['Total'] : 0;
		}
  		
  		public function CheckInvoiceTransactionsExist($OrderId)
        {
            $SQL = "SELECT Id
                    FROM tblinvoicetransactions 
                    WHERE OrderId=".$OrderId;

                //echo "<br/><br/><br/><br/><br/><br/>".$SQL;	
                parent::GetDALInstance()->SQLQuery($SQL);
				
				$row = parent::GetDALInstance()->GetRow();
				return ($row) ? true : false;
			

		}
}
?>