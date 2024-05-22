<?php

use App\Models\Conference\Conference;
use App\Models\Organization\Organization;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('organization_conference', function (Blueprint $table) {
            $table->foreignIdFor(Organization::class);
            $table->foreignIdFor(Conference::class);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organization_conference');
    }
};
