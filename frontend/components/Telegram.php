<?php

namespace frontend\components;

use TelegramBot\Api\BotApi;
use TelegramBot\Api\Exception;

class Telegram
{
    /**
     * @param string $message
     * @param integer $chatId
     */
    public static function send($message, $chatId)
    {
        $bot = new BotApi(\Yii::$app->params['botApiToken']);
        try {
            $bot->sendMessage($chatId, $message);
        } catch (Exception $e) {
            \Yii::info($e->getMessage());
        }
    }
}