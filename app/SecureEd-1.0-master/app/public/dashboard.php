<?php
session_start();

if (!isset($_SESSION['email']) || empty($_SESSION['email'])) {
    http_response_code(403);
    die('Forbidden');
}

$roles = [
    1 => ["Admin", "Manage accounts and review the student directory.", [
        ["Create account", "create_account.php"],
        ["User search", "user_search.php"],
    ]],
    2 => ["Faculty", "Upload grade records for your course sections.", [
        ["Enter grades", "enter_grades.php"],
    ]],
    3 => ["Student", "Search the catalog and enroll in an available section.", [
        ["Course search", "course_search.php"],
    ]],
];

$accountType = (int) ($_SESSION['acctype'] ?? 0);
if (!isset($roles[$accountType])) {
    http_response_code(403);
    die('Forbidden');
}

[$roleName, $roleDescription, $actions] = $roles[$accountType];
$pageTitle = "Secure ED. - {$roleName} Dashboard";
$showLogout = true;
$showDashboard = false;
?>
<?php include "includes/header.php"; ?>
    <main>
        <div class="page-heading">
            <p class="eyebrow"><?php echo htmlspecialchars($roleName); ?> workspace</p>
            <h1><?php echo htmlspecialchars($roleName); ?> dashboard</h1>
            <p class="page-intro"><?php echo htmlspecialchars($roleDescription); ?></p>
        </div>

        <div class="dashboard-grid">
            <?php foreach ($actions as [$label, $href]): ?>
                <a class="dashboard-card" href="<?php echo htmlspecialchars($href); ?>">
                    <span class="card-kicker">Portal action</span>
                    <strong><?php echo htmlspecialchars($label); ?></strong>
                    <span class="card-arrow" aria-hidden="true">→</span>
                </a>
            <?php endforeach; ?>

            <a class="dashboard-card dashboard-card-lab" href="labs/index.php">
                <span class="card-kicker">Learn by doing</span>
                <strong>Open lab exercises</strong>
                <span class="card-arrow" aria-hidden="true">→</span>
            </a>
        </div>
    </main>
<?php include "includes/footer.php"; ?>
