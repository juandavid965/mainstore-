<?php
/*
    Use this URL to print data in browser:
    http://localhost:80/main-store/src/list_users.php
*/
include('../settings/database.php');

// Get data from users table
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
    <link rel="icon" type="image/png" href="icons/main_store_icon.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,600;12..96,700&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="awning" aria-hidden="true"></div>
    <main class="page">
        <header class="topbar">
            <a class="brand" href="home.php">Main Store</a>
            <nav>
                <a href="home.php">Home</a>
                <a href="list_users.php" aria-current="page">Users</a>
                <a href="logout.php">Logout</a>
            </nav>
        </header>

        <h1>Users</h1>
        <p class="lead">Review, edit or remove the people registered in the store.</p>

        <div class="table-wrap">
            <table class="users">
                <thead>
                    <tr>
                        <th>Photo</th>
                        <th>Full name</th>
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
                            <img src="<?= htmlspecialchars($foto) ?>" class="avatar" alt="User photo profile">
                        </td>
                        <td><?= htmlspecialchars($row['fullname']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= htmlspecialchars($row['mobile_phone']) ?></td>
                        <td>
                            <span class="badge <?= $row['status'] === 'Active' ? 'badge-active' : 'badge-inactive' ?>"><?= $row['status'] ?></span>
                        </td>
                        <td>
                            <div class="options">
                                <!-- Botón Editar -->
                                <a href="edit_user.php?id=<?= $row['id'] ?>" title="Edit user" class="icon-btn">
                                    <img src="icons/edit.png" alt="Edit user">
                                </a>
                                <!-- Botón Buscar/Ver -->
                                <a href="#" title="Search user" class="icon-btn">
                                    <img src="icons/search.png" alt="Search user">
                                </a>
                                <!-- Botón Borrar (conectado a delete_user.php con confirmación) -->
                                <a href="delete_user.php?userID=<?= $row['id'] ?>" title="Delete user" class="icon-btn danger" onclick="return confirm('Are you sure you want to delete this user?');">
                                    <img src="icons/delete.png" alt="Delete user">
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>