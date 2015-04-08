function ajax(url, json, fnsuccess) {
	var oAjax = XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");

	oAjax.onreadystatechange = function() {
		if (oAjax.readyState === 4 && oAjax.status === 200) {
			var a=parseInt(oAjax.responseText.indexOf("}"));
			var r=oAjax.responseText.substring(9,a);
			fnsuccess (r);
		}
	}

	oAjax.open('POST', url, false);
	oAjax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	oAjax.send(json);

}
