<?php
include('../settings/database.php');

$id           = $_POST['id'];
$firstname    = $_POST['firstname'];
$lastname     = $_POST['lastname'];
$email        = $_POST['email'];
$mobile_phone = $_POST['mobile_phone'];

// ---------- PARTE A: Actualizar los datos de texto ----------
$sql = 'UPDATE users
        SET firstname = $1, lastname = $2, email = $3, mobile_phone = $4, updated_at = NOW()
        WHERE id = $5';
$result = pg_query_params($local_conn, $sql, array($firstname, $lastname, $email, $mobile_phone, $id));

if (!$result) {
    echo "Error al actualizar los datos";
    exit;
}

// ---------- PARTE B1: ¿Marcaron la opción de borrar foto? ----------
if (isset($_POST['delete_photo']) && $_POST['delete_photo'] == '1') {
    
    // Buscar la ruta de la foto actual en la BD
    $sql_old = 'SELECT url_photo FROM users WHERE id = $1';
    $res_old = pg_query_params($local_conn, $sql_old, array($id));
    $row_old = pg_fetch_assoc($res_old);

    // Si tiene archivo físico y NO es la imagen por defecto, borrarlo del servidor
    if (!empty($row_old['url_photo']) && $row_old['url_photo'] != 'photos/photo_default.png' && file_exists($row_old['url_photo'])) {
        unlink($row_old['url_photo']);
    }

    // Asignar la foto por defecto correcta en la base de datos
    $default_photo = 'photos/photo_default.png';
    $sql_clear = 'UPDATE users SET url_photo = $1 WHERE id = $2';
    pg_query_params($local_conn, $sql_clear, array($default_photo, $id));

} 
// ---------- PARTE B2: O si subieron una nueva foto ----------
else if ($_FILES['photo']['name'] != "") {

    $ext = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));

    if ($ext == "jpg" || $ext == "jpeg" || $ext == "png") {

        // Validar tamaño máximo de 1 MB
        $max_size = 1 * 1024 * 1024; 
        if ($_FILES['photo']['size'] > $max_size) {
            echo "La foto pesa demasiado. El límite máximo es de 1 MB. <a href='edit_user.php?id=$id'>Volver</a>";
            exit;
        }

        // Borrar foto anterior si existía y no era la por defecto
        $sql_old = 'SELECT url_photo FROM users WHERE id = $1';
        $res_old = pg_query_params($local_conn, $sql_old, array($id));
        $row_old = pg_fetch_assoc($res_old);

        if (!empty($row_old['url_photo']) && $row_old['url_photo'] != 'photos/photo_default.png' && file_exists($row_old['url_photo'])) {
            unlink($row_old['url_photo']);
        }

        // Guardar la nueva foto usando el ID único
        $url_photo = "photos/user_" . $id . "." . $ext;

        if (move_uploaded_file($_FILES['photo']['tmp_name'], $url_photo)) {

            $sql = 'UPDATE users SET url_photo = $1 WHERE id = $2';
            pg_query_params($local_conn, $sql, array($url_photo, $id));

        } else {
            echo "No se pudo guardar la foto. Revisa la carpeta photos.";
            exit;
        }

    } else {
        echo "Solo se permiten fotos JPG o PNG. <a href='edit_user.php?id=$id'>Volver</a>";
        exit;
    }
}

// ---------- PARTE C: Volver a la lista ----------
header("Location: list_users.php");
exit;
?>