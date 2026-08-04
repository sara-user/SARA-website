<?php
require_once __DIR__ . '/includes/event-data.php';
include 'includes/header.php';

// Newest gallery of any kind, for the link under the photo at the top.
$latestEvent  = sara_latest_event();
// Every picnic gallery, newest first, for the Events card.
$picnicSlugs  = sara_event_slugs('picnic');
?>
    <figure style="width: max-content;">
        <img src="images/view.jpeg" class="img-fluid w-100" alt="View">
        <figcaption class="text-center mt-2 fw-bold fs-5">Welcome to SARA <br> the Suburban Amateur Repeater Association
        </figcaption>
    </figure>


    <?php if ($latestEvent !== null) : ?>
        <div class="d-flex align-items-center gap-2">
            <a href="<?php echo htmlspecialchars(sara_event_url($latestEvent['slug']), ENT_QUOTES); ?>">
                <h3><?php echo htmlspecialchars($latestEvent['title'], ENT_QUOTES); ?> Photos</h3>
            </a>
        </div>
    <?php endif; ?>

    <div class="container mt-4">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">

            <div class="col">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Repeaters</h5>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <tbody>
                                <tr>
                                    <td>VHF</td>
                                    <td>FM</td>
                                    <td>146.880</td>
                                </tr>
                                <tr>
                                    <td>UHF</td>
                                    <td>FM</td>
                                    <td>444.375</td>
                                </tr>
                                <tr>
                                    <td title="Polish-American Ham Radio Operators Society">PAAROS</td>
                                    <td>Fusion</td>
                                    <td>440.250</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <a href="/repeaters.php" class="btn btn-primary">Details</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100">
                    <div>
                        <div class="card-body">
                            <h5 class="card-title">Events</h5>
                            <table class="table table-sm ">
                                <tbody>
                                <tr>
                                    <td><a href="holidayParty.php">Chistmas Party</a></td>
                                    <td><?php echo sara_photo_link('holiday-party') ?: 'Tues 12/9/2025'; ?></td>
                                </tr>
                                <tr>
                                    <td><a href="papaChris.php">Saturday Lunch</a></td>
                                    <td>Saturdays</td>
                                </tr>
                                <?php // One row per picnic gallery; a new folder of photos adds itself. ?>
                                <?php foreach ($picnicSlugs as $i => $slug) :
                                    $picnic = sara_event_meta($slug);
                                    ?>
                                    <tr>
                                        <td><?php if ($i === 0) : ?><a href="picnic.php">Picnic</a><?php endif; ?></td>
                                        <td>
                                            <a href="<?php echo htmlspecialchars(sara_event_url($slug), ENT_QUOTES); ?>">
                                                <?php echo htmlspecialchars(substr($picnic['date'], 0, 4), ENT_QUOTES); ?> Photos
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                <?php if ($picnicSlugs === []) : ?>
                                    <tr>
                                        <td><a href="picnic.php">Picnic</a></td>
                                        <td>Late Summer</td>
                                    </tr>
                                <?php endif; ?>
                                <tr>
                                    <td><a href="events.php">Photo Galleries</a></td>
                                    <td>All events</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card h-100">

                    <div class="nets">
                        <div class="card-body">
                            <h5 class="card-title">Nets on 146.88 Mhz</h5>
                            <table class="table table-sm ">
                                <tbody>
                                <tr>
                                    <td><a href="https://www.csraham.com" target="_blank"
                                           title="Chicago Suburban Radio Association">CSRA</td>
                                    <td>Mondays 7PM</td>
                                </tr>
                                <tr>
                                    <td><a href="https://wcars.radio" target="_blank"
                                           title="Windy City Amateur Radio Society">WCARS
                                    </td>
                                    <td>Thursdays 7PM</td>
                                </tr>


                                </tbody>
                            </table>
                            <a href="/nets.php" class="btn btn-primary">Details</a>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100">
                    <div>
                        <div class="card-body">
                            <h5 class="card-title">Public Service
                                <h5>
                                    <p>
                                        SARA Helps Out
                                    </p>
                                    <a href="/publicService.php" class="btn btn-primary">Details</a>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100">
                    <div>
                        <div class="card-body">
                            <h5 class="card-title">SARA Info
                                <h5>
                                    <table>
                                        <tr>
                                            <td><a href="contact.php">Join</a></td>
                                        </tr>
                                        <tr>
                                            <td><a href="whoWeAre.php">Who we are</a></td>
                                        </tr>
                                    </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100">
                    <div>
                        <div class="card-body">
                            <h5 class="card-title">History
                                <h5>
                                    <p>
                                        Since 1967
                                    </p>
                                    <a href="/history.php" class="btn btn-primary">Details</a>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Bob Schiff, SK</h5>
                        <img src="images/bob.jpg" alt="Photo of Bob Schiff" width="50%">
                        <p>In Memory of Bob Schiff, KA9HHH, sk March 30, 2020</p>
                    </div>
                </div>
            </div>

        </div>
    </div>

<?php include 'includes/footer.php'; ?>