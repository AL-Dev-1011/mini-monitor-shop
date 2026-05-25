<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::table('users', function (Blueprint $table) {
      $table->string('phone')->nullable()->after('email');
      $table->string('first_name')->nullable()->after('name');
      $table->string('last_name')->nullable()->after('first_name');
      $table->text('address')->nullable()->after('role');
      $table->string('city')->nullable()->after('address');
      $table->string('province')->nullable()->after('city');
      $table->string('postal_code')->nullable()->after('province');
      $table->string('country')->default('Thailand')->after('postal_code');
    });
  }

  public function down(): void {
    Schema::table('users', function (Blueprint $table) {
      $table->dropColumn([
        'phone',
        'first_name',
        'last_name',
        'address',
        'city',
        'province',
        'postal_code',
        'country',
      ]);
    });
  }
};