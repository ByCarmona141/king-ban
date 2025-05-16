<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::disableForeignKeyConstraints();

        Schema::create('king_bans', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('king_user_id')->nullable()->constrained()->comment('Usuario que fue baneado');
            $table->text('endpoint')->comment('Endpoint que fue baneado');
            $table->text('headers')->nullable()->comment('headers de la accion');
            $table->text('token')->nullable()->comment('token con el cual se realiza la accion');
            $table->string('ip', 255)->comment('ip que fue baneada');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('king_bans');
    }
};
