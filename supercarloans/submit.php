<?php 

    require_once("include/files.php");
    
   

    if(isset($_POST['ContactInfoId']) && $_POST['ContactInfoId']!='')
    {        
        $ContactInfoId = $_POST['ContactInfoId'];
        $ContactInfo = new ContactInfo();
        $ContactInfo->loadContactInfo($ContactInfoId);
        
    }
    else
    {
        session_unset();
        session_destroy();
        session_write_close();
        header('Location:index.php');
        exit();
    }

    if(isset($_POST['Finish']) && $_POST['Finish'] == 'Finish')
    {
        
        $DOB= $_POST['DYear'] . "-" . $_POST['DMon'] . "-" . $_POST['DDate'];
        //tblcontactinfo - primary applicant
        $ContactInfo->Address1 = $_POST['Address1'];
        $ContactInfo->Postal = $_POST['Postal'];
        $ContactInfo->City = $_POST['City'];
        $ContactInfo->Province = $_POST['Province'];
        $ContactInfo->SIN = $_POST['Sin'];
        $ContactInfo->DOB = FormatDate($DOB,'Y-m-d');
        $ContactInfo->MaritalStatus = $_POST['MaritalStatus'];
        $ContactInfo->Gender = $_POST['Gender'];
        $ContactInfo->ResidenceYears = $_POST['ResidenceYears'];
        $ContactInfo->ResidenceMonths = $_POST['ResidenceMonths'];
        $ContactInfo->Created = date('Y-m-d H:i:s');
        $ContactInfo->Status = 1;
        $ContactInfo->updateContactInfo();


        //echo "<br/> ContactInfo completed <br/>";

        //tblmortgage - applicant
        $Mortgage = new Mortgage();

        $MortgageId = 0;
        $Mortgage->MortgageType = "'". TypeOfHouse($_POST['TypeOfHouse']) . "'";
        $Mortgage->MortgagePayment = ($_POST['MonthlyPayment']) ? $_POST['MonthlyPayment'] : 0.00;
        $Mortgage->MortgageAmount = ($_POST['MortgageAmount']) ? $_POST['MortgageAmount'] : 0.00;
        $Mortgage->MortgageHolder = ($_POST['MortgageHolder']) ? $_POST['MortgageHolder'] : '';
        $Mortgage->MarketValue = ($_POST['MarketValue']) ? $_POST['MarketValue'] : 0.00;
        $Mortgage->Status = 1;
        $MortgageId = $Mortgage->addMortgage();

        //echo "<br/> Mortgage completed <br/>";

        //tblemployment - applicant
        $Employment = new Employment();
        $Employment->EmpStatusId   = $Decrypt->decrypt($_POST['EmploymentStatus']);
        $Employment->EmpTypeId   = $Decrypt->decrypt($_POST['EmploymentType']);
        $Employment->OrganizationName   = ($_POST['EmpWorkplace']) ? $_POST['EmpWorkplace'] : '';
        $Employment->JobTitle   = $_POST['EmpJobTitle'];
        $Employment->Address1   = $_POST['EmpAddress1'];
        $Employment->City   = $_POST['EmpCity'];
        $Employment->Province   = $_POST['EmpProvince'];
        $Employment->Postal   = $_POST['EmpPostal'];
        $Employment->Phone1   = $_POST['EmpPhone'];
        $Employment->EmpYears   = $_POST['EmpYears'];
        $Employment->EmpMonths   = $_POST['EmpMonths'];
        $Employment->GrossIncome   = ($_POST['GrossIncome']) ? $_POST['GrossIncome'] : 0.00;
        $Employment->OtherIncome   = ($_POST['OtherIncomeAmount']) ? $_POST['OtherIncomeAmount'] : 0.00;
        if($Decrypt->decrypt($_POST['OtherIncomeFrequency']) != '')
            $Employment->FrequencyId   = $Decrypt->decrypt($_POST['OtherIncomeFrequency']);
        else
            $Employment->FrequencyId   = 5;

        if($Decrypt->decrypt($_POST['OtherIncomeFrequency']) != '')
            $Employment->OtherIncomeTypeId   = $Decrypt->decrypt($_POST['OtherIncome']);
        else
            $Employment->OtherIncomeTypeId   = 9;

        $Employment->Status   = 1;
        $EmploymentId = $Employment->addEmployment();

        
        $PreviousEmploymentId = 0;

        if( $_POST['EmpYears'] <= 1 )
        {
            
            $PreviousEmployment = new PreviousEmployment();
            $PreviousEmployment->Name = $_POST['PreEmployer'];
            $PreviousEmployment->PrevEmpYears = $_POST['PreEmployerYears'];
            $PreviousEmployment->PrevEmpMonths = $_POST['PreEmployerMonths'];
            $PreviousEmployment->Status   = 1;
            $PreviousEmploymentId = $PreviousEmployment->addPreviousEmployment();

            //echo "<br/> PreviousEmployment completed <br/>";

        }

        $ContactId =0;
        //tblcontact - applicant 
        $Contact = new Contact();
        $Contact->ContactInfoId = $ContactInfoId;
        $Contact->MortgageId = $MortgageId ;
        $Contact->EmploymentId = $EmploymentId;
        $Contact->PreviousEmpId = $PreviousEmploymentId;
        $Contact->CreateDate = date('Y-m-d H:i:s');
        $Contact->Status = 2;
        $ContactId = $Contact->addContact();
        //////////////////////////////////////////////////////////////////////////////////////////////

        //echo "<br/> Contact completed <br/>";

        //affiliatetransaction update affiliate
        $affiliateTransaction = new AffiliateTransaction();
        if($affiliateTransaction->loadTransactionByContactInfo($_REQUEST['ContactInfoId']))
        {
            $affiliateTransaction->status = 1;
            $affiliateTransaction->description = 2;
            $affiliateTransaction->UpdateTransaction();
        }

        //tblcontactinfo - coapplicant
        if($_POST['chkCoApplicantToggle'])
        {
            $CoDate= $_POST['Co-DYear'] . "-" . $_POST['Co-DMon'] . "-" . $_POST['Co-DDate'];
            $CoContactInfo = new ContactInfo();

            $CoContactInfo->FirstName = $_POST['Co-FirstName'];
            $CoContactInfo->LastName = $_POST['Co-LastName'];
            $CoContactInfo->Email = $_POST['Co-EmailAddress'];
            $CoContactInfo->Phone1 = $_POST['Co-Phone'];
            $CoContactInfo->Address1 = $_POST['Co-Address1'];
            $CoContactInfo->Postal = $_POST['Co-Postal'];
            $CoContactInfo->City = $_POST['Co-City'];
            $CoContactInfo->Province = $_POST['Co-Province'];
            $CoContactInfo->Phone1 = $_POST['Co-Phone'];
            $CoContactInfo->SIN = $_POST['Co-Sin'];
            $CoContactInfo->DOB = $CoDate;
            $CoContactInfo->MaritalStatus = $_POST['Co-MaritalStatus'];
            $CoContactInfo->Gender = $_POST['Co-Gender'];
            $CoContactInfo->Status = 1;
            $CoContactInfoId = $CoContactInfo->addContactInfo();

            //echo "<br/> CoContactInfo completed <br/>";
        
                $CoEmploymentId= 0;
                $PreviousCoEmploymentId = 0;
                if($_POST['chkCoApplicantEmploymentToggle'])
                {

                   //tblemployment - co-applicant
                        $CoEmployment = new Employment();
                        $CoEmployment->EmpStatusId   = $Decrypt->decrypt($_POST['CoEmploymentStatus']);
                        $CoEmployment->EmpTypeId   = $Decrypt->decrypt($_POST['CoEmploymentType']);
                        $CoEmployment->OrganizationName   = $_POST['CoEmpWorkplace'];
                        $CoEmployment->JobTitle   = '';
                        $CoEmployment->Address1   = $_POST['CoEmpAddress1'];
                        $CoEmployment->City   = $_POST['CoEmpCity'];
                        $CoEmployment->Province   = $_POST['CoEmpProvince'];
                        $CoEmployment->Postal  = $_POST['CoEmpPostal'];
                        $CoEmployment->Phone1   = $_POST['CoEmpPhone'];
                        $CoEmployment->EmpYears   = $_POST['CoEmpYears'];
                        $CoEmployment->EmpMonths   = $_POST['CoEmpMonths'];
                        $CoEmployment->GrossIncome   = $_POST['CoMonthlyGrossIncome'];
                        $CoEmployment->OtherIncome   = $_POST['CoOtherIncomeAmount'];
                        $CoEmployment->FrequencyId   = $Decrypt->decrypt($_POST['CoOtherIncomeFrequency']);
                        $CoEmployment->OtherIncomeTypeId   = $Decrypt->decrypt($_POST['CoOtherIncome']);
                        $CoEmployment->Status   = 1;
                        $CoEmploymentId = $CoEmployment->addEmployment();

                       // echo "<br/> CoEmployment completed <br/>";
                        $PreviousCoEmploymentId = 0;

                        if( $_POST['CoEmpYears'] <= 1 )
                        {
                            $PreviousCoEmployment = new PreviousEmployment();
                            $PreviousCoEmployment->Name = $_POST['CoPreEmployer'];
                            $PreviousCoEmployment->PrevEmpYears = $_POST['CoPreEmployerYears'];
                            $PreviousCoEmployment->PrevEmpMonths = $_POST['CoPreEmployerMonths'];
                            $PreviousCoEmployment->Status   = 1;
                            $PreviousCoEmploymentId = $PreviousCoEmployment->addPreviousEmployment();

                           //echo "<br/> PreviousCoEmployment completed <br/>";

                        }
                }

                $CoApplicantId = 0;
                //tblcoaplicant - coapplicant 
                $CoApplicant = new CoApplicant();
                $CoApplicant->ContactInfoId = $CoContactInfoId;
                $CoApplicant->EmploymentId = $CoEmploymentId ;
                $CoApplicant->PreviousEmpId = $PreviousCoEmploymentId;
                $CoApplicant->RelationContactId = $ContactId;
                $CoApplicant->Relation = $_POST['Co-Relation'];
                $CoApplicant->Status = 1;
                $CoApplicantId = $CoApplicant->addCoApplicant();

               //echo "<br/> CoApplicant completed <br/>";
                //////////////////////////////////////////////////////////////////////////////////////////////
        }
        
                
                if($ContactInfo->Email !='')
                {
                    $VerifyManual = APPROOT.'info.php?' . $Encrypt->encrypt('ContactId='.$ContactId.'&Verify=true');
                    $Name = $ContactInfo->FirstName . " " . $ContactInfo->LastName;

                    ContactInfo::ConfirmAccount($ContactInfo->Email,$VerifyManual,$Name);
                }
                

            session_unset();
            session_destroy();
            session_write_close();
            header('Location:index.php?' . $Encrypt->encrypt("Message=Congratulations. Now sit back, relax and wait for your approval phone call."));
                
    }



    function TypeOfHouse($Type)
    {
        
        switch($Type)
        {
            case "OW": return "Own with Mortgage"; break;
            case "OF": return "Own Free Clear"; break;
            case "RE": return "Rent"; break;
            case "PA": return "With Parents"; break;
            case "RH": return "Reserve Housing"; break;
            case "OT": return "Other"; break;
            default: return '';
        }
    }
?>