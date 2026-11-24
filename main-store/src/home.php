<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header('refresh:0;url=signin.html');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Store - Home</title>
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
                <a href="home.php" aria-current="page">Home</a>
                <a href="list_users.php">Users</a>
                <a href="logout.php">Logout</a>
            </nav>
        </header>

        <section class="card full welcome">
            <p class="lead" style="margin-bottom:4px;">Welcome back</p>
            <p class="name"><?php echo htmlspecialchars($_SESSION['user_firstname'] . " " . $_SESSION['user_lastname']); ?></p>
            <p class="lead" style="margin:0 0 24px;">You are signed in to Main Store.</p>
            <div class="actions">
                <a class="btn btn-primary" href="list_users.php">View users</a>
                <a class="btn btn-secondary" href="logout.php">Logout</a>
            </div>
        </section>
    </main>
</body>
</html>