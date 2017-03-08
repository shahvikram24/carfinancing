<?php
class FileRelations extends BaseClass
	{
		public $Id = false;
		public $FileId = false;
		public $ContactId = false;
		public $AffiliateId = false;
		public $DealId = false;
		
		public $Status = 0;

		function __construct()
		{
			parent::__construct();
		}

		function InsertRelation()
		{
			$FileId = NullCheck($this->FileId);
			$ContactId = NullCheck($this->ContactId);
			$AffiliateId = NullCheck($this->AffiliateId);
			$DealId = NullCheck($this->DealId);
			

			$SQL = "INSERT INTO tblfilerelations SET FileId=".$FileId.", 
					ContactId=".$ContactId.", 
					AffiliateId=".$AffiliateId.", 
					DealId=".$DealId.", 
					Status=".$this->Status;
                        
                        $this->Id = parent::GetDALInstance()->SQLQuery($SQL, 2);

			return $this->Id;
		}

		

	}
?>