<?php
//Get database conecttion
include('../settings/database.php');

session_start();

//Get payload from frontend
$email = $_POST['email'];
//$passwd = MD5($_POST['pswd']);

$sql_get_password = "SELECT password FROM users WHERE email = '$email' ";
$res = pg_query($local_conn, $sql_get_password); // CAMBIO 1: el ";" era una "," 
$row = pg_fetch_assoc($res);
$passwd_db = $row['password'] ?? ''; // CAMBIO 2: evita el warning si el email no existe

$passwd = password_verify($_POST['pswd'], $passwd_db); 

$sql_check_email = "
    SELECT
        id,
        firstname,
        lastname,
        email,
        url_photo
    FROM    
        users 
    WHERE 
        email = '$email'
"; // CAMBIO 3: se quitó "and password = '$passwd'"
$res = pg_query($local_conn, $sql_check_email);
$total = pg_num_rows($res);
$row = pg_fetch_assoc($res);
    
if($total > 0 && $passwd){ // CAMBIO 4: ahora también se valida la contraseña
    $_SESSION ['user_id'] = $row ['id'];
    $_SESSION ['user_firstname'] = $row ['firstname'];
    $_SESSION ['user_lastname'] = $row ['lastname'];
    header ('refresh:0;url=home.php');
}else{
    echo "<script>alert('Invalid email or password. Try again!')</script>";
    header('refresh:0;url=signin.html');
}