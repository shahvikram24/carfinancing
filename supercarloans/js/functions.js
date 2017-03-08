//By default send order button would not be visible


function PrimaryApplicantToggle()
{
	var Address1 = $('#Address1').val();
	var City = $('#City').val();
	var Province = $('#Province').val();
	
	var Gender = $('#Gender').val();


	var years =  $('#ResidenceYears').val();
	var months =  $('#ResidenceMonths').val();
	var TypeOfHouse =  $('#TypeOfHouse').val();
	var MonthlyPayment =  $('#MonthlyPayment').val();
	var MortgageAmount =  $('#MortgageAmount').val();
	var MortgageHolder =  $('#MortgageHolder').val();
	var MarketValue =  $('#MarketValue').val();
	
	
	
	if(Address1.length == 0)
	{
		alert("Enter Residential Address");
		$("#Address1").focus();
		return false;
	}
	 /* =========================== */
	if(City.length == 0)
	{
		alert("Enter City of Residence");
		$("#City").focus();
		return false;
	}
	 /* =========================== */
	if(Province.length == 0)
	{
		alert("Enter Province of Residence");
		$("#Province").focus();
		return false;
	}
	 
	 /* =========================== */
	if(Gender.length == 0)
	{
		alert("Provide your gender");
		$("#Gender").focus();
		return false;
	}
	 /* =========================== */
	if(years.length == 0)
	{
		alert("Enter Years of Residence");
		$("#ResidenceYears").focus();
		return false;
	}	
	/* =========================== */

	if(months < 0 || months > 11)
	{
		alert("Enter Months of Residence Between 0 to 11");
		$("#ResidenceMonths").focus();
		return false;
	}

	/* =========================== */
	if(TypeOfHouse == "OW")
	{
		
		
		if(MonthlyPayment.length==0)
		{
			alert("Enter Monthly Payment Amount");
			$("#MonthlyPayment").focus();
			return false;
		}

		if(MortgageAmount.length==0)
		{
			alert("Enter Mortgage Amount");
			$("#MortgageAmount").focus();
			return false;
		}

		if(MortgageHolder.length==0)
		{
			alert("Enter Mortgage Holder");
			$("#MortgageHolder").focus();
			return false;
		}

		if(MarketValue.length==0)
		{
			alert("Enter Market Value Amount");
			$("#MarketValue").focus();
			return false;
		}
	}

	var EmploymentStatus = $('#EmploymentStatus').val();
	var EmploymentType = $('#EmploymentType').val();
	var EmpWorkplace = $('#EmpWorkplace').val();
	var EmpJobTitle = $('#EmpJobTitle').val();

	/*var Address1 = $('#EmpAddress1').val();*/
	var City1 = $('#EmpCity').val();
	var Province1 = $('#EmpProvince').val();
	
	
	var years1 =  $('#EmpYears').val();
	var months1 =  $('#EmpMonths').val();

	if(EmploymentStatus.length == 0)
	{
		alert("Select Your Employment Status");
		$("#EmploymentStatus").focus();
		return false;
	}
	 /* =========================== */
	if(EmploymentType.length == 0)
	{
		alert("Select Type of Employment");
		$("#EmploymentType").focus();
		return false;
	}
	 /* =========================== */

	if(EmpWorkplace.length == 0)
	{
		alert("Enter Name of the Workplace");
		$("#EmpWorkplace").focus();
		return false;
	}
	 /* =========================== */

	if(EmpJobTitle.length == 0)
	{
		alert("Enter the Job Title");
		$("#EmpJobTitle").focus();
		return false;
	}

	
	 /* =========================== */
	if(City1.length == 0)
	{
		alert("Enter City of Workplace");
		$("#EmpCity").focus();
		return false;
	}
	 /* =========================== */
	if(Province1.length == 0)
	{
		alert("Enter Province of Workplace");
		$("#EmpProvince").focus();
		return false;
	}
	 /* =========================== */

	if(years1.length == 0)
	{
		alert("Enter Years of Employment");
		$("#EmpYears").focus();
		return false;
	}
	 /* =========================== */

	if(months1.length == 0 )
	{
		alert("Enter Months of Employment");
		$("#EmpMonths").focus();
		return false;
	}
	 /* =========================== */

	if(months1 < 0 || months1 > 11)
	{
		alert("Enter Months of Employment Between 0 to 11");
		$("#EmpMonths").focus();
		return false;
	}

	if(years1 <= 0)
    {
        var PreEmployer = $('#PreEmployer').val();
		var PreEmployerYears = $('#PreEmployerYears').val();
		var PreEmployerMonths = $('#PreEmployerMonths').val();

				/* =========================== */
			if(PreEmployer.length == 0)
			{
				alert("Enter Name of the Previous Employer");
				$("#PreEmployer").focus();
				return false;
			}
			 /* =========================== */

			if(PreEmployerYears.length == 0)
			{
				alert("Enter Years of Previous Employment");
				$("#PreEmployerYears").focus();
				return false;
			}
			 /* =========================== */

			if(PreEmployerMonths.length == 0 )
			{
				alert("Enter Months of Previous Employment");
				$("#PreEmployerMonths").focus();
				return false;
			}
			 /* =========================== */

			if(PreEmployerMonths < 0 || PreEmployerMonths > 11)
			{
				alert("Enter Months of Previous Employment Between 0 to 11");
				$("#PreEmployerMonths").focus();
				return false;
			}

    }
    
	 /* =========================== */
	 
	return true;
	
	
}


function CoapplicantToggleCheck()
{
	$chk = $("#chkCoApplicantToggle:checked").val();
	

	if($chk == 1)
	{	
		var FirstName1 = $('#CoFirstName').val();
		var LastName1 = $('#CoLastName').val();
		var Email1 = $('#CoEmailAddress').val();		
		var City1 = $('#CoCity').val();
		var Province1 = $('#CoProvince').val();
		var Postal1 = $('#CoPostal').val();



		/* =========================== */
		if(FirstName1.length == 0)
		{
			alert("Enter Coapplicant first name");
			$("#CoFirstName").focus();
			return false;
		}
		 /* =========================== */
		if(LastName1.length == 0)
		{
			alert("Enter Coapplicant last name");
			$("#CoLastName").focus();
			return false;
		}
		/* =========================== */
		if(Email1.length == 0)
		{
			alert("Enter Email address of Coapplicant");
			$("#CoEmailAddress").focus();
			return false;
		}
		 /* =========================== */
		 /* =========================== */
		if(City1.length == 0)
		{
			alert("Enter City of Residence");
			$("#CoCity").focus();
			return false;
		}
		 /* =========================== */
		 /* =========================== */
		if(Province1.length == 0)
		{
			alert("Enter Coapplicant Province");
			$("#CoProvince").focus();
			return false;
		}
		 /* =========================== */
		 if(Postal1.length == 0)
		{
			alert("Enter Coapplicant Postal code");
			$("#CoPostal").focus();
			return false;
		}
		 /* =========================== */
		
		var CoEmploymentStatus = $('#CoEmploymentStatus').val();
		var CoEmploymentType = $('#CoEmploymentType').val();
		
		/*var Address1 = $('#EmpAddress1').val();*/
		var CoEmpCity = $('#CoEmpCity').val();
		var CoEmpProvince = $('#CoEmpProvince').val();
		
		
		var years1 =  $('#CoEmpYears').val();
		var months1 =  $('#CoEmpMonths').val();

		if(CoEmploymentStatus.length == 0)
		{
			alert("Select Your Employment Status");
			$("#CoEmploymentStatus").focus();
			return false;
		}
		 /* =========================== */
		if(CoEmploymentType.length == 0)
		{
			alert("Select Type of Employment");
			$("#CoEmploymentType").focus();
			return false;
		}
		 /* =========================== */

		

		
		 /* =========================== */
		if(CoEmpCity.length == 0)
		{
			alert("Enter City of Workplace");
			$("#CoEmpCity").focus();
			return false;
		}
		 /* =========================== */
		if(CoEmpProvince.length == 0)
		{
			alert("Enter Province of Workplace");
			$("#CoEmpProvince").focus();
			return false;
		}
		 /* =========================== */

		if(years1.length == 0)
		{
			alert("Enter Years of Employment");
			$("#CoEmpYears").focus();
			return false;
		}
		 /* =========================== */

		if(months1.length == 0 )
		{
			alert("Enter Months of Employment");
			$("#CoEmpMonths").focus();
			return false;
		}
		 /* =========================== */

		if(months1 < 0 || months1 > 11)
		{
			alert("Enter Months of Employment Between 0 to 11");
			$("#CoEmpMonths").focus();
			return false;
		}

		if(years1 <= 0)
	    {
	        var PreEmployer = $('#CoPreEmployer').val();
			var PreEmployerYears = $('#CoPreEmployerYears').val();
			var PreEmployerMonths = $('#CoPreEmployerMonths').val();

				/* =========================== */
			if(PreEmployer.length == 0)
			{
				alert("Enter Name of the Previous Employer");
				$("#CoPreEmployer").focus();
				return false;
			}
			 /* =========================== */

			if(PreEmployerYears.length == 0)
			{
				alert("Enter Years of Previous Employment");
				$("#CoPreEmployerYears").focus();
				return false;
			}
			 /* =========================== */

			if(PreEmployerMonths.length == 0 )
			{
				alert("Enter Months of Previous Employment");
				$("#CoPreEmployerMonths").focus();
				return false;
			}
			 /* =========================== */

			if(PreEmployerMonths < 0 || PreEmployerMonths > 11)
			{
				alert("Enter Months of Previous Employment Between 0 to 11");
				$("#CoPreEmployerMonths").focus();
				return false;
			}

   		 }

   	}
	/* =========================== */
	return true;
}

