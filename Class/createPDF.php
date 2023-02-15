<?php
require_once(APP_ROOT."/etc/dompdf/autoload.inc.php");
use Dompdf\Dompdf;
use Dompdf\Options;

class PDF{
    public function createPDF($configuration){

        $options = new Options();
        $options->set('defaultFont', 'DejaVu Sans');
        $dompdf = new Dompdf($options);
        
        $chars = ['[',']'];
        $arrayAccessories = explode(",", str_replace($chars, '', $configuration['accessories_list']));
        
        $i = 0;
        foreach ($arrayAccessories as &$value) {
            if($i>0) $accessories_name.=", ";
	        $accessories_name .= explode("=>", $value)[1];
	        $i++;
	    }
	    
        $type = pathinfo($configuration['image_href'], PATHINFO_EXTENSION);
        $data = file_get_contents($configuration['image_href']);
        $src_image = 'data:image/' . $type . ';base64,' . base64_encode($data);

        $html = "
            <style>
                * {
                    box-sizing: border-box;
                }
            
                body {
                    color: #384047;
                    font-family: 'DejaVu Sans', sans-serif;
                }
            
                table {
                    max-width: 960px;
                    width: 560px;
                    margin: 10px auto;
                }
                
                .image_configurator{
                    width: 560px;
                }
            
                thead th {
                    font-weight: 400;
                    background: #8a97a0;
                    color: #fff;
                }
            
                tr {
                    background: #f4f7f8;
                    border-bottom: 1px solid #fff;
                    margin-bottom: 5px;
                }
            
                tr:nth-child(even) {
                    background: #e8eeef;
                }
            
                th,
                td {
                    text-align: left;
                    padding: 20px;
                    font-weight: 300;
                    font-size: 12px;
                }
            
                .nobackground {
                    background: transparent !important;
                }
            
                .parametrs_title td, caption {
                    font-size: 22px;
                    font-weight: 600;
                }
            
                .totalPrice td {
                    font-size: 18px;
                    font-weight: 600;
                }
            </style>
            <table>
                <caption>Конфигуратор входной двери</caption>
                <tbody>
                    <tr class='nobackground'>
                        <td colspan='2'>
                            <img class='image_configurator' src='".$src_image."' alt=''>
                        </td>
                    </tr>
                    <tr class='nobackground parametrs_title'>
                        <td colspan='2' class='title'>Параметры</td>
                    </tr>
                    <tr>
                        <td>Цвет покраски:</td>
                        <td>".$configuration['name_Painting']."</td>
                    </tr>
                    <tr>
                        <td>Цвет пленки:</td>
                        <td>".$configuration['name_Skin']."</td>
                    </tr>
                    <tr>
                        <td>Цвет ручки:</td>
                        <td>".$configuration['name_Knob']."</td>
                    </tr>
                    <tr>
                        <td>Ширина:</td>
                        <td>".$configuration['name_Width']."</td>
                    </tr>
                    <tr>
                        <td>Высота:</td>
                        <td>".$configuration['name_Height']."</td>
                    </tr>
                    <tr>
                        <td>Открывание:</td>
                        <td>".$configuration['name_Type']."</td>
                    </tr>
                    <tr>
                        <td>Аксессуары:</td>
                        <td>".$accessories_name."</td>
                    </tr>
                    <tr class='totalPrice'>
                        <td>Итоговая стоимость:</td>
                        <td>".$configuration['totalPrice']."</td>
                    </tr>
                </tbody>
            </table>
        ";
        $date = date("Y-m-d(H:i:s)");
        $path_pdf = "../etc/files/door_".$date.".pdf";

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        // return base64_encode($dompdf->output());
        $output = $dompdf->output();
        file_put_contents($path_pdf, $output);
        return $path_pdf;
    }
}
?>