<?php
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
?>
