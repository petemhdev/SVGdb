		<?php
		header('Content-Type: application/json');//Declare that we are returning JSON
			//Connect to the database
			$conn = new PDO('mysql:host=localhost;dbname=svgdb', 'root', '');
			
			try{
				
				//Get all data from shapes table
				foreach($conn->query('SELECT * FROM tblshapes') as $row) {
					//Format shape data in JSON style
					echo "{\n";
					echo '"width":"' . $row['width'] . "\"\n";
					echo '"height":"' . $row['height'] . "\"\n";
					echo '"x":"' . $row['x'] . "\"\n";
					echo '"y":"' . $row['y'] . "\"\n";
					echo '"red":"' . $row['red'] . "\"\n";
					echo '"green":"' . $row['green'] . "\"\n";
					echo '"blue":"' . $row['blue'] . "\"\n";
					echo "}\n";
				}
			}
			catch(PDOException $ex){ //If an error occurs output in readable form
				echo $ex->getMessage();
			}
		?>