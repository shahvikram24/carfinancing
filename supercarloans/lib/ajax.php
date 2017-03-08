<?
include("../include/files.php");
$ResultMessage = 'ERROR';


    if(is_array($_POST)) {
        if(isset($_POST['P']))
            $UrlString = $Decrypt->decrypt($_POST["Params"]);
        else {
            foreach($_POST as $Key => $Value) {
                $UrlString .= '&'.$Key.'='.$Value;
            }

            $UrlString = substr($UrlString, 1);
        }

        parse_str($UrlString);

        $Function = (isset($Function)) ? $Function : $F;

        switch($Function) {
            
            case 3:
            case 'EncryptDecrypt':
                            
                    if($Mode == 'Encrypt')
                        $ResultMessage = $Encrypt->encrypt($String);
                    else
                        $ResultMessage = $Decrypt->decrypt($String);
                break;

        }
    }

echo $ResultMessage;


?>