function displayAttr(type) {
    if (type.length == 0) {
        document.getElementById("Attr").innerHTML = "";
    } else {
        xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200)
            document.getElementById("Attr").innerHTML = this.responseText;
        };
        xmlhttp.open("GET", "typeattr.php?t=" + type, true);
        xmlhttp.send();
    }
}
