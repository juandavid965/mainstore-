<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header('refresh:0;url=signin.html');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <center>
        <?php echo $_SESSION['user_firstname']." " . $_SESSION['user_lastname']; ?>
        <h3>Welcome to main store</h3>
        <a href="logout.php">Logout</a>
    </center>
</body>
</html