function ajax(url, json) {
    var oAjax = XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");

    oAjax.onreadystatechange = function() {
        if (oAjax.readyState === 4 && oAjax.status === 200) {
            console.log(oAjax);
            return oAjax.responseText
        } else {
            alert('出错了！');
        }
    }

    oAjax.open('POST', url, true);
    oAjax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    oAjax.send(json);

}
