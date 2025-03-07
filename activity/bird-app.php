<?php
session_start();

if (!isset($_SESSION['username']) || !isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avicast Dashboard</title>
    <link rel="stylesheet" href="AppStyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

<div id="loading-screen">
    <div class="spinner"></div>
    <p>Loading...</p>
</div>

<aside class="sidebar" id="sidebar">
    <div class="logo-container">
        <div class="logo">A</div>
        <span class="brand-name">Avicast</span>
        <i class="fas fa-times close-btn" onclick="toggleSidebar()"></i>
    </div>
    <ul class="menu">
        <li><a href="Birds_list/BirdList.php" onclick="showLoading(event)"><i class="fas fa-dove"></i> Birds List</a></li>
        <li><a href="Bird_Identification/bird_identification.php" onclick="showLoading(event)"><i class="fas fa-search"></i> Birds Identification</a></li>
        <li><a href="Sites/site_list.php" onclick="showLoading(event)"><i class="fas fa-map-marker-alt"></i> Sites</a></li>
        <li><a href="Statistics/statistical_report.php" onclick="showLoading(event)"><i class="fas fa-chart-bar"></i> Statistical Reports</a></li>
        <li><a href="help.html" onclick="showLoading(event)"><i class="fas fa-question-circle"></i> Help</a></li>
        <li class="logout"><a href="logout.php" onclick="showLoading(event)"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
    </ul>
</aside>

<div class="main-content">
    <nav class="top-nav">
        <i class="fas fa-bars menu-btn" onclick="toggleSidebar()"></i>
        <div class="user-info">
            <i class="fas fa-bell"></i>
            <img src="Resources/james.png" alt="User Profile">
            <span><?php echo htmlspecialchars($_SESSION['username']); ?></span>
        </div>
    </nav>

    <section class="dashboard">
        <h2>Welcome Back, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
        <div class="dashboard-grid">
            <div class="dashboard-box" onclick="showLoading(event, 'Statistics/statistical_report.php')">
                <h2>📊 Statistical Reports</h2>
                <p>View latest data and reports.</p>
            </div>
            <div class="dashboard-box" onclick="showLoading(event, 'Sites/site_list.php')">
                <h2>🖼️ Water Bird Census Management</h2>
                <p>Manage water bird census reports.</p>
            </div>
            <div class="dashboard-box" onclick="showLoading(event, 'Bird_Identification/bird_identification.php')">
                <h2>🔍 Birds Identification</h2>
                <p>Identify and manage bird species.</p>
            </div>
            <div class="dashboard-box" onclick="showLoading(event, 'Birds_list/BirdList.php')">
                <h2>🦜 List of Birds</h2>
                <p>View detailed bird species descriptions.</p>
            </div>
        </div>
    </section>
</div>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById("sidebar");
        const mainContent = document.querySelector(".main-content");

        sidebar.classList.toggle("active");
        mainContent.classList.toggle("sidebar-open");
    }

    function showLoading(event, url = null) {
        event.preventDefault();
        const loadingScreen = document.getElementById("loading-screen");
        loadingScreen.style.display = "flex";

        setTimeout(function () {
            if (url) {
                window.location.href = url;
            } else {
                window.location.href = event.target.href;
            }
        }, 500);
    }
</script>
</body>
</html>