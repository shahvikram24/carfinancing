//By default send order button would not be visible

function toggleApprove(check)
{
	check = parseInt(check) - parseInt("1");
	//alert(check);

	chkvaluer=document.DeleteFrm.elements['del[]'];
	chkvaluedel=document.DeleteFrm.elements['delreason[]'];
	
			
			if(chkvaluer[check].disabled)
			{
				chkvaluer[check].disabled = false;
				
			}	
			else
			{
				chkvaluer[check].disabled = true;
				chkvaluedel[check].disabled = true;
			}	
	
}

function toggleDelete(check)
{
	check = parseInt(check) - parseInt("1");
	//alert(check);

	chkvaluer=document.DeleteFrm.elements['approve[]'];
	chkvaluedel=document.DeleteFrm.elements['delreason[]'];

			if(chkvaluer[check].disabled)
			{
				chkvaluer[check].disabled = false;
				chkvaluedel[check].disabled = true;
			}	
			else
			{
				chkvaluer[check].disabled = true;
				chkvaluedel[check].disabled = false;

			}	
}
