<?php
/*
    Use this Endpoint to test request
    http://localhost/main-store/src/delete_user.php?userID=ANY-ID-NUMBER
*/
include('../settings/database.php');

// Get data from URL
$user_id = $_GET['userID'];

$sql_photo = 'SELECT url_photo FROM users WHERE id = $1';
$res_photo = pg_query_params($local_conn, $sql_photo, array($user_id));
if ($res_photo && $row = pg_fetch_assoc($res_photo)) {
    $photo_path = $row['url_photo'];
    
    // Si tiene foto y NO es la imagen por defecto, borrar el archivo físico del servidor
    if (!empty($photo_path) && $photo_path != 'photos/photo_default.png' && file_exists($photo_path)) {
        unlink($photo_path);
    }
}

$sql_delete_user = 'DELETE FROM users WHERE id = $1';
$res = pg_query_params($local_conn, $sql_delete_user, array($user_id));

if ($res) {
    echo "<script>alert('User has been deleted successfully !!!')</script>";
    header('refresh:0;url=list_users.php');
} else {
    echo "<script>alert('User has not been deleted successfully !!!')</script>";
    header('refresh:0;url=list_users.php');
}
exit;
?>