<?php 
require_once(APP_ROOT."/Class/database.php");
class Query extends Database {

	public function get_ColorPainting($name = ""){
		$conn = $this->conn_db();
		$conn->set_charset('utf8mb4');
		if(!empty($name)){
			$query = $conn->prepare("SELECT cp.id, cp.price, c.code, c.name FROM color as c LEFT JOIN ColorPainting as cp ON c.id = cp.color_id WHERE `name` Like '".$name."'");
		}
		else {
			$query = $conn->prepare("SELECT cp.id, cp.price, c.code, c.name FROM color as c LEFT JOIN ColorPainting as cp ON c.id = cp.color_id");
		}
		$query->execute();			
		$result = $query->get_result();		
		return $result;	
	}

	public function get_ColorSkin($name = ""){
		$conn = $this->conn_db();
		$conn->set_charset('utf8mb4');

		
		if(!empty($name)){
			$query = $conn->prepare("SELECT cs.id, cs.price, c.code, c.name FROM color as c LEFT JOIN ColorSkin as cs ON c.id = cs.color_id WHERE `name` Like '".$name."'");
		}
		else {
			$query = $conn->prepare("SELECT cs.id, cs.price, c.code, c.name FROM color as c LEFT JOIN ColorSkin as cs ON c.id = cs.color_id");
		}	
		$query->execute();			
		$result = $query->get_result();		
		return $result;	
	}

	public function get_ColorKnob($name = ""){
		$conn = $this->conn_db();
		$conn->set_charset('utf8mb4');
		if(!empty($name)){
			$query = $conn->prepare("SELECT ck.id, ck.price, c.code, c.name FROM color as c LEFT JOIN ColorKnob as ck ON c.id = ck.color_id WHERE `name` Like '".$name."'");
		}
		else {
			$query = $conn->prepare("SELECT ck.id, ck.price, c.code, c.name FROM color as c LEFT JOIN ColorKnob as ck ON c.id = ck.color_id");
		}	
		$query->execute();			
		$result = $query->get_result();		
		return $result;	
	}

	public function get_Width($name = ""){
		$conn = $this->conn_db();
		$conn->set_charset('utf8mb4');
		if(!empty($name)){
			$query = $conn->prepare("SELECT `id`, `price` FROM Width WHERE `name` Like '".$name."'");
		}
		else {
			$query = $conn->prepare("SELECT * FROM Width");
		}	
		$query->execute();			
		$result = $query->get_result();		
		return $result;	
	}

	public function get_Height($name = ""){
		$conn = $this->conn_db();
		$conn->set_charset('utf8mb4');
		if(!empty($name)){
			$query = $conn->prepare("SELECT `id`, `price` FROM Height WHERE `name` Like '".$name."'");
		}
		else {
			$query = $conn->prepare("SELECT * FROM Height");
		}		
		$query->execute();			
		$result = $query->get_result();		
		return $result;	
	}

	public function get_type($name = ""){
		$conn = $this->conn_db();
		$conn->set_charset('utf8mb4');
		if(!empty($name)){
			$query = $conn->prepare("SELECT `id`, `price` FROM `type` WHERE `name` Like '".$name."'");
		}
		else {
			$query = $conn->prepare("SELECT * FROM `type`");
		}		
		$query->execute();			
		$result = $query->get_result();		
		return $result;	
	}

	public function get_accessories($name = ""){
		$conn = $this->conn_db();
		$conn->set_charset('utf8mb4');
		if(!empty($name)){
			$query = $conn->prepare("SELECT `id`, `price` FROM accessories WHERE `name` Like '".$name."'");
		}
		else {
			$query = $conn->prepare("SELECT * FROM accessories");
		}	
		$query->execute();			
		$result = $query->get_result();		
		return $result;	
	}

	public function insert_variation($ColorPainting_id = 0, $ColorSkin_id = 0, $ColorKnob_id = 0, $Width_id = 0, $Height_id = 0, $type_id=  0, $accessories_ids= "", $total_price= 0, $pdf_href= ""){
		$conn = $this->conn_db();
		$conn->set_charset('utf8mb4');
		$query = $conn->prepare("INSERT INTO variationTable (`ColorPainting_id`, `ColorSkin_id`, `ColorKnob_id`, `Width_id`, `Height_id`, `type_id`, `accessories_ids`, `total_price`, `pdf_href`) VALUES ('.$ColorPainting_id.','.$ColorSkin_id.','.$ColorKnob_id.','.$Width_id.','.$Height_id.','.$type_id.','".$accessories_ids."','".intval($total_price)."','".$pdf_href."')");
		if(!$query){
			echo "Prepare failed: (". $conn->errno.") ".$conn->error."<br>";
		}
		try {
			$query->execute();
			return "Inserted";		
			
		} catch(PDOException $e) {
			return $conn->errno;
		}
	}
}
?>