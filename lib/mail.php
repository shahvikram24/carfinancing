<?
	//** the newline character(s) to be used when generating an email message.
	define("EmailNewLine", "\r\n");
	require_once APPLICATIONREQUIREROOT.'AWSSDKforPHP/sdk.class.php';
    require_once APPLICATIONREQUIREROOT.'swift/swift_required.php';
	
	class Email
	{
		//** (String) the recipiant email address, or comma separated addresses.
		public $To = false;

		//** (String) the recipiant addresses to receive a copy. Can be a comma
		//** separated addresses.
		public $Cc = false;

		//** (String) the recipiant addresses to receive a hidden copy. Can be a
		//** comma separated addresses.
		public $Bcc = false;

		//** (String) the email address of the message sender.
		public $From = false;

		//** (String) the subject of the email message.
		public $Subject = false;

		//** (String) body content for the message. Must be plain text or HTML based
		//** on the 'TextOnly' field. This field is ignored if
		//** SetMultipartAlternative() is called with valid content.
		public $Content = false;

		//** an array of EmailAttachment instances to be sent with this message.
		var $Attachments;

		//** any custom header information that must be used when sending email.
		public $Headers = false;

		//** whether email to be sent is a text email or a HTML email.
		var $TextOnly = false;

		//** the charset of the email to be sent (initially none, let type decide).
		public $Charset = DEFAULTCHARSET;

		//** Create a new email message with the parameters provided.
		function __construct($To = false, $From = false, $Subject = false, $Headers = false)
		{
			$this->To = $To;
			$this->From = ($From) ? $From : 'CarFinancing' ;
			$this->Subject = $Subject;
			$this->Headers = $Headers;

			//** create an empty array for attachments. NULL out attachments used for
			//** multipart/alternative messages initially.

			$this->Attachments = Array();
			$this->Attachments["text"] = null;
			$this->Attachments["html"] = null;
		}

		//** Returns: Boolean
		//** Set this email message to contain both text and HTML content.
		//** If successful all attachments and content are ignored.

		function SetMultipartAlternative($Text = false, $Html = false)
		{
			//** non-empty content for the text and HTML version is required.

			if(strlen(trim(strval($Html))) == 0 || strlen(trim(strval($Text))) == 0)
				return false;
			else
			{
				//** create the text email attachment based on the text given and the standard
				//** plain text MIME type.

				$this->Attachments["text"] = new EmailAttachment(false, "text/plain");
				$this->Attachments["text"]->LiteralContent = strval($Text);

				//** create the html email attachment based on the HTML given and the standard
				//** html text MIME type.

				$this->Attachments["html"] = new EmailAttachment(false, "text/html");
				$this->Attachments["html"]->LiteralContent = strval($Html);

				return true;  //** operation was successful.
			}
		}

		//** Returns: Boolean
		//** Create a new file attachment for the file (and optionally MIME type)
		//** given. If the file cannot be located no attachment is created and
		//** FALSE is returned.
		function Attach($pathToFile, $mimeType = false, $FileName = false)
		{
			//** create the appropriate email attachment. If the attachment does not
			//** exist the attachment is not created and FALSE is returned.

			$Attachment = new EmailAttachment($pathToFile, $mimeType, $FileName);
			if(!$Attachment->Exists())
				return false;
			else
			{
				$this->Attachments[] = $Attachment;  //** add the attachment to list.
				return true;                         //** attachment successfully added.
			}
		}
		//** Returns: Boolean
		//** Determine whether or not the email message is ready to be sent. A TO and
		//** FROM address are required.
		private function IsComplete()
		{
			if(strlen(trim($this->From)) > 0) 
			return true;
			else
			{
				$this->ThrowException(1,"Email From address required ");
				return false;
			}
		}
		/*
		 * Returns : Boolea
		 * Check if the destination email is valid
		 * 
		*/
		private function IsValid()
		{
                        $To = explode(",", $this->To);
                        foreach ($To as $ToEmail)
                        {    
			  if(filter_var(trim($ToEmail),FILTER_VALIDATE_EMAIL) === FALSE)
			  {
				$this->ThrowException(1,"Invalid or Empty destination email".$ToEmail);
				return false;
			  }
                        }
		       return true;
		}
		
		/*
		  Handler email errors
		*/
	    function ThrowException($ExceptionTypeId, $Message)
		{
			throw new Exception($Message);
		}

		//** Returns: Boolean
		//** Attempt to send the email message. Attach all files that are currently
		//** valid. Send the appropriate text/html message. If not complete FALSE is
		//** returned and no message is sent.
		function Send()
		{

			if(!$this->IsComplete() || !$this->IsValid())  //** message is not ready to send.
				return false;           //** no message will be sent.

				//echo "<br/> SEND() - " . APPLICATIONREQUIREROOT . "<br/>";
                        $message = Swift_Message::newInstance($this->Subject);
                        $message->setFrom(array('no-reply@carfinancing.help' => $this->From));                        
      
                        $message->setTo(explode(",", $this->To));

                        if($this->TextOnly){
                            $message->setBody($this->Content, 'text/plain');
                        }else{
                            $isMultipartAlternative = ($this->Attachments["text"] != null && $this->Attachments["html"] != null);
                            if($isMultipartAlternative){
                                $message->setBody($this->Attachments['html']->LiteralContent, 'text/html');
                                $message->addPart($this->Attachments['text']->LiteralContent, 'text/plain');
                            }else{
                                $message->setBody($this->Content, 'text/html');
                                foreach($this->Attachments as $Attachment)
				{
					//** check for NULL attachments used by multipart alternative emails. Do not
					//** attach these.
					if($Attachment != null)
					{
                                            $attachmentData = $Attachment->GetContent();
                                            if($attachmentData != null){
                                                $attachment = Swift_Attachment::newInstance();
                                                $attachment->setFilename($Attachment->FileName);
                                                $attachment->setContentType($Attachment->ContentType);
                                                $attachment->setBody($attachmentData);

                                                $message->attach($attachment);
                                            }
					}
				}
                            }
                        }

                        //$transport = Swift_SendmailTransport::newInstance('/usr/sbin/sendmail.postfix -bs');
                        $transport = Swift_MailTransport::newInstance();

			            if('live' != CurrentServer()){
                            $transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465,'ssl')
							->setUsername('support@websuitepro.com')
                            ->setPassword('Testing67');
                        }

                        //if(!file_exists('/usr/sbin/sendmail.postfix')){
                        //    $transport = $transport = Swift_MailTransport::newInstance();
                        //}

                        $mailer = Swift_Mailer::newInstance($transport);

                        return $mailer->send($message);			

                        //OLD COLD FOLLOWS

			//** generate a unique boundry identifier to separate attachments.

			$theBoundary = "==Multipart_Boundary_x" . md5(time()) . "x";
			//** the from email address and the current date of sending.

			$Headers = "Date: " . date("r", time()) . EmailNewLine . "From: " . $this->From . EmailNewLine;

			//** if a non-empty CC field is provided add it to the headers here.
			if(strlen(trim(strval($this->Cc))) > 0)
				$Headers .= "CC: " . $this->Cc . EmailNewLine;

			//** if a non-empty BCC field is provided add it to the headers here.
			if(strlen(trim(strval($this->Bcc))) > 0)
				$Headers .= "BCC: " . $this->Bcc . EmailNewLine;

			//** add the custom headers here, before important headers so that none are
			//** overwritten by custom values.

			if($this->Headers != null && strlen(trim($this->Headers)) > 0)
				$Headers .= $this->Headers . EmailNewLine;

			//** determine whether or not this email is mixed HTML and text or both.

			$isMultipartAlternative = ($this->Attachments["text"] != null && $this->Attachments["html"] != null);

			//** determine the correct MIME type for this message.
			$baseContentType = "multipart/" . ($isMultipartAlternative ? "alternative" : "mixed");

			//** add the custom headers, the MIME encoding version and MIME typr for the
			//** email message, the boundry for attachments, the error message if MIME is
			//** not suppported.
			$Headers .= "MIME-Version: 1.0" . EmailNewLine . "Content-Type: $baseContentType;" . EmailNewLine . " boundary=\"" . $theBoundary . "\"";

			//** if a multipart message add the text and html versions of the content.
			if($isMultipartAlternative)
			{
				//** add the text and html versions of the email content.
				$theBody = "--$theBoundary" . EmailNewLine . $this->Attachments["text"]->ToHeader() . EmailNewLine . "--$theBoundary" . EmailNewLine . $this->Attachments["html"]->ToHeader() . EmailNewLine;
			}
			else
			{
				//** if either only html or text email add the content to the email body.
				//** determine the proper encoding type and charset for the message body.

				$theEmailType = "text/" . ($this->TextOnly ? "plain" : "html");
				if(IsEmpty($this->Charset) || $this->Charset == "DEFAULTCHARSET")
					$this->Charset = "iso-8859-1";

				//** add the encoding header information for the body to the content.

				$theBody = "--$theBoundary" . EmailNewLine . "Content-Type: $theEmailType; charset=$this->Charset" . EmailNewLine . "Content-Transfer-Encoding: 8bit" . EmailNewLine . EmailNewLine . $this->Content . EmailNewLine;

				//** loop over the attachments for this email message and attach the files
				//** to the email message body. Only if not multipart alternative.

				foreach($this->Attachments as $Attachment)
				{
					//** check for NULL attachments used by multipart alternative emails. Do not
					//** attach these.
					if($Attachment != null)
					{
						$attachmentHeaders .= "--".$theBoundary . EmailNewLine . $Attachment->ToHeader();
					}
				}
			}
			//** end boundry marker is required.

			$theBody = $theBody . $attachmentHeaders .  "--$theBoundary--";


			//** attempt to send the email message. Return the operation success.

			//if(CurrentServer() == "local")
			//	return true;

			return mail($this->To, $this->Subject, $theBody, $Headers);
		}
	}

	class EmailAttachment
	{
		//** (String) the full path to the file to be attached.
		var $FilePath = false;

		//** (String) the MIME type for the file data of this attachment.
		var $ContentType = false;

		//** binary content to be used instead the contents of a file.
		var $LiteralContent = false;

		var $FileName = false;

		//** Creates a new email attachment ffrom the file path given. If no content
		//** type is given the default 'application/octet-stream' is used.

		function __construct($pathToFile = false, $mimeType = false, $FileName = false)
		{
			//** if no MIME type is provided use the default value specifying binary data.
			//** Otherwise use the MIME type provided.

			if($mimeType == false || strlen(trim($mimeType)) == 0)
				$this->ContentType = "application/octet-stream";
			else
				$this->ContentType = $mimeType;

			$this->FileName = (IsEmpty($FileName)) ? basename($this->FilePath) : $FileName;
			$this->FileName = str_replace(" ", "", $this->FileName);
			$this->FileName = str_replace("\"", "", $this->FileName);
			$this->FileName = str_replace("\'", "", $this->FileName);

			$this->FilePath = $pathToFile;  //** save the path to the file attachment.
		}

		//** Returns: Boolean
		//** Determine whether literal content is provided and should be used as the
		//** attachment rather than a file.
		function HasLiteralContent()
		{
			return (strlen(strval($this->LiteralContent)) > 0);
		}

		//** Returns: String
		//** Get the binary string data to be used as this attachment. If literal
		//** content is provided is is used, otherwise the contents of the file path
		//** for this attachment is used. If no content is available NULL is returned.
		function GetContent()
		{
			//** non-empty literal content is available. Use that as the attachment.
			//** Assume the user has used correct MIME type.

			if($this->HasLiteralContent())
				return $this->LiteralContent;
			else
			{
				//** no literal content available. Try to get file data.
				if(!$this->Exists())  //** file does not exist.
					return false;     //** no content is available.
				else
				{
					//** open the file attachment in binary mode and read the contents.
					$theFile = fopen($this->FilePath, "rb");
					$Data = fread($theFile, filesize($this->FilePath));
					fclose($theFile);
					return $Data;
				}
			}
		}

		//** Returns: Boolean
		//** Determine whether or not the email attachment has a valid, existing file
		//** associated with it.
		function Exists()
		{
			if($this->FilePath == false || strlen(trim($this->FilePath)) == 0)
				return false;
			else
				return file_exists($this->FilePath);
		}

		//** Returns: String
		//** Generate the appropriate header string for this email attachment. If the
		//** the attachment content does not exist NULL is returned.
		function ToHeader()
		{
			$attachmentData = $this->GetContent();  //** get content for the header.
			if($attachmentData == null)             //** no valid attachment content.
				return null;                        //** no header can be generted.

			//** add the content type and file name of the attachment.
			$Header = "Content-Type: $this->ContentType;";

			//** if an attachment then add the appropriate disposition and file name(s).
			if(!$this->HasLiteralContent())
			{
				$Header .= EmailNewLine . " name=\"" . $this->FileName . "\"" . EmailNewLine . "Content-Disposition: attachment; " . EmailNewLine. " filename=\"" . basename($this->FilePath) . "\"";
			}

			$Header .= EmailNewLine;

			//** add the key for the content encoding of the attachment body to follow.
			$Header .= "Content-Transfer-Encoding: base64" . EmailNewLine .	EmailNewLine;

			//** add the attachment data to the header. encode the binary data in BASE64
			//** and break the encoded data into the appropriate chunks.
			$Header .= chunk_split(base64_encode($attachmentData)) . EmailNewLine;

			return $Header;  //** return the headers generated by file.
		}
	}

?>

