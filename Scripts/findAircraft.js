function findAircraft(airline, source, destination) {
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
                $(`#SegmentAircraft`).val(Number(this.responseText)).trigger(`change`);
            }
        };
        xmlhttp.open("GET","FindRoute.php?Airline="+airline+"&Source="+source+"&Destination="+destination+"&Affect=Aircraft",true);
        xmlhttp.send();
    }
}
