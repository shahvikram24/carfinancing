	function GetXmlHttpObject(handler)
	{
		var objXmlHttp=null
		if (navigator.userAgent.indexOf("Opera")>=0)
		{
			objXmlHttp=new XMLHttpRequest()
			objXmlHttp.onload=handler
			objXmlHttp.onerror=handler
			return objXmlHttp
		}
		if (navigator.userAgent.indexOf("MSIE")>=0)
		{
			var strName="Msxml2.XMLHTTP"
			if (navigator.appVersion.indexOf("MSIE 5.5")>=0)
			{
				strName="Microsoft.XMLHTTP"
			}
			try
			{
				objXmlHttp=new ActiveXObject(strName)
				objXmlHttp.onreadystatechange=handler
				return objXmlHttp
			}
			catch(e)
			{
				alert("Error. Scripting for ActiveX might be disabled")
				return
			}
		}
		if (navigator.userAgent.indexOf("Mozilla")>=0)
		{
			objXmlHttp=new XMLHttpRequest()
			objXmlHttp.onload=handler
			objXmlHttp.onerror=handler
			return objXmlHttp
		}
	}
	
	function stateChanged()
	{
		if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
		{
			invalidUser=xmlHttp.responseText;
		}
	}

	function AjaxFunction(params)
	{
		url='http://localhost/carfinancing/lib/ajax.php'
		var requestParams
		requestParams = params;
		xmlHttp=GetXmlHttpObject(stateChanged)
		xmlHttp.open("POST", url, false)
		var content_type = 'application/x-www-form-urlencoded';
		xmlHttp.setRequestHeader('Content-Type', content_type);
		xmlHttp.send(requestParams)
		return invalidUser;
	}

	$().ready(function()
	{
		function findValueCallback(event, data, formatted)
		{
			$("<li>").html( !data ? "No match!" : "Selected: " + formatted).appendTo("#result");
		}
		
		function formatItem(row){
			return row[0];
		}
		function formatResult(row){
			return row[0].replace(/(<.+?>)/gi, '');
		}
	

		$(".suggest").result(findValueCallback).next().click(function() {
			$(this).prev().search();
		});

		$("#scrollChange").click(changeScrollHeight);
		
		$("#clear").click(function() {
			$(":input").unautocomplete();
		});
	});
	
	function changeOptions(){
		var max = parseInt(window.prompt('Please type number of items to display:', jQuery.Autocompleter.defaults.max));
		if (max > 0) {
			$("#suggest4").setOptions({
				max: max
			});
		}
	}
	
	function changeScrollHeight() {
		var h = parseInt(window.prompt('Please type new scroll height (number in pixels):', jQuery.Autocompleter.defaults.scrollHeight));
		if(h > 0) {
			$("#suggest4").setOptions({
				scrollHeight: h
			});
		}
	}