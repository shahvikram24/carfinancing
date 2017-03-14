<?php
class Login extends BaseClass{
	public $Id;
	public $CustomerId;
	public $EmailId;
	public $SALT;
	public $HASH;
	public $Timestamp;
	public $Status;
	

	/*

		Status:
					0:	Activation email sent and waiting to activate 
					1:	Active user					
					3:	Account closed by admin. Only admin can undo. and set account to 1
	*/
	
  	public function loadcustomerinfo($Id) {
		
				
	$SQL = "SELECT * FROM tbllogin WHERE Id = " . $Id . " AND Status = 1";
	parent::GetDALInstance()->SQLQuery($SQL);
	$row = parent::GetDALInstance()->GetRow(false);
			
			if($row)
			{
				$this->Id = $row['Id'];
				$this->CustomerId = $row['CustomerId'];
				$this->EmailId = $row['EmailId'];
				$this->SALT = $row['SALT'];
				$this->HASH = $row['HASH'];
				$this->Timestamp = $row['Timestamp'];
				$this->Status = $row['Status'];
				
				
				return $this;
			}
			return false;

		}
		
		
		public function addCustomerInfo() 
		{
      		$SQL = " INSERT INTO tbllogin 
					SET Id = '" . $this->Id . "', 
						CustomerId = " . $this->CustomerId . ", 
						EmailId = '" . $this->EmailId . "', 
						SALT = '" . $this->SALT . "', 
						HASH = '" . $this->HASH . "', 
						Timestamp = null, 
						Status = " . $this->Status . "
						";
				
				//echo "<br/><br/><br/><br/><br/><br/>".$SQL;
				$this->Id = parent::GetDALInstance()->SQLQuery($SQL, 2);
				return $this->Id;
		}
		
		
		public function UpdateCustomerInfo($Id) 
		{
      			$SQL = " UPDATE tbllogin 
				SET Id = '" . $this->Id . "',
						CustomerId = " . $this->CustomerId . ", 
						EmailId = '" . $this->EmailId . "', 
						SALT = '" . $this->SALT . "', 
						HASH = '" . $this->HASH . "', 
						Timestamp = null, 
						Status = " . $this->Status . "

						WHERE Id=".$Id;
						
						//echo "<br/><br/><br/><br/><br/><br/>".$SQL;
						
				parent::GetDALInstance()->SQLQuery($SQL);
		        return parent::GetDALInstance()->AffectedRows();
		
		}
  		
	public function loadcustomerinfobycustomerid($CustomerId) {
		
				
	$SQL = "SELECT * FROM tbllogin WHERE CustomerId = " . $CustomerId ;
	parent::GetDALInstance()->SQLQuery($SQL);
	$row = parent::GetDALInstance()->GetRow(false);
		//echo "<br/><br/><br/><br/><br/><br/>".$SQL;	
			if($row)
			{
				$this->Id = $row['Id'];
				$this->CustomerId = $row['CustomerId'];
				$this->EmailId = $row['EmailId'];
				$this->SALT = $row['SALT'];
				$this->HASH = $row['HASH'];
				$this->Timestamp = $row['Timestamp'];
				$this->Status = $row['Status'];
				
				
				return $this;
			}
			return false;

		}

	public function CheckUserByLogin($UserLogin)
        {
            $SQL = "SELECT CustomerId
                    FROM tbllogin 
                    WHERE EmailId='".$UserLogin."'";
                
                parent::GetDALInstance()->SQLQuery($SQL);
				//echo "<br/><br/><br/><br/><br/><br/>".$SQL;	
				$row = parent::GetDALInstance()->GetRow();
				return ($row) ? $row[0] : false;
			

		}
		
  	
}

?>