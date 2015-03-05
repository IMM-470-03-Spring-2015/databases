<html>
<head>
<title>My Database Script</title>
</head>
<body>
<h1>Results of Query...</h1><br>
<?php
$dbh=pg_connect("host=database.tcnj.edu dbname=thompsom user=thompsom password=0D1NRULEs");
$sql="select * from mytable";
$result=pg_exec($sql);

$rowcount=pg_numrows($result);

?>

<table border=1>
<tr>
	<th>First Name</th><th>Last Name</th><th>Age</th>
</tr>

<?php

	for($i=0;$i<$rowcount;$i++) {
			$row = pg_fetch_array($result);
			print "<tr><td>" . $row["firstname"] . "</td>";
			print "<td>" . $row["lastname"] . "</td>";
			print "<td>" . $row["age"] . "</td>";
			print "</tr>";
    }

	pg_close($dbh);
?>

</table>
</body>
</html>