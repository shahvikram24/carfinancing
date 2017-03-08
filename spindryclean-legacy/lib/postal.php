<?php
class PostalCode extends BaseClass{
	public $Id;
	public $Area;
	public $Status;
	

	
	
  	public function loadPostal() {
		
				
	$SQL = "SELECT * FROM tblpostalcode order by Area";
	//echo $SQL;
			
			$ResultSet = new ResultSet();
				if($ResultSet->LoadResult($SQL))
					return $ResultSet;
				else
					return false;

		}
		
		
		public function addPostalInfo() 
		{
      		$SQL = " INSERT INTO tblpostalcode 
					SET Id = '" . $this->Id . "', 
						Area = '" . strtoupper($this->Area) . "', 
						Status = " . $this->Status . "
						";
				
				//echo "<br/><br/><br/><br/><br/><br/>".$SQL;
				$this->Id = parent::GetDALInstance()->SQLQuery($SQL, 2);
				return $this->Id;
		}
		
		
		public function deletePostal($Id) 
		{
		
				
			$SQL = "Delete FROM tblpostalcode Where Id = ".$Id;
	
			
			parent::GetDALInstance()->SQLQuery($SQL);
				
				return parent::GetDALInstance()->AffectedRows();

		}


		public function checkPostal($Area) 
		{
		
			$SQL = "SELECT SUBSTRING(`Area`,1,3) FROM tblpostalcode WHERE Area like '".$Area . "%'";
				parent::GetDALInstance()->SQLQuery($SQL);
		
				//echo "<br/><br/><br/><br/><br/><br/>".$SQL;

				$row = parent::GetDALInstance()->GetRow();
				return ($row) ? true : false;

		}
	
		
  	
}
?>