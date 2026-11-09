<?php
require_once __DIR__ . '/includes/event-data.php';
include 'includes/header.php';

$latestParty = sara_latest_event('holiday-party');
?>

<div class="container">
    <h3>Christmas Party</h3>
    <img src="/images/holiday/holly-2957539.svg" alt="Holly" width="10%">
    <p>Save the date: <em>Tuesday December 15th, 2026 7PM.</em></p>
    <p>Dino's Pizza & Italian Restaurant<br/>
        7004 W Higgins Ave<br/>
        Chicago IL 60656<br/>
        <a href="http://www.dinospizzachicago.com">www.dinospizzachicago.com</a></p>
    <p>
        All members and their guests are invited to attend. Cost is $15.00 per person.</p>

    <p> Pizza and soft drinks will be served (buffet-style).</p>

    <?php if ($latestParty !== null) : ?>
        <p>See the <a href="<?php echo htmlspecialchars(sara_event_url($latestParty['slug']), ENT_QUOTES); ?>">photos</a>
            from the <?php echo htmlspecialchars(substr($latestParty['date'], 0, 4), ENT_QUOTES); ?> party.</p>
    <?php endif; ?>
</div>
<?php include 'includes/footer.php'; ?>
