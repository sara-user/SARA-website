<?php
/**
 * Photo gallery page for one event.
 *
 * Set $event to the directory name under images/events/ and require this file:
 *
 *   <?php $event = 'picnic-2026'; require __DIR__ . '/includes/gallery.php';
 *
 * Photos open full screen in GLightbox, which handles swiping on a phone,
 * arrow keys on a desktop, and pinch zoom.
 */

require_once __DIR__ . '/event-data.php';

$event  = $event ?? '';
$meta   = $event === '' ? null : sara_event_meta($event);
$images = $meta === null ? [] : sara_event_images($event);

$extraHead = '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox@3.3.1/dist/css/glightbox.min.css"/>';

include __DIR__ . '/header.php';
include __DIR__ . '/back.php';
?>
<div class="container py-4">
    <?php if ($meta === null) : ?>
        <h2>Photos</h2>
        <div class="alert alert-warning" role="alert">
            That photo gallery wasn't found. See <a href="events.php">all photo galleries</a>.
        </div>
    <?php else : ?>
        <div class="d-flex align-items-center justify-content-between">
            <h2 class="mb-0"><?php echo htmlspecialchars($meta['title'], ENT_QUOTES); ?></h2>
            <?php if (!empty($images)) : ?>
                <small class="text-muted"><?php echo sara_photo_count_label(count($images)); ?></small>
            <?php endif; ?>
        </div>
        <?php if ($meta['blurb'] !== '') : ?>
            <p class="text-muted"><?php echo htmlspecialchars($meta['blurb'], ENT_QUOTES); ?></p>
        <?php endif; ?>

        <?php if (empty($images)) : ?>
            <div class="alert alert-warning" role="alert">
                No images were found in <code><?php echo htmlspecialchars(SARA_EVENTS_SUBDIR . '/' . $event, ENT_QUOTES); ?></code>.
                Make sure the folder contains JPG/PNG/WEBP/AVIF files.
            </div>
        <?php else : ?>
            <p class="text-muted small">Click a photo to see it full size.</p>

            <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 g-3">
                <?php foreach ($images as $image) : ?>
                    <div class="col">
                        <a href="<?php echo htmlspecialchars($image['url'], ENT_QUOTES); ?>"
                           class="glightbox d-block border rounded-3 overflow-hidden"
                           data-gallery="event-photos"
                           <?php if ($image['caption'] !== '') : ?>
                               data-title="<?php echo htmlspecialchars($image['caption'], ENT_QUOTES); ?>"
                           <?php endif; ?>>
                            <img src="<?php echo htmlspecialchars($image['url'], ENT_QUOTES); ?>"
                                 class="img-fluid d-block"
                                 alt="<?php echo htmlspecialchars($image['caption'] !== '' ? $image['caption'] : $meta['title'], ENT_QUOTES); ?>"
                                 loading="lazy"
                                 decoding="async"
                                 style="aspect-ratio: 4/3; object-fit: cover;">
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <p class="mt-4"><a href="events.php">All photo galleries</a></p>
</div>

<?php if (!empty($images)) : ?>
    <script src="https://cdn.jsdelivr.net/npm/glightbox@3.3.1/dist/js/glightbox.min.js"></script>
    <script>
        GLightbox({selector: '.glightbox', touchNavigation: true, loop: true});
    </script>
<?php endif; ?>

<?php include __DIR__ . '/footer.php'; ?>
