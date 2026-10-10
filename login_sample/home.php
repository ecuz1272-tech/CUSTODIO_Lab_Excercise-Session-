<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$username = htmlspecialchars($_SESSION["username"], ENT_QUOTES, "UTF-8");
$userInitial = htmlspecialchars(strtoupper(substr($_SESSION["username"], 0, 1)), ENT_QUOTES, "UTF-8");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="dashboard-page">
    <div class="dashboard-container">
        <header class="dashboard-header">
            <a class="dashboard-brand" href="home.php">MEMBER SPACE</a>
            <a class="logout-link" href="logout.php">Sign out</a>
        </header>

        <main>
            <section class="dashboard-welcome">
                <p class="dashboard-eyebrow">MEMBER DASHBOARD</p>
                <h1>Welcome back, <?php echo $username; ?>.</h1>
                <p>You are signed in. Here is an overview of your account.</p>
            </section>

            <section class="dashboard-panel" aria-labelledby="account-heading">
                <div class="panel-heading">
                    <div>
                        <p class="dashboard-eyebrow">YOUR ACCOUNT</p>
                        <h2 id="account-heading">Account overview</h2>
                    </div>
                    <span class="status-badge"><span></span> Active</span>
                </div>

                <div class="account-details">
                    <div class="account-avatar" aria-hidden="true"><?php echo $userInitial; ?></div>
                    <div>
                        <p class="detail-label">Username</p>
                        <p class="detail-value"><?php echo $username; ?></p>
                    </div>
                    <div>
                        <p class="detail-label">Member ID</p>
                        <p class="detail-value">#<?php echo htmlspecialchars((string) $_SESSION["user_id"], ENT_QUOTES, "UTF-8"); ?></p>
                    </div>
                </div>
            </section>

            <section class="dashboard-footer" aria-label="Session status">
                <p><span class="status-dot"></span> Your session is secure and active.</p>
            </section>
        </main>
    </div>
</body>
</html>