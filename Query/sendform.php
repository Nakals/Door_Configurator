<?php
require_once("../etc/config.php");
require_once(APP_ROOT."/Class/queryAPI.php");
require_once(APP_ROOT."/Class/telegram.php");
require_once(APP_ROOT."/Class/createPDF.php");
$query = new Query();
$telegram = new Telegram();
$PDF = new PDF();

$values = array();
parse_str($_POST['form'], $values);

$paintingId = $values["form_color_painting"];
$skinId = $values["form_color_skin"];
$knobId = $values["form_color_knob"];
$widthId = $values["form_options_width"];
$heightId = $values["form_options_height"];
$typeId = $values["form_options_type"];
$accessoriesIds = $values["form_accessories"];

$arrayAccessories = explode(", ", $accessoriesIds);

$image = $_POST["image"];
$image_href = "";

$pdf_src = "";

$get_configuration = $query->get_configuration_db($paintingId, $skinId, $knobId, $widthId, $heightId, $typeId, $arrayAccessories);
// проверка на существование конфигурации в бд, если такая уже есть, то получаем все данные конфигурации, создаем PDF и отправляем в телеграм
if($get_configuration->num_rows > 0){
    while ($item = $get_configuration->fetch_assoc()) {
        $pdf_src = $PDF->createPDF($item);
        $telegram->send_to_telegram($pdf_src);
    }
}
// если же конфигурация абсолютно новая, записываем ее в бд, после чего получаем все данные для этой конфигурации, формируем PDF и отправляем в телеграм
else{
    
    $data = explode( ',', $image );

    $date = date("Y-m-d(H:i:s)");
    $image_href = "../etc/files/door_".$date.".png";
    file_put_contents($image_href,base64_decode($data[1]));
    $insert = $query->insert_variation($paintingId, $skinId, $knobId, $widthId, $heightId, $typeId, $arrayAccessories, $image_href);
    
    if($insert->num_rows > 0){
        while ($item = $insert->fetch_assoc()) {
            $pdf_src = $PDF->createPDF($item);
            $telegram->send_to_telegram($pdf_src);
        }
    }
    
}
?>