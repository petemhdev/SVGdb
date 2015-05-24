<?php


class ShapeModel
{
    protected $db;

	//We take a PDO object on construction
    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

	//Get contents of shape table
    public function getShapes() {

        return $this->db->query('SELECT id,width,height,x,y,red,green,blue FROM tblshapes');
    }
	
	//Insert new shape
    public function insertShape($width,$height,$x,$y,$red,$green,$blue) {
		$sql = "INSERT INTO tblshapes (width,height,x,y,red,green,blue) VALUES (:width,:height,:x,:y,:red,:green,:blue)";
						$q = $this->db->prepare($sql);
						//Execute query
						$q->execute(array(':width'=>$width,
										  ':height'=>$height,':x'=>$x,':y'=>$$y,
										  ':red'=>$red,':green'=>$green,':blue'=>$blue));
		return true;
	}
	
	//Update shape into table
	 public function updateShape($id,$width,$height,$x,$y,$red,$green,$blue) {
		 $sql = "UPDATE tblshapes SET width=:width,height=:height,x=:x,y=:y,red=:red,green=:green,blue=:blue WHERE id=:id";
						$q = $this->db->prepare($sql);
						//Execute query
						$q->execute(array(':width'=>$width,
										  ':height'=>$height,':x'=>$x,':y'=>$y,
										  ':red'=>$_GET['red'],':green'=>$green,':blue'=>$blue,':id'=>$id));
		return true;
	}
}