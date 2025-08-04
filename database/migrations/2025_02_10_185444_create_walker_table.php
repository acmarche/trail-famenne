<?php

use App\Constant\TshirtEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('walkers', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->integer('registration_id')->unique()->nullable();
            $table->string('email')->nullable();
            $table->string('last_name');
            $table->string('first_name');
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('club_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('number')->nullable();
            $table->integer('tshirt_number')->unique()->nullable();
            $table->string('tshirt_sex')->nullable();
            $table->string('tshirt_size')->default(TshirtEnum::NO->value)->nullable();
            $table->boolean('display_accepted')->default(false);
            $table->boolean('gdpr_accepted')->default(false);
            $table->boolean('newsletter_accepted')->default(false);
            $table->boolean('regulation_accepted')->default(false);
            $table->timestamp('registration_date')->useCurrent();
            $table->timestamp('payment_date')->default(null)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('walkers');
    }
};
