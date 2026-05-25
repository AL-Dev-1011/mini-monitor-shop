<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('products', function (Blueprint $table) {

      $table->id();

      $table->string('image')->nullable();

      $table->string('brand');

      $table->string('name');

      $table->string('application')->nullable();

      $table->string('display_size')->nullable();

      $table->string('resolution')->nullable();

      $table->string('refresh_rate')->nullable();

      $table->string('panel_type')->nullable();

      $table->string('aspect_ratio')->nullable();

      $table->string('response_time')->nullable();

      $table->string('screen_curvature')->nullable();

      $table->string('brightness')->nullable();

      $table->string('color_bit')->nullable();

      $table->string('color_depth')->nullable();

      $table->string('contrast_ratio')->nullable();

      $table->text('accessory_in_box')->nullable();

      $table->string('weight')->nullable();

      $table->json('connection_types')->nullable();

      $table->json('color_gamuts')->nullable();

      $table->decimal('dimension_width', 10, 2)->nullable();

      $table->decimal('dimension_height', 10, 2)->nullable();

      $table->decimal('dimension_depth', 10, 2)->nullable();

      $table->decimal('price', 10, 2);

      $table->enum('discount_type', ['percent', 'fixed'])
        ->default('percent');

      $table->decimal('discount', 10, 2)
        ->default(0);

      $table->decimal('discounted_price', 10, 2)
        ->nullable();

      $table->timestamps();
    });
  }

  public function down(): void {
    Schema::dropIfExists('products');
  }
};