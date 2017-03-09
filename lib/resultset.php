<?php
	class ResultSet extends BaseClass
	{
		public $TotalResults = 0;
		public $TotalPages = 0;
		public $ResultsPerPage = 25;
		public $Result = false;
		public $CurrentPage = false;
		public $CurrentPageResult = false;
		public $CurrentPageCount = 0;
		public $IsCached = false;
		public $PagingDataBindFunction = false;
		public $ColumnIndexes = false;		
                public $CurrentLetter = false;
		public $PagerColumn = false;

                public $PagerClass = 'pager';
					
		private $DataType = false;
		private $SortOrder = "ASC";
		private $SortExpression = false;
		private $OriginalResult = false;

                //this is to enable ajax functionality without rewriting code
                public $SQL = '';

		function __construct()
		{
			global  $PagerColumn , $CurrentLetter;
			$this->CurrentLetter = ($CurrentLetter) ? $CurrentLetter : false;
			$this->PagerColumn = ($PagerColumn) ? $PagerColumn : false;
			parent::__construct();
			
		}

		function LoadResult($SQL, $ForceReload = false, $CacheResult = true, $PrepareColumnIndexes = false)
		{
                    

                    if(empty($this->SQL)){
                        $this->SQL = $SQL;
                    }
                    
			if(!IsEmpty($SQL))
			{
				//echo $SQL; die('inside sql'); exit;
				$CacheKey = sha1(CurrentServer().$SQL);
				//$Result = (!$ForceReload) ? apc_fetch($CacheKey) : false;
				$Result = false;
				//echo $CacheKey . ' <br/> ' .  $Result;
				//die();

				if(!$Result || !$this->EnableCache || $ForceReload)
				{
					if($this->DAL->SQLQuery($SQL))
					{
						$this->Result = $this->DAL->GetArray();

                    
						if($this->Result)
						{
							$this->TotalResults = count($this->Result);
							//print_r($this->Result); die('total result sql'); exit;
							$this->TotalPages = ceil($this->TotalResults/$this->ResultsPerPage);

							if($PrepareColumnIndexes)
								$this->PrepareColumnIndexes($PrepareColumnIndexes);

							
                        
							return true;
						}
					}
				}
				else
				{
					if($Result && !$this->CheckForTableChanges($SQL, $CacheKey))
					{
						global $CacheCount;

						$this->Result = $Result;
						$this->TotalResults = count($this->Result);
						$this->TotalPages = ceil($this->TotalResults/$this->ResultsPerPage);
						$this->IsCached = true;

						$CacheCount += 1;

						return true;
					}
					else
						return $this->LoadResult($SQL, true, $CacheResult);
				}
			}

			return false;
		}

		private function PrepareColumnIndexes($Columns)
		{
			$Columns = (!is_array($Columns)) ? explode(',', $Columns) : $Columns;

			for($x = 0; $x <= $this->TotalResults - 1; $x++)
			{
				foreach($Columns as $Value)
				{
					$this->ColumnIndexes[$Value][] = $this->Result[$x][$Value];
				}
				unset($Value);
			}

			return true;
		}

		/**
		* Find()
		*
		* Loops through the entire array and returns either the first match, all matches or an entire column.
		*
		* @static no
		* @public yes
		* @param Name of Column string
		* @param Value string
		* @param 1 Return the first result; 2 = Return all occurances string
		* @return mixed
		*/

		function Find($ColumnName, $Value, $ReturnMode = 1)
		{
			$ReturnArray = array();
			$Found = ($ReturnMode == 3) ? true : false;

			for($x = 0; $x <= $this->TotalResults - 1; $x++)
			{
				if($this->Result[$x][$ColumnName] == $Value && $ReturnMode < 3)
				{
					if($ReturnMode == 2)
					{
						$ReturnArray[] = $this->Result[$x];
						$Found = true;
					}
					else if($ReturnMode == 1)
						return $this->Result[$x];
				}
				else
				{
					$ReturnArray[] = $this->Result[$x][$ColumnName];
				}
			}

			return ($ReturnMode > 1 && $Found) ? $ReturnArray : false;
		}

		function Recalculate()
		{
			$this->TotalResults = count($this->Result);
			$this->TotalPages = ceil($this->TotalResults / $this->ResultsPerPage);
			$this->IsCached = false;
		}

		function SortResultSet($SortExpression = false, $SortOrder = false, $DataType = 'string')
		{
			$this->SortOrder = $SortOrder;
			$this->SortExpression = $SortExpression;
			$this->DataType = $DataType;

			usort($this->Result, array($this, 'ColumnCompare'));
		}

		function ColumnCompare($arg1, $arg2)
		{
			switch(strtoupper($this->DataType))
			{
				case "NUMBER":
                                case "MONEY" :
					return $this->CompareNumber($arg1[$this->SortExpression], $arg2[$this->SortExpression], $this->SortOrder);

				case "DATETIME":
				case "DATE":
					return $this->CompareDate($arg1[$this->SortExpression], $arg2[$this->SortExpression], $this->SortOrder);

				default:
					return $this->CompareString($arg1[$this->SortExpression], $arg2[$this->SortExpression], $this->SortOrder);
			}
		}

		private function CompareString($arg1, $arg2, $SortOrder = false)
		{
			$Compare = strcasecmp($arg1, $arg2);

			if($Compare == 0)
				return 0;
			else if($SortOrder == "DESC")
				return ($Compare < 0) ? 1 : -1;
			else
				return $Compare;
		}

		private function CompareNumber($arg1, $arg2, $SortOrder = false)
		{
			$arg1 = (is_numeric($arg1)) ? $arg1 : false;
			$arg2 = (is_numeric($arg2)) ? $arg2 : false;

			if($arg1 == $arg2)
				return 0;
			else if($SortOrder == "DESC")
				return ($arg1 < $arg2) ? 1 : -1;
			else
				return ($arg1 < $arg2) ? -1 : 1;
		}

		private function CompareDate($arg1, $arg2, $SortOrder = false)
		{
			$arg1 = (is_numeric($arg1)) ? $arg1 : strtotime($arg1);
			$arg2 = (is_numeric($arg2)) ? $arg2 : strtotime($arg2);

			if($arg1 == $arg2)
				return 0;
			else if($SortOrder == "DESC")
				return ($arg1 < $arg2) ? 1 : -1;
			else
				return ($arg1 < $arg2) ? -1 : 1;
		}

		function CheckForTableChanges($SQL, $CacheKey)
		{
			$TableCache = apc_fetch("TABLECACHEKEY");

			if($TableCache)
			{
				preg_match_all("/tbl[a-z]{1,}/", $SQL, $TableNames);
				$TableNames = $TableNames[0];
				$TableCount = count($TableNames);
				$APCCache = apc_cache_info("user");
				$APCCache = $APCCache['cache_list'];

				$APCCount = count($APCCache);

				for($y = 0; $y <= $APCCount - 1; $y++)
				{
					if($CacheKey == $APCCache[$y]['info'])
					{
						$CreationTime = $APCCache[$y]['creation_time'];

						for($x = 0; $x <= $TableCount - 1; $x++)
						{
							if($CreationTime < $TableCache[$TableNames[$x]])
								return true;
						}

						break;
					}
				}
			}

			return false;
		}

		function GetPage($Page = 1)
		{
			if($this->Result)
			{
				if(!NumberCheck($Page) || $Page > $this->TotalPages)
					$Page = 1;
     
				$ReturnArray = array();

				for($x = ($Page * $this->ResultsPerPage - $this->ResultsPerPage); $x <= ($this->TotalPages * $this->ResultsPerPage) && $x <= $this->TotalResults - 1; $x++)
				{
					if($x >= ($Page * $this->ResultsPerPage - $this->ResultsPerPage) && $x < ($Page * $this->ResultsPerPage))
						$ReturnArray[] = $this->Result[$x];
				}
                
				return $ReturnArray;
			}

			return false;
		}

		function SetPage($Page = 1 , $SetIndex = true  )
		{
		   
			$CurrentLetter = $this->CurrentLetter;
			$PagerColumn = $this->PagerColumn;			
			$NewResult = array();			      		        	       	 
			if($this->Result)
			{
                            $this->TotalPages = ceil($this->TotalResults/$this->ResultsPerPage);
				$this->OriginalResult = $this->Result;		 				    	
				 if($CurrentLetter && $PagerColumn)
			     { 			     	
			     	for($x=0;$x<$this->TotalResults;$x++)
			       {	      
        	               $NewLetter = getFirstLetter($this->Result[$x][$PagerColumn]);
					 if($NewLetter == $CurrentLetter )
					{
						$NewResult[] = $this->Result[$x];
					}
			       }
			      $this->TotalResults = count($NewResult); 
			      
			      $this->Result = $NewResult; 
			    }			    
			    
				if(!NumberCheck($Page) || $Page > $this->TotalPages)
					$Page = 1;

				$ReturnArray = array();
				$this->CurrentPageCount = 0;
				$y = ($Page * $this->ResultsPerPage - $this->ResultsPerPage);
             
				for($x = ($Page * $this->ResultsPerPage - $this->ResultsPerPage); $x <= ($y + $this->ResultsPerPage) && $x <= $this->TotalResults - 1; $x++)
				{
					if($x >= ($Page * $this->ResultsPerPage - $this->ResultsPerPage) && $x < ($Page * $this->ResultsPerPage))
					{												
						
							$this->CurrentPageCount += 1;
								$Data = $this->Result[$x];

						       if($SetIndex)
							         $Data['__Index'] = $x;

						         $ReturnArray[] = $Data;
						
					}
				}
        
				$this->CurrentPageResult = $ReturnArray;
				$this->CurrentPage = $Page;

				return true;
			}

			return false;
		}

		function FindPage($Index)
		{
			if($this->Result && NumberCheck($Index))
			{
				return ceil(($Index + 1) / $this->ResultsPerPage);
			}

			return false;
		}
        function BuildAlphaNavigation($ColumnName)
        {           	
        	$Letter = $this->CurrentLetter;
        	$Alphabet = array();
        	$ReturnString = "<div class='alpha_sort'>";
        	$ReturnString .= ($Letter) ? "<a  href=".GetCurrentPage()."  >All</a>" : "<a href='#' class='active_sort' >All</a>";
        	
            for($x=0;$x<count($this->OriginalResult);$x++)
			 {			 	
			 $FirstLetter = getFirstLetter($this->OriginalResult[$x][$ColumnName]);
			 		
             if( !in_array($FirstLetter,$Alphabet))
        	 {	        		
        	   array_push($Alphabet,$FirstLetter);
        	  }     
			 }       	
        	
        	foreach (range('A','Z') as $AlphaLetter)
        	{
        		if(in_array($AlphaLetter,$Alphabet))
        		$ReturnString .= (strtoupper($Letter) == $AlphaLetter) ? "<a href='#' class='active_sort'>".$AlphaLetter."</a>" : "<a href=".GetCurrentPage().GetQueryString('CurrentLetter='.$AlphaLetter.'&PagerColumn='.$ColumnName).">".$AlphaLetter."</a>";
        	    else $ReturnString .= "<a href='#' class='null'>".$AlphaLetter.'</a>';
        	  
        	}
        	unset($AlphaLetter);
        	$ReturnString .= "</div>";
        	return $ReturnString;
        }
		function BuildNavigation($PageName = false, $Page = false, $OptionalParameters = false, $PrintStats = true)
		{
			if($this->PagingDataBindFunction === false)
			{
				global $CurrentPage, $SortExpression, $SortOrder;
               
				$NumberOfLinks = 10;
				$OptionalParameters = ($OptionalParameters === false) ? "" : $OptionalParameters;
				$Page = (NumberCheck($Page)) ? $Page : $this->CurrentPage;
				$Page = (NumberCheck($Page)) ? $Page : 1;
				$PageName = ($PageName === false) ? "" : $PageName;

				$OptionalParameters .= (isset($SortExpression)) ? "&SortExpression=".$SortExpression : false;
				$OptionalParameters .= (isset($SortOrder)) ? "&SortOrder=".$SortOrder : false;

				if(strpos($OptionalParameters, "&") === 0)
					$OptionalParameters = substr($OptionalParameters, 1);

				$StartPage = ($Page - $NumberOfLinks > 0) ? $Page - $NumberOfLinks : 1;
				$EndPage = ($Page + $NumberOfLinks <= $this->TotalPages) ? $Page + $NumberOfLinks : $this->TotalPages;

				if($this->TotalPages == 1)
				{
					$ReturnString .= ($PrintStats) ? "<div class='".$this->PagerClass."'><div class='pagerRight'>Total Results: ".$this->TotalResults."</div><div class='pagerLeft'>Page 1 of 1</div></div>" : false;
				}
				else
				{
					$ReturnString .= "<div class='".$this->PagerClass."'>";

					$ReturnString .= "<div class='pagerRight'>Total Results: ".$this->TotalResults."</div>";
					$ReturnString .= "<div class='pagerLeft'>";
					if ($Page > 1)
					{
							$NewParams =  $this->Encrypt->encrypt($OptionalParameters."&CurrentPage=".($Page - 1));
							$ReturnString .= "<a href='".GetCurrentPage().GetQueryString($this->Decrypt->decrypt($NewParams))."'><< Prev</a> ";
							//$ReturnString .= '<input type="submit" name="btn'.$Id.'_Prev" value="<< Prev" />';
					}

					for ($i = $StartPage; $i <= $EndPage; $i++)
					{
						if ($i == $Page)
						{
							$ReturnString .= "<a href='#' class='pagerActive'>$i</a> ";
						}
						else
						{
							$NewParams =  $this->Encrypt->encrypt($OptionalParameters."&CurrentPage=".$i);
							$ReturnString .= "<a href='".GetCurrentPage().GetQueryString($this->Decrypt->decrypt($NewParams))."'>".$i."</a> ";
							//$ReturnString .= '<input type="submit" name="btn'.$Id.'_Page_'.$i.'" value="'.$i.'" />';
						}
					}

					if ($Page < $EndPage)
					{
							$NewParams =  $this->Encrypt->encrypt($OptionalParameters."&CurrentPage=".($Page + 1));
							$ReturnString .= "<a href='".GetCurrentPage().GetQueryString($this->Decrypt->decrypt($NewParams))."'>Next >></a> ";
							//$ReturnString .= '<input type="submit" name="btn'.$Id.'_Next" value="Next >>" />';
					}
					$ReturnString .= "</div>";

					$ReturnString .= ($PrintStats) ? "</div>" : false;
				}
				
				return $ReturnString;
			}
			else
			{
				return call_user_func($this->PagingDataBindFunction);
			}
             
		}

		function BuildPagingSortLink($CurrentPage, $Expression, $SortOrder = "DESC", $Params = "", $LinkName = "")
		{
			global $SortExpression;

			$QueryString = "CurrentPage=".$CurrentPage."&SortExpression=".$Expression;
			$QueryString .= ($SortOrder == "ASC") ? "&SortOrder=DESC" : "&SortOrder=ASC";

			if($Params != "")
			   $QueryString .= "&".$Params;

			$ReturnString = ($Expression == $SortExpression) ? "<a href='?".$this->Encrypt->encrypt($QueryString)."' title='Sorted by ".$LinkName." ".$SortOrder."' >".$LinkName."</a>" : "<a href='?".$this->Encrypt->encrypt($QueryString)."' title='Sort by ".$LinkName." ".$SortOrder."' >".$LinkName."</a>";

			if($SortExpression == $Expression)
				$ReturnString .= ($SortOrder == "DESC") ? " <img src='".APPROOT."images/ad.gif' alt='Descending' />" : " <img src='".APPROOT."images/au.gif' alt='Ascending' />";

			return $ReturnString;
		}
	}
?>