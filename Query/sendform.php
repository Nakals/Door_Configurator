<?php
require_once("../etc/config.php");
require_once(APP_ROOT."/Class/queryAPI.php");
require_once(APP_ROOT."/Class/telegram.php");
// require_once(APP_ROOT."/Class/createPDF.php");
$query = new Query();
$telegram = new Telegram();
// $PDF = new PDF();
$values = array();
parse_str($_POST['form'], $values);

$form_color_painting = $values["form_color_painting"];
$form_color_skin = $values["form_color_skin"];
$form_color_knob = $values["form_color_knob"];
$form_options_width = $values["form_options_width"];
$form_options_height = $values["form_options_height"];
$form_options_type = $values["form_options_type"];
$form_accessories = $values["form_accessories"];
$pdf = $_POST["pdf"];

base64_decode($pdf);

$date = date("Y-m-d(H:i:s)");
$path_pdf = "../etc/files/door_".$date.".pdf";

file_put_contents($path_pdf,base64_decode($pdf));

// $form_color_painting = 'синий';
// $form_color_skin = 'желтый';
// $form_color_knob = 'зеленый';
// $form_options_width = '940 мм';
// $form_options_height = '2220 мм';
// $form_options_type = 'Правое';
// $form_accessories = 'Подсветка ручек, Регулируемые петли, Стучало "Лев"';
$array_form_accessories = explode(", ", $form_accessories);

if($form_options_type == 'Левое'){
    $justify = 'left';
    $justify_inside = 'right';
}
else{
    $justify = 'right';
    $justify_inside = 'left';
}

$totalPrice = 0;
$paintingPrice = 0;
$skinPrice = 0;
$knobPrice = 0;
$widthPrice = 0;
$heightPrice = 0;
$typePrice = 0;
$accessoriesPrice = 0;

$colorPainting = "";
$colorSkin = "";
$colorKnob = "";

$paintingId = 0;
$skinId = 0;
$knobId = 0;
$widthId = 0;
$heightId = 0;
$typeId = 0;
$accessoriesIds = "";

$pdf_href = "";

$result_painting=$query->get_ColorPainting($form_color_painting);
if($result_painting->num_rows > 0){   
    while ($item = $result_painting->fetch_assoc()) {
        $paintingPrice = $item['price'];
        $colorPainting = $item['code'];
        $paintingId = $item['id'];
    }
}

$result_skin=$query->get_ColorSkin($form_color_skin);
if($result_skin->num_rows > 0){   
    while ($item = $result_skin->fetch_assoc()) {
        $skinPrice = $item['price'];
        $colorSkin = $item['code'];
        $skinId = $item['id'];
    }
}

$result_knob=$query->get_ColorKnob($form_color_knob);
if($result_knob->num_rows > 0){   
    while ($item = $result_knob->fetch_assoc()) {
        $knobPrice = $item['price'];
        $colorKnob = $item['code'];
        $knobId = $item['id'];
    }
}

$result_width=$query->get_Width($form_options_width);
if($result_width->num_rows > 0){   
    while ($item = $result_width->fetch_assoc()) {
        $widthPrice = $item['price'];
        $widthId = $item['id'];
    }
}

$result_height=$query->get_Height($form_options_height);
if($result_height->num_rows > 0){   
    while ($item = $result_height->fetch_assoc()) {
        $heightPrice = $item['price'];
        $heightId = $item['id'];
    }
}

$result_type=$query->get_type($form_options_type);
if($result_type->num_rows > 0){   
    while ($item = $result_type->fetch_assoc()) {
        $typePrice = $item['price'];
        $typeId = $item['id'];
    }
}

$arrayAccessories = array();
$i = 0;
foreach($array_form_accessories as $value){
    $result_accessories=$query->get_accessories($value);
    if($result_accessories->num_rows > 0){
        while ($item = $result_accessories->fetch_assoc()) {
            if($i>0) $accessoriesIds .= ", ";
            $accessoriesPrice = $accessoriesPrice + intval($item['price']);
            $accessoriesIds .= $item['id'];
            $i++;
        }
    }
}
//echo a .'+'.$skinPrice .'+'. $knobPrice .'+'. $widthPrice .'+'. $heightPrice .'+'. $typePrice .'+'. $accessoriesPrice .'<br>';
echo $totalPrice = $paintingPrice + $skinPrice + $knobPrice + $widthPrice + $heightPrice + $typePrice + $accessoriesPrice;

$telegram->send_to_telegram($path_pdf);

// echo $PDF->createPDF($colorPainting, $colorSkin, $colorKnob, $justify, $justify_inside, $form_color_painting, $form_color_skin, $form_color_knob, $form_options_width, $form_options_height, $form_options_type, $form_accessories, $totalPrice);
//echo $totalPrice;

$query->insert_variation($paintingId, $skinId, $knobId, $widthId, $heightId, $typeId, $accessoriesIds, $totalPrice, $path_pdf);

?>