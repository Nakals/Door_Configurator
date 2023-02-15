<?php 
require_once(APP_ROOT."/Class/database.php");
class Query extends Database {

	public function get_ColorPainting(){
		$conn = $this->conn_db();
		$conn->set_charset('utf8mb4');
		$query = $conn->prepare("SELECT cp.id, cp.price, c.code, c.name FROM color as c LEFT JOIN ColorPainting as cp ON c.id = cp.color_id");
		$query->execute();			
		$result = $query->get_result();		
		return $result;	
	}

	public function get_ColorSkin(){
		$conn = $this->conn_db();
		$conn->set_charset('utf8mb4');
		$query = $conn->prepare("SELECT cs.id, cs.price, c.code, c.name FROM color as c LEFT JOIN ColorSkin as cs ON c.id = cs.color_id");
		$query->execute();			
		$result = $query->get_result();		
		return $result;	
	}

	public function get_ColorKnob(){
		$conn = $this->conn_db();
		$conn->set_charset('utf8mb4');
		$query = $conn->prepare("SELECT ck.id, ck.price, c.code, c.name FROM color as c LEFT JOIN ColorKnob as ck ON c.id = ck.color_id");
		$query->execute();			
		$result = $query->get_result();		
		return $result;	
	}

	public function get_Width(){
		$conn = $this->conn_db();
		$conn->set_charset('utf8mb4');
		$query = $conn->prepare("SELECT * FROM Width");
		$query->execute();			
		$result = $query->get_result();		
		return $result;	
	}

	public function get_Height(){
		$conn = $this->conn_db();
		$conn->set_charset('utf8mb4');
		$query = $conn->prepare("SELECT * FROM Height");
		$query->execute();			
		$result = $query->get_result();		
		return $result;	
	}

	public function get_type(){
		$conn = $this->conn_db();
		$conn->set_charset('utf8mb4');
		$query = $conn->prepare("SELECT * FROM `type`");	
		$query->execute();			
		$result = $query->get_result();		
		return $result;	
	}

	public function get_accessories(){
		$conn = $this->conn_db();
		$conn->set_charset('utf8mb4');
		$query = $conn->prepare("SELECT * FROM accessories");
		$query->execute();			
		$result = $query->get_result();		
		return $result;	
	}

	public function insert_variation($ColorPainting_id = 0, $ColorSkin_id = 0, $ColorKnob_id = 0, $Width_id = 0, $Height_id = 0, $type_id=  0, $arrayAccessories= "", $image_href= ""){
		$conn = $this->conn_db();
		$conn->set_charset('utf8mb4');
		$query = $conn->prepare("INSERT INTO variationTable (`ColorPainting_id`, `ColorSkin_id`, `ColorKnob_id`, `Width_id`, `Height_id`, `type_id`, `image_href`) VALUES ('.$ColorPainting_id.','.$ColorSkin_id.','.$ColorKnob_id.','.$Width_id.','.$Height_id.','.$type_id.','".$image_href."')");
		
		if(!$query){
			echo "Prepare failed: (". $conn->errno.") ".$conn->error."<br>";
		}
		try {
			$query->execute();
		    $id_variation = $query->insert_id;
			
		} catch(PDOException $e) {
			return $conn->errno;
		}
// 		записываем отдельно в таблицу id выбранных аксессуаров, связанных по id с конфигурацией
		foreach ($arrayAccessories as &$value) {
    		$query = $conn->prepare("INSERT INTO variation_to_accessories (`id_variation`, `id_accessories`) VALUES ('.$id_variation.','.$value.')");
    		if(!$query){
    			echo "Prepare failed: (". $conn->errno.") ".$conn->error."<br>";
    		}
    		try {
    			$query->execute();		
    			
    		} catch(PDOException $e) {
    			return $conn->errno;
    		}
		}
// 		получаем все данные для конфигурации
		return $this->get_configuration_db($ColorPainting_id, $ColorSkin_id, $ColorKnob_id, $Width_id, $Height_id, $type_id, $arrayAccessories);
	}
	
// 	получение конфигурации вх. двери
	public function get_configuration_db($ColorPainting_id = 0, $ColorSkin_id = 0, $ColorKnob_id = 0, $Width_id = 0, $Height_id = 0, $type_id=  0, $arrayAccessories = ""){
	    
	    $i = 0;
	    $strAccessories = "";
	    foreach ($arrayAccessories as &$value) {
	        if($i > 0)  $strAccessories.=",";
	        $strAccessories.=$value;
	        $i++;
	    }
	    
	    $conn = $this->conn_db();
		$conn->set_charset('utf8mb4');
		$query = $conn->prepare("SELECT vt.image_href, cp.price as price_Painting, c1.name as name_Painting, cs.price as price_Skin, c2.name as name_Skin, ck.price as price_Knob, c3.name as name_Knob, w.price as price_Width, w.name as name_Width, h.price as price_Height, h.name as name_Height, t.price as price_Type, t.name as name_Type, va.accessories_list, va.accessoriesId_list, (cp.price+cs.price+ck.price+w.price+h.price+t.price+accessories_price) as totalPrice FROM variationTable as vt LEFT JOIN ColorPainting as cp ON cp.id = vt.ColorPainting_id LEFT JOIN color as c1 ON c1.id = cp.color_id LEFT JOIN ColorSkin as cs ON cs.id = vt.ColorSkin_id LEFT JOIN color as c2 ON c2.id = cs.color_id LEFT JOIN ColorKnob as ck ON ck.id = vt.ColorKnob_id LEFT JOIN color as c3 ON c3.id = ck.color_id LEFT JOIN Width as w ON vt.Width_id = w.id LEFT JOIN Height as h ON h.id = vt.Height_id LEFT JOIN type as t ON t.id = vt.type_id Left JOIN(SELECT variation_to_accessories.id_variation as id, SUM(accessories.price) as accessories_price, group_concat('[',accessories.price, '=>', accessories.name,']' ORDER BY variation_to_accessories.id_accessories) as accessories_list, group_concat(accessories.id ORDER BY variation_to_accessories.id_accessories) as accessoriesId_list FROM accessories Left JOIN variation_to_accessories on variation_to_accessories.id_accessories = accessories.id GROUP BY variation_to_accessories.id_variation) va ON va.id = vt.id WHERE (vt.ColorPainting_id = '".intval($ColorPainting_id)."' AND vt.ColorSkin_id = '".intval($ColorSkin_id)."' AND vt.ColorKnob_id = '".intval($ColorKnob_id)."' AND vt.Width_id = '".intval($Width_id)."' AND vt.Height_id = '".intval($Height_id)."' AND vt.type_id = '".intval($type_id)."' AND va.accessoriesId_list = '".$strAccessories."')");
		$query->execute();			
		$result = $query->get_result();		
		return $result;
	}
}
?>