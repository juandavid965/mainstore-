<?php
//Get database conecttion
include('../settings/database.php');

//Get payload from frontend
$email = $_POST['email'];
$passwd_form = $_POST['pswd'];
// verify if from password is equal to database password 

$sql_check_email = "SELECT COUNT (email) as total FROM users WHERE email = '$email'"; 
$res = pg_query($local_conn, $sql_check_email);
$row1 = pg_fetch_assoc($res);

$sql_get_password = "SELECT password FROM users WHERE email = '$email' ";
$res = pg_query($local_conn, $sql_get_password);
$row2 = pg_fetch_assoc($res);
$passwd_db = $row2['password'];

$passwd = password_verify($passwd_form, $passwd_db);

echo "Q1: ". $row1['total'] . "<br>";
echo "Q2: ". $passwd;

if ($row1['total'] == 1 and $passwd == 1 ){
    echo "you got it.";
}else{
    echo "no access.";
}