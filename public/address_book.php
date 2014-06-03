<?php
// $address_book = [];
// $filename = "";

class AddressDataStore{
    public $filename = 'data/address_book.csv';

    public function read_address_book()
    {
        $handle = fopen($this->filename, 'r');
        $address_book= [];

        while(!feof($handle)){
            $row = fgetcsv($handle);
            if(is_array($row)){
                $address_book[] = $row;
            }
        }
        fclose($handle);
        return $address_book;
    }

    public function write_address_book($addresses_array)
    {
        if(is_writeable($this->filename)){
            $handle = fopen($this->filename, 'w');
            foreach($addresses_array as $subArray){
                fputcsv($handle, $subArray);  
            }
    
        }
        fclose($handle);
    }
}

$address_book = new AddressDataStore;

// Set var to array from object method
$address_data = $address_book->read_address_book();


if(isset($_GET['id'])){ //getting the information from the url ?id= the key number from the array that is getting deleted
    unset($address_data[$_GET['id']]);//delete an item from the array
    $address_book->write_address_book($address_data);
    //after deleting saving the address_book.csv
    header("location: address_book.php");//redirecting to the file location
    exit;
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
if (!empty($_POST['name']) && !empty($_POST['address']) && !empty($_POST['city']) && !empty($_POST['state']) && !empty($_POST['zip'])) {

    $new_address ['name'] = $_POST['name'];
    $new_address ['address'] = $_POST['address'];
    $new_address ['city'] = $_POST['city'];
    $new_address ['state'] = $_POST['state'];
    $new_address ['zip'] = $_POST['zip'];
    $new_address ['phone'] = $_POST['phone'];
    
    array_push($address_data, $new_address);
    $address_book->write_address_book($address_data);
}
else{
   foreach($new_address as $key => $value){
        if (empty($value)){
            echo ucfirst($key) . " is required." . PHP_EOL; 
        }
    }
}

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
<? foreach($address_data as $key => $subArray): ?>
    <tr>
       <? foreach ($subArray as $value) : ?>
            <td><?= htmlspecialchars(strip_tags($value)); ?>
            </td>
        <? endforeach; ?>
            <td><a href = "?id=<?=$key;?>">Delete Contact</a></td>
    </tr>
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