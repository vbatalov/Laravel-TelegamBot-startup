<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use TelegramBot\Api\InvalidJsonException;

class Command extends Controller
{

    public function list()
    {
        global $bot;
        global $client;

        /**
         * Команда /start
         */

        $this->client->command('start', function ($message) use ($bot) {
            /**
             * Сведения о полученном сообщении
             */
            $this->cid = $message->getChat()->getId();
            $this->username = $message->getChat()->getUsername() ?? null;
            $this->firstname = $message->getChat()->getFirstname() ?? null;
            $this->lastname = $message->getChat()->getLastname() ?? null;
            $this->text = $message->getText() ?? null;

            /**
             * If user not exists in DB
             * then save new user
             */
            if (!$this->user->isExists($this->cid)) {
                $this->user->store($this->cid);
            }

            $keyboard = $this->start();
            $this->bot->sendMessage("$this->cid", "Hello! It's <b>my first</b> bot", "HTML", false, null, $keyboard, false);

        });

        try {
            if (isset($this->client)) {
                $this->client->run();
            }
        } catch (InvalidJsonException $e) {
            $message = $e->getMessage();
            $line = $e->getLine();
            $file = $e->getFile();
            \Log::error("$message as line $line in file $file");
        }
    }

}
