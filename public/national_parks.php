<?php
// Get new instance of PDO object
$dbc = new PDO('mysql:host=127.0.0.1;dbname=codeup_pdo_test_db', 'alicia', 'password');

// Tell PDO to throw exceptions on error
$dbc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $dbc->query('SELECT * FROM national_parks');

$array = ($stmt->fetchAll(PDO::FETCH_ASSOC));

?>

<!DOCTYPE html>
<html>
<head>
	<title>National Parks</title>
</head>
<body>
<h1>National Parks</h1>
<table>
	<tr>
		<th>Name</th>
		<th>Location</th>
		<th>Date Established</th>
		<th>Area in Acres</th>
	</tr>
	<tr>
<? foreach ($array as $key => $value) :?>
	<td><?= $value['name'] ?></td>
	<td><?= $value['location'] ?></td>
	<td><?= $value['date_established'] ?></td>
	<td><?= $value['area_in_acres'] ?></td>
	</tr>
<? endforeach;?>
</table>

</body>
</html>