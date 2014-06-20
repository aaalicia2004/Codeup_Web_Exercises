<?php

require_once('classes-Objects/Address_Data_Store_Class.php');

$address_book1 = [];

$address_book = new AddressDataStore("data/address_book.csv"); // Set variable name to array from object method

$address_data = $address_book->read(); //

if(isset($_GET['id'])){ //getting the information from the url ?id= the key number from the array that is getting deleted
    unset($address_data[$_GET['id']]);//delete an item from the array
    $address_book->write($address_book1);
    //after deleting saving the address_book.csv
    header("location: address_book.php");//redirecting to the file location
    exit;
}
$new_address = [];//empty array for adding address input
try{
    if (isset($_POST['name']) && isset($_POST['address']) && isset($_POST['city']) && isset($_POST['state']) && isset($_POST['zip'])) {
    
        $new_address ['name'] = $_POST['name'];
        $new_address ['address'] = $_POST['address'];
        $new_address ['city'] = $_POST['city'];
        $new_address ['state'] = $_POST['state'];
        $new_address ['zip'] = $_POST['zip'];
        $new_address ['phone'] = $_POST['phone'];

        foreach($new_address as $key => $value){
            if (strlen($value) == 0 || strlen($value) > 125){
             throw new Exception('Invalid entry! Please make input greater than 0 characters and less than 240 characters!'); 
            }
        }
    }
}catch(Exception $e){
    $errorMessage = "Please check your entry to make sure it is greater than 0 characters long and less than 240 characthers!";
}
    array_push($address_data, $new_address);
    $address_book->write($address_book1);


//only gets used when a file is uploaded to the form method
if (count($_FILES) > 0 && $_FILES['UploadFile1']['error'] == 0) {

    if ($_FILES['UploadFile1']['type']!= 'text/csv'){
        echo "ERROR: file must be in text/csv!";
    } else {
        //set the destination directory for uploads
        //Grab the filename from the uploaded file by using basename
        $upload_dir = '/vagrant/sites/codeup.dev/public/uploads/';
        // Grab the filename from the uploaded file by using basename
        $Uploadfilename = basename($_FILES['UploadFile1']['name']);
        // Create the saved filename using the file's original name and our upload directory
        $saved_filename = $upload_dir . $Uploadfilename;
        // Move the file from the temp location to our uploads directory
        move_uploaded_file($_FILES['UploadFile1']['tmp_name'], $saved_filename);

        // Check if we saved a file
        $newAddressFile = new AddressDataStore($saved_filename);
    
        $newFile = $newAddressFile->read(); 
        //$newFile was created as the placeholder for the new array to be merged with my master array $todo
    
        $address_book = array_merge($address_book, $newFile);//this is the merging of the the newfile with the master array
        $address_book->write($address_book1);
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
    <? if(isset ($errorMessage)): ?>
    <?= "<p>$errorMessage</p>"; ?>
<? endif; ?>
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

<h1>Upload File</h1>

<form method="POST" enctype="multipart/form-data">
    <p>
        <label for="UploadFile1">File to upload:</label>
        <input id="UploadFile1" name="UploadFile1" type="file" accept=".csv">
    </p>
    <p>
        <input type="Submit" value="Upload File">
    </p>
</form>
</body>
</html>






