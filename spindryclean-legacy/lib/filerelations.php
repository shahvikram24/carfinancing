<?php
class FileRelations extends BaseClass
	{
		public $Id = false;
		public $FileId = false;
		public $OrderId = false;
		
		public $Status = 0;

		function __construct()
		{
			parent::__construct();
		}

		function InsertRelation()
		{
			$FileId = NullCheck($this->FileId);
			$OrderId = NullCheck($this->OrderId);
			

			$SQL = "INSERT INTO tblfilerelations SET FileId=".$FileId.", 
					OrderId=".$OrderId.", 
					Status=".$this->Status;
                        
            $this->Id = parent::GetDALInstance()->SQLQuery($SQL, 2);

			return $this->Id;
		}

		

	}
?>