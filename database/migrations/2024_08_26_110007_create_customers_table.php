<?php

use App\Enums\ApprovalStatus;
use App\Enums\Gender;
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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('place_of_birth');
            $table->date('birth_date');
            $table->enum('gender', [Gender::LAKI_LAKI->value, Gender::WANITA->value]);
            $table->foreignId('occupation_id')->constrained('occupations');
            $table->foreignId('province_id')->constrained('provinces');
            $table->foreignId('regency_id')->constrained('regencies');
            $table->foreignId('district_id')->constrained('districts');
            $table->foreignId('village_id')->constrained('villages');
            $table->text('address');
            $table->string('rt', 3);
            $table->string('rw', 3);
            $table->decimal('deposit', 15, 2);
            $table->enum('status', [ApprovalStatus::MENUNGGU_APPROVAL->value, ApprovalStatus::DISETUJUI->value])->default(ApprovalStatus::MENUNGGU_APPROVAL->value);
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
