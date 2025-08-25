<?php
include 'includes/header.php';
include 'includes/back.php';

// Directory containing picnic photos (relative to this PHP file)
$dir = __DIR__ . '/images/picnic-2025';

// Collect image files with common extensions (case-insensitive)
$images = [];
if (is_dir($dir)) {
    $allowed = ['jpg','jpeg','png','gif','webp','avif'];
    foreach (scandir($dir) as $f) {
        if ($f === '.' || $f === '..') continue;
        $ext = strtolower(pathinfo($f, PATHINFO_EXTENSION));
        if (in_array($ext, $allowed)) {
            $images[] = 'images/picnic-2025/' . $f; // web path
        }
    }
    // natural sort for names like 1,2,10
    natsort($images);
    $images = array_values($images);
}
?>
<div class="container py-4">
    <div class="d-flex align-items-center justify-content-between">
        <h2 class="mb-0">2025 SARA Annual Picnic</h2>
        <?php if (!empty($images)) : ?>
            <small class="text-muted"><?php echo count($images); ?> photos</small>
        <?php endif; ?>
    </div>
    <p class="text-muted">The annual SARA picnic was on Sunday, August 24 at LaBagh Woods in Chicago.</p>

    <?php if (empty($images)) : ?>
        <div class="alert alert-warning" role="alert">
            No images were found in <code>images/picnic-2025</code>. Make sure the folder exists and contains JPG/PNG/WEBP/AVIF files.
        </div>
    <?php else : ?>
        <!-- Bootstrap 5 Carousel -->
        <div id="picnicCarousel" class="carousel slide" data-bs-ride="carousel">
            <!-- Indicators -->
            <div class="carousel-indicators">
                <?php foreach ($images as $idx => $_) : ?>
                    <button type="button"
                            data-bs-target="#picnicCarousel"
                            data-bs-slide-to="<?php echo $idx; ?>"
                            <?php if ($idx === 0) echo 'class="active" aria-current="true"'; ?>
                            aria-label="Slide <?php echo $idx + 1; ?>"></button>
                <?php endforeach; ?>
            </div>

            <!-- Slides -->
            <div class="carousel-inner">
                <?php foreach ($images as $idx => $src) :
                    $caption  = ucwords(str_replace(['-', '_'], ' ', pathinfo(basename($src), PATHINFO_FILENAME)));
                    ?>
                    <div class="carousel-item <?php if ($idx === 0) echo 'active'; ?>">
                        <img
                                src="<?php echo htmlspecialchars($src, ENT_QUOTES); ?>"
                                class="d-block mx-auto img-fluid"
                                alt="<?php echo htmlspecialchars($caption, ENT_QUOTES); ?>"
                                loading="lazy"
                                style="max-height: 75vh; object-fit: contain;"
                        >
                        <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded-3 p-2">
                            <div class="small fw-semibold"><?php echo htmlspecialchars($caption, ENT_QUOTES); ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Controls -->
            <button class="carousel-control-prev" type="button" data-bs-target="#picnicCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#picnicCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

        <!-- Optional: thumbnails grid below -->
        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 g-3 mt-4">
            <?php foreach ($images as $idx => $src) :
                $caption  = ucwords(str_replace(['-', '_'], ' ', pathinfo($src, PATHINFO_FILENAME)));
                ?>
                <div class="col">
                    <a href="#" data-bs-target="#picnicCarousel" data-bs-slide-to="<?php echo $idx; ?>" class="d-block border rounded-3 overflow-hidden">
                        <img src="<?php echo htmlspecialchars($src, ENT_QUOTES); ?>"
                             class="img-fluid d-block"
                             alt="<?php echo htmlspecialchars($caption, ENT_QUOTES); ?>"
                             loading="lazy"
                             style="aspect-ratio: 4/3; object-fit: cover;">
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
