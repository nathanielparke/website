<?php 

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $to = "outreach@bmun.org";
    $nameErr = $emailErr = $schoolErr = $dateErr = $messageErr = "";
    $name = $email = $school = $date = $message = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["name"])) {
            $nameErr = "Name is required";
        } else {
            $name = test_input($_POST["name"]);
            if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
                $nameErr = "Please enter a valid name"; 
            }
        }

        if (empty($_POST["email"])) {
            $emailErr = "Email is required";
        } else {
            $email = test_input($_POST["email"]);
            if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$email)) {
                $emailErr = "Invalid email format"; 
            }
        }

        if (empty($_POST["school"])) {
            $schoolErr = "School is required";
        } else {
            $school = test_input($_POST["school"]);
            if (!preg_match("/^[a-zA-Z ]*$/",$school)) {
                $schoolErr = "Please enter a valid school name"; 
            }
        }

        if (empty($_POST["date"])) {
            $dateErr = "Date is required";
        } else {
            $date = $_POST["date"];
        }

        if (empty($_POST["message"])) {
            $messageErr = "Please provide information about your session request";
        } else {
            $message = test_input($_POST["message"]);
        }
    }

    $errors = true;

    if (empty($nameErr) and empty($emailErr) and empty($schoolErrr) and empty($dateErr) 
        and empty($messageErr) and $_SERVER["REQUEST_METHOD"] == "POST") {

        $errors = false;

        $to = "outreach@bmun.org";
        $from = "From:" . $_POST['email'];
        $name = $_POST['name'];
        $subject = "Outreach Request Session for " . $_POST['school'] . " on " . $_POST['date'];

        $message = $_POST['message'];

        mail($to, $subject, $message, $from);
    }

    include 'html/header.html';
    include 'html/navbar.html';

?>


<!-- Marketing Container -->
<div class="container">
    <div class="col-md-10 col-md-offset-1 content bgimg">
        <h1 class="content-heading">Outreach Request Form</h1>
        <hr>

        <div class="col-md-offset-1">
            <form role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" 
                method="POST" id="outreach">

                <?php if (!$errors) {
                    echo "<div class=\"alert alert-success\"> Thank you " . $_POST['name'] . 
                    "! Your email has been sent. We hope to get back to you soon.</div>";
                }
                else {
                    if (!empty($nameErr)) { 
                        echo "<div class=\"alert alert-danger\">" . $nameErr . "</div>"; }
                    if (!empty($emailErr)) { 
                        echo "<div class=\"alert alert-danger\">" . $emailErr . "</div>"; }
                    if (!empty($schoolErr)) { 
                        echo "<div class=\"alert alert-danger\">" . $schoolErr . "</div>"; }
                    if (!empty($dateErr)) { 
                        echo "<div class=\"alert alert-danger\">" . $dateErr . "</div>"; }
                    if (!empty($messageErr)) { 
                        echo "<div class=\"alert alert-danger\">" . $messageErr . "</div>"; }
                    }

                ?>

                <?php 
                    if (!empty($nameErr)) {
                        echo "<div class=\"form-group has-error\">";
                    } else {
                        echo "<div class=\"form-group \">";
                    }
                ?>
                    <label for="name">Name</label>
                    <input type="text" class="form-control" name="name" 
                    value="<?php if (empty($nameErr)) { echo $name; } ?>" >
                </div>

                <?php 
                    if (!empty($emailErr)) {
                        echo "<div class=\"form-group has-error\">";
                    } else {
                        echo "<div class=\"form-group \">";
                    }
                ?>
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" 
                    value="<?php if (empty($emailErr)) { echo $email; } ?>" >
                </div>

                <?php 
                    if (!empty($schoolErr)) {
                        echo "<div class=\"form-group has-error\">";
                    } else {
                        echo "<div class=\"form-group \">";
                    }
                ?>
                    <label for="school">School</label>
                    <input type="text" class="form-control" name="school" 
                    value="<?php if (empty($schoolErr)) { echo $school; } ?>">
                </div>

                <?php 
                    if (!empty($dateErr)) {
                        echo "<div class=\"form-group has-error\">";
                    } else {
                        echo "<div class=\"form-group \">";
                    }
                ?>
                    <label for="date">Date</label>
                    <input type="date" class="form-control" name="date" 
                    value="<?php if (empty($dateErr)) { echo $date; } ?>">
                </div>
                
                <?php 
                    if (!empty($messageErr)) {
                        echo "<div class=\"form-group has-error\">";
                    } else {
                        echo "<div class=\"form-group \">";
                    }
                ?>
                    <label for="message">Please provide a brief description of your program and what 
                        you would like to cover in this session</label>
                    <textarea rows="7" class="form-control" name="message" form="outreach"><?php if (empty($messageErr)) { echo $message; } ?></textarea>
                </div>

                <small> All fields are required. </small><br>
                <input type="submit" name="submit" value="Submit">

            </form>
        </div>


    </div>
</div>

<?php
    include 'html/footer.html';
?>