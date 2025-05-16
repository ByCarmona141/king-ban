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
            $table->string('type', length: 25)->comment('Tipo de baneo'); // ip, token, endpoint, user_id, etc.
            $table->bigInteger('king_user_id')->nullable()->comment('Usuario que realizo la accion');
            $table->text('endpoint')->comment('Endpoint de la accion realizada');
            $table->text('token')->nullable()->comment('token de la accion');
            $table->string('ip', 255)->comment('ip de la accion');
            $table->string('reason')->nullable()->comment('Razon por la cual fue baneado');
            $table->timestamp('banned_at')->useCurrent()->comment('Fecha del baneo');
            $table->timestamp('expired_at')->nullable()->comment('Tiempo que expira el baneo'); // null = permanente
            $table->boolean('active')->default(true)->comment('Usuario que realizo la accion');
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
