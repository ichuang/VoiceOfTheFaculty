function findRoute(airline, source, destination = 0) {
    if (airline == "") {
        document.getElementById("RouteDiv").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("RouteDiv").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","FindRoute.php?Airline="+airline+"&Source="+source+"&Destination="+destination+"&Affect=No",true);
        xmlhttp.send();

        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("SegmentRoute").value = Number(this.responseText);
            }
        };
        xmlhttp.open("GET","FindRoute.php?Airline="+airline+"&Source="+source+"&Destination="+destination+"&Affect=Route",true);
        xmlhttp.send();
    }
}
