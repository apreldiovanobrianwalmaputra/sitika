<?php

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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();

            $table->string('code')->unique();

            $table->foreignId('reporter_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('category_id')
                ->constrained('categories');

            $table->string('title');
            $table->string('location');
            $table->text('description');

            $table->enum('urgency', [
                'RENDAH',
                'SEDANG',
                'TINGGI'
            ]);

            $table->enum('status', [
                'OPEN',
                'IN_PROGRESS',
                'RESOLVED'
            ])->default('OPEN');

            $table->text('resolution_note')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
