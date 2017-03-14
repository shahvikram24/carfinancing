<?php


class AffiliateTransaction extends BaseClass{
	public $affiliatetransactionid;
	public $affiliateid;
	public $contactinfoid;
	public $description;
	public $amount;
	public $dateadded;
	public $status;
	
	
	
	public function loadTransaction() {
	
			
		$SQL = "SELECT * FROM affiliatetransaction WHERE status = 1";
		$ResultSet = new ResultSet();

			if($ResultSet->LoadResult($SQL))
			{
				
				return $ResultSet;
			}
		
		return false;

	}
		

		public function loadTransactionId($affiliatetransactionid) {
		
				
			$SQL = "SELECT * FROM affiliatetransaction WHERE affiliatetransactionid = " . $affiliatetransactionid ;
			parent::GetDALInstance()->SQLQuery($SQL);
			$row = parent::GetDALInstance()->GetRow(false);

			//echo "<br/><br/><br/><br/><br/><br/>".$SQL;			
					if($row)
					{
						$this->affiliatetransactionid = $row['affiliatetransactionid'];
						$this->affiliateid = $row['affiliateid'];
						$this->contactinfoid = $row['contactinfoid'];
						$this->description = $row['description'];
						$this->amount = $row['amount'];
						$this->dateadded = $row['dateadded'];
						$this->status = $row['status'];
						
						return $this;
					}
					return false;

				}


		
		public function addTransaction() 
		{
      		$SQL = " INSERT INTO affiliatetransaction 
					SET 
						affiliateid = " . $this->affiliateid . ", 
						contactinfoid = " . $this->contactinfoid . ", 
						description = " . $this->description . ", 
						amount = " . $this->amount . ", 
						dateadded =  NOW(), 						
						status = " . $this->status 
					;
				
				//echo "<br/><br/><br/><br/><br/><br/>".$SQL;			

				$this->affiliatetransactionid = parent::GetDALInstance()->SQLQuery($SQL, 2);
				return $this->affiliatetransactionid;
		}
		
		
		public function UpdateTransaction() 
		{
      			$SQL = " UPDATE affiliatetransaction 
				SET 
						affiliateid = " . $this->affiliateid . ", 
						contactinfoid = " . $this->contactinfoid . ", 
						description = " . $this->description . ", 
						amount = " . $this->amount . ", 
						status = " . $this->status . 

					" WHERE affiliatetransactionid=".$this->affiliatetransactionid;
						
						
						
				parent::GetDALInstance()->SQLQuery($SQL);
		        return parent::GetDALInstance()->AffectedRows();
		
		}

		public function loadTransactionByContactInfo($contactinfoid) {
		
				
			$SQL = "SELECT * FROM affiliatetransaction WHERE contactinfoid = " . $contactinfoid ;
			parent::GetDALInstance()->SQLQuery($SQL);
			$row = parent::GetDALInstance()->GetRow(false);

			//echo "<br/><br/><br/><br/><br/><br/>".$SQL;			
					if($row)
					{
						$this->affiliatetransactionid = $row['affiliatetransactionid'];
						$this->affiliateid = $row['affiliateid'];
						$this->contactinfoid = $row['contactinfoid'];
						$this->description = $row['description'];
						$this->amount = $row['amount'];
						$this->dateadded = $row['dateadded'];
						$this->status = $row['status'];
						
						return $this;
					}
					return false;

				}

		public function loadByAffiliate($affiliateid) {
		
				
			$SQL = "SELECT * FROM affiliatetransaction  WHERE affiliateid = " . $affiliateid .
					" Order By dateadded DESC "
			;
			//echo "<br/><br/><br/><br/><br/><br/>".$SQL;	
			$ResultSet = new ResultSet();
				if($ResultSet->LoadResult($SQL))
					return $ResultSet;
			
			return false;

		}

		public function getAffiliateCode($ContactId)
		{
			$SQL = "SELECT affiliateid 
				FROM affiliatetransaction 
				WHERE contactinfoid = " . $ContactId ;

			//echo  "\n". $SQL . "\n";

			parent::GetDALInstance()->SQLQuery($SQL);
			$row = parent::GetDALInstance()->GetRow();

			return ($row) ? $row["affiliateid"] : false;
		}
	
  	public function Count($affiliateid, $condition='')
	{
		$SQL = "SELECT count(*) AS 'TotalLeads'
				FROM affiliatetransaction 
				WHERE affiliateid = " . $affiliateid

		;

		if($condition !='')
		{
			$SQL .= ' AND ' . $condition;
		}

		parent::GetDALInstance()->SQLQuery($SQL);
		$row = parent::GetDALInstance()->GetRow();

		return ($row) ? $row["TotalLeads"] : 0;
	}

	public function UpdateConditionally($value, $condition) 
		{
      			$SQL = " UPDATE affiliatetransaction SET " . $value . " WHERE " . $condition;						
						
						
				parent::GetDALInstance()->SQLQuery($SQL);
		        return parent::GetDALInstance()->AffectedRows();
		
		}



}
?>