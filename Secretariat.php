<?php 
    include 'html/header.html';
    include 'html/navbar.html'
?>

<div class="container">
 	<div class="col-md-10 col-md-offset-1 content bgimg">
        <h1 class="content-heading">Secretariat</h2>
        <hr>
 
        <?php
        	$secretariats = fopen("./Bios/SecretariatBios.csv", "r");
        	while (! feof($secretariats)) {
				$secretariat = fgetcsv($secretariats);
				$secretariat_name = $secretariat[0];
				$secretariat_major = $secretariat[1];
				$secretariat_year = $secretariat[2];
				$filename = ".\Headshots\\" . str_replace(' ', '', $secretariat_name) . ".jpg";
 			
                echo "<div class=\"row front\">";
	            
                echo "<div class=\"col-md-3\" >
	                    <ul>
	                    	<li><b>Name: </b>$secretariat_name</li>
	                    	<li><b>Major: </b>$secretariat_major</li>
	                    	<li><b>Year: </b>$secretariat_year</li>
	                    </ul>
	                </div>
 
	                <div class=\"col-md-3\">
	                    <img class=\"featurette-image img-responsive\" style=\"margin:7px\" src=$filename height=300 width=200>
	                </div>";
            	
				
                if (feof($secretariats)) {
                    echo "</div>";
                    break;
                }

                $secretariat = fgetcsv($secretariats);
                $secretariat_name = $secretariat[0];
                $secretariat_major = $secretariat[1];
                $secretariat_year = $secretariat[2];
                $filename = ".\Headshots\\" . str_replace(' ', '', $secretariat_name) . ".jpg";
            
                echo "<div class=\"col-md-3\" >
                        <ul>
                            <li><b>Name: </b>$secretariat_name</li>
                            <li><b>Major: </b>$secretariat_major</li>
                            <li><b>Year: </b>$secretariat_year</li>
                        </ul>
                    </div>
 
                    <div class=\"col-md-3\">
                        <img class=\"featurette-image img-responsive\" style=\"margin:7px\" src=$filename height=300 width=200>
                    </div>";
                echo "</div>";

            }

        ?>
         
        <br>
 
    </div>
</div>
<?php
    include 'html/footer.html';
?>
