<?php
$pageTitle = "Security Lab Exercises";
$showLogout = false;
$showDashboard = false;
?>
<?php include "../includes/header.php"; ?>
    <main>
        <h1>Secure ED - Vulnerability Labs</h1>
        <div class="horizontal_line"><hr></div>

        <p class="page-intro">Each page below is a beginner-friendly demo. Try the flow, then use the <a href="http://localhost:8080/guide.html">project guide</a> if you need the full steps.</p>

        <section class="lab-grid">
            <article class="lab-card">
                <h2>CWE-640: Weak Password Recovery</h2>
                <p>Reset a password using only an email in a link. No secret token is required.</p>
                <a href="CWE-640.php">Open Lab</a>
            </article>

            <article class="lab-card">
                <h2>CWE-613: Insufficient Session Expiration</h2>
                <p>Learn how sessions can stay valid for long delays because the app does not enforce an expiration check.</p>
                <a href="CWE-613.php">Open Lab</a>
            </article>

            <article class="lab-card">
                <h2>CWE-384: Session Fixation</h2>
                <p>Use a known session ID and keep it after login because the app does not regenerate IDs.</p>
                <a href="CWE-384.php">Open Lab</a>
            </article>
        </section>

        <p style="margin-top: 1rem;">Need help? Start from the project root README file and then jump to each lab.</p>
    </main>
<?php include "../includes/footer.php"; ?>
