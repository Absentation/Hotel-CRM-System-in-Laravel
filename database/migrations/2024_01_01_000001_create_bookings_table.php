<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->date('booking_date')->useCurrent();
            $table->date('check_in_date');
            $table->date('expected_check_out')->nullable();
            $table->date('check_out_date')->nullable();
            $table->text('special_request')->nullable();
            $table->foreignId('customer_id')->constrained('customers');
            $table->foreignId('room_id')->constrained('rooms');
            $table->foreignId('employee_id')->constrained('employees');
            $table->string('username')->unique();
            $table->string('password');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
