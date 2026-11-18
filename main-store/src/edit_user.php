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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4 mb-5" style="max-width: 600px;">
        <h2 class="mb-4">Edit User</h2>

        <form action="update_user.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $user['id'] ?>">

            <div class="mb-3">
                <label class="form-label">First name</label>
                <input type="text" name="firstname" class="form-control" value="<?= $user['firstname'] ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Last name</label>
                <input type="text" name="lastname" class="form-control" value="<?= $user['lastname'] ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="<?= $user['email'] ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Mobile phone</label>
                <input type="text" name="mobile_phone" class="form-control" value="<?= $user['mobile_phone'] ?>" required>
            </div>

            <?php if (!empty($user['url_photo']) && file_exists($user['url_photo'])) { ?>
                <div class="mb-3 p-3 border rounded bg-light">
                    <label class="form-label d-block fw-bold">Current photo:</label>
                    <img src="<?= $user['url_photo'] ?>" width="100" class="rounded border mb-2 d-block">
                    
                    <!-- Checkbox para eliminar la foto -->
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="delete_photo" value="1" id="deletePhotoCheck">
                        <label class="form-check-label text-danger" for="deletePhotoCheck">
                            Eliminar foto actual
                        </label>
                    </div>
                </div>
            <?php } ?>

            <div class="mb-4">
                <label class="form-label">Upload new photo (JPG or PNG)</label>
                <input type="file" name="photo" class="form-control" accept=".jpg,.jpeg,.png">
            </div>

            <button type="submit" class="btn btn-primary">Save changes</button>
            <a href="list_users.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>