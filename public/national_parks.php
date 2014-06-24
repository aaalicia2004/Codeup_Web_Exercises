<?php
// Get new instance of PDO object
$dbc = new PDO('mysql:host=127.0.0.1;dbname=codeup_pdo_test_db', 'alicia', 'password');

// Tell PDO to throw exceptions on error
$dbc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (!empty($_GET)) {
	$page= $_GET['page'];
} else {
	$page = 1;
}

$limit= 4;
$offset = (($limit * $page) - $limit);
$nextPage = $page + 1;
$prevPage = $page - 1;

$stmt =$dbc->prepare('SELECT * FROM national_parks LIMIT :limit OFFSET :offset ');
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();

$parks = $stmt->fetchAll(PDO::FETCH_ASSOC);

if(!empty($_POST)){
$stmt = $dbc->prepare("INSERT INTO national_parks (name, location, date_established, area_in_acres, park_description) VALUES (:name, :location, :date_established, :area_in_acres, :park_description)");
	
	$stmt->bindValue(':name', $_POST['name'], PDO::PARAM_STR);
    $stmt->bindValue(':location', $_POST['location'], PDO::PARAM_STR);
	$stmt->bindValue(':date_established', $_POST['date_established'], PDO::PARAM_STR);
	$stmt->bindValue(':area_in_acres', $_POST['area_in_acres'], PDO::PARAM_STR);
	$stmt->bindValue(':park_description', $_POST['park_description'], PDO::PARAM_STR);

	$stmt->execute();
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>National Parks</title>
</head>
<body>
<h1>National Parks</h1>
<div class="container">
<table>
	<tr>
		<th>Name</th>
		<th>Location</th>
		<th>Date Established</th>
		<th>Area in Acres</th>
		<th>Park Description</th>
	</tr>
	<tr>
<? foreach ($parks as $park) :?>
	<td><?= $park['name'] ?></td>
	<td><?= $park['location'] ?></td>
	<td><?= $park['date_established'] ?></td>
	<td><?= $park['area_in_acres'] ?></td>
	<td><?= $park['park_description'] ?></td>
	</tr>
<? endforeach;?>
</table>
<? if($prevPage > 0):?>
<?= "<a href='?page=$prevPage'>Previous</a>";?>
<? endif; ?>
<? if($prevPage < 2) : ?>
<?= "<a href='?page=$nextPage'>Next</a>";?>
<? endif; ?>

</div>

	<h2>Add a National Park!</h2>
	<form method="POST" action="national_parks.php">
		<p>
		<label for="name">Name</label>
		<input id="name" name="name" type="text">
		</p>
		<p>
		<label for="location">Location</label>
		<input id="location" name="location" type="text">
		</p>
		<p>
		<label for="date_established">Date Established</label>
		<input id="date_established" name="date_established" type="text">
		</p>
		<p>
		<label for="area_in_acres">Area In Acres</label>
		<input id="area_in_acres" name="area_in_acres" type="text">
		</p>
		<p>
		<label for="park_description">Park Description</label>
		<input id="park_description" name="park_description" type="text">
		</p>
		<p>
		<button type="submit">Submit</button>
		</p>
	</form>



</body>
</html>