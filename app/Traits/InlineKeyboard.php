<?php
namespace App\Traits;


use JetBrains\PhpStorm\Pure;
use TelegramBot\Api\Types\Inline\InlineKeyboardMarkup;

trait InlineKeyboard {


    #[Pure] public function start(): InlineKeyboardMarkup
    {
        return new InlineKeyboardMarkup (
            [
                [
                    ['callback_data' => 'callback_name', 'text' => 'I want see more'],
                ],
            ]
        );
    }
}