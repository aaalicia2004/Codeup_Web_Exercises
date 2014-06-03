<?php
$address_book = [
    ['The White House', '1600 Pennsylvania Avenue NW', 'Washington', 'DC', '20500', 'phone number'],
    ['Marvel Comics', 'P.O. Box 1527', 'Long Island City', 'NY', '11101', 'phone number'],
    ['LucasArts', 'P.O. Box 29901', 'San Francisco', 'CA', '94129-0901', 'phone number']
];
$filename = "data/address_book.csv";

function write_save_file($filename, $empty_array)//created function - Chris Turner
{
    if(is_writeable($filename)){
      $handle = fopen($filename, 'w');
    foreach($empty_array as $subArray){
        fputcsv($handle, $subArray);  
    }
    fclose($handle);
    }
}
// if (!empty($_POST)){
//     $new_address = []; //this is an empty array for us to add to...initialize it
//     //$new_address [] = $_POST['name'];
//     foreach ($_POST as $key => $value){
        
//         $new_address[] = $value;
//     }
// }
// $errors = [];

$new_address = [];//empty array
if(!empty($_POST)){
    $errors = [];

    $new_address ['name'] = $_POST['name'];
    $new_address ['address'] = $_POST['address'];
    $new_address ['city'] = $_POST['city'];
    $new_address ['state'] = $_POST['state'];
    $new_address ['zip'] = $_POST['zip'];
    $new_address ['phone'] = $_POST['phone'];

    foreach($new_address as $key => $value){
        if (empty($value)){
            echo ucfirst($key) . " is required." . PHP_EOL;
        }
    }
   // var_dump($new_address);
}

//foreach($new_address as $key => $error){
//     if (empty($error)){
//         $errors[] = ucfirst($key) . " is not found.";
//     }else{
//         $entries [] = $error;
//     }
// }
//$mergedArray = array_push($address_book, $new_address);
$mergedArray = array_merge_recursive($address_book, $new_address);
//var_dump($new_address);
var_dump($mergedArray);


write_save_file($filename, $address_book);

?>

<!DOCTYPE html>
<head>
	<meta charset="utf-8">
	<title>Address Book</title>
</head>
<h1>Address Book</h1>
<body>
<table>
    <tr>
        <th>Name</th>
        <th>Address</th>
        <th>City</th>
        <th>State</th>
        <th>Zip</th>
        <th>Phone</th>
    </tr>
<? foreach($mergedArray as $subArray): ?>
    <tr>
       <? foreach ($subArray as $value) : ?>
            <td><?= $value; ?></td>
        <? endforeach; ?>
<?endforeach;?>
</table>
<? //var_dump($address_book);?>
<? //var_dump($_POST);?>

<h1>Sign Up Here!</h1>

<h2><em>Join Mailing List</em></h2>
<form method ="POST" action="address_book.php">

<label for="name">Name</label>
<input id= "name" name ="name" type = "text"><br>
<br>
<label for="address">Address</label>
<input id= "address" name ="address" type = "text"><br>
<br>
<label for="city">City</label>
<input id= "city" name ="city" type = "text"><br>
<br>
<label for="state">State</label>
<input id= "state" name ="state" type = "text"><br>
<br>
<label for="zip">Zip Code</label>
<input id= "zip" name ="zip" type = "text"><br>
<br>
<label for="phone">Phone Number</label>
<input id= "phone" name ="phone" type = "text"><br>
<br>
<input type= "submit" value = "Submit">

</body>
</html>