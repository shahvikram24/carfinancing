<?php

function debugObj(&$obj){
    echo '<pre>'.print_r($obj,true).'</pre>';
}

/**
 *	@desc Validates a string against the supplied regex pattern Id
 *	@param string $String The string to check
 * 	@param mixed $Pattern The Id of the regular expression you want to validate against. If your Id is not a number then preg_match is run against your supplied argument. Good for custom regex patterns
 * 	@return bool Returns true if a match is found or false is no match is found.
 */
function RegExValidator($String, $Pattern) {
    //1 = Name / Title / Province
    //2 = Company Name
    //3 = Phone/Fax Number
    //4 = Postal/Zip
    //5 = Address
    //6 = URL
    //7 = Email
    //8 = Only letters with spaces
    //9 = Only numbers with spaces
    //10 = Letters, numbers & puncuation (any word character)
    //11 = Date Format
    //12 = Money
    //13 = Discount  // Money% or Money

    if(is_numeric($Pattern)) {
        switch ($Pattern) {

            case 1:
            // First or last name eg(John, John-Mar, JohnMar, John Mar, Dr. John Mar)
                return preg_match('/^[a-zA-Z \-\.]{1,}$/', $String);

            case 2:
            // Used for company/organization names Allows A-Z, numbers, & @ ! ( ) : - _ , ? . | ' / \
            //return preg_match("/^[a-zA-Z9-0 \,\_\-\.\:\!\?\@\&\(\)]{1,}$/", $String);
                return preg_match('/^[\s\w\&\@\!\(\)\:\-_\,\?\.\|\$\\\'\/\\\]{1,}$/', $String);
            // 9, 13, 32, 33, 36, 38, 40, 41, 44, 45, 46, 47, 48-57, 58, 63, 64, 65-90, 92, 95, 97-122, 124

            case 3:
                //return preg_match('/^[\d\-\.\(\)\+ ]{7,20}$/', $String);
                return preg_match('/^([0-9]( |-)?)?(\(?[0-9]{3}\)?|[0-9]{3})( |-)?([0-9]{3}( |-)?[0-9]{4}|[a-zA-Z0-9]{7})\s*(([xX]|[eE][xX][tT])\.?\s*(\d+))*$/i', $String); //with optional extension support (x or ext.)
            // 32, 40, 41, 43, 45, 46, 48-57

            case 4:
                return preg_match('/^[-a-zA-Z0-9 ]{2,}$/', $String);
            // 32, 45, 48-57, 65-90, 97-122

            case 5:
                return preg_match('/^[a-zA-Z0-9 \#\.\,\:\&\-\/]{1,}$/', $String);
            // 32, 35, 38, 44, 45, 46, 47, 48-57, 65-90, 97-122

            case 6:
                return preg_match("/^(https?:\/\/)?(([0-9a-z_!~*'().&=+$%-]+: )?[0-9a-z_!~*'().&=+$%-]+@)?(([0-9]{1,3}\.){3}[0-9]{1,3}|([0-9a-z_!~*'()-]+\.)*([0-9a-z][0-9a-z-]{0,61})?[0-9a-z]\.[a-z]{2,6})(:[0-9]{1,4})?((\/?)|(\/[0-9a-z_!~*'().;?:@&=+$,%#-]+)+\/?)$/", $String);

            case 7:
            //return preg_match("/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/");
                return preg_match("/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*\.(([0-9]{1,3})|([a-zA-Z]{2,3})|(aero|coop|info|museum|name))$/", $String);

            case 8:
                return preg_match("/^[a-zA-Z ]{1,}$/", $String);

            case 9:
                return preg_match("/^[0-9 ]{1,}$/", $String);

            case 10:
                return preg_match("/^[\w\-]{1,}$/", $String);

            case 11:
                return preg_match("/^((((((0?[13578])|(1[02]))[\.\-\/\s]?((0?[1-9])|([1-2][0-9])|(3[01])))|(((0?[469])|(11))[\.\-\/\s]?((0?[1-9])|([1-2][0-9])|(30)))|(0?2[\.\-\/\s]?((0?[1-9])|([1-2][0-9]))))[\.\-\/\s]?\d{2}(([02468][048])|([13579][26])))|(((((0?[13578])|(1[02]))[\.\-\/\s]?((0?[1-9])|([1-2][0-9])|(3[01])))|(((0?[469])|(11))[\.\-\/\s]?((0?[1-9])|([1-2][0-9])|(30)))|(0?2[\.\-\/\s]?((0?[1-9])|(1[0-9])|(2[0-8]))))[\.\-\/\s]?\d{2}(([02468][1235679])|([13579][01345789]))))?$/",$String); //  m/d/yyyy

            case 12:
                return preg_match("/^[0-9]{1,3}(?:,?[0-9]{3})*(?:\.[0-9]{1,2})?$/", $String); //matchs 23  23.56 23.00
            //return preg_match("/^[\d]{1,10}.[\d]{2}$/", $String);  //decimal part is madatory in this    23.56 23.00

            case 13:
                return preg_match("/^((?:\+|\-)?(?:\d+|\d{1,3}(?:\,\d{3})*)(?:\.\d+)?(?:\%)?)$/", $String);
            //return preg_match("/^[0-9]{1,3}(?:,?[0-9]{3})*(?:\.[0-9]{1,2})*(?:%)?$/", $String);
            // "/^((?:\+|\-|\$)?(?:\d+|\d{1,3}(?:\,\d{3})*)(?:\.\d+)?(?:[a-zA-Z]{2}|\%)?)$/"
             case 14:
                return preg_match("~(?P<month>\d\d?)(/|-)(?P<day>\d\d?)(/|-)(?P<year>\d\d\d?\d?) +(?P<time>\d\d?:\d\d *[ap]m)~i", $String); //  m/d/yyyy h:m:s ampm
	    
        }
    }
    else {
        return preg_match($Pattern, $String);
    }

}

/**
 *	@desc Validates that the supplied parameter is a valid email. Should be used when sending emails
 * 	@param mixed $Emails Parameter can be a comma-separated string of emails or an array
 * 	@return bool Returns true if the supplied parameter is a valid email. Returns false if any emails within the array/list are invalid
 */
function ValidateEmails($Emails) {
    if(!is_array($Emails)) {
        if(IsEmpty($Emails))
            return false;

        $Emails = split(",", $Emails);
    }

    foreach($Emails as $Key) {
        if(!RegExValidator($Key, 7))
            return false;
    }
    unset($Key);
    return true;
}

//TODO - Remove the second parameter from all function calls
/**
 *	@desc Checks if the supplied parameter is an absolute number (positive number) or not.
 * 	@param mixed $Id The variable to check
 *	@return boolean Returns true if the supplied parameter is a number.
 */
function NumberCheck($Id) {
    if(isset($Id) && is_numeric($Id) && $Id >= 0) {
        return true;
    }
    else
        return false;
}

/**
 *	@desc Formats a name based on the supplied parameters
 * 	@param string $FirstName
 * 	@param string $LastName
 * 	@param string $CompanyName
 * 	@param bool $ReverseOrder Reverse the output so that the company name is display before the user name
 * 	@return string Returns a string with the formatted parameters
 */
function FormatName($FirstName = false, $LastName = false, $CompanyName = false, $ReverseOrder = false) {
    $Name = trim($FirstName.' '.$LastName);

    if(!IsEmpty($Name) && !IsEmpty($CompanyName))
        return (!$ReverseOrder) ? $Name.' - '.$CompanyName : $CompanyName.' - '.$Name;
    else if(!IsEmpty($CompanyName))
        return $CompanyName;
    else
        return $Name;
}

//TODO - This should be changed to return true or false instead of "null". Should also change the logic to allow a string equal to "null" to verify
/**
 *	@desc Checks if the supplied parameter has a value. If no value is found then the string "null" is returned. Should be used to check for null fields for SQL
 * 	@param string $Value The value to check. An empty string, false, null and the string "null" are considered to be null.
 * 	@return string Returns the string "null" if the supplied parameter is an empty string, false, null or equal to the string "null", otherwise the value is returned
 */
function NullCheck($Value) {
    $Value = trim($Value);
    return (is_null($Value) || $Value == false || IsEmpty($Value) || strtolower($Value) == "null") ? "null" : $Value;
}

/**
 *	@desc Checks if the supplied parameter is a number or not. Should be used for converting user input of $1,459.03 to 1459.03 for SQL statements
 * 	@param mixed $Value The value to check
 * 	@return double Returns an double of the supplied parameter with no dollar signs ($) or commas (,)
 */
function MoneyCheck($Value) {
    $StripFields = array('$', ',');
    $Value = trim(str_replace($StripFields, '', $Value));
    return (is_numeric($Value)) ? $Value : 0;
}

/**
 *	@desc Verifies that the supplied parameter is a date
 * 	@param mixed $Date Value to check. Can be a string or timestamp integer
 * 	@return mixed Returns a formatted datetime string if the supplied parameter is a valid date, otherwise false
 */
function DateCheck($Date) {
    $Date = (is_null($Date) || $Date === false || IsEmpty($Date)) ? false : $Date;
    $Date = (!is_numeric($Date)) ? strtotime($Date) : $Date;
    return ($Date !== false) ? FormatDate($Date, MYSQLDATETIMEFORMAT) : false;
}

//TODO - Remove this function. Check if we still need it or if there is better logic that can be done
/**
 * 	@deprec Avoid using this function. Removed for next update
 *	@desc Compares two arrays values to find the differences
 * 	@param array $NewArray Represents an array after changes have been made to it
 * 	@param array $OldArray Represents an array before changes were made
 * 	@return array Returns a multi-dimensional array. The first value is an array containing all the values that were added to the new array (Missing in the old array). The second value is an array containing all the values that were deleted (values are present in the $OldArray parameter but are absent in the $NewArray parameter)
 */
function GetArrayDifference($NewArray, $OldArray) {
    $NewArray = (!is_array($NewArray)) ? array() : $NewArray;
    $OldArray = (!is_array($OldArray)) ? array() : $OldArray;

    $DeletedArray = array();
    $AddedArray = array();

    foreach($NewArray as $Key) {
        if(!in_array($Key, $OldArray)) {
            $AddedArray[] = $Key;
        }
    }
    unset($Key);

    foreach($OldArray as $Key) {
        if(!in_array($Key, $NewArray)) {
            $DeletedArray[] = $Key;
        }
    }
    unset($Key);
    $AddedArray = (count($AddedArray) == 0) ? false : $AddedArray;
    $DeletedArray = (count($DeletedArray) == 0) ? false : $DeletedArray;

    //0 = Added Items
    //1 = Deleted Items

    return array($AddedArray, $DeletedArray);
}

/**
 * Retieves the current querystring. Optionally you can provide a comma separated list of values to append / ignore
 *
 * @param string $Append Comma separated list of values to append onto the current encrypted querystring
 * @param string $DoNotInclude Comma separated list of values to not include into the return value
 * @return string Returns an encrypted querystring
 */
function GetQueryString($Append = false, $DoNotInclude = "Title,Message,SendEmail") {
    global $Decrypt, $Encrypt;
    $QueryString = $_SERVER['QUERY_STRING'];

    if(trim($QueryString) != "") {
        $UrlString = explode("&", $_SERVER['QUERY_STRING']);

        if(count($UrlString) > 1) {
            $DecryptedString = $Decrypt->decrypt($UrlString[0]);
            unset($UrlString[0]);
            $DecryptedString = explode("&", $DecryptedString);
            $QueryString = array_merge($UrlString, $DecryptedString);
        }
        else {
            $QueryString = $Decrypt->decrypt($QueryString);
            $QueryString = split("&", $QueryString);
        }

        for($x = 0; $x <= count($QueryString) - 1; $x++) {
            $KeyValue = split("=", $QueryString[$x]);
            $KeyValueArray[$KeyValue[0]] = $KeyValue[1];
        }

        $NewQueryString = "";

        if(!is_array($DoNotInclude))
            $DoNotInclude = explode(",", $DoNotInclude);

        foreach($KeyValueArray as $Key => $Value) {
            if(!in_array($Key, $DoNotInclude))
                $NewQueryString .= "&".$Key."=".$Value;
        }
        unset($Value);

        if($Append !== false) {
            if(is_array($Append))
                $AppendString = "&".implode("&", $Append);
            else
                $AppendString = "&".$Append;
        }

        if($NewQueryString || $AppendString)
            return "?".$Encrypt->encrypt(substr($NewQueryString, 1).$AppendString);
        else
            return false;

    }
    else if($Append) {
        return "?".$Encrypt->encrypt($Append);
    }
}

//TODO - Change this function so that we don't need to pass in the array from the superglobal $_FILES. See the function FileCheck below
/**
 *	@desc Checks that the supplied parameter is a valid image. Optionally you may specify the maximum size in bytes, width and height. Automatically adds error messages to $Errors variable if violations are triggered
 * 	@param array $Image Pass in the superglobal $_File['NameOfFileUpload']
 * 	@param int $MaxAvatarSize Maximum size in bytes that the image can be
 * 	@param int $MaxAvatarWidth Maximum width the image can be. Ignored if either $MaxAvatarWidth or $MaxAvatarHeight are false
 * 	@param int $MaxAvatarHeight Maximum height the image can be. Ignored if either $MaxAvatarWidth or $MaxAvatarHeight are false
 * 	@param string $ErrorName The display name to show in the errors array
 * 	@return bool Returns true if the supplied parameters verifies successfully, otherwise false
 */
function ImageCheck($Image, $MaxAvatarSize = 100000, $MaxAvatarWidth = false, $MaxAvatarHeight = false, $ErrorName = "Avatar") {
    global $Errors;

    $AllowedAvatarTypes = array('image/gif','image/pjpeg','image/jpeg','image/png');
    $AllowedAvatarExtensions = array('gif', 'jpeg', 'png');
    $ReturnValue = true;

    $ImageDimensions = getimagesize($Image['tmp_name']);
    $Extension = strrchr($Image['name'], ".");

    if(!in_array($Image['type'], $AllowedAvatarTypes) && !in_array($Extension, $AllowedAvatarExtensions)) {
        $Errors->AddToErrorList($ErrorName, INVALID_IMAGE);
        $ReturnValue = false;
    }

    if($MaxAvatarHeight !== false && $MaxAvatarWidth !== false && ($ImageDimensions[0] > $MaxAvatarWidth || $ImageDimensions[1] > $MaxAvatarHeight)) {
        $Errors->AddToErrorList($ErrorName." Resolution", 'Image size must not exceed '.$MaxAvatarWidth."x".$MaxAvatarHeight." pixels");
        $ReturnValue = false;
    }

    if($Image['size'] > $MaxAvatarSize && $MaxAvatarSize > 0) {
        $Errors->AddToErrorList($ErrorName." Size", 'Image size must not exceed '.($MaxAvatarSize / 1000)." Kb");
        $ReturnValue = false;
    }

    return $ReturnValue;
}

/**
 *	@desc Checks that the supplied parameter is a valid file. Optionally you may specify the maximum size in bytes.
 * 	@param array $File Name of the file within the $_FILES superglobal to check
 * 	@param string $FileType The file extension to validate against. Do not include a period (.txt)
 * 	@param int $MaxFileSize Maximum size in bytes that the file can be
 * 	@param string $ErrorName The display name to show in the errors array
 * 	@param string $ErrorGroupId Id of the ErrorGroup
 * 	@param bool $DisplayErrors Boolean to show the file within the error list
 * 	@return bool Returns true if the supplied parameters verifies successfully, otherwise false
 */
function FileCheck($File, $FileType = "csv", $MaxFileSize = 100000, $ErrorName = "File", $ErrorGroupId = false, $DisplayErrors = true) {
    global $Errors;

    $ReturnValue = true;

    if(is_file($_FILES[$File]['tmp_name'])) {
        $File = $_FILES[$File];
        $FileExt = strtolower(substr(strrchr($File['name'],"."), 1));

        if($File['size'] > $MaxFileSize) {
            $Errors->AddToErrorList($ErrorName, 'File size must not exceed '.($MaxFileSize / 1000)." Kb", false, $DisplayErrors, $ErrorGroupId);
            $ReturnValue = false;
        }

        if($FileExt !== (strtolower($FileType))) {
            $Errors->AddToErrorList($ErrorName, 'Only '.$FileType.' are permitted', false, $DisplayErrors, $ErrorGroupId);
            $ReturnValue = false;
        }
    }

    return $ReturnValue;
}

/**
 *	@desc Write the supplied string into a file
 * 	@param string $FileLocation Location of the file on the drive. If the file does not exist an attempt will be made to create it
 * 	@param string $Contents Contents to write to the file. All data within the file will be overwritten
 * 	@return bool Returns true
 */
function WriteToFile($FileLocation, $Contents) {
    $FileHandle = fopen($FileLocation, 'w');
    fwrite($FileHandle, $Contents);
    fclose($FileHandle);

    return true;
}

/**
 *	@desc Reads the contents of a file at the supplied location
 * 	@param string $FileLocation The location of the file on the drive. If no file is found then false is returned
 * 	@return string Contents of the file
 */
function ReadFromFile($FileLocation) {
    if(!IsEmpty($FileLocation) && is_file($FileLocation)) {
        $fileHandle = fopen($FileLocation, 'r');
        $Contents = fread($fileHandle, filesize($FileLocation));
        fclose($fileHandle);
        return $Contents;
    }

    return false;
}

/**
 *	@desc Takes the supplied filename and saves it both to the disk and hard drive. Automatically renames the file with a random name, and saves that information into the table tblfiles. Returns the Id of the insert
 * 	@param string $FileUploadName Name of the file within the superglobal $_FILES to save
 * 	@param string $FileName Name of the file to save into the database
 * 	@param string $FileExtension Optional parameter to rename the file extension. If false then the current extension is used
 * 	@return int Returns the Id of the insert or nothing if anything fails
 */
function ProcessFile($FileUploadName, $FileName = "Generic File", $FileExtension = false,$Location= false) {
    if(is_uploaded_file($_FILES[$FileUploadName]['tmp_name'])) {
        
        $FileExtension = (IsEmpty($FileExtension)) ? strrchr($_FILES[$FileUploadName]['name'], ".") : $FileExtension;
        
        $UniqueFileName = uniqid(rand()).$FileExtension;       
        
        $FileLocation = ($Location) ? WEBROOT.$Location.$UniqueFileName :  WEBROOT.'crm/files/'.$UniqueFileName;

        if(copy($_FILES[$FileUploadName]['tmp_name'], $FileLocation) && chmod($FileLocation, 0777)) {
            $File = new Files();
            $File->FileName = $FileName;
            $File->FileSize = $_FILES[$FileUploadName]['size'];
            $File->FileMIME = $_FILES[$FileUploadName]['type'];
            $File->FileLocation = $UniqueFileName;
            $File->Status = 1;
            $File->CompanyUserId = COMPANYUSERID;
            $File->InsertFile();

            return $File->Id;

        }
        else {
            if(file_exists($FileLocation) && !unlink($FileLocation)) {
                $Log = new SystemLogging();
                $Log->Title = "Error Processing File";
                $Log->File = "";
                $Log->Line = 0;
                $Log->UserId = USERID;
                $Log->Message = "File could not be deleted";
                $Log->Variables = $Log->GenerateHeader("File Location").$FileLocation.$Log->GenerateFooter("File Location");
                $Log->InsertLog();
            }
        }
    }
}

/**
 *	@desc Removes the specified data from the cache
 * 	@param string $CacheKey Name of the key within the cache
 * 	@return bool Returns true if the key is found and removed
 */
function ExpireCache($CacheKey = false) {
    if($CacheKey !== false) {
        if(apc_fetch($CacheKey)) {
            apc_remove($CacheKey);
            return true;
        }
    }

    return false;
}

/**
 *	@desc Takes an array and converts it to a string. Same effect as if you were to call print_r. Useful for dumping the contents of an array into the database
 * 	@param array $Array The array to convert
 * 	@param bool $FormatAsQueryString If true then the return result is formatted like a querystring in a Key1=Value1&Key2=Value2 fashion. Ignores multidimensional arrays
 * 	@return string Returns a string
 */
function ArrayToString($Array, $FormatAsQueryString = false) {
    if(is_array($Array)) {
        $Keys = array_keys($Array);
        $Values = array_values($Array);
        $ArrayLength = count($Keys);
        $ReturnString = "";

        for($x = 0; $x <= $ArrayLength - 1; $x++) {
            if($FormatAsQueryString) {
                $ReturnString .= "&".$Keys[$x]."=".$Values[$x];
            }
            else {
                $ReturnString .= "[".$Keys[$x]."=>";
                if(is_array($Values[$x]))
                    $ReturnString .= ArrayToString($Values[$x]);
                else
                    $ReturnString .= $Values[$x];

                $ReturnString .= "]";

            }
        }

        return ($FormatAsQueryString) ? substr($ReturnString, 1) : $ReturnString;
    }

    return $Array;

}

/**
 *	@desc Searches an array of objects for the specified value. Useful for searching array relations for a desired object.
 * 	@param array $Array The array to search
 * 	@param string $SearchTerm The value to search for within the array
 * 	@param string $Target The class member to check
 * 	@param bool $ReturnClone Specify whether to return a clone of the found object or not
 * 	@return mixed Returns an object within the array, or false if none was found
 */
function SearchArray($Array, $SearchTerm, $Target = "Id", $ReturnClone = false) {
    if(is_array($Array)) {
        $ArrayLength = count($Array);

        for($x = 0; $x <= $ArrayLength - 1; $x++) {
            $ClassArray = get_object_vars($Array[$x]);
            if($ClassArray[$Target] == $SearchTerm)
                return ($ReturnClone) ? clone $Array[$x] : $Array[$x];
        }
    }

    return false;
}

//TODO - change this function so that it dose not need to rely on an authenticated user
/**
 *	@desc Sends a login email to the specified companyuser. Used for creating new staff members and clients that are granted login access. User of this function requires an authenticated user
 * 	@param CompanyUser $CompanyUser The CompanyUser object of the user to send the email to
 * 	@param bool $IsStaffMember If true then the company welcome email template is used, otherwise the company welcome client email is used
 * 	@return bool Returns true or false if the email was successfully sent
 */
function SendLoginEmail(CompanyUser $CompanyUser, $IsStaffMember = true,$TemplateId=8) {
    global $User, $Encrypt, $Decrypt;

    $objEmail = new Email();

    if($IsStaffMember) {
        $objEmail = new Email($CompanyUser->UserRelation->UserLogin, NOTIFICATIONNAME .' <'.NOTIFICATIONEMAIL.'>', "We've signed you up as a staff member! - ".$User->GetCurrentCompany()->CompanyName);
        $rtnArray = Template::TrackEmail(7, $CompanyUser->Id, $objEmail, array( '<!--USERNAME-->' => $CompanyUser->UserRelation->FirstName." ".$CompanyUser->UserRelation->LastName, '<!--COMPANYNAME-->' => $User->GetCurrentCompany()->CompanyName, '<!--ADMINNAME-->' => $User->FirstName." ".$User->LastName, '<!--LOGINURL-->' => APPROOT."resetpassword.php?".$Encrypt->encrypt('option=SetPassword&ActivateAccount=true&UserId='.$CompanyUser->UserId."&ExpireDate=".date("Y-m-d", mktime(0, 0, 0, date("m") , date("d")+2, date("Y"))))));

        return $rtnArray['EmailObject']->Send();

    }
    
    else {
         $rtnArray = false;
        switch ($TemplateId) {            
            case  8 :
                $objEmail = new Email($CompanyUser->UserRelation->UserLogin, NOTIFICATIONNAME .' <'.NOTIFICATIONEMAIL.'>', "We have signed you up as a client! - ".$User->GetCurrentCompany()->CompanyName);
                $rtnArray = Template::TrackEmail(8, $CompanyUser->Id, $objEmail, array( '<!--CLIENTNAME-->' => $CompanyUser->UserRelation->FirstName." ".$CompanyUser->UserRelation->LastName, '<!--COMPANYNAME-->' => $User->GetCurrentCompany()->CompanyName, '<!--CLIENTCOMPANYNAME-->' => $CompanyUser->CompanyRelation->CompanyName, '<!--USERNAME-->' => $User->FirstName." ".$User->LastName, '<!--LOGINURL-->' => APPROOT."resetpassword.php?".$Encrypt->encrypt('option=SetPassword&ActivateAccount=true&UserId='.$CompanyUser->UserRelation->Id."&ExpireDate=".date("Y-m-d", mktime(0, 0, 0, date("m") , date("d")+2, date("Y"))))));
                break;
            case  12:
                $objEmail = new Email($CompanyUser->UserRelation->UserLogin, NOTIFICATIONNAME .' <'.NOTIFICATIONEMAIL.'>', "We have signed you up as a vendor! - ".$User->GetCurrentCompany()->CompanyName);
                $rtnArray = Template::TrackEmail(12, $CompanyUser->Id, $objEmail, array( '<!--VENDORNAME-->' => $CompanyUser->UserRelation->FirstName." ".$CompanyUser->UserRelation->LastName, '<!--COMPANYNAME-->' => $User->GetCurrentCompany()->CompanyName, '<!--VENDORCOMPANYNAME-->' => $CompanyUser->CompanyRelation->CompanyName, '<!--USERNAME-->' => $User->FirstName." ".$User->LastName, '<!--LOGINURL-->' => APPROOT."resetpassword.php?".$Encrypt->encrypt('option=SetPassword&ActivateAccount=true&UserId='.$CompanyUser->UserRelation->Id."&ExpireDate=".date("Y-m-d", mktime(0, 0, 0, date("m") , date("d")+2, date("Y"))))));
                break;           
               
        }  
       
        return $rtnArray['EmailObject']->Send();

    }
}

/**
 *	@desc Resizes an image with the use of ImageMagick http://www.imagemagick.org/script/index.php
 * 	@param string @ImageLocation Location on the drive of the image to resize
 * 	@param int @Width New width of the image. Set to null if you wish to ignore
 * 	@param int @Height New height of the image. Set to null if you wish to ignore
 * 	@return bool Returns true if successful or otherwise false
 */
function ImageResize($ImageLocation, $Width, $Height) {
    $ImageDimensions = getimagesize($ImageLocation);

    if((isset($Width) && $ImageDimensions[0] > $Width) || (isset($Height) && $ImageDimensions[1] > $Height)) {
        if(strpos(PHP_OS, "WIN") !== false)
            $Command = 'C:\ImageMagick\convert.exe '.$ImageLocation;
        else
            $Command = '/usr/bin/convert '.$ImageLocation;

        if(isset($Height) xor isset($Width))
        {
            if(isset($Width))
                $Command .= ' -resize '.$Width.'x';
            else if(isset($Height))
                $Command .= ' -resize x'.$Height;
        }
            else
                $Command .= ' -resize '.$Width.'x'.$Height;

        //2>&1 will output all infomation (return codes, errors, etc) from the console so we can debug. Do not remove it!
        $Command .= ' '.$ImageLocation.' 2>&1';
        exec($Command, $Array, $ReturnCode);

        if($ReturnCode != 0) {
            global $User;
            $Log = new SystemLogging();
            $Log->Title = "Error Resizing Image";
            $Log->File = $ImageLocation;
            $Log->Line = 0;
            $Log->UserId = USERID;
            $Log->Message = "Error Resizing Image";
            $Log->Variables = $Log->GenerateHeader("Return Array").implode(",", $Array).$Log->GenerateFooter("Return Array").$Log->GenerateHeader("Return Code").$ReturnCode.$Log->GenerateFooter("Return Code").$Log->GenerateHeader("Command").$Command.$Log->GenerateFooter("Command");

            $Log->InsertLog();

            return false;
        }
    }

    return true;
}

/**
 *	@desc Returns the current page URL with the port, SSL, page and optional querystring
 * 	@param bool $GetQueryString Specify whether or not to return the querystring. Use the function GetQueryString if should need to add/remove encrypted values from the querystring
 * 	@return string Returns a URL for the current page
 */
function GetCurrentPage($GetQueryString = false) {
    $pageURL = 'http';
    //$pageURL .= ($_SERVER["HTTPS"] == "on") ? "s" : false;
    if('live' == CurrentServer()){
        $pageURL .= 's';
    }
    $pageURL .= "://";

    if ($_SERVER["SERVER_PORT"] != "80" && $_SERVER['HTTPS'] != "on")
        $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
    else
        $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];

    /*if($ReturnOnlyDirectory)
		{
			if(strpos($pageURL, ".php") !== false)
			{
				$Array = explode("/", $pageURL);
				$pageURL = "";

				foreach($Array as $Key => $Value)
				{
					if(strpos($Value, ".php"))
					{
						$Value = substr($Value, strpos($Value, ".php") + 4);
					}

					$pageURL .= $Value."/";
				}
			}
		}*/

    if(!$GetQueryString) {
        if(strpos($pageURL, ".php?") !== false || strpos($pageURL, "/?") !== false) {
            $pageURL = (strpos($pageURL, ".php?") !== false) ? substr($pageURL, 0, strpos($pageURL, ".php?") + 4) : substr($pageURL, 0, strpos($pageURL, "/?") + 1);
        }
    }

    return $pageURL;
}

/**
 *	@desc Returns a url for the current directory
 * 	@return string Returns a URL for the current directory
 */
function GetCurrentDirectory() {
    $PageURL = 'http';
    $PageURL .= ($_SERVER["HTTPS"] == "on") ? "s" : false;
    $PageURL .= "://";

    if ($_SERVER["SERVER_PORT"] != "80" && $_SERVER['HTTPS'] != "on")
        $PageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
    else
        $PageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];

    return substr($PageURL, 0, strrpos($PageURL, "/"));
}

/**
 *	@desc Generates a random string using letters and numbers
 * 	@param int $Length Specific the length of the string
 * 	@return string Returns a random string
 */
function GenerateSALT($Length = 32) {
    $salt = substr(md5(uniqid(rand(), true)), 0, $Length);
    return $salt;
}

/**
 *	@desc Computes the sha1 hash of the specified string. Used for hashing passwords
 * 	@param string $SALT Optional SALT of the string to concatenate to the beginning
 * 	@param string $Password String to HASH. Typically a users password
 * 	@return string Returns the sha1 hash of the specified string
 */
function GenerateHASH($SALT = false, $Password) {
    return sha1($SALT.$Password);
}

/**
 *	@desc Formats a date to the specified format. Optionally you can specify the format, to display the time, an end date with format and separator
 * 	@param mixed $StartDate The starting date to format. Can be a formatted datetime string or timestamp integer
 * 	@param mixed $StartDateFormat The formatting for the startdate. You may specify your own format or one from the database to use
 * 	@param bool $DisplayTime Specify whether to display the time
 * 	@param mixed $EndDate Optional ending date to format. Can be a formatted datetime string or timestamp integer
 * 	@param mixed $EndDateFormat The formatting for the enddate. You may specify your own format or one from the database to use
 * 	@param string $Separator The string used to separate the two dates. Useful for inserting your own text
 * 	@return string Returns a formatted string of the supplied parameters, or false if values are invalid
 */
function FormatDate($StartDate, $StartDateFormat = 'Y-m-d H:i:s', $DisplayTime = false, $EndDate = false, $EndDateFormat = false, $Separator = ' - ') {
    $StartDate = ($StartDate == EMPTYDATE) ? false : $StartDate;
    $StartDate = (!is_numeric($StartDate)) ? strtotime($StartDate) : $StartDate;

    if($EndDate !== false) {
        $EndDate = ($EndDate == EMPTYDATE) ? false : $EndDate;
        $EndDate = (!is_numeric($EndDate)) ? strtotime($EndDate) : $EndDate;
    }

    $EndDateFormat = ($EndDateFormat === false) ? $StartDateFormat : $EndDateFormat;

    if((is_numeric($StartDate) && $EndDate === false) || (is_numeric($StartDate) && $EndDate !== false && is_numeric($EndDate)))
        return ($EndDate !== false) ? FormatUserDate($StartDate, $StartDateFormat, $DisplayTime).$Separator.FormatUserDate($EndDate, $EndDateFormat, $DisplayTime) : FormatUserDate($StartDate, $StartDateFormat, $DisplayTime);

    return false;
}

function FormatUserDate($Date, $Format, $DisplayTime = false) {
            
          $ReturnString  = date($Format, $Date);          
         
           if($DisplayTime )
           {
                if(date('Y-m-d', $Date) == date('Y-m-d'))
                {
                $ReturnString = 'Today';    
                }
                else if(date('Y-m-d', $Date)== date('Y-m-d', strtotime('-1 day')))
                {
                $ReturnString = 'Yesterday';     
                }
                else if(date('Y-m-d', $Date) == date('Y-m-d', strtotime('tomorrow')))
                {                
                 $ReturnString = 'Tomorrow';     
                }
                
                $ReturnString  =  $ReturnString.' at '.date(TIMEFORMAT, $Date) ;
           }           
            
            
           return  $ReturnString;           
                       
    
}





function FormatNumber($Number, $Decimals = "2", $Sign = '') {
    if(NumberCheck($Number)) {
        switch(true) {
            case ($Number && $Decimals):
                return $Sign.number_format($Number, $Decimals, '.', ',');
            case ($Number && !$Decimals):
                return intval($Number);
            default:
                return 'N/A';
        }
    }

    return false;
}

function FormatMoney($Number = false, $CurrencySymbol = false, $RoundPrecision = 2) {
    if(is_numeric($CurrencySymbol)) {
        switch($CurrencySymbol) {
            case 10:
                $CurrencySymbol = '&#82;&#36;';
                break;
            case 11:
                $CurrencySymbol = '&#1083;&#1074;';
                break;
            case 14:
            case 15:
                $CurrencySymbol = '&#20803;';
                break;
            case 17:
                $CurrencySymbol = '&#75;&#269;';
                break;
            case 18:
                $CurrencySymbol = '&#107;&#114;';
                break;
            case 21:
                $CurrencySymbol = '&#163;';
                break;
            case 22:
                $CurrencySymbol = '&#128;';
                break;
            case 29:
                $CurrencySymbol = 'HK&#36;';
                break;
            case 30:
                $CurrencySymbol = '&#70;&#116;';
                break;
            case 31:
                $CurrencySymbol = '&#107;&#114;';
                break;
            case 32:
                $CurrencySymbol = '&#8360;';
                break;
            case 33:
                $CurrencySymbol = '&#82;&#112;';
                break;
            case 35:
                $CurrencySymbol = '&#8362;';
                break;
            case 37:
                $CurrencySymbol = '&#74;&#36;';
                break;
            case 38:
                $CurrencySymbol = '&#165;';
                break;
            case 40:
                $CurrencySymbol = '&#8361;';
                break;
            case 42:
                $CurrencySymbol = '&#163;';
                break;
            case 44:
                $CurrencySymbol = '&#82;&#77;';
                break;
            case 48:
                $CurrencySymbol = '&#402;';
                break;
            case 50:
                $CurrencySymbol = '&#107;&#114;';
                break;
            case 51:
                $CurrencySymbol = '&#8360;';
                break;
            case 54:
                $CurrencySymbol = '&#80;&#104;&#112;';
                break;
            case 56:
                $CurrencySymbol = '&#122;&#322;';
                break;
            case 58:
                $CurrencySymbol = '&#108;&#101;&#105;';
                break;
            case 59:
                $CurrencySymbol = '&#1088;&#1091&#1073;';
                break;
            case 60:
                $CurrencySymbol = '&#65020;';
                break;
            case 64:
                $CurrencySymbol = '&#82;';
                break;
            case 65:
                $CurrencySymbol = '&#8361;';
                break;
            case 69:
                $CurrencySymbol = '&#107;&#114;';
                break;
            case 70:
                $CurrencySymbol = '&#67;&#72;&#70;';
                break;
            case 71:
                $CurrencySymbol = '&#78;&#84;&#36;';
                break;
            case 72:
                $CurrencySymbol = '&#3647;';
                break;
            case 73:
                $CurrencySymbol = '&#84;&#84;&#36;';
                break;
            case 74:
                $CurrencySymbol = '&#8356;';
                break;
            case 76:
                $CurrencySymbol = '&#163;';
                break;
            case 78:
                $CurrencySymbol = '&#66;&#115;';
                break;
            default:
                $CurrencySymbol = '&#36;';
                break;
        }
    }

    if(strpos($Number, "-") !== false) {
        return "-".$CurrencySymbol.' '.substr(number_format(round($Number, $RoundPrecision), $RoundPrecision, ".", " "), 1);
    }

    return $CurrencySymbol.' '.number_format(round($Number, $RoundPrecision), $RoundPrecision, ".", " ");

}

function GetCookieCrumbArray($String) {
    $IndexOf = strpos($String, "/crm");
    $Tail = substr($String, $IndexOf + 1);
    return split("/", $Tail);
}

function IsMobile($ForceReload = false) {

    if(isset($_SESSION[ISMOBILE]) && !$ForceReload)
        if($_SESSION[ISMOBILE])
            return unserialize($_SESSION[ISMOBILE]);
        else
            return false;

    $mobile_browser = 0;
    $ReturnValue = false;
    $UserAgent = strtolower($_SERVER['HTTP_USER_AGENT']);

    if(preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|ipod|phone|iphone)/i', $UserAgent)) {
        $mobile_browser++;
        $ReturnValue = (preg_match('/(ipod|iphone)/i', $UserAgent)) ? 'ipod' : true;
    }

    if((strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml') > 0) || ((isset($_SERVER['HTTP_X_WAP_PROFILE']) || isset($_SERVER['HTTP_PROFILE'])))) {
        $mobile_browser++;
        $ReturnValue = true;
    }

    if (isset($_SERVER['ALL_HTTP']) && (strpos(strtolower($_SERVER['ALL_HTTP']),'OperaMini') > 0)) {
        $mobile_browser++;
        $ReturnValue = true;
    }

    $mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
    $mobile_agents = array(
            'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
            'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
            'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
            'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
            'newt','noki','palm','pana','pant','phil','play','port','prox','qwap',
            'sage','sams','sany','sch-','sec-','send','seri','sgh-','shar','sie-',
            'siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-','tosh',
            'tsm-','upg1','upsi','vk-v','voda','wap-','wm5 pie','wapa','wapi','wapp',
            'wapr','webc','winw','winw','xda','xda-');

    if( in_array($mobile_ua,$mobile_agents)) {
        $mobile_browser++;
        $ReturnValue = $mobile_ua;
    }
  
   
   //echo $mobile_ua;
   //
   //redirect blackberry torch browser to the web version
    
   if(eregi('blackberry 9800',$_SERVER['HTTP_USER_AGENT']))
   return false;
    else if($mobile_browser > 0)
        return $ReturnValue;
    else
        return false;
}

function TextScrubber($string) {
    return addslashes($string);
}

function TextRevert($string) {
    return stripslashes($string);
}

function RemoveSlashesArray($Array) {

    if(count($Array) != count($Array, 1)) {
        $MultiCount = (count($Array, 1) - count($Array)) / count($Array);
        foreach($Array as $key => $value) {
            foreach($value as $key2) {
                $Array[$key][$key2] = RemoveSlashesArray($Array[$key][$key2]);
            }
            unset($key2);
        }
        unset($value);
    }
    else {
        foreach($Array as $key => $value) {
            $Array[$key] = stripslashes($Array[$key]);
        }
        unset($value);
    }

    return $Array;
}

function ListTable($table, $id, $name, $fld_name='id', $where="", $order='', $type="checkbox", $selected='', $perRow=1) {
    $retval = '';
    global $DAL, $EnableCache;

    $sel_cat = "SELECT $id, $name FROM $table";
    if($where != '') $sel_cat .= '  WHERE  '.$where;
    if($order != '') $sel_cat .= ' ORDER BY '.$order;
    //$num_cat = $DAL->RowCount($sel_cat);

    $ResultSet = new ResultSet();

    if($ResultSet->LoadResult($sel_cat)) {
        $res_cat = $ResultSet->Result;
        $num_cat = $ResultSet->TotalResults;

        $sel_arr = array();
        if(!is_array($selected) && $selected!='') {
            $selected = str_replace('##',',',$selected);
            $selected = str_replace('#','',$selected);
            $sel_arr = split(',',$selected);
        }
        else if(is_array($selected))
            $sel_arr = $selected;

        if($type=='checkbox' && $num_cat > 0) {
            $CntCol = 1;
            for($srno = 0; $srno < $num_cat; $srno++) {
                if($CntCol==1) $retval .= '<div>';
                $retval .= "<input type='checkbox' name='".$fld_name."[]' value=".$res_cat[$srno][$id]."";
                if(in_array($res_cat[$srno][$id],$sel_arr)) // || array_search($res_cat[$srno][$id],$sel_arr))
                    $retval .= " checked";
                $retval .= "> ".stripslashes($res_cat[$srno][$name]);
                if($CntCol==$perRow && $srno<$num_cat-1) {
                    $retval .= '</div><div>';
                    $CntCol = 1;
                }
                else if($CntCol==$perRow && $srno==$num_cat-1) {
                    $retval .= '</div>';
                    $CntCol++;
                }
            }
        }
        else if($type=='list' && $num_cat > 0) {

            for($srno = 0; $srno < $num_cat; $srno++) {
                $retval .= "<option value=\"".$res_cat[$srno][$id]."\"";
                if(in_array($res_cat[$srno][$id],$sel_arr)) $retval .= " selected";
                $retval .= ">".stripslashes($res_cat[$srno][$name])."</option>";
            }
        }
        else if($type=='resultSet') {
            $retval = $ResultSet;
        }
        return $retval;
    }
}

function PrintDebugFooter() {
    global $DAL, $CacheCount, $IsPostBack, $EnableCache;
//?7uiJNnqtAWpSBXa2UBFs+w==
    $ReturnString = (!IsMobile()) ? '<script language="javascript">
							function EncryptDecrypt(Params)
							{
								var ReturnVal = AjaxFunction("F=3&Mode=" + Params + "&String=" + document.getElementById("__txtdecrypt").value);
								if(ReturnVal!="ERROR")
									document.getElementById("lblDecryptEncrypt").innerHTML = ReturnVal;
							}
							</script>' : false;

    $ReturnString .= "<div id='toggle' class='toggle deb' name='toggle' style=''><form method='post'><div class='debt' style='width:550px;'>Debug Info - <i>".CurrentServer()."</i></div><ul class='debul' style='width:550px;border-right:1px solid #ccc;float:left;'>";
    if(!IsMobile()) {
        $ReturnString .= "<li><input type='text' id='__txtdecrypt' name='__txtdecrypt' class='encrypt_field' />&nbsp;<input type='button' id='btnEncrypt' name='btnEncrypt' value='Encrypt' onclick='EncryptDecrypt(\"Encrypt\");' /> <input type='button' id='btnDecrypt' name='btnDecrypt' value='Decrypt' onclick='EncryptDecrypt(\"Decrypt\");' />";
        $ReturnString .= "<div style='padding:10px;border:1px dashed #bbb;width:500px;margin-top:10px;'><strong>Result:</strong> <span id='lblDecryptEncrypt' style='color: Red;' ></span></div></li>";
    }
    if(isset($EnableCache) && is_bool($EnableCache))
        $ReturnString .= ($EnableCache) ? "<li><strong>Current Page Cache:</strong> <span style='color: Green;' >Enabled</span></li>" : "<li><strong>Current Page Cache: </strong><span style='color: Red;' >Disabled</span></li>";
    if(isset($_SESSION[ISMOBILE]) && unserialize($_SESSION[ISMOBILE]) !== false)
        $ReturnString .= (unserialize($_SESSION[ISMOBILE]) === 'ipod') ? '<li><input name="btnDevChangeTemplate" type="submit" value="Switch to Desktop" ><input name="btnDevChangeTemplate" type="submit" value="Switch to Mobile" ></li>' : '<li><input name="btnDevChangeTemplate" type="submit" value="Switch to Desktop" ><input name="btnDevChangeTemplate" type="submit" value="Switch to High Mobile" ></li>';
    else
//        $ReturnString .= '<li><input name="btnDevChangeTemplate" type="submit" id="btnEncrypt" value="Switch to Mobile" ></li>';
    //$ReturnString .= '<li><input type="submit" name="btnEnableDebugger" value="Enable Debugger" onclick="javascript:location.href=location.protocol+\'//\'+location.hostname+location.pathname+\'?DBGSESSID=1;d=1,p=0\'"; return false; /> <input type="submit" name="btnDisableDebugger" value="Disable Debugger" onclick="javascript:location.href=location.protocol+\'//\'+location.hostname+location.pathname+\'?DBGSESSID=-1\'"; return false; /></li>';
    $ReturnString .= "</ul>";
    $ReturnString .='<script type="text/javascript">
                    var BrowserDetect = {
                    init: function () {
                    this.browser = this.searchString(this.dataBrowser) || "An unknown browser";
                    this.version = this.searchVersion(navigator.userAgent)
			|| this.searchVersion(navigator.appVersion)
			|| "an unknown version";
		this.OS = this.searchString(this.dataOS) || "an unknown OS";
	},
	searchString: function (data) {
		for (var i=0;i<data.length;i++)	{
			var dataString = data[i].string;
			var dataProp = data[i].prop;
			this.versionSearchString = data[i].versionSearch || data[i].identity;
			if (dataString) {
				if (dataString.indexOf(data[i].subString) != -1)
					return data[i].identity;
			}
			else if (dataProp)
				return data[i].identity;
		}
	},
	searchVersion: function (dataString) {
		var index = dataString.indexOf(this.versionSearchString);
		if (index == -1) return;
		return parseFloat(dataString.substring(index+this.versionSearchString.length+1));
	},
	dataBrowser: [
		{
			string: navigator.userAgent,
			subString: "Chrome",
			identity: "Chrome"
		},
		{ 	string: navigator.userAgent,
			subString: "OmniWeb",
			versionSearch: "OmniWeb/",
			identity: "OmniWeb"
		},
		{
			string: navigator.vendor,
			subString: "Apple",
			identity: "Safari",
			versionSearch: "Version"
		},
		{
			prop: window.opera,
			identity: "Opera"
		},
		{
			string: navigator.vendor,
			subString: "iCab",
			identity: "iCab"
		},
		{
			string: navigator.vendor,
			subString: "KDE",
			identity: "Konqueror"
		},
		{
			string: navigator.userAgent,
			subString: "Firefox",
			identity: "Firefox"
		},
		{
			string: navigator.vendor,
			subString: "Camino",
			identity: "Camino"
		},
		{		// for newer Netscapes (6+)
			string: navigator.userAgent,
			subString: "Netscape",
			identity: "Netscape"
		},
		{
			string: navigator.userAgent,
			subString: "MSIE",
			identity: "Explorer",
			versionSearch: "MSIE"
		},
		{
			string: navigator.userAgent,
			subString: "Gecko",
			identity: "Mozilla",
			versionSearch: "rv"
		},
		{ 		// for older Netscapes (4-)
			string: navigator.userAgent,
			subString: "Mozilla",
			identity: "Netscape",
			versionSearch: "Mozilla"
		}
	],
                    dataOS : [
		{
			string: navigator.platform,
			subString: "Win",
			identity: "Windows"
		},
		{
			string: navigator.platform,
			subString: "Mac",
			identity: "Mac"
		},
		{
			   string: navigator.userAgent,
			   subString: "iPhone",
			   identity: "iPhone/iPod"
	    },
		{
			string: navigator.platform,
			subString: "Linux",
			identity: "Linux"
		}
	]

};
                    BrowserDetect.init();
                    </script>';
    $ReturnString .= '<ul style="width:400px;float:right;padding-right:125px;line-height:150%;">';
    $ReturnString .= ' <li><strong>Browser: </strong><script type="text/javascript">document.write(BrowserDetect.browser + " " + BrowserDetect.version + " (" + BrowserDetect.OS+")");</script></li>';
    $ReturnString .= "<li><strong>Rendered:</strong></li>";
    $ReturnString .= "<li><strong>Queries:</strong> ".$DAL->QueryCount()."</li><li><strong>Cached: </strong>".$CacheCount."</li>";
    $ReturnString .= "<li><strong>Cookies Enabled: </strong><script type='text/javascript'>document.write(navigator.cookieEnabled);</script></li>";
    $ReturnString .='<li><strong>Resolution: </strong><script type="text/javascript">document.write(screen.width+" x "+screen.height);</script></li>';
    $ReturnString .= ($IsPostBack) ? "<li><strong>Post:</strong> This page was created due to a post back.</li>" : "<li><strong>Post:</strong> This page was loaded for the first time.</li>";
    $ReturnString .= (ENABLECACHE) ? "<li><strong>Global Caching:</strong> <span style='color: Green;' >Enabled</span></li>" : "<li><strong>Global Caching:</strong> <span style='color: Red;' >Disabled</span></li>";
//    $ReturnString .= "<li><strong>Current IP:</strong> ".$_SERVER['REMOTE_ADDR']."</li>";
//    $ReturnString .= "<li><strong>Current User Agent:</strong> ".$_SERVER['HTTP_USER_AGENT']."</li>";
//    $ReturnString .= "<li><strong>Current User Agent Short:</strong> ".strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4))."</li>";
//    $ReturnString .= (IsMobile()) ? "<li><strong>Output:</strong> Currently viewing on mobile</li>" : "<li><strong>Output:</strong> Currently viewing on desktop</li>" ;
    $ReturnString .= '</ul></form><div class="clear"></div></div>';

    return $ReturnString;
}

function CurrentServer() {
    global $ForceLivestage, $ForceLive;

    if((isset($ForceLive) && $ForceLive) || $_SERVER['SERVER_NAME'] == "www.supercarloans.ca" || $_SERVER['SERVER_NAME'] == "supercarloans.ca")
        return "live";
    else if((isset($ForceLivestage) && $ForceLivestage) || $_SERVER['SERVER_NAME'] == "supercarloans.vstudiozzz.com")
        return "vstudiozzz";
    else
        return "local";
}

function DebugMode() {
    global $Debug;

    if(CurrentServer() != "local") {
        /*
        if($Debug === true && SearchIPAddress($_SERVER['REMOTE_ADDR']))
            return true;
        else
            return false;
         */
        return false;
    }
    else {
        return $Debug;
    }
}

function SearchIPAddress($IPAddress) {
    global $RemoteDebugIPs;

    for($x = 0; $x <= count($RemoteDebugIPs) - 1; $x++) {
        if(strpos($RemoteDebugIPs[$x], "*")) {
            $IPBreakDown = explode(".", $IPAddress);
            $RemoteIPBreakDown = explode(".", $RemoteDebugIPs[$x]);
            $ReturnValue = true;

            for($y = 0; $y <= count($IPBreakDown) - 1; $y++) {
                if($RemoteIPBreakDown[$y] != "*" && $RemoteIPBreakDown[$y] != $IPBreakDown[$y]) {
                    $ReturnValue = false;
                    break;
                }
            }
            if($ReturnValue)
                return true;
        }
        else {
            if($RemoteDebugIPs[$x] == $IPAddress)
                return true;
        }
    }
    return false;
}

function DisplayValue($Value, $Empty='N/A') {
    return (!IsEmpty($Value)) ? $Value: $Empty;
}

function DisplayAddress($Address1 = false, $Address2 = false, $City = false, $Province = false, $Postal = false, $Country = false, $SingleLine = true, $Phone1 = false) {
    if($SingleLine) {
        $ReturnString .= (!IsEmpty($Address1)) ? $Address1 : false;
        $ReturnString .= (!IsEmpty($Address2)) ? " ".$Address2."" : false;
        $ReturnString .= (!IsEmpty($City)) ? "<br/>".$City.", " : false;
        $ReturnString .= (!IsEmpty($Province)) ? $Province : false;
        $ReturnString .= (!IsEmpty($Postal)) ? " ".$Postal."<br/>" : false;
        $ReturnString .= (!IsEmpty($Phone1)) ? " ".$Phone1 : false;
    }
    else {
        $ReturnString .= (!IsEmpty($Address1) || !IsEmpty($Address2)) ? $Address1." ".$Address2."<br />" : false;
        $ReturnString .= (!IsEmpty($City)) ? $City.", " : false;
        $ReturnString .= (!IsEmpty($Province)) ? $Province : false;
        $ReturnString .= (!IsEmpty($Postal)) ? " ".$Postal."<br />" : false;
        $ReturnString .= (!IsEmpty($Country)) ? ' '.$Country."<br/>" : false;
        $ReturnString .= (!IsEmpty($Phone1)) ? " ".$Phone1 : false;

    }
    return (IsEmpty($ReturnString)) ? false : $ReturnString;
}

function IsEmpty($String) {
    return ($String === false || $String === null || $String === "" || trim($String) == "") ? true : false;
}

function TruncateText($Text, $Length = 50, $EndChar = '...') {
    $ReturnString = '';
    if(strlen($Text) > $Length) {
        $ReturnString = substr($Text, 0, $Length).$EndChar;
    }
    else $ReturnString = $Text;

    return TextScrubber($ReturnString);
}

function PrintClassVariables($Object) {
    $Array = get_object_vars($Object);
    $ReturnString = false;

    foreach($Array as $Key => $Value) {
        $ReturnString .= "<div>[".$Key."] => ".$Value."</div>";
    }
    unset($Value);
    return $ReturnString;
}

//TODO: Unnesscesary SQL call. We can get anyones avatar info from their objects
function GetAvatar($AvId = 1,$AvatarName  = 'noimage.png') {
    global $User,$DAL;
    
    if( $User && NumberCheck($AvId) && $AvId > 1) {
        $DAL->SQLQuery("select FileLocation from ".TBLFILE." where Id=".$AvId);
        $AvName = $DAL->GetRow(false);
        if($AvName)
            $AvatarName = $AvName[0];
    }
    return $AvatarName;
}

function ReadXML($Data, $ReadAsFile = false) {
    // read the xml
    if($ReadAsFile)
        $Data = implode("",file($Data));

    $Parser = xml_parser_create();
    xml_parser_set_option($Parser,XML_OPTION_CASE_FOLDING,0);
    xml_parser_set_option($Parser,XML_OPTION_SKIP_WHITE,1);
    xml_parse_into_struct($Parser, $Data, $Values, $Tags);
    xml_parser_free($Parser);

    return $Values;
}

function InsertIntoXMLStructure($Array, $Target, $Tag = false) {
    $ArrayLength = count($Target);

    for($x = 0; $x <= $ArrayLength - 1; $x++) {
        $CurrentLevel = $Target[$x]['level'];
        if($Tag !== false) {
            //Try and find the tag, If we can find it then insert before, after or replace as specified
            if($CurrentLevel == $Array['level'] && isset($Target[$x + 1]) && $Target[$x + 1]['level'] == ($Array['level'] - 1)) {
                $Front = array_slice($Target, 0, $x + 1);
                $Tail = array_slice($Target, $x + 1);
                $Front[] = $Array;

                $TailLength = count($Tail);
                for($x = 0; $x <= $TailLength - 1; $x++) {
                    $Front[] = $Tail[$x];
                }

                return $Front;
            }
        }
        else {
            if($CurrentLevel == $Array['level'] && isset($Target[$x + 1]) && $Target[$x + 1]['level'] == ($Array['level'] - 1)) {
                $Front = array_slice($Target, 0, $x + 1);
                $Tail = array_slice($Target, $x + 1);
                $Front[] = $Array;

                $TailLength = count($Tail);
                for($x = 0; $x <= $TailLength - 1; $x++) {
                    $Front[] = $Tail[$x];
                }

                return $Front;
            }
        }

    }

    return false;
}

function CreateXMLFromStructure($Array) {
    $ArrayLength = count($Array);
    $XML = '<?xml version="1.0" encoding="UTF-8"?>';

    for($x = 0; $x <= $ArrayLength - 1; $x++) {
        $Element = $Array[$x];
        if($Element['type'] == "open" || $Element['type'] == 'complete') {
            if(isset($Element['attributes']) && is_array($Element['attributes'])) {
                $XML .= "<".$Element['tag'];
                foreach($Element['attributes'] as $Key => $Value) {
                    $XML .= " ".$Key.'="'.$Value.'"';
                }
                unset($Value);
                if($Element['type'] == "open")
                    $XML .= " >";
                else if($Element['type'] == "complete" && $Element['value'] != "")
                    $XML .= ">".$Element['value']."</".$Element['tag'].">";
                else if($Element['type'] == "complete" && $Element['value'] == "")
                    $XML .= " />";
            }
            else {
                $XML .= ($Element['type'] == "open") ? "<".$Element['tag'].">" : "<".$Element['tag'].">".$Element['value']."</".$Element['tag'].">";
            }
        }
        else if($Element['type'] == "close")
            $XML .= "</".$Element['tag'].">";

    }

    return $XML;
}

function ProductFields($Result) {
    $Fields = array();
    $NumFileds = count($Result);
    for($inc = 0; $inc <$NumFileds; $inc++) {
        if($Result[$inc]['tag'] == "Field" && ($Result[$inc]['attributes']['Type'] == "Multiple" || $Result[$inc]['attributes']['Type'] == "Text" || $Result[$inc]['attributes']['Type'] == "Number" )) {
            $Fields[] = $Result[$inc]['attributes']['Name'];
        }
    }
    return $Fields;
}

function ListTime($WhichArray, $Selected = '') {
    $ReturnVal = '';

    foreach($WhichArray as $Key => $Value) {
        $ReturnVal .= '<option value="'.$Key.'"';
        if($Key==$Selected) $ReturnVal .= ' selected ';
        $ReturnVal .= '>'.$Value.'</option>';

    }
    unset($Value);
    return $ReturnVal;
}

/**
 *@desc Returns an array with the time difference between the two dates
 */

function GetTimeDifference($start, $end) {
    //Should any negative numbers be return then the end date is earilier than the start date
    //print "Start Date = '".$start."'<br />End Date = '".$end."'<br />";

    $uts['start'] = (!is_numeric($start)) ? strtotime($start) : $start;
    $uts['end'] = (!is_numeric($end)) ? strtotime($end) : $end;

    if($uts['start'] != $uts['end']) {

        if( $uts['start'] !== -1 && $uts['end'] !== -1 ) {
            if( $uts['end'] >= $uts['start'] ) {
                $diff = $uts['end'] - $uts['start'];
                if( $days=intval((floor($diff/86400))) )
                    $diff = $diff % 86400;
                if( $hours=intval((floor($diff/3600))) )
                    $diff = $diff % 3600;
                if( $minutes=intval((floor($diff/60))) )
                    $diff = $diff % 60;

                $diff = intval( $diff );

                return( array('days'=>$days, 'hours'=>$hours, 'minutes'=>$minutes, 'seconds'=>$diff) );

            }
        }
    }

    return false;
}

function DateCompare($Date, $Today) {

    if(!is_numeric($Date))
        $Date = strtotime($Date);
    if(!is_numeric($Today))
        $Today = strtotime($Today);

    $Date = getdate($Date);
    $Today = getdate($Today);

    return ($Today['year']."-".$Today['mon'].$Today['mday'] == $Date['year']."-".$Date['mon'].$Date['mday']) ? true : false;

}

/**
 * @desc Checks the given date is valid or not
 * @param string may be a string or timestamp int. Strings must be in the format year/month/day
 */

function DateIsValid($Date) {
    if(is_numeric($Date))
        $DateTimeArray = getdate($Date);
    else
        $DateTimeArray = getdate(strtotime($Date));
    list($Year, $Month, $Day) = split("[/.-]", $Date);

    //return (checkdate($Month, $Day, $Year)) ? true : false ;
    return (checkdate($DateTimeArray['mon'], $DateTimeArray['mday'], $DateTimeArray['year'])) ? true : false ;

}
function getFirstLetter($StringVal) {
    if(!IsEmpty($StringVal)) {
        preg_match('/^[^a-z]*([a-z])/im',$StringVal,$FirstLetter);
        return strtoupper($FirstLetter[1]);
    }
    return false;
}

function PrintTimestamp($Format = false) {
    $Format = ($Format === false) ? MYSQLDATETIMEFORMAT : $Format;
    return date($Format, time());
}

function DisplayName($args) {
    $ContactName = (!IsEmpty($args['FirstName']) || !IsEmpty($args['LastName'])) ? trim($args['FirstName'].' '.$args['LastName']) : false;
    $CompanyName = (!IsEmpty($args['CompanyName'])) ? $args['CompanyName'] : false;

    if($args['ClientId'])
        return $args['CompanyName'].' - '.$args['FirstName'].' '.$args['LastName'];
}

function Click2DialCheck() {
    // I suppose this is on.
    return false;
}

function CreateClick2DialLink($PhoneNumber, $CompanyUserId) {
    global $Encrypt;

    return (Click2DialCheck() && !IsEmpty($PhoneNumber) && RegExValidator($PhoneNumber, 3)) ? '<a href="'.$approot.'click2dial/dial.php?'.$Encrypt->encrypt('PhoneNumber='.$PhoneNumber).'" title="Click to call this number" class="co">'.$PhoneNumber.'</a>' : DisplayValue($PhoneNumber);
}

function ByteSize($bytes)
    {
    $size = $bytes / 1024;
    if($size < 1024)
        {
        $size = number_format($size, 2);
        $size .= ' KB';
        }
    else
        {
        if($size / 1024 < 1024)
            {
            $size = number_format($size / 1024, 2);
            $size .= ' MB';
            }
        else if ($size / 1024 / 1024 < 1024)
            {
            $size = number_format($size / 1024 / 1024, 2);
            $size .= ' GB';
            }
        }
    return $size;
 }

 function GetItemArr($idArr = array(), $table = '', $idField='Id', $nameField='Name'){
    $itemResults = array();
    if(count($idArr) > 0){
        $SQL = "SELECT {$idField} as Id, {$nameField} as Name FROM {$table} WHERE {$idField} IN (".implode(',', $idArr).')';
        $ResultSet = new ResultSet();
        if($ResultSet->LoadResult($SQL) && ($ResultSet->TotalResults > 0)){
            foreach($ResultSet->Result as &$result){
                $itemResults[$result[$idField]] = $result[$nameField];
            }
        }
    }
    echo $SQL;
    return $itemResults;
}


function ConvertMinutesToHours($Minutes)
{
    if ($Minutes < 0)
    {
        $Min = Abs($Minutes);
    }
    else
    {
        $Min = $Minutes;
    }

    $iHours = (int)($Min / 60);
    $Minutes = (int)($Min - $iHours * 60) ;
   
    return (($iHours)?(($iHours<10)?("0".$iHours):$iHours):"00").":".(($Minutes)?(($Minutes<10)?("0".$Minutes):$Minutes):"00");
  
}

function fetch_page($url, $host_ip = NULL) 
    { 

      $ch = curl_init(); 

      if (!is_null($host_ip)) 
      { 
        $urldata = parse_url($url); 

        //  Ensure we have the query too, if there is any... 
        if (!empty($urldata['query'])) 
          $urldata['path'] .= "?".$urldata['query']; 

        //  Specify the host (name) we want to fetch... 
        $headers = array("Host: ".$urldata['host']); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); 

        //  create the connecting url (with the hostname replaced by IP) 
        $url = $urldata['scheme']."://".$host_ip.$urldata['path']; 
      } 

      curl_setopt($ch,  CURLOPT_URL, $url); 
      curl_setopt ($ch, CURLOPT_HEADER, 0); 
      curl_setopt($ch,  CURLOPT_RETURNTRANSFER, true); 

      $result = curl_exec ($ch); 
      curl_close ($ch); 

      return $result; 
    } 




function parse_path() {
  $path = array();
  if (isset($_SERVER['REQUEST_URI'])) {
    $request_path = explode('?', $_SERVER['REQUEST_URI']);

    $path['base'] = rtrim(dirname($_SERVER['SCRIPT_NAME']), '\/');
    $path['call_utf8'] = substr(urldecode($request_path[0]), strlen($path['base']) + 1);
    $path['call'] = utf8_decode($path['call_utf8']);
    if ($path['call'] == basename($_SERVER['PHP_SELF'])) {
      $path['call'] = '';
    }
    $path['call_parts'] = explode('/', $path['call']);

    $path['query_utf8'] = urldecode($request_path[1]);
    $path['query'] = utf8_decode(urldecode($request_path[1]));
    $vars = explode('&', $path['query']);
    foreach ($vars as $var) {
      $t = explode('=', $var);
      $path['query_vars'][$t[0]] = $t[1];
    }
  }
return $path;
}





?>