<?php
require __DIR__ . '/vendor/autoload.php';
use Longman\TelegramBot\Request;
// include 'longman\telegram-bot\structure.sql';

$bot_api_key  = 'your_bot_password';
$bot_username = 'your_bot_name';


// $mysql_credentials = [
//    'host'     => '127.0.0.1',
//    'port'     => 3306, // optional
//    'user'     => '',
//    'password' => '',
//    'database' => '',
// ];
while(true){
    try {
        // Create Telegram API object
        $telegram = new Longman\TelegramBot\Telegram($bot_api_key, $bot_username);
        $telegram->useGetUpdatesWithoutDatabase();

        // Enable MySQL
        // $telegram->enableMySql($mysql_credentials);

        // Handle telegram getUpdates request
        $server_response = $telegram->handleGetUpdates();

        if($server_response->isOk()){
            $result = $server_response->getResult();


            foreach($result as $message_item){
                $message = $message_item->getMessage();

                $message_chat_id = $message->getFrom()->getId();
                $message_text = $message->getText();

                $result = Request::sendMessage([
                    'chat_id' => $message_chat_id,
                    'text' => 'Ответ: ' . $message_text
                ]);

                print_r([$message_chat_id, $message_text]);
            }
            
        }
    } catch (Longman\TelegramBot\Exception\TelegramException $e) {
        // log telegram errors
        echo $e->getMessage();
    }
    sleep(1);
}