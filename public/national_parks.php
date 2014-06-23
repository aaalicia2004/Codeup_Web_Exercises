<?php
function getOffset(){
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	return ($page - 1) * 4;
}

// if (!empty($_GET)) {
// 	var_dump($_GET);
// 	$pageID = // get value of page ID here
// 	$offset = pageID * 4
// }

//$query = "SELECT * FROM national_parks LIMIT 4 OFFSET $offset;";



$query ='SELECT * FROM national_parks LIMIT 4 OFFSET ' . getOffset();
$parks = $dbc->query($query)->fetchAll(PDO::FETCH_ASSOC);

//$parks = $dbc->query("SELECT * FROM national_parks LIMIT 4 OFFSET" . getOffset(); )->fetchAll(PDO::FETCH_ASSOC);
$count = $dbc->query('SELECT count(*) FROM national_parks')->fetchColumn();
$numPages = ceil($count/4);
//$array = ($stmt->fetchAll(PDO::FETCH_ASSOC));
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$nextPage = $page + 1;
$prevPage = $page - 1;

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
<? foreach ($parks as $park) :?>
	<td><?= $park['name'] ?></td>
	<td><?= $park['location'] ?></td>
	<td><?= $park['date_established'] ?></td>
	<td><?= $park['area_in_acres'] ?></td>
	</tr>
<? endforeach;?>
</table>

<? if($page > 1):?>
<button id="back"> <a href="?page=<?= $prevPage; ?>"</a>Previous</button>
<? endif; ?>
<? if($nextPage <= $numPages) : ?>
<button id="next"> <a href="?page=<?= $nextPage; ?>"</a>Next</button>
<? endif; ?>

</body>
</html>