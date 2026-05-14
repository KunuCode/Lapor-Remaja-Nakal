<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('camat_photos', function (Blueprint $table) {
            $table->id();
            $table->string('image_path');
            $table->string('name');
            $table->string('position');
            $table->text('bio')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('camat_photos');
    }
};
