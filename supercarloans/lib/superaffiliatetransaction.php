<?php


class SuperAffiliateTransaction extends BaseClass{
	public $superaffiliatetransactionid;
	public $superaffiliateid;
	public $affiliateid;
	public $description;
	public $amount;
	public $dateadded;
	public $status;
	
	
	
  	public function loadTransaction() {
		
				
	$SQL = "SELECT * FROM superaffiliatetransaction WHERE status = 1";
	$ResultSet = new ResultSet();

				if($ResultSet->LoadResult($SQL))
				{
					
					return $ResultSet;
				}
			
			return false;

		}
		

		public function loadTransactionId($superaffiliatetransactionid) {
		
				
			$SQL = "SELECT * FROM superaffiliatetransaction WHERE superaffiliatetransactionid = " . $superaffiliatetransactionid ;
			parent::GetDALInstance()->SQLQuery($SQL);
			$row = parent::GetDALInstance()->GetRow(false);

			//echo "<br/><br/><br/><br/><br/><br/>".$SQL;			
					if($row)
					{
						$this->superaffiliatetransactionid = $row['superaffiliatetransactionid'];
						$this->superaffiliateid = $row['superaffiliateid'];
						$this->affiliateid = $row['affiliateid'];
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
      		$SQL = " INSERT INTO superaffiliatetransaction 
					SET 
						superaffiliateid = " . $this->superaffiliateid . ", 
						affiliateid = " . $this->affiliateid . ", 
						description = '" . $this->description . "', 
						amount = " . $this->amount . ", 
						dateadded = '". $this->dateadded . "', 						
						status = " . $this->status 
					;
				
				//echo "<br/><br/><br/><br/><br/><br/>".$SQL;			

				$this->superaffiliatetransactionid = parent::GetDALInstance()->SQLQuery($SQL, 2);
				return $this->superaffiliatetransactionid;
		}
		
		
		public function UpdateTransaction() 
		{
      			$SQL = " UPDATE superaffiliatetransaction 
				SET 
						superaffiliateid = " . $this->superaffiliateid . ", 
						affiliateid = " . $this->affiliateid . ", 
						description = '" . $this->description . "', 
						amount = " . $this->amount . ", 
						status = " . $this->status . 

					" WHERE superaffiliatetransactionid=".$this->superaffiliatetransactionid;
						
						
						
				parent::GetDALInstance()->SQLQuery($SQL);
		        return parent::GetDALInstance()->AffectedRows();
		
		}

		public function loadTransactionByContactInfo($affiliateid) {
		
				
			$SQL = "SELECT * FROM superaffiliatetransaction WHERE affiliateid = " . $affiliateid ;
			parent::GetDALInstance()->SQLQuery($SQL);
			$row = parent::GetDALInstance()->GetRow(false);

			//echo "<br/><br/><br/><br/><br/><br/>".$SQL;			
					if($row)
					{
						$this->superaffiliatetransactionid = $row['superaffiliatetransactionid'];
						$this->superaffiliateid = $row['superaffiliateid'];
						$this->affiliateid = $row['affiliateid'];
						$this->description = $row['description'];
						$this->amount = $row['amount'];
						$this->dateadded = $row['dateadded'];
						$this->status = $row['status'];
						
						return $this;
					}
					return false;

				}

		public function loadByAffiliate($superaffiliateid) {
		
				
			$SQL = "SELECT  sat.superaffiliatetransactionid, sat.superaffiliateid, sat.amount, sat.dateadded, 
					at.contactinfoid, at.description, at.affiliateid 
					FROM superaffiliatetransaction sat 
					JOIN superaffiliate sa ON sa.superaffiliate_id = sat.superaffiliateid 
					JOIN affiliatetransaction at ON at.affiliatetransactionid = sat.affiliateid 
					WHERE sat.superaffiliateid = " . $superaffiliateid .
					" Order By at.dateadded DESC "
			;
			//echo "<br/><br/><br/><br/><br/><br/>".$SQL;	
			$ResultSet = new ResultSet();
				if($ResultSet->LoadResult($SQL))
					return $ResultSet;
			
			return false;

		}

		public function getAffiliateCode($ContactId)
		{
			$SQL = "SELECT superaffiliateid 
				FROM superaffiliatetransaction 
				WHERE affiliateid = " . $ContactId ;

			//echo  "\n". $SQL . "\n";

			parent::GetDALInstance()->SQLQuery($SQL);
			$row = parent::GetDALInstance()->GetRow();

			return ($row) ? $row["superaffiliateid"] : false;
		}
	
  		
}
?>