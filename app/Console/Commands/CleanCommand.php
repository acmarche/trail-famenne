<?php

namespace App\Console\Commands;

use App\Models\Registration;
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
    protected $description = 'Remove empty registrations';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        foreach (Registration::query()->whereDoesntHave('walkers')->get() as $registration) {
            $this->info('Delete registration '.$registration->email);
            $registration->delete();
        }

        return SfCommand::SUCCESS;
    }
}
