<?php
class NotesRelations extends BaseClass
	{
		public $Id = false;
		public $NotesId = false;
		public $ContactId = false;
		public $AffiliateId = false;
		public $ContactInfoId = false;
		
		public $Status = 1;

		function __construct()
		{
			parent::__construct();
		}

		function InsertRelation()
		{
			$NotesId = NullCheck($this->NotesId);
			$ContactId = NullCheck($this->ContactId);
			$AffiliateId = NullCheck($this->AffiliateId);
			$ContactInfoId = NullCheck($this->ContactInfoId);
			

			$SQL = "INSERT INTO tblnotesrelation SET NotesId=".$NotesId.", 
					ContactId=".$ContactId.", 
					AffiliateId=".$AffiliateId.", 
					ContactInfoId=".$ContactInfoId.", 
					Status=".$this->Status;
                        
                        $this->Id = parent::GetDALInstance()->SQLQuery($SQL, 2);

			return $this->Id;
		}

		

	}
?>