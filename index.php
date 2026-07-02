<?php
require_once __DIR__ . '/config/autoload.php';
require_once __DIR__ . '/components/renderers.php';
require_once __DIR__ . '/components/widgets.php';
Session::start();

if (!Session::isLoggedIn()) {
    header('Location: /2014/auth/login.php');
    exit();
}

$user = Session::user();
$db = Database::getInstance();
$tracks = $db->getAllTracks();
$stats = $db->getStats();
$pageTitle = 'Dashboard';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?> - <?= APP_NAME ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?= CSS_URL ?>variables.css">
    <link rel="stylesheet" href="<?= CSS_URL ?>reset.css">
    <link rel="stylesheet" href="<?= CSS_URL ?>components.css">
    <link rel="stylesheet" href="<?= CSS_URL ?>dashboard.css">
    <link rel="stylesheet" href="<?= CSS_URL ?>responsive.css">
</head>
<body>
    <div class="dashboard">
        <?php include __DIR__ . '/includes/sidebar.php'; ?>

        <main class="main-content">
            <?php include __DIR__ . '/includes/topbar.php'; ?>

            <div class="content">
                <div class="profile-card">
                    <div class="profile-photo">
                        <img src="<?= IMAGES_URL ?>myphoto.png" alt="<?= sanitize($user['name']) ?>">
                    </div>
                    <div class="profile-info">
                        <h2 dir="rtl">أهلاً بك <?= sanitize($user['name']) ?></h2>
                        <p>Track your learning progress and explore new courses.</p>
                        <div class="profile-stats">
                            <div class="profile-stat">
                                <div class="profile-stat-value" data-count="<?= $stats['total_courses'] ?>">0</div>
                                <div class="profile-stat-label">Courses</div>
                            </div>
                            <div class="profile-stat">
                                <div class="profile-stat-value" data-count="<?= $stats['total_lessons'] ?>">0</div>
                                <div class="profile-stat-label">Lessons</div>
                            </div>
                            <div class="profile-stat">
                                <div class="profile-stat-value" data-count="<?= $stats['total_hours'] ?>">0</div>
                                <div class="profile-stat-label">Hours</div>
                            </div>
                            <div class="profile-stat">
                                <div class="profile-stat-value" data-count="<?= $stats['completion_rate'] ?>">0</div>
                                <div class="profile-stat-label">Completion %</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="stats-grid">
                    <?php
                    renderStatCard('fas fa-users', 'rgba(108, 99, 255, 0.2)', $stats['total_students'], 'Total Students', 12.5);
                    renderStatCard('fas fa-graduation-cap', 'rgba(72, 198, 239, 0.2)', $stats['total_courses'], 'Active Courses', 5);
                    renderStatCard('fas fa-book-open', 'rgba(247, 140, 162, 0.2)', $stats['total_lessons'], 'Total Lessons', 8.3);
                    renderStatCard('fas fa-clock', 'rgba(0, 214, 143, 0.2)', $stats['total_hours'], 'Learning Hours', 15.2);
                    ?>
                </div>

                <div class="chart-container glass-card">
                    <div class="chart-header">
                        <h3>Student Enrollment Trends</h3>
                        <div class="tabs">
                            <span class="tab active">Monthly</span>
                            <span class="tab">Weekly</span>
                        </div>
                    </div>
                    <div class="chart-canvas"></div>
                </div>

                <div class="section-header">
                    <h2>Available Courses</h2>
                    <a href="/2014/courses/" class="view-all">View All <i class="fas fa-arrow-right"></i></a>
                </div>

                <div class="courses-grid">
                    <?php foreach ($tracks as $track): ?>
                        <?php renderTrackCard($track); ?>
                    <?php endforeach; ?>
                </div>
            </div>

            <footer style="text-align: center; padding: var(--spacing-xl); color: var(--text-tertiary); font-size: var(--text-sm);">
                <p>&copy; <?= date('Y') ?> <?= APP_NAME ?>. Built with <i class="fas fa-heart" style="color: var(--accent-color);"></i> by <?= APP_AUTHOR ?></p>
            </footer>
        </main>
    </div>

    <script src="<?= JS_URL ?>app.js"></script>
    <script src="<?= JS_URL ?>progress.js"></script>
    <script src="<?= JS_URL ?>search.js"></script>
    <script src="<?= JS_URL ?>dashboard.js"></script>
    <script src="<?= JS_URL ?>course.js"></script>
    <script src="<?= JS_URL ?>main.js"></script>
</body>
</html>
