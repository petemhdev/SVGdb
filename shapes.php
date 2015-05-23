		<?php

			//Connect to the database
			include('dbconfig.php');//Load connection string
			
			try{
				//If we are in a specified mode (not select)
				if(isset($_GET['mode'])){
					if($_GET['mode']=="update"){
						//Update the shape as specified by GET data
						//Using a prepared statement
						$sql = "UPDATE tblshapes SET width=:width,height=:height,x=:x,y=:y,red=:red,green=:green,blue=:blue WHERE id=:id";
						$q = $conn->prepare($sql);
						//Execute query
						$q->execute(array(':width'=>$_GET['width'],
										  ':height'=>$_GET['height'],':x'=>$_GET['x'],':y'=>$_GET['y'],
										  ':red'=>$_GET['red'],':green'=>$_GET['green'],':blue'=>$_GET['blue'],':id'=>$_GET['id']));
					}
					elseif($_GET['mode']=="insert"){
						//Insert the shape as specified by GET data
						//Using a prepared statement
						$sql = "INSERT INTO tblshapes (width,height,x,y,red,green,blue) VALUES (:width,:height,:x,:y,:red,:green,:blue)";
						$q = $conn->prepare($sql);
						//Execute query
						$q->execute(array(':width'=>$_GET['width'],
										  ':height'=>$_GET['height'],':x'=>$_GET['x'],':y'=>$_GET['y'],
										  ':red'=>$_GET['red'],':green'=>$_GET['green'],':blue'=>$_GET['blue']));
										
					}
				}
				else{//Selection mode
					//Get all data from shapes table
					echo '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="640" height="480" id="drawing">' . "\n";
					foreach($conn->query('SELECT * FROM tblshapes') as $row) {
						//Format shape data into HTML

						//Escape html special chars for security
						echo "<rect id=";
						echo '"shape' . htmlspecialchars($row['id'], ENT_NOQUOTES, 'utf-8') . '"'
						. ' width="' . htmlspecialchars($row['width'], ENT_NOQUOTES, 'utf-8') . '"'
						. ' height="' . htmlspecialchars($row['height'], ENT_NOQUOTES, 'utf-8') . '"'
						. ' x="' . htmlspecialchars($row['x'], ENT_NOQUOTES, 'utf-8') . '"'
						. ' y="' . htmlspecialchars($row['y'], ENT_NOQUOTES, 'utf-8') . '"'
						. ' style="fill:rgb(' . htmlspecialchars($row['red'], ENT_NOQUOTES, 'utf-8') . ',' . htmlspecialchars($row['green'], ENT_NOQUOTES, 'utf-8') . ',' . htmlspecialchars($row['blue'], ENT_NOQUOTES, 'utf-8') . ')"></rect>' . "\n";
					}
					echo '</svg>';
				}
			}
			catch(PDOException $ex){ //If an error occurs output in readable form
				echo $ex->getMessage();
			}
		?>