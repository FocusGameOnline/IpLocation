# IpLocation
TO use this script you first need to make sure you're using the index.php uploaded to here,this is to make sure that the service runs as smoothly as possible.

[code]<?php
$IPaddr = Dot2LongIP($_GET['IPaddr']);

function Dot2LongIP ($IPaddr)
{
    if ($IPaddr == "") {
        return 0;
    } else {
        $ips = split ("\.", "$IPaddr");
        return ($ips[3] + $ips[2] * 256 + $ips[1] * 256 * 256 + $ips[0] * 256 * 256 * 256);
    }
}
	
$con=mysqli_connect("LOCALHOST:3306","MYSQLUSERNAME","MYSQLPASSWORD","ip2location");

if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$sql = mysqli_query($con,"SELECT country_code, country_name, region_name, city_name FROM ip2location_db3 WHERE $IPaddr BETWEEN IP_FROM AND IP_TO");

while($row = mysqli_fetch_array($sql)) {
  echo $row['country_code'] . "\n" . $row['country_name'] . "\n" . $row['region_name'] . "\n" . $row['city_name'];

}
?>[/code]

The point of this is to convert the IP standard into IP Long. Which will determine between one and the other using the ip database from ip2location.com on the server which is on that code. After that is used you use the code achieved by the website i.e. www.focusgameonline.com:1080/test.php?IPaddr=<ip> Pretty easy to do. But you can modify it to allow you to use "connection" also. Makes it slightly easier. This is in use by WinMX Proceedure which i have already released the code for on the forums i use however this is only a RoboMX system.

The code then works by methods of PHP and MYSQL with the addition of XML coding!

[code]<out condition="!?" lvalue="$WebLoc2$" rvalue="%IP%" type="push" extdata="WebLoc"><operator type="readweb" nvalue="http://www.focusgameonline.com:1080/test.php?IPaddr=%IP%" lvalue="l" rvalue="1"/></out>
<out condition="!?" lvalue="$WebLoc2$" rvalue="%IP%" type="push" extdata="Country"> <operator type="strrep" nvalue="$WebLoc$" lvalue="COUNTRY CODE:" rvalue="#c9#,#c1#"/> </out>
<out condition="!?" lvalue="$WebLoc2$" rvalue="%IP%" type="push" extdata="State"><operator type="readweb" nvalue="http://www.focusgameonline.com:1080/test.php?IPaddr=%IP%" lvalue="l" rvalue="3"/></out>
<out condition="!?" lvalue="$WebLoc2$" rvalue="%IP%" type="push" extdata="Region"> <operator type="strrep" nvalue="$State$" lvalue="STATE OR REGION:" rvalue="#c9#,#c1#"/> </out>
<out condition="!?" lvalue="$WebLoc2$" rvalue="%IP%" type="push" extdata="Cit"><operator type="readweb" nvalue="http://www.focusgameonline.com:1080/test.php?IPaddr=%IP%" lvalue="l" rvalue="4"/></out>
<out condition="!?" lvalue="$WebLoc2$" rvalue="%IP%" type="push" extdata="City"> <operator type="strrep" nvalue="$Cit$" lvalue="CITY:" rvalue=" "/> </out>
<out condition="==" lvalue="$CitySwitch$" rvalue="0" type="push" extdata="City">#c8# PROTECTED</out>[/code]

This checks the server for certain conditions such as Region/City/Country. When the switch is turned off it'll display  a protected system.....i.e.

[code][OpMsg] <Metis..282_58990> [Location Cache] template Is From: PROTECTED, WESTERN AUSTRALIA, AU[/code]

Shows that Template is from AU which is how i set it up.
