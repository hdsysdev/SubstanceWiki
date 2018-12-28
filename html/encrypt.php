<?php
//Gets plaintext username and password from post method, generates a salt, stores the salt in the database, encrypts the credentials
//and posts the now encrypted credentials to the admin.php page.
include("connection.php");

$username = "\"" . $_POST['username'] . "\"";
$password = "\"" . $_POST['password'] . "\"";

$sql = "SELECT * FROM admin WHERE username=" . $username . " AND password=" . $password;
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $encryptedPass = crypt($password);
    var_dump($encryptedPass);
    mysqli_query($conn,"INSERT INTO admin (username, password) VALUES(\"" . $username . "\", \"" . $encryptedPass . "\");");
}

?>