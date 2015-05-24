		<?php

			//Connect to the database
			include('dbconfig.php');//Load connection string
			include('shapeModel.php');
			
			//Make a new shape model, passing our connection string
			$shapeModel=new ShapeModel($conn);
			try{
				//If we are in a specified mode (not select)
				if(isset($_GET['mode'])){
					if($_GET['mode']=="update"){
						//Update the shape as specified by GET data
						$shapeModel->updateShape($_GET['id'],$_GET['width'],$_GET['height'],$_GET['x'],$_GET['y'],$_GET['red'],$_GET['green'],$_GET['blue']);
					}
					elseif($_GET['mode']=="insert"){
						//Insert the shape as specified by GET data
						$shapeModel->insertShape($_GET['width'],$_GET['height'],$_GET['x'],$_GET['y'],$_GET['red'],$_GET['green'],$_GET['blue']);
					}
				}
				else{//Selection mode is default, this means we can view our drawing directly without the interface
					//Get all data from shapes table
					echo '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="640" height="480" id="drawing">' . "\n";
					foreach($shapeModel->getShapes() as $row) {
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