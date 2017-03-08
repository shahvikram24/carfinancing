<?php
class Invoice extends BaseClass{
	public $Id;
	public $OrderId;
	public $CustomerId;
	public $InvoiceNumber;
	public $Discount = 0.00;
	public $TotalPrice;
	public $InvoiceStatus = 1;
	public $DueDate;
	public $Notes;
	public $Timestamp;
	public $Status = 1;


			/*
					Status = 0 :	Archived
					Status = 1 :	Active / Enabled
					Status = 2 :	Disabled

					InvoiceStatus = 0	:	Archived
					InvoiceStatus = 1	:	Inactive
					InvoiceStatus = 2	:	Active
					InvoiceStatus = 3	:	Paid
					InvoiceStatus = 4	:	Draft
					InvoiceStatus = 5	:	Dispute



			*/

	public function __construct()
	{
		$Status = 1;
		$InvoiceStatus = 1;
		$Discount = 0.00;
	}

	public function loadInvoice($Condition = '')
	{
		
				
		$SQL = "SELECT * FROM tblinvoice ";

		if($Condition) 
			$SQL .= " WHERE " . $Condition;
		

		parent::GetDALInstance()->SQLQuery($SQL);
		$row = parent::GetDALInstance()->GetRow(false);
			
			if($row)
			{
				$this->Id = $row['Id'];
				$this->OrderId = $row['OrderId'];
				$this->CustomerId = $row['CustomerId'];
				$this->InvoiceNumber = $row['InvoiceNumber'];
				$this->Discount = $row['Discount'];
				$this->TotalPrice = $row['TotalPrice'];
				$this->InvoiceStatus = $row['InvoiceStatus'];
				$this->DueDate = $row['DueDate'];
				$this->Notes = $row['Notes'];
				$this->Timestamp = $row['Timestamp'];
				$this->Status = $row['Status'];
				
				
				return $this;
			}
			return false;

	}

	public function addInvoice() 
	{
  		$SQL = " INSERT INTO tblinvoice 
				SET 
					OrderId = " . $this->OrderId . ", 
					CustomerId = " . $this->CustomerId . ", 
					InvoiceNumber = '" . $this->InvoiceNumber . "',  
					Discount = " . $this->Discount . " ,
					TotalPrice = " . $this->TotalPrice . " ,
					InvoiceStatus = " . $this->InvoiceStatus . " ,
					DueDate = '" . $this->DueDate . "' ,
					Notes = '" . $this->Notes . "' ,
					Timestamp = '" . $this->Timestamp . "' ,
					Status = " . $this->Status . " 
					";
			//echo "<br/><br/><br/><br/><br/><br/>".$SQL;		
			$this->Id = parent::GetDALInstance()->SQLQuery($SQL,2);
			return $this->Id;
	}

	public function updateInvoice() 
	{
  		$SQL = " UPDATE tblinvoice 
				SET 
					OrderId = " . $this->OrderId . ", 
					CustomerId = " . $this->CustomerId . ", 
					InvoiceNumber = '" . $this->InvoiceNumber . "',  
					Discount = " . $this->Discount . " ,
					TotalPrice = " . $this->TotalPrice . " ,
					InvoiceStatus = " . $this->InvoiceStatus . " ,
					DueDate = '" . $this->DueDate . "' ,
					Notes = '" . $this->Notes . "' ,
					Timestamp = '" . $this->Timestamp . "' ,
					Status = " . $this->Status . " 
					WHERE Id=".$this->Id;
			//echo "<br/><br/><br/><br/><br/><br/>".$SQL;		
			return parent::GetDALInstance()->SQLQuery($SQL);
	}

	public function GetInvoiceList()
		{
			
				$SQL = "SELECT * FROM tblinvoice I
						WHERE I.Status IN (1) 
						";

					//echo "<br/>" . $SQL;

				$ResultSet = new ResultSet();
				if($ResultSet->LoadResult($SQL))
					return $ResultSet;
				else
					return false;
		}

	public function archiveInvoice($IdArray) 
	{
  		$SQL = " UPDATE tblinvoice 
				SET 
					Status = 0 
				WHERE Id IN (" . $IdArray . ")

			";
		//echo "<br/><br/><br/><br/><br/><br/>".$SQL;		
		return parent::GetDALInstance()->SQLQuery($SQL);
	}

	public function CheckInvoiceExist($OrderId)
        {
            $SQL = "SELECT Id
                    FROM tblinvoice 
                    WHERE OrderId=".$OrderId;

                //echo "<br/><br/><br/><br/><br/><br/>".$SQL;	
                parent::GetDALInstance()->SQLQuery($SQL);
				
				$row = parent::GetDALInstance()->GetRow();
				return ($row) ? true : false;
			

		}

	public function GetTotal($OrderId)
		{
			$SQL = "SELECT TotalPrice AS 'Total' 
					FROM tblinvoice 
					WHERE Status IN (1,2) AND OrderId = " . $OrderId 
					
			;

			//echo  "\n". $SQL . "\n";

			parent::GetDALInstance()->SQLQuery($SQL);
			$row = parent::GetDALInstance()->GetRow();

			return ($row) ? $row['Total'] : 0;
		}
}
