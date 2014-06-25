<?php

// Get new instance of PDO object
$dbc = new PDO('mysql:host=127.0.0.1;dbname=AddressBook', 'alicia', 'password');

// Tell PDO to throw exceptions on error
$dbc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//echo $dbc->getAttribute(PDO::ATTR_CONNECTION_STATUS) . "\n";

//Create the query and assign to var
$query1 = 'CREATE TABLE contacts (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    PRIMARY KEY (id)
)';
// Run query, if there are errors they will be thrown as PDOExceptions
$dbc->exec($query1);

$query2 = 'CREATE TABLE addresses (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    street_address VARCHAR(240) NOT NULL,
    city VARCHAR(100) NOT NULL,
    state CHAR(2) NOT NULL,
    zip_code CHAR(5) NOT NULL,
    PRIMARY KEY (id)
)';
$dbc->exec($query2);

$query3 = 'CREATE TABLE contact_has_address (
    contact_id INT UNSIGNED NOT NULL,
    address_id INT UNSIGNED NOT NULL,
    PRIMARY KEY (contact_id, address_id),
    FOREIGN KEY (contact_id) REFERENCES contacts(id) ON DELETE CASCADE, 
    FOREIGN KEY (address_id) REFERENCES addresses(id) ON DELETE CASCADE,
)';
$dbc->exec($query3);

//NOTES: 
//Created 3 different queries to represent each table created in the address book database
//query number 3--ON DELETE CASCADE will delete the id's in the contact_has_address table when it has been removed from either the contacts table or the addresses table
?>