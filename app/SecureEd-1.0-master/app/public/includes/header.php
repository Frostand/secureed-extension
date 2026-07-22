<?php
$pageTitle = $pageTitle ?? "Secure ED";
$showLogout = $showLogout ?? false;
$showDashboard = $showDashboard ?? false;
$isAuthenticated = isset($_SESSION["email"]) && !empty($_SESSION["email"]);
$isLabPage = strpos($_SERVER["SCRIPT_NAME"] ?? "", "/public/labs/") !== false;
$resourcePath = $isLabPage ? "../../resources" : "../resources";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="<?php echo $resourcePath; ?>/secure_app.css">
    <link rel="icon" type="image/svg+xml" href="<?php echo $resourcePath; ?>/Header_Lock_Image.svg">
    <script defer src="<?php echo $resourcePath; ?>/nav.js"></script>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
</head>
<body>
  <div id="wrapper">
    <header class="app-header">
	  <div class="header_table">
        <div class="lock">
            <img src="<?php echo $resourcePath; ?>/Header_Lock_Image.svg" alt="Secure ED lock icon">
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
