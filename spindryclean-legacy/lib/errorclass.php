<?php
	class ErrorClass
	{
		private $ErrorList = array();
		private $MessageList = array();
		private $ErrorMessage = "";
		private $InformativeMessage = "";
		public $GlobalDisableTimeout = false;

		function __construct()
		{
			set_error_handler(array($this, 'ErrorHandler'));
			set_exception_handler(array($this, 'ExceptionHandler'));
		}

		function ExceptionHandler($ex)
		{
			global $User;

			$Log = new SystemLogging();

			$Log->Title = "Unhandled Exception";
			$Log->Message = $ex->getMessage();
			$Log->File = $ex->getFile();
			$Log->Line =$ex->getLine();
			$Log->Variables = $Log->GenerateHeader("Code").$ex->getCode().$Log->GenerateFooter("Code").$Log->GenerateHeader("Stack Trace").$ex->getTraceAsString().$Log->GenerateFooter("Stack Trace");
			if($User instanceof User)
				$Log->UserId = $User->Id;
			$Log->LogTypeId = 1;

			$Log->InsertLog();

			switch (DebugMode())
			{
				case true:
					echo "<html><head><link rel='stylesheet' href='".APPROOT."css/error.css' type='text/css' /></head><body><div class='eh'>Unhandled exception occured within the application</div>";
					echo "<div class='eme'><p class='ep'><strong>Error Message:</strong> ".$ex->getMessage()."</p>";
					echo "<p class='ep'><strong>Error File:</strong> ".$ex->getFile()."</p>";
					echo "<p class='ep'><strong>Error Line:</strong> ".$ex->getLine()."</p>";
					echo "<p class='ep'><strong>Variables:</strong> Code:".$ex->getCode()."</p></div>";
					echo "<div class='ste'><p class='ep'><strong>Stack Trace:</strong></p>";

					$StackTrace = $ex->getTrace();
					$Count = count($StackTrace);
					for($x = 0; $x <= $Count - 1; $x++)
					{
						echo "<p class='ep'>#".$x." - ";
						foreach($StackTrace[$x] as $Key)
						{
							if(is_array($Key))
							{
								foreach($Key as $Key2)
								{
									echo " ".$Key2;
								}
							}
							else
								echo " ".$Key;
						}
						echo "</p>";
					}
					echo "</div></body></html>";
					exit;
				default:
					header("Location: ".APPROOT."error.php");
					exit;
			}
		}

		function ErrorHandler($type, $message, $file, $line, $variables)
		{
			global $User;
			switch($type)
			{
				case E_USER_ERROR:
					$Log = new SystemLogging();
					$Log->Title = "System Error";
					$Log->File = $file;
					$Log->Line = $line;
					$Log->UserId = ($User instanceof User) ? $User->Id : 0;
					$Log->Message = $message;
					$Log->Variables = $Log->GenerateHeader("Variables").$variables.$Log->GenerateFooter("Variables").$Log->GenerateHeader("Type").$type.$Log->GenerateFooter("Type");

					$Log->InsertLog();

					switch (DebugMode())
					{
						case true:
							echo "<html><head><link rel='stylesheet' href='".APPROOT."css/error.css' type='text/css' /></head><body><div class='eh'>A fatal error occured within the application</div>";
							echo "<div class='eme'><p class='ep'><strong>Error Message:</strong> ".$message."</p>";
							echo "<p class='ep'><strong>Error File:</strong> ".$file."</p>";
							echo "<p class='ep'><strong>Error Line:</strong> ".$line."</p>";
							echo "<p class='ep'><strong>Variables:</strong> ".$variables."</p></div></body></html>";
							exit;
						default:
							header("Location: ".APPROOT."error.php");
							exit;
					}
					break;

				case E_USER_WARNING:
					echo "<br /><b>Error Reported at <b>[</b>".$file." - ".$line."<b>]</b>:</b><br /><span style='color: red;'>".$message." - [".$type."]</span><br /><b>Variables:</b>".$variables;
					break;

				case E_USER_NOTICE:
					echo "<br /><b>Warning Reported at <b>[</b>".$file." - ".$line."<b>]</b>:</b> [".$type."] - <span style='color: red;'>".$message."</span><br /><b>Variables:</b>".$variables;

					break;
				/*default:
					echo "<br /><b>Warning Reported at <b>[</b>".$file." - ".$line."<b>]</b>:</b> [".$type."] - <span style='color: red;'>".$message."</span><br /><b>Variables:</b>".$variables;
					break;*/
			}
		}
		function ToggleErrorGroupDisplay($ErrorGroupId, $Display = true)
		{
			for($x = 0; $x <= count($this->ErrorList) - 1; $x++)
			{
				if($this->ErrorList[$x]['GroupId'] == $ErrorGroupId)
					$this->ErrorList[$x]['DisplayError'] = $Display;
			}
		}
		function ErrorGroupExists($ErrorGroupId)
		{
			for($x = 0; $x <= count($this->ErrorList) - 1; $x++)
			{
				if($this->ErrorList[$x]['GroupId'] == $ErrorGroupId)
					return true;
			}
			return false;
		}

		function GetErrorKey($ErrorGroupId)
		{
			for($x = 0; $x <= count($this->ErrorList) - 1; $x++)
			{
				if($this->ErrorList[$x]['GroupId'] == $ErrorGroupId)
					return $this->ErrorList[$x]['Key'];
			}
			return false;
		}

		function AddToErrorList($Key, $Value = false, $DisableTimeout = false, $DisplayError = true, $ErrorGroupId = false)
		{
			$Value = ($Value === false) ? "We apologize for the inconvenience, but an error has occurred within the application. Our programming team has been notified and we're working to resolve this issue shortly. We thank you for your patience." : $Value;

			if(is_array($this->ErrorList))
			{
				$this->ErrorList[] = array('Key' => $Key, 'Value' => $Value, 'DisplayError' => $DisplayError, 'GroupId' => $ErrorGroupId);
			}
			else
			{
				$this->ErrorList = array();
				$this->ErrorList[] = array('Key' => $Key, 'Value' => $Value, 'DisplayError' => $DisplayError, 'GroupId' => $ErrorGroupId);
			}

			if($DisableTimeout)
				$this->GlobalDisableTimeout = true;
		}

		function AddToMessageList($Key, $Value, $DisableTimeout = false)
		{
			if(is_array($this->MessageList))
			{
				$this->MessageList[] = array('Key' => $Key, 'Value' => $Value);
			}
			else
			{
				$this->MessageList = array();
				$this->MessageList[] = array('Key' => $Key, 'Value' => $Value);
			}

			if($DisableTimeout)
				$this->GlobalDisableTimeout = true;
		}

		function ErrorCount($IncludeHiddenErrors = true)
		{
			if(is_array($this->ErrorList))
			{
				if($IncludeHiddenErrors)
					return count($this->ErrorList);
				else
				{
					for($x = 0; $x <= count($this->ErrorList) - 1; $x++)
					{
						$Count += ($this->ErrorList[$x]['DisplayError'] === true) ? 1 : 0;
					}

					return $Count;
				}
			}

			return 0;
		}

		function GetErrorList()
		{
			if( sizeof($this->ErrorList) >= 1)
			{
				//echo "<div style='background-color: red; font-weight: bold;'>The following error(s) halted operations:<ul>";
				//$List = "<ul>";
                                //  $List.= "<li><div class=\"close\" ><a  href=\"#\" onclick=\"$('.error_shadow').fadeOut('800');$('.error_container').fadeOut('800');\" class=\"close_screen\" title=\"Close Message\" >X</a></div></li>";
                                $List.= "<li><h1>Error</h1></li>";
				foreach ($this->ErrorList as $key => $value)
				{
					$List .= (is_bool($value['DisplayError']) && $value['DisplayError'] == true) ? "<li><p><strong>".$value['Key'].":</strong> ".$value['Value']."</p></li>" : false;
				}

				//$List .= "</ul>";

				return $List;
			}
			else
			{
				return "";
			}
		}

		function GetMessageList($DisplayCloseButton=true)
		{
			if( sizeof($this->MessageList) >= 1)
			{
                               $List = "<div>";
			       $List .= "<ul>";
			       if($DisplayCloseButton) $List .= "<li><div class=\"close\" ><a  href=\"#\" onclick=\"$('.error_shadow').fadeOut('800');$('.error_container').fadeOut('800');\" class=\"close_screen\" title=\"Close Message\" >X</a></div></li>";
				foreach ($this->MessageList as $key => $value)
				{
					$List .= "<li><h1>".$value['Key']."</h1></li>";
					$List .= "<li><p>".$value['Value']."</p></li>";
			       }
				$List .= "</ul></div>";                           
				return $List;
			}
			else
			{
				return "";
			}
		}

                function DisplayInformativeMessage()
                {
                    if( sizeof($this->InformativeMessage) >= 1)
		    {
                    $x = "<div>";
                    $x.= "<ul>";
                    $x.= "<li><div class=\"close\" ><a  href=\"#\" onclick=\"$('.error_shadow').fadeOut('800');$('.error_container').fadeOut('800');\" class=\"close_screen\" title=\"Close Message\" >X</a></div></li>";
                    $x.= "<li>".$this->InformativeMessage."</li>";
                    $x.= "</ul>";
                    $x.= "</div>";
                    return $x;
                    }
                    else return "";
                  
                }
		function SetErrorMessage($Message = false, $DisableTimeout = false)
		{
			$Message = ($Message === false) ? "We apologize for the inconvenience, but an error has occurred within the application. Our programming team has been notified and we're working to resolve this issue shortly. We thank you for your patience." : $Message;
                        $this->ErrorMessage .= "<li><h1>Error</h1></li>";
			$this->ErrorMessage .= $Message." ";

			if($DisableTimeout)
				$this->GlobalDisableTimeout = true;
		}
		function SetDisplayMessage($Message = false, $DisableTimeout = false)
		{
			$Message = ($Message === false) ? "We apologize for the inconvenience, but an error has occurred within the application. Our programming team has been notified and we're working to resolve this issue shortly. We thank you for your patience." : $Message;
			$this->InformativeMessage .= $Message." ";
			if($DisableTimeout)
				$this->GlobalDisableTimeout = true;
		}
		function DisplayErrors($Timeout = "6000")
		{
			if(sizeof($this->ErrorList) >= 1 || strlen($this->ErrorMessage) >= 1)
			{
                                $x .="<div class=\"error_shadow\">";
				$x .= "<div class=\"error_container\">";
                                $x .= "<ul>";
                                $x .= "<li><div class=\"close\" ><a  href=\"#\" onclick=$(\".error_shadow\").fadeOut(\"800\");$(\".error_container\").fadeOut(\"800\"); class=\"close_screen\" title=\"Close Message\" >X</a></div></li>";
                               // $x .= "<li><h1>Error</h1></li>";
                                $x .= "<li><p>";
                                $x .= (trim($this->ErrorMessage) != "") ? $this->ErrorMessage : "";
                                $x .= "</p></li>";
				$x .= (sizeof($this->ErrorList) >= 1) ? $this->GetErrorList() : "";
                                $x .= "</ul>";
				$x .= "</div></div><div class=\"clear\"></div>";
				echo $x;
			}
			$this->DisableTimeout = false;
			$this->ClearErrors();
		}
		function ClearErrors()
		{
			$this->ErrorList = array();
		}
		function DisplayMessages($Timeout = "6000")
		{
			global $MessageType;
			if(sizeof($this->MessageList) >= 1 || strlen($this->InformativeMessage) >= 1)
			{
				//Javascript Popup HTML code
				if(!IsMobile())
				{
                                        $x .="<div class='error_shadow'>";
					if ($MessageType == 'Error'){                                         
                                         $x .= "<div class='error_container'>";                                         
                                         }
                                        else {                                   
                                        				
                                        $x .= "<div class='screen'></div><div class='success_container'>";
                                        }
					$x .= (trim($this->InformativeMessage) != "") ? $this->DisplayInformativeMessage() : "";
					$x .= (sizeof($this->MessageList) >= 1) ? $this->GetMessageList(true) : "";
					$x .= "</div></div><div class='clear'></div>";
				}
				else{
				//Message box that shows without javascript, but is hidden with javascript
				$x .= "<div class='message_container'>";
				$x .= (strlen($this->InformativeMessage) > 1) ? $this->InformativeMessage : "";
				$x .= (sizeof($this->MessageList) >= 1) ? $this->GetMessageList() : "";
				$x .= "</div>";
				}
				echo $x;
				if($this->GlobalDisableTimeout)
					$Timeout = true;
			}
			$this->MessageList = array();
			$this->DisableTimeout = false;
		}
	}
?>