		<?php

			//Connect to the database
			$conn = new PDO('mysql:host=localhost;dbname=svgdb', 'root', '');
			
			try{
				//If we are in insert mode
				if(isset($_GET['mode'])){
					//Update the shape as specified by GET data
					//Using a prepared statement
					$sql = "UPDATE tblshapes SET width=:width,height=:height,x=:x,y=:y,red=:red,green=:green,blue=:blue WHERE id=:id";
					$q = $conn->prepare($sql);
					//Execute query
					$q->execute(array(':width'=>$_GET['width'],
									  ':height'=>$_GET['height'],':x'=>$_GET['x'],':y'=>$_GET['y'],
									  ':red'=>$_GET['red'],':green'=>$_GET['green'],':blue'=>$_GET['blue'],':id'=>$_GET['id']));
				}
				else{//Selection mode
					//Get all data from shapes table
					//echo '<svg width="640" height="480">';
					foreach($conn->query('SELECT * FROM tblshapes') as $row) {
						//Format shape data into HTML
						//<rect id="shape1" width="200" height="200" style="fill:rgb(0,0,255)" x="1" y="1" />
						echo "<rect id=";
						echo '"shape' . $row['id'] . '"'
						. ' width="' . $row['width'] . '"'
						. ' height="' . $row['height'] . '"'
						. ' x="' . $row['x'] . '"'
						. ' y="' . $row['y'] . '"'
						. ' style="fill:rgb(' . $row['red'] . ',' . $row['green'] . ',' . $row['blue'] . ')" />' . "\n";
					}
					//echo '</svg>';
				}
			}
			catch(PDOException $ex){ //If an error occurs output in readable form
				echo $ex->getMessage();
			}
		?>