<?php
include('../settings/database.php');

$id = $_GET['id'];

$sql = 'SELECT * FROM users WHERE id = $1';
$result = pg_query_params($local_conn, $sql, array($id));
$user = pg_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Store - Edit user</title>
    <link rel="icon" type="image/png" href="icons/main_store_icon.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,600;12..96,700&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="awning" aria-hidden="true"></div>
    <main class="page narrow">
        <header class="topbar">
            <a class="brand" href="home.php">Main Store</a>
            <nav>
                <a href="home.php">Home</a>
                <a href="list_users.php" aria-current="page">Users</a>
                <a href="logout.php">Logout</a>
            </nav>
        </header>

        <div class="card full">
            <h1>Edit user</h1>
            <p class="lead">Update the details and save your changes.</p>

            <form action="update_user.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= htmlspecialchars($user['id']) ?>">

                <div class="row">
                    <div class="field">
                        <label for="firstname">First name</label>
                        <input type="text" id="firstname" name="firstname" value="<?= htmlspecialchars($user['firstname']) ?>" required>
                    </div>
                    <div class="field">
                        <label for="lastname">Last name</label>
                        <input type="text" id="lastname" name="lastname" value="<?= htmlspecialchars($user['lastname']) ?>" required>
                    </div>
                </div>

                <div class="field">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
                </div>

                <div class="field">
                    <label for="mobile_phone">Mobile phone</label>
                    <input type="text" id="mobile_phone" name="mobile_phone" value="<?= htmlspecialchars($user['mobile_phone']) ?>" required>
                </div>

                <?php if (!empty($user['url_photo']) && file_exists($user['url_photo'])) { ?>
                    <div class="photo-box">
                        <img src="<?= htmlspecialchars($user['url_photo']) ?>" alt="Current photo">
                        <div>
                            <strong>Current photo</strong>
                            <!-- Checkbox para eliminar la foto -->
                            <label class="check" for="deletePhotoCheck">
                                <input type="checkbox" name="delete_photo" value="1" id="deletePhotoCheck">
                                Delete current photo
                            </label>
                        </div>
                    </div>
                <?php } ?>

                <div class="field">
                    <label for="photo">Upload new photo (JPG or PNG)</label>
                    <input type="file" id="photo" name="photo" accept=".jpg,.jpeg,.png">
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Save changes</button>
                    <a href="list_users.php" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </main>
</body>
</html>