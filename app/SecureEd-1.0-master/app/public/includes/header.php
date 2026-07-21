<?php
$pageTitle = $pageTitle ?? "Secure ED";
$showLogout = $showLogout ?? false;
$showDashboard = $showDashboard ?? false;
$isAuthenticated = isset($_SESSION["email"]) && !empty($_SESSION["email"]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../resources/secure_app.css">
    <link rel="icon" type="image/svg" href="../resources/Header_Lock_Image.svg">
    <script defer src="../resources/nav.js"></script>
    <meta charset="utf-8" />
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
</head>
<body>
  <div id="wrapper">
    <header class="app-header">
	  <div class="header_table">
        <div class="lock">
            <img src="../resources/Header_Lock_Image.svg" alt="Secure ED lock icon">
        </div>
        <div class="title">Secure ED.</div>
        <div class="header_table_cell">
            <span class="subtitle">Educational Security Lab</span>
        </div>
	  </div>
    </header>

      <nav class="main-nav">
          <?php if ($showDashboard && $isAuthenticated): ?>
              <button class="btn btn-primary" type="button" onclick="toDashboard();">Dashboard</button>
          <?php endif; ?>
          <?php if ($showLogout && $isAuthenticated): ?>
              <button class="btn btn-danger" type="button" onclick="toLogout();">Log Out</button>
          <?php endif; ?>
      </nav>
