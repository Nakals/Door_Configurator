<?php
require_once("etc/config.php");
require_once(APP_ROOT."/Class/queryAPI.php");
$query = new Query();
?>
<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width" />
    <title>Конфигуратор входной двери</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css" />
</head>

<body>
    <section id="configurator">
        <div class="container">
            <div class="configurator_wrapper">
                <h1 class="title">Конфигуратор входной двери</h1>
                <div class="configurator_construct">
                    <div class="configurator_construct_wrapper">
                        <div class="configurator_construct_item">
                            <div class="door_wrapper">
                                <div class="door_color color_painting">
                                    <div class="door_skin color_skin">
                                        <div class="door_knob color_knob"></div>
                                    </div>
                                </div>
                                <div class="door_title">
                                    <span>вид снаружи</span>
                                </div>
                            </div>
                        </div>
                        <div class="configurator_construct_item">
                            <div class="door_wrapper">
                                <div class="door_color color_painting">
                                    <div class="door_skin color_skin inside">
                                        <div class="door_knob color_knob"></div>
                                    </div>
                                </div>
                                <div class="door_title">
                                    <span>вид изнутри</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="configurator_construct_desc">
                        <h2>Параметры</h2>
                        <div class="options_wrapper">
                            <div class="options_item">
                                <div class="options_title">
                                    <span>Цвет покраски</span>
                                </div>
                                <div class="options_value">
                                    <div class="options_btn">Выбор</div>
                                    <div class="options_popup color_painting">
                                        <div class="overlay"></div>
                                        <div class="options_popup_wrapper">
                                            <div class="cross_popup">X</div>
                                        <?php
                                            $result=$query->get_ColorPainting();
                                            if($result->num_rows > 0){   
                                                while ($item = $result->fetch_assoc()) {
                                                    ?>
                                                    <label>
                                                        <input type="radio" name="color_painting" id="color_painting_<?=$item["id"]?>" attr_color="<?=$item["code"]?>" attr_id="<?=$item["id"]?>" attr_price="<?=$item["price"]?>" />
                                                        <span><div class="squareColor" style="background: <?=$item["code"]?>;"></div><?=$item["name"]?></span>
                                                    </label>
                                                    <?
                                                }
                                            }
                                        ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="options_item">
                                <div class="options_title">
                                    <span>Цвет пленки</span>
                                </div>
                                <div class="options_value">
                                    <div class="options_btn">Выбор</div>
                                    <div class="options_popup color_skin">
                                        <div class="overlay"></div>
                                        <div class="options_popup_wrapper">
                                            <div class="cross_popup">X</div>
                                        <?php
                                            $result=$query->get_ColorSkin();
                                            if($result->num_rows > 0){   
                                                while ($item = $result->fetch_assoc()) {
                                                    ?>
                                                    <label>
                                                        <input type="radio" name="color_skin" id="color_skin_<?=$item["id"]?>" attr_color="<?=$item["code"]?>" attr_id="<?=$item["id"]?>" attr_price="<?=$item["price"]?>" />
                                                        <span><div class="squareColor" style="background: <?=$item["code"]?>;"></div><?=$item["name"]?></span>
                                                    </label>
                                                    <?
                                                }
                                            }
                                        ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="options_item">
                                <div class="options_title">
                                    <span>Цвет ручки</span>
                                </div>
                                <div class="options_value">
                                    <div class="options_btn">Выбор</div>
                                    <div class="options_popup color_knob">
                                        <div class="overlay"></div>
                                        <div class="options_popup_wrapper">
                                            <div class="cross_popup">X</div>
                                        <?php
                                            $result=$query->get_ColorKnob();
                                            if($result->num_rows > 0){   
                                                while ($item = $result->fetch_assoc()) {
                                                    ?>
                                                    <label>
                                                        
                                                        <input type="radio" name="color_knob" id="color_knob_<?=$item["id"]?>" attr_color="<?=$item["code"]?>" attr_id="<?=$item["id"]?>" attr_price="<?=$item["price"]?>" />
                                                        <span><div class="squareColor" style="background: <?=$item["code"]?>;"></div><?=$item["name"]?></span>
                                                    </label>
                                                    <?
                                                }
                                            }
                                        ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="options_item">
                                <div class="options_title">
                                    <span>Ширина</span>
                                </div>
                                <div class="options_select options_width" attr_name="options_width">
                                    <div class="options_btn">Выбор</div>
                                    <div class="options_list">
                                        <ul class="list">
                                        <?php
                                            $result=$query->get_Width();
                                            if($result->num_rows > 0){   
                                                while ($item = $result->fetch_assoc()) {
                                                    ?>
                                                    <li>
                                                        <span attr_id="<?=$item["id"]?>" attr_price="<?=$item["price"]?>"><?=$item["name"]?></span>
                                                    </li>
                                                    <? 
                                                }
                                            }
                                        ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="options_item">
                                <div class="options_title">
                                    <span>Высота</span>
                                </div>
                                <div class="options_select options_height" attr_name="options_height">
                                    <div class="options_btn">Выбор</div>
                                    <div class="options_list">
                                        <ul class="list">
                                        <?php
                                            $result=$query->get_Height();
                                            if($result->num_rows > 0){   
                                                while ($item = $result->fetch_assoc()) {
                                                    ?>
                                                    <li>
                                                        <span attr_id="<?=$item["id"]?>" attr_price="<?=$item["price"]?>"><?=$item["name"]?></span>
                                                    </li>
                                                    <? 
                                                }
                                            }
                                        ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="options_item">
                                <div class="options_title">
                                    <span>Открывание</span>
                                </div>
                                <div class="options_select options_type" attr_name="options_type">
                                    <div class="options_btn">Выбор</div>
                                    <div class="options_list">
                                        <ul class="list">
                                        <?php
                                            $result=$query->get_type();
                                            if($result->num_rows > 0){   
                                                while ($item = $result->fetch_assoc()) {
                                                    ?>
                                                    <li>
                                                        <span attr_id="<?=$item["id"]?>" attr_price="<?=$item["price"]?>"><?=$item["name"]?></span>
                                                    </li>
                                                    <? 
                                                }
                                            }
                                        ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="options_item">
                                <div class="options_title">
                                    <span>Аксессуары</span>
                                </div>
                                <div class="options_value">
                                    <div class="options_btn">Выбор</div>
                                    <div class="options_popup accessories">
                                        <div class="overlay"></div>
                                        <div class="options_popup_wrapper options_popup_accessories">
                                            <div class="cross_popup">X</div>
                                        <?php
                                            $result=$query->get_accessories();
                                            if($result->num_rows > 0){   
                                                while ($item = $result->fetch_assoc()) {
                                                    ?>
                                                    <label>
                                                        <input type="checkbox" name="accessories" id="accessories_<?=$item["id"]?>" attr_id="<?=$item["id"]?>" attr_price="<?=$item["price"]?>" />
                                                        <span><?=$item["name"]?></span>
                                                    </label>
                                                    <?
                                                }
                                            }
                                        ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="total_price" style="display: none;">
                            <div class="total_price_title">Итоговая стоимость:</div>
                            <div class="total_price_value"></div>
                        </div>
                        <form method="POST" class="sendForm" style="display: none;" data-html2canvas-ignore="true">
                            <input type="text" name="form_color_painting" value="" attr_price="" readonly required hidden>
                            <input type="text" name="form_color_skin" value="" attr_price="" readonly required hidden>
                            <input type="text" name="form_color_knob" value="" attr_price="" readonly required hidden>
                            <input type="text" name="form_options_width" value="" attr_price="" readonly required hidden>
                            <input type="text" name="form_options_height" value="" attr_price="" readonly required hidden>
                            <input type="text" name="form_options_type" value="" attr_price="" readonly required hidden>
                            <input type="text" name="form_accessories" value="" attr_price="" readonly required hidden>
                            <button id="sendForm_btn">Отправить</button>
                            <span class="send_info"></span>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script   src="https://code.jquery.com/jquery-3.6.1.min.js"   integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ="   crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js" integrity="sha512-BNaRQnYJYiPSqHHDb58B0yaPfCu+Wgds8Gp/gU33kqBtgNS4tSPHuGibyoeqMV/TJlSKda6FXzoEyYGjTe+vXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="js/script.js"></script>
    <script src="js/form.js"></script>
</body>

</html>