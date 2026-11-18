<?php
/*
    Use this URL to print data in browser:
    http://localhost:80/main-store/src/list_users.php
*/
include('../settings/database.php');

$sql = "
    select 
        id,
        firstname || ' ' || lastname as fullname,
        email,
        mobile_phone,
        case when status = true then 'Active' else 'Inactive' end as status,
        url_photo
    from 
        users
    order by 
        id;
";

$res = pg_query($local_conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Store - List users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container mt-4">
        <h2 class="mb-3">Users List</h2>
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Photo</th>
                    <th>Fullname</th>
                    <th>Email</th>
                    <th>Mobile phone</th>
                    <th>Status</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = pg_fetch_assoc($res)) { ?>
                <tr>
                    <td>
                        <?php 
                            // Valida si la ruta existe en la BD y el archivo físico existe, de lo contrario usa photo_default.png
                            $foto = (!empty($row['url_photo']) && file_exists($row['url_photo'])) ? $row['url_photo'] : 'photos/photo_default.png';
                        ?>
                        <img src="<?= $foto ?>" width="45" height="45" class="rounded-circle object-fit-cover" alt="User photo profile">
                    </td>
                    <td><?= $row['fullname'] ?></td>
                    <td><?= $row['email'] ?></td>
                    <td><?= $row['mobile_phone'] ?></td>
                    <td><?= $row['status'] ?></td>
                    <td>
                        <a href="edit_user.php?id=<?= $row['id'] ?>" title="Edit user" class="text-decoration-none me-2">
                            <img src="icons/edit.png" alt="Edit user" width="20">
                        </a>
                        <a href="#" title="Search user" class="text-decoration-none me-2">
                            <img src="icons/search.png" alt="Search user" width="20">
                        </a>
                        <a href="#" title="Delete user" class="text-decoration-none">
                            <img src="icons/delete.png" alt="Delete user" width="20">
                        </a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>