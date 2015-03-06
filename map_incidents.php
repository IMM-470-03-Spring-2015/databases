<?php
header('Content-Type: application/json');

// connect to the incident db & select all records
$dbh=pg_connect("host=database.tcnj.edu dbname=thompsom user=thompsom password=0D1NRULEs");
$sql="select * from incidents";
$result=pg_exec($sql);

// cycle through the records, appending them to an output array
$incident_arr = array();
while ($row = pg_fetch_row($result)) {
  $incident_arr[] = $row;
}

// encode the output array as json & return
echo json_encode($incident_arr);

pg_close($dbh);
?>