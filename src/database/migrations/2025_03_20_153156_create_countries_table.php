<?php

use App\Models\Country;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('countries', static function (Blueprint $table) {
            $table->id();
            $table->string('locale_key')->unique();
            $table->string('code')->unique();
            $table->timestamps();
        });

        Country::create(['locale_key' => 'country.russia', 'code' => 'RU']);
        Country::create(['locale_key' => 'country.usa', 'code' => 'US']);
        Country::create(['locale_key' => 'country.ukraine', 'code' => 'UA']);
        Country::create(['locale_key' => 'country.belarus', 'code' => 'BY']);
    }

    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
