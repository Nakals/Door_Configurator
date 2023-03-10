<?php

class Telegram{
    public function send_to_telegram($path_pdf){

        $apiToken = "telegram_token";
        $chatId = "telegram_chatid";

        $postFields = array(
            "chat_id" => $chatId,
            "document" => new CURLFile($path_pdf)
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type:multipart/form-data"
        ));
        curl_setopt($ch, CURLOPT_URL, "https://api.telegram.org/bot" . $apiToken . "/sendDocument");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        $output = curl_exec($ch);
        curl_close($ch);
        
        unlink($path_pdf);
    }
}
?>