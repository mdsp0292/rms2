<?php

namespace App\Console\Commands;

use App\Models\Account;
use App\Models\Opportunity;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class HelloCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hello';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'A Hello Command';

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
        $opportunity = Opportunity::query()->where('id',3)->first();
        echo $opportunity->account->id.PHP_EOL;
        echo $opportunity->account->users->email.PHP_EOL;
    }
}
