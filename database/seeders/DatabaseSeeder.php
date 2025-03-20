<?php

namespace Database\Seeders;

use App\Constant\TshirtEnum;
use App\Models\Role;
use App\Models\User;
use App\Models\Walker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    protected static ?string $password;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $adminRole = Role::factory()->create([
            'name' => Role::ROLE_ADMIN,
        ]);
        $runnerRole = Role::factory()->create([
            'name' => Role::ROLE_WALKER,
        ]);
        $user = User::factory()
            ->hasAttached($adminRole)
            ->hasAttached($runnerRole)
            ->create([
                'first_name' => 'Jf',
                'last_name' => 'Sénéchal',
                'email' => 'jf@marche.be',
                'password' => static::$password ??= Hash::make('marge'),
            ]);

        User::factory(4)->hasAttached($adminRole)->create();

        Walker::factory(10)->create([
            'tshirt_size' => $this->randomShirt(),
        ]);

    }

    private function randomShirt(): TshirtEnum
    {
        return TshirtEnum::from(array_rand(array_flip(array_map(fn($case) => $case->value, TshirtEnum::cases()))));
    }
}
