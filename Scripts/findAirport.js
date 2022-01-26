function findAirport(airline, source = "") {
    if (airline == "") {
        document.getElementById("AirportDiv").innerHTML = "";
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
		if (source == "")
		{
			document.getElementById("AirportSource").innerHTML = this.responseText;
		}
		else
		{
			document.getElementById("AirportDestination").innerHTML = this.responseText;
		}
            }
        };
        xmlhttp.open("GET","FindAirport.php?Airline="+airline+"&RouteSource="+source, true);
        xmlhttp.send();
    }
}
