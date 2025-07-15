<?php include 'includes/header.php'; ?>
    <figure style="width: max-content;">
        <img src="images/view.jpeg" class="img-fluid w-100" alt="View">
        <figcaption class="text-center mt-2 fw-bold fs-5">Welcome to SARA <br> the Suburban Amateur Repeater Association
        </figcaption>
    </figure>


    <div class="d-flex align-items-center gap-2">
        <img src="images/picnic-svgrepo-com.svg" alt="Icon 1" width="32" height="32">
        <a href="picnic-2025.php"><h3>Annual SARA Picnic Sunday August 24, 2025</h3></a>
        <img src="images/antenna-svgrepo-com.svg" alt="Icon 2" width="32" height="32">
    </div>

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
                    <div class="card-body">
                        <h5 class="card-title">Bob Schiff, SK</h5>
                        <img src="images/bob.jpg" alt="Photo of Bob Schiff" width="75%">
                        <p>In Memory of Bob Schiff, KA9HHH, sk March 30, 2020</p>
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

                    <div class="nets">
                        <div class="card-body">
                            <h5 class="card-title">SARA Info<h5>
                            <p>
                                Contact, Join, Support
                            </p>
                            <a href="/contact.php" class="btn btn-primary">Details</a>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100">

                    <div class="history">
                        <div class="card-body">
                            <h5 class="card-title">History<h5>
                            <p>
                                How we got here.
                            </p>
                            <a href="/contact.php" class="btn btn-primary">Details</a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php include 'includes/footer.php'; ?>