<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Add new fields after existing columns only if they don't exist
            if (!Schema::hasColumn('bookings', 'name')) {
                $table->string('name')->after('id')->nullable();
            }
            if (!Schema::hasColumn('bookings', 'event_id')) {
                $table->foreignId('event_id')->nullable()->after('email')->constrained('events')->onDelete('set null');
            }
            if (!Schema::hasColumn('bookings', 'guest_count')) {
                $table->integer('guest_count')->default(1)->after('event_date');
            }
            if (!Schema::hasColumn('bookings', 'special_requests')) {
                $table->text('special_requests')->nullable()->after('guest_count');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['event_id']);
            $table->dropColumn(['name', 'event_id', 'guest_count', 'special_requests']);
        });
    }
};
