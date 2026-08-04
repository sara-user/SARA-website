<?php
require_once __DIR__ . '/includes/event-data.php';
include 'includes/header.php';
include 'includes/back.php';

$latestPicnic = sara_latest_event('picnic');
?>
<div class="container">
    <h2>SARA Annual Picnic</h2>

    <p>SARA's annual picnic is held in late Summer each year. This year's was on July 26th, 2026.</p>
    <p>Check back here when we get closer to next Summer.</p>
    <?php if ($latestPicnic !== null) : ?>
        <p>In the meantime, check out the
            <a href="<?php echo htmlspecialchars(sara_event_url($latestPicnic['slug']), ENT_QUOTES); ?>">photos</a>
            from the <?php echo htmlspecialchars(substr($latestPicnic['date'], 0, 4), ENT_QUOTES); ?> picnic.</p>
    <?php endif; ?>
    <p><a href="events.php">All photo galleries</a></p>
<?php include 'includes/footer.php'; ?>
