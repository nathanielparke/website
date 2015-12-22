<?php
    include 'html/header.html';
    include 'html/navbar.html';
    ini_set("auto_detect_line_endings", true);
?>

<div class="container">
    <div class="col-md-10 col-md-offset-1 content bgimg">
        <h1 class="content-heading">Officers</h2>
        <hr>

        <?php
            $officers = fopen("./Bios/OfficerBios.csv", "r");
            while (! feof($officers)) {
                $officer = fgetcsv($officers);
                $officer_name = $officer[0];
                $officer_position = $officer[1];
                $officer_major = $officer[2];
                $officer_year = $officer[3];
                $officer_role = $officer[4];
                $officer_delegates = $officer[5];
                $filename = "./OfficerPics\\".str_replace(' ', '', $officer_name).".jpg";

                echo "<div class=\"row front\">
                    <div class=\"col-md-6\" >
                        <ul>
                            <li><b>Name: </b>$officer_name</li>
                            <li><b>Position: </b>$officer_position</li>
                            <li><b>Major: </b>$officer_major</li>
                            <li><b>Year: </b>$officer_year</li>
                            <li><b>Their Role in Bmun: </b>$officer_role</li>
                            <li><b>Message to Delegates: </b>$officer_delegates</li>
                        </ul>
                    </div>

                    <div class=\"col-md-6\">
                        <img class=\"featurette-image img-responsive\" style=\"margin:7px\" src=$filename height=600 width=400>
                    </div>
                </div>";
                }

        ?>
        <br>
    </div>
</div>

<?php
    include './html/footer.html';
?>
