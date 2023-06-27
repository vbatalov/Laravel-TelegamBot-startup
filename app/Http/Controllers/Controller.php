<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\InlineKeyboard;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use TelegramBot\Api\BotApi;
use TelegramBot\Api\Client;
use TelegramBot\Api\Exception;
use Throwable;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    use InlineKeyboard;

    /**
     * @var Client
     */
    protected Client $client;
    /**
     * @var BotApi
     */
    protected BotApi $bot;

    /** @var User  */
    protected User $user;

    protected string $cid;
    protected mixed $username;
    protected mixed $firstname;
    protected mixed $lastname;
    protected mixed $text;

    public function __construct()
    {
        $token = env("BOT_API");
        $this->bot = new BotApi("$token", null);
        $this->client = new Client($token, null);

        $this->user = new User();
    }

    /** Register Webhook */
    public function register()
    {
        $page_url1 = env("BOT_URL");
        $page_url2 = "bot";
        $page_url = $page_url1 . $page_url2;

        try {
            if ($this->bot->deleteWebhook()) {
                print_r("Webhook deleted");
            }
            if ($this->bot->setWebhook($page_url)) {
                print_r("\nWebhook set $page_url");
            }
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
    }

    public function index()
    {
        try {
            $commands = new Command();
            $commands->list();

//            $callback_command = new Callback();
//            $callback_command->callback();
//
//            $messages = new Message();
//            $messages->messagesList();

        } catch (Throwable $e) {
            $message = $e->getMessage();
            $line = $e->getLine();
            $file = $e->getFile();
            \Log::error("$message as line $line in file $file");
        }
    }
}
