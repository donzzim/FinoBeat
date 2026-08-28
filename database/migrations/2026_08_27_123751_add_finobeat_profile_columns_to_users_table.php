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
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->change();
            $table->string('password')->nullable()->change();
            $table->string('avatar_path')->nullable();
            $table->string('status')->default('active');
            $table->string('locale', 10)->default('pt_BR');
            $table->string('timezone')->default('America/Sao_Paulo');
            $table->text('document')->nullable();
            $table->text('pix_key')->nullable();
            $table->string('pix_key_type')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('position')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('invited_by_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('invited_at')->nullable();
            $table->timestamp('last_login_at')->nullable();

            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropConstrainedForeignId('invited_by_id');
            $table->dropColumn([
                'avatar_path',
                'status',
                'locale',
                'timezone',
                'document',
                'pix_key',
                'pix_key_type',
                'birth_date',
                'position',
                'notes',
                'invited_at',
                'last_login_at',
            ]);

            $table->string('phone')->nullable(false)->change();
            $table->string('password')->nullable(false)->change();
        });
    }
};
