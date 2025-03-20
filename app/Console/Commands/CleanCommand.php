<?php

namespace App\Console\Commands;


use App\Models\Walker;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as SfCommand;

class CleanCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'trail:clean';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove empty walker';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        foreach (Walker::query()->whereDoesntHave('walkers')->get() as $walker) {
            $this->info('Delete walker '.$walker->email);
            $walker->delete();
        }

        return SfCommand::SUCCESS;
    }
}
