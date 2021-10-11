<?php

namespace App\Console\Commands;

use App\Models\ApiZapito;
use App\Models\Recipient;
use Illuminate\Console\Command;
use Vedmant\FeedReader\Facades\FeedReader;

class ProcessG1RSSFeed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'process:rss';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Processa o feed do G1 e envia mensagens pelo whataspp para os usuários ativos';

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
     * @return int
     */
    public function handle()
    {

        $news = array_slice(FeedReader::read('https://g1.globo.com/rss/g1/')->get_items(), 0, 2);
        $newsMessages = [];

        $activeRecipients = Recipient::where('active', '=', true)->get();

        foreach($news as $index => $article){

            array_push($newsMessages, "*".$article->get_title()."*\n".$article->get_link());

            foreach($activeRecipients as $recipient){

                var_dump("Entrou");
                ApiZapito::sendMessage($recipient->number, "Olá ". $recipient->name . ", você pode se interessar nisso: ". $newsMessages[$index]);
            }
        }

        return 0;
    }
}
