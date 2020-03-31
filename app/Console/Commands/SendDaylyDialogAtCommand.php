<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\URL;

class SendDaylyDialogAtCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:senddaylydialogat {chat_id} {lesson_id} {message_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // {chat_id} {lesson_id} {message_id}
        $chat_id = $this->argument('chat_id');
        $lesson_id = $this->argument('lesson_id');
        $message_id = $this->argument('message_id');
        var_dump(URL::to('/'));die();

    }
}
