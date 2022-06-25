<?php

namespace App\Console\Commands;

use App\Models\Guardian;
use Illuminate\Console\Command;

class SetDefaultPasswordsForGuardians extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'set-default-password-for-guardians';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'As the signature implies';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $guardians = Guardian::all();

        $guardians->map(function ($guardian) {
            $guardian->password = bcrypt('password');
            $guardian->save();
        });

        return 0;
    }
}
