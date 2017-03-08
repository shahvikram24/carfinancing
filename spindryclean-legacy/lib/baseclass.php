<?php
	class BaseClass
	{
		public $DAL;
		public $EncryptData = false;
		protected $Encrypt;
		protected $Decrypt;
		protected $EnableCache = false;
		public  $range =12;

		function __construct()
		{
			global $DAL, $Decrypt, $Encrypt, $EnableCache;
			$this->DAL = $DAL;
			$this->Encrypt = $Encrypt;
			$this->Decrypt = $Decrypt;

			
		}

		/**
		* @desc Returns the current instance of the DAL. Use for static functions
		* @return DAL
		*/

		protected static function GetDALInstance()
		{
			global $DAL;
		
			if($DAL instanceof DAL)
				return $DAL;
			else
				return new DAL();
		}

		protected static function FormatDate($Date, $Format = 'Y-m-d H:i:s')
		{
			if($Date != '0000-00-00' && !IsEmpty($Date))
				return FormatDate($Date, $Format);
		}

		protected static function DateCheck($Date)
		{
			return DateCheck($Date);
		}

		protected static function NullCheck($Field)
		{
			return NullCheck($Field);
		}

		protected static function MoneyCheck($Field)
		{
			return MoneyCheck($Field);
		}
                function zeropad($number, $limit)
                {
                  return (strlen($number) >= $limit) ? $number : str_pad($number,$limit,'0',STR_PAD_LEFT);
                }

		protected static function CleanText($String)
		{
			return TextScrubber($String);
		}

		protected static function RevertText($String)
		{
			return TextRevert($String);
		}

		/**
		*@deprec This function will be removed. Do not rely on usage. Use NumberCheck instead.
		*/
		protected static function NumberCheck(&$Id, $ClassId = null)
		{
			return NumberCheck($Id, $ClassId);
		}

		protected function PrintClassVariables($Object)
		{
			return PrintClassVariables($Object);
		}

		protected static function PrintTimestamp($Format = false)
		{
			return PrintTimestamp($Format);
		}

		function __wakeup()
		{
			$this->__construct();
		}
		
		function getStartMonth($range)
		{
			$month = date('m');
			$year = date('Y');
		
			$startMonth=$month-$range;
			$startYear = $year;
		
			if($startMonth == 0)
			{
				$startMonth = 12;
				$startYear--;
			}
			
			else if($startMonth < 0)
			{
				$startMonth = $startMonth + 12;
				$startYear--;
			}
		
			return strftime("%Y-%m", strtotime($startYear."-".$startMonth));
		}


		function getArrayOfMonths()
		{
			$obj = new BaseClass();
			$range = $obj->range;
			$startMonth = BaseClass::getStartMonth($range);
			
			$ArrayOfMonths=array();
			$currentOperationMonth = substr($startMonth,5,8);
			$currentOperationYear =substr($startMonth,0,4);
		
		
			for($x = 0 ;$x < $range ; $x ++)
			{
				if($currentOperationMonth > 12 )
				{
					$currentOperationMonth = $currentOperationMonth - 12 ;
					$currentOperationYear++;
				}

				$month = $currentOperationYear."-".str_pad ($currentOperationMonth, 2, "0", STR_PAD_LEFT);
			
				array_push($ArrayOfMonths,$month) ;
				$currentOperationMonth +=1;
			} 
			
			return $ArrayOfMonths;
		}
	}
?>
