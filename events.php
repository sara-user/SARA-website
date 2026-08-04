<?php
/**
 * Every photo gallery we have, newest first. Nothing to edit here when photos
 * are added -- a new directory under images/events/ shows up on its own.
 */
require_once __DIR__ . '/includes/event-data.php';

$slugs = sara_event_slugs();

include 'includes/header.php';
include 'includes/back.php';
?>
<div class="container py-4">
    <h2>Photo Galleries</h2>

    <?php if ($slugs === []) : ?>
        <div class="alert alert-warning" role="alert">
            There are no photo galleries yet. Add one by making a folder of photos
            in <code><?php echo SARA_EVENTS_SUBDIR; ?></code>.
        </div>
    <?php else : ?>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4 mt-2">
            <?php foreach ($slugs as $slug) :
                $event = sara_event_meta($slug);
                $url   = htmlspecialchars(sara_event_url($slug), ENT_QUOTES);
                ?>
                <div class="col">
                    <div class="card h-100">
                        <?php if ($event['cover'] !== null) : ?>
                            <a href="<?php echo $url; ?>">
                                <img src="<?php echo htmlspecialchars($event['cover'], ENT_QUOTES); ?>"
                                     class="card-img-top"
                                     alt="<?php echo htmlspecialchars($event['title'], ENT_QUOTES); ?>"
                                     loading="lazy"
                                     decoding="async"
                                     style="aspect-ratio: 4/3; object-fit: cover;">
                            </a>
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title">
                                <a href="<?php echo $url; ?>"><?php echo htmlspecialchars($event['title'], ENT_QUOTES); ?></a>
                            </h5>
                            <p class="card-text text-muted small mb-0">
                                <?php echo htmlspecialchars(date('F j, Y', strtotime($event['date'])), ENT_QUOTES); ?>
                                &middot; <?php echo sara_photo_count_label($event['count']); ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
