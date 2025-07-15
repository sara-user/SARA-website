
<?php
include 'includes/header.php';
// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize form inputs
    $name     = htmlspecialchars($_POST['name'] ?? '');
    $email    = htmlspecialchars($_POST['email'] ?? '');
    $callsign = htmlspecialchars($_POST['callsign'] ?? '');
    $address  = htmlspecialchars($_POST['address'] ?? '');
    $city     = htmlspecialchars($_POST['city'] ?? '');
    $state    = htmlspecialchars($_POST['state'] ?? '');
    $zip      = htmlspecialchars($_POST['zip'] ?? '');
    $phone    = htmlspecialchars($_POST['phone'] ?? '');
    $addGroup = isset($_POST['add_to_group']) ? 'Yes' : 'No';

    // Compose email
    $to = "your@email.com"; // Replace with your actual email
    $subject = "New Form Submission";
    $message = <<<EOD
Name: $name
Email: $email
Call Sign: $callsign
Address: $address
City: $city
State: $state
Zip: $zip
Phone: $phone
Add to Group: $addGroup
EOD;

    $headers = "From: $email";

    // Send email
    $sent = mail($to, $subject, $message, $headers);
    $status = $sent ? "✅ Message sent successfully." : "❌ Failed to send message.";
}

?>

<div class="container">

    <?php if (!empty($status)) echo "<div class='alert alert-info'>$status</div>"; ?>


    <form method="post" action="">
        <fieldset class="border p-4 rounded">
            <legend class="float-none w-auto px-2">Membership Form</legend>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Call Sign</label>
                    <input type="text" name="callsign" class="form-control" required>
                </div>

                <div class="col-12">
                    <label class="form-label">Address</label>
                    <input type="text" name="address" class="form-control" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label">City</label>
                    <input type="text" name="city" class="form-control" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label">State</label>
                    <input type="text" name="state" class="form-control" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Zip</label>
                    <input type="text" name="zip" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Phone Number</label>
                    <input type="text" name="phone" class="form-control">
                </div>

                <div class="col-12">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="add_to_group" id="addToGroup">
                        <label class="form-check-label" for="addToGroup">
                            Add me to the group mailing list
                        </label>
                    </div>
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </fieldset>
    </form>



    <p>Annual Dues are $30</p>
    <p>For more information contact <a href="mailto:sara@u505.com?subject=Contact%20Request">Email us</a></p>
</div>
<?php include 'includes/footer.php'; ?>
