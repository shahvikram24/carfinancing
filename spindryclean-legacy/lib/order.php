<?php
class Order extends BaseClass{
	public $Id;
	public $OrderId;
	public $Instructions;
	
	public $LoginId;
	public $PickupDate;
	public $DropoffDate;
	public $Recurrancefreq;
	public $RecurringOn;
	public $OrderStatus;
	public $RejectReason;
	public $Timestamp;
	public $Status;

	public $PickupAfter;
	public $PickupBefore;

	
	
  	public function loadorder($Id) {
		
				
	$SQL = "SELECT * FROM tblorder WHERE Id = " . $Id . " AND Status = 1";
	parent::GetDALInstance()->SQLQuery($SQL);
	$row = parent::GetDALInstance()->GetRow(false);
	
	

			if($row)
			{
				$this->Id = $row['Id'];
				$this->OrderId = $row['OrderId'];
				$this->Instructions = $row['Instructions'];				
				$this->LoginId = $row['LoginId'];
				$this->PickupDate = $row['PickupDate'];
				$this->DropoffDate = $row['DropoffDate'];
				$this->Recurrancefreq = $row['Recurrancefreq'];
				$this->RecurringOn = $row['RecurringOn'];
				$this->OrderStatus = $row['OrderStatus'];
				$this->RejectReason = $row['RejectReason'];
				$this->Timestamp = $row['Timestamp'];
				$this->Status = $row['Status'];
				
				$this->PickupAfter = $row['PickupAfter'];
				$this->PickupBefore = $row['PickupBefore'];

				return $this;
			}
			return false;

		}
		
		
		public function addOrder() 
		{
      		$SQL = " INSERT INTO tblorder 
					SET Id = '" . $this->Id . "', 
						`OrderId` = '" . $this->OrderId . "', 
						`Instructions` = '" . $this->Instructions . "',				
						`LoginId` = " . $this->LoginId . ", 
						`PickupDate` = '" . $this->PickupDate . "', 
						`DropoffDate` = '" . $this->DropoffDate . "', 
						`Recurrancefreq` = " . $this->Recurrancefreq . ", 
						`RecurringOn` = " . $this->RecurringOn . ", 
						`OrderStatus` = '" . $this->OrderStatus . "', 
						`RejectReason` = '" . $this->RejectReason . "', 
						`PickupAfter` = '" . $this->PickupAfter . "', 
						`PickupBefore` = '" . $this->PickupBefore . "', 
						`Timestamp` = null, 
						Status = " . $this->Status . " 
						";
				//echo "<br/><br/><br/><br/><br/><br/>".$SQL;		
				$this->Id = parent::GetDALInstance()->SQLQuery($SQL,2);
				return $this->Id;
		}
		
		
		public function UpdateOrder($Id) 
		{
      			$SQL = " UPDATE tblorder 
				SET Id = " . $this->Id . ", 
						OrderId = '" . $this->OrderId . "',
						Instructions = '" . $this->Instructions . "',						
						LoginId = " . $this->LoginId . ", 
						PickupDate = '" . $this->PickupDate . "', 
						DropoffDate = '" . $this->DropoffDate . "', 
						Recurrancefreq = " . $this->Recurrancefreq . ", 
						RecurringOn = " . $this->RecurringOn . ", 
						OrderStatus = '" . $this->OrderStatus . "', 
						`RejectReason` = '" . $this->RejectReason . "', 
						`PickupAfter` = '" . $this->PickupAfter . "', 
						`PickupBefore` = '" . $this->PickupBefore . "', 
						Timestamp = null, 
						Status = " . $this->Status . "
						
						
						WHERE Id=".$Id;
						
						//echo "<br/><br/><br/><br/><br/><br/>".$SQL;
						
				parent::GetDALInstance()->SQLQuery($SQL);
		        return parent::GetDALInstance()->AffectedRows();
		
		}
  		
	
		public function GetCustomerOrderLsit($LoginId)
		{
			
				$SQL = "SELECT O.Id, O.OrderId, O.Instructions, O.PickupDate, O.DropOffDate, O.Recurrancefreq, O.PickupAfter, O.PickupBefore, 
						O.RecurringOn, O.OrderStatus, L.EmailId, O.Timestamp, O.RejectReason, 
						CONCAT_WS(' ',C.FirstName, C.LastName) AS ContactName, 
						C.Address1, C.Address2, C.City, C.Province, C.PostalCode,  C.Cellphone, 
						CASE WHEN O.Recurrancefreq =0 THEN 'One Time Order' ELSE 'Recurring Order' END AS 'Occurance'
						FROM tblorder O 
						JOIN tbllogin L ON L.Id=O.LoginId
						JOIN tblcustomer C ON C.Id=L.CustomerId
						WHERE O.Status NOT IN (0,3) AND C.Status=1 AND L.Status=1 
								AND O.LoginId = '" . $LoginId ."' 
						Order By O.PickupDate
						";

					//echo "<br/>" . $SQL;

				$ResultSet = new ResultSet();
				if($ResultSet->LoadResult($SQL))
					return $ResultSet;
				else
					return false;
		}

		public function GetOrderLsit()
		{
			
				$SQL = "SELECT O.Id, O.OrderId, O.Instructions, O.PickupDate, O.DropOffDate, O.Recurrancefreq, O.PickupAfter, O.PickupBefore, 
						O.RecurringOn, O.OrderStatus, L.EmailId, O.Timestamp, O.RejectReason, 
						CONCAT_WS(' ',C.FirstName, C.LastName) AS ContactName, 
						C.Address1, C.Address2, C.City, C.Province, C.PostalCode,  C.Cellphone, 
						CASE WHEN O.Recurrancefreq =0 THEN 'One Time Order' ELSE 'Recurring Order' END AS 'Occurance'
						FROM tblorder O 
						JOIN tbllogin L ON L.Id=O.LoginId
						JOIN tblcustomer C ON C.Id=L.CustomerId
						WHERE O.Status NOT IN (0) AND C.Status=1 AND L.Status=1
							/* AND O.PickupDate = '". FormatDate(NOW,'Y-m-d') . "' */
						Order By O.PickupDate
						";

					//echo "<br/>" . $SQL;

				$ResultSet = new ResultSet();
				if($ResultSet->LoadResult($SQL))
					return $ResultSet;
				else
					return false;
		}

		public function GetApprovalOrderLsit()
		{
			
				$SQL = "SELECT O.Id, O.OrderId, O.Instructions, O.PickupDate, O.DropOffDate, O.Recurrancefreq, O.PickupAfter, O.PickupBefore, 
						O.RecurringOn, O.OrderStatus, L.EmailId, O.Timestamp, O.RejectReason, 
						CONCAT_WS(' ',C.FirstName, C.LastName) AS ContactName, C.Id AS CustomerId, 
						C.Address1, C.Address2, C.City, C.Province, C.PostalCode,  C.Cellphone, 
						CASE WHEN O.Recurrancefreq =0 THEN 'One Time Order' ELSE 'Recurring Order' END AS 'Occurance'
						FROM tblorder O 
						JOIN tbllogin L ON L.Id=O.LoginId
						JOIN tblcustomer C ON C.Id=L.CustomerId
						WHERE O.Status =2 AND C.Status=1 AND L.Status=1
								AND O.OrderStatus = 'Order Placed' 
							/* AND O.PickupDate = '". FormatDate(NOW,'Y-m-d') . "' */
						Order By O.PickupDate
						";

					//echo "<br/>" . $SQL;

				$ResultSet = new ResultSet();
				if($ResultSet->LoadResult($SQL))
					return $ResultSet;
				else
					return false;
		}


		public function GetApprovedOrderLsit()
		{
			
				$SQL = "SELECT O.Id, O.OrderId, O.Instructions, O.PickupDate, O.DropOffDate, O.Recurrancefreq, O.PickupAfter, O.PickupBefore,  
						O.RecurringOn, O.OrderStatus, L.EmailId, O.Timestamp, O.RejectReason, O.LoginId, 
						CONCAT_WS(' ',C.FirstName, C.LastName) AS ContactName, 
						C.Address1, C.Address2, C.City, C.Province, C.PostalCode,  C.Cellphone, 
						CASE WHEN O.Recurrancefreq =0 THEN 'One Time Order' ELSE 'Recurring Order' END AS 'Occurance'
						FROM tblorder O 
						JOIN tbllogin L ON L.Id=O.LoginId
						JOIN tblcustomer C ON C.Id=L.CustomerId
						WHERE O.Status=1 AND C.Status=1 AND L.Status=1
							/* AND O.PickupDate = '". FormatDate(NOW,'Y-m-d') . "' */
						Order By O.PickupDate DESC
						";

					//echo "<br/>" . $SQL;

				$ResultSet = new ResultSet();
				if($ResultSet->LoadResult($SQL))
					return $ResultSet;
				else
					return false;
		}

		public function GetRejectedList()
		{
			
				$SQL = "SELECT O.Id, O.OrderId, O.Instructions, O.PickupDate, O.DropOffDate, O.Recurrancefreq, O.PickupAfter, O.PickupBefore,  
						O.RecurringOn, O.OrderStatus, L.EmailId, O.Timestamp, O.RejectReason, 
						CONCAT_WS(' ',C.FirstName, C.LastName) AS ContactName, 
						C.Address1, C.Address2, C.City, C.Province, C.PostalCode,  C.Cellphone, 
						CASE WHEN O.Recurrancefreq =0 THEN 'One Time Order' ELSE 'Recurring Order' END AS 'Occurance'
						FROM tblorder O 
						JOIN tbllogin L ON L.Id=O.LoginId
						JOIN tblcustomer C ON C.Id=L.CustomerId
						WHERE O.Status=3 AND C.Status=1 AND L.Status=1
						Order By O.PickupDate DESC
						";

					//echo "<br/>" . $SQL;

				$ResultSet = new ResultSet();
				if($ResultSet->LoadResult($SQL))
					return $ResultSet;
				else
					return false;
		}

		public function TodayPickup($date = '')
		{
			
				$SQL = "SELECT O.Id, O.OrderId, O.Instructions, O.PickupDate, O.DropOffDate, O.Recurrancefreq, O.PickupAfter, O.PickupBefore,  
						O.RecurringOn, O.OrderStatus, L.EmailId, O.Timestamp, O.RejectReason, 
						CONCAT_WS(' ',C.FirstName, C.LastName) AS ContactName, 
						C.Address1, C.Address2, C.City, C.Province, C.PostalCode,  C.Cellphone, 
						CASE WHEN O.Recurrancefreq =0 THEN 'One Time Order' ELSE 'Recurring Order' END AS 'Occurance'
						FROM tblorder O 
						JOIN tbllogin L ON L.Id=O.LoginId
						JOIN tblcustomer C ON C.Id=L.CustomerId
						WHERE O.Status=1 AND C.Status=1 AND L.Status=1 ";

					if($date!='')
						$SQL .= " AND O.PickupDate = '". $date . "' ";
					else
						$SQL .= " AND O.PickupDate = '". FormatDate(NOW,'Y-m-d') . "'";

					$SQL .= " Order By O.PickupDate DESC ";

					//echo "<br/>" . $SQL; die();

				$ResultSet = new ResultSet();
				if($ResultSet->LoadResult($SQL))
					return $ResultSet;
				else
					return false;
		}

		public function GetRejectedOrderLsit($CustomerId)
		{
			
				$SQL = "SELECT O.Id, O.OrderId, O.Instructions, O.PickupDate, O.DropOffDate, O.Recurrancefreq, O.PickupAfter, O.PickupBefore,  
						O.RecurringOn, O.OrderStatus, L.EmailId, O.Timestamp, O.RejectReason, 
						CONCAT_WS(' ',C.FirstName, C.LastName) AS ContactName, 
						C.Address1, C.Address2, C.City, C.Province, C.PostalCode,  C.Cellphone, 
						CASE WHEN O.Recurrancefreq =0 THEN 'One Time Order' ELSE 'Recurring Order' END AS 'Occurance'
						FROM tblorder O 
						JOIN tbllogin L ON L.Id=O.LoginId
						JOIN tblcustomer C ON C.Id=L.CustomerId
						WHERE O.Status=3 AND C.Status=1 AND L.Status=1 AND C.Id = " . $CustomerId . " 
							
						Order By O.PickupDate
						";

					//echo "<br/>" . $SQL;

				$ResultSet = new ResultSet();
				if($ResultSet->LoadResult($SQL))
					return $ResultSet;
				else
					return false;
		}
  	
  		public function GetInfoById($Id)
		{
			
				$SQL = "SELECT C.BusinessName, C.FirstName , C.LastName, C.Address1, C.Address2, C.City, C.Province, C.Postalcode, 
						C.Cellphone, L.EmailId, O.OrderId, O.PickupDate, O.RejectReason 
						FROM tblcustomer C 
						JOIN tbllogin L ON L.CustomerId=C.Id 
						JOIN tblorder O ON O.LoginId=L.Id 
						WHERE C.Status = 1  
							  AND C.Approved = 1
							  AND O.Id=".$Id;
						

					//echo "<br/>" . $SQL;

				$ResultSet = new ResultSet();
				if($ResultSet->LoadResult($SQL))
					return $ResultSet;
				else
					return false;
		}

		public function GetField($LoginId)
		{
			$SQL = "SELECT count(*) AS 'Total' 
					FROM tblorder 
					WHERE Status = 1 AND LoginId = " . $LoginId 
					
			;

			//echo  "\n". $SQL . "\n";

			parent::GetDALInstance()->SQLQuery($SQL);
			$row = parent::GetDALInstance()->GetRow();

			return ($row) ? $row['Total'] : 0;
		}

		public function GetTotal($LoginId)
		{
			$SQL = "SELECT count(*) AS 'Total' 
					FROM tblorder 
					WHERE Status IN (1,2) AND LoginId = " . $LoginId 
					
			;

			//echo  "\n". $SQL . "\n";

			parent::GetDALInstance()->SQLQuery($SQL);
			$row = parent::GetDALInstance()->GetRow();

			return ($row) ? $row['Total'] : 0;
		}

		public function GetAdminOrders($LoginId)
		{
			$SQL = "SELECT count(*) AS 'Total' 
					FROM tblorder 
					WHERE Status IN (1,2) AND LoginId = " . $LoginId 
					
			;

			//echo  "\n". $SQL . "\n";

			parent::GetDALInstance()->SQLQuery($SQL);
			$row = parent::GetDALInstance()->GetRow();

			return ($row) ? $row['Total'] : 0;
		}

		public function getOrderCount($Month)
		{
			$SQL = "SELECT count(*) AS Count FROM tblorder 
					WHERE MONTHNAME(PickupDate)='".$Month . "' AND Status = 1 ";
			parent::GetDALInstance()->SQLQuery($SQL);
			$row = parent::GetDALInstance()->GetRow(false);
			
			//echo "<br/>" . $SQL;


			if($row)
				return $row['Count'] ;
			else
				return false;
		}

		public function AcceptOrder($SqlQuery) 
		{
      			//echo "<br/><br/><br/><br/><br/><br/>".$SQL;
						
				parent::GetDALInstance()->SQLQuery($SqlQuery);
		        return parent::GetDALInstance()->AffectedRows();
		
		}
}
?>