<?php 

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $to = "outreach@bmun.org";
    $nameErr = $emailErr =  $phoneErr = $schoolErr = $dateErr = $surveyErr = $expErr = $messageErr = "";
    $name = $email = $phone = $school = $date = $survey = $exp = $message = "";

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

        if (empty($_POST["phone"])) {
            $phoneErr = "Phone is required";
        } else {
            $phone = test_input($_POST["phone"]);
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
            $date = test_input($_POST["date"]);
        }

        if (empty($_POST["ch"])) {
            $surveyErr = "Please select from the survey";
        } else {

        }

        if (empty($_POST["exp"])) {
            $expErr = "Please select an experience level";
        } else {
            $exp = $_POST["exp"];
        }

        if (empty($_POST["message"])) {
            $messageErr = "Please provide information about your session request";
        } else {
            $message = test_input($_POST["message"]);
        }
    }

    $errors = true;

    if (empty($nameErr) and empty($emailErr) and empty($phoneErr) and empty($schoolErrr) and empty($dateErr) and empty($surveyErr) and empty($expErr) and empty($messageErr) and $_SERVER["REQUEST_METHOD"] == "POST") {

        $errors = false;

        $to = "outreach@bmun.org";
        $from = "From:" . $_POST['email'];
        $subject = "Outreach Request Session for " . $_POST['school'] . " from " . $_POST['name'];

        if (isset($_POST["ch"])) {
            if (is_array($_POST["ch"])) {
                foreach($_POST["ch"] as $val) {
                    $survey .= $val . "\n";
                }
            } else {
                $survey = $_POST["ch"] . "\n";
            }
        }
        $messageToSend = "Survey:\n" . $survey . "\nExperience:\n" . $exp . "\n\nDates:\n" . $date . "\n\nPhone:\n" . $phone . "\n\nMessage:\n" . $message;

        $sentmail = mail($to, $subject, $messageToSend, $from);

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
                    if ($sentmail) {
                        echo "<div class=\"alert alert-success\"> Thank you " . $_POST['name'] . "! Your email has been sent. We hope to get back to you soon.</div>";
                    } else {
                        echo "<div class=\"alert alert-danger\"> Your email could not be sent. Please email outreach@bmun.org directly. </div>";
                    }
                }
                else {
                    if (!empty($nameErr)) { 
                        echo "<div class=\"alert alert-danger\">" . $nameErr . "</div>"; }
                    if (!empty($emailErr)) { 
                        echo "<div class=\"alert alert-danger\">" . $emailErr . "</div>"; }
                    if (!empty($phoneErr)) { 
                        echo "<div class=\"alert alert-danger\">" . $phoneErr . "</div>"; }
                    if (!empty($schoolErr)) { 
                        echo "<div class=\"alert alert-danger\">" . $schoolErr . "</div>"; }
                    if (!empty($dateErr)) { 
                        echo "<div class=\"alert alert-danger\">" . $dateErr . "</div>"; }
                    if (!empty($surveyErr)) { 
                        echo "<div class=\"alert alert-danger\">" . $surveyErr . "</div>"; }
                    if (!empty($expErr)) { 
                        echo "<div class=\"alert alert-danger\">" . $expErr . "</div>"; }
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
                    <label for="name">Advisor/Person of Contact</label>
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
                    <label for="email">Email <small>(please provide your most used email)</small></label>
                    <input type="email" class="form-control" name="email" 
                    value="<?php if (empty($emailErr)) { echo $email; } ?>" >
                </div>

                <?php 
                    if (!empty($phoneErr)) {
                        echo "<div class=\"form-group has-error\">";
                    } else {
                        echo "<div class=\"form-group \">";
                    }
                ?>
                    <label for="phone">Phone Number <small>(include best time to call)</small></label>
                    <input type="text" class="form-control" name="phone" 
                    value="<?php if (empty($phoneErr)) { echo $phone; } ?>" >
                </div>

                <?php 
                    if (!empty($schoolErr)) {
                        echo "<div class=\"form-group has-error\">";
                    } else {
                        echo "<div class=\"form-group \">";
                    }
                ?>
                    <label for="school">School Name</label>
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
                    <label for="date">Preferred Time/Location of Session</label>
                    <input type="text" class="form-control" name="date" 
                    value="<?php if (empty($dateErr)) { echo $date; } ?>">
                </div>

                <?php 
                    if (!empty($surveyErr)) {
                        echo "<div class=\"form-group has-error\">";
                    } else {
                        echo "<div class=\"form-group \">";
                    }
                ?>
                    <label for="survey">Survey <small>(please check all applicable boxes)</small></label><br>
                    <input type="checkbox" name="ch[]" 
                    value= "We plan on attending the Delegate Workshop in November"> We plan on attending the Delegate Workshop in November<br>
                    <input type="checkbox" name="ch[]" 
                    value= "We have attended the Delegate Workshop before"> We have attended the Delegate Workshop before<br>
                    <input type="checkbox" name="ch[]" 
                    value= "We plan on attending the conference in March"> We plan on attending the conference in March<br>
                    <input type="checkbox" name="ch[]" 
                    value= "We have attended the conference before"> We have attended the conference before<br>
                    <input type="checkbox" name="ch[]" 
                    value= "We currently have a Model UN Program"> We currently have a Model UN Program<br>
                    <input type="checkbox" name="ch[]" 
                    value= "We want to start a Model UN Program"> We want to start a Model UN Program<br>
                    <input type="checkbox" name="ch[]" 
                    value= "We would be interested in hosting our own conference"> We would be interested in hosting our own conference<br>
                </div>
                
                <?php 
                    if (!empty($expErr)) {
                        echo "<div class=\"form-group has-error\">";
                    } else {
                        echo "<div class=\"form-group \">";
                    }
                ?>
                    <label for="exp">What level of MUN experience do your students have?</label><br>
                    <input type="radio" name="exp" value="Novice"> Novice<br>
                    <input type="radio" name="exp" value="Intermediate"> Intermediate<br>
                    <input type="radio" name="exp" value="Advanced"> Advanced<br>
                    <input type="radio" name="exp" value="Range (all levels)"> Range (all levels)<br>
                </div>

                <?php 
                    if (!empty($messageErr)) {
                        echo "<div class=\"form-group has-error\">";
                    } else {
                        echo "<div class=\"form-group \">";
                    }
                ?>
                    <label for="message">Please provide a brief description of your program and what you would like to cover in this session <small>(topics include MUN procedure, public speaking, current events, chair training, committee simulation, etc.) </label>
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