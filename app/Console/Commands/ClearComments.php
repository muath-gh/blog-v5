<?php

namespace App\Console\Commands;

use App\Models\Comment;
use Illuminate\Console\Command;

class ClearComments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:clear-comments';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Comment::truncate();
      
        $this->info('All comments have been deleted successfully');
    }
}
