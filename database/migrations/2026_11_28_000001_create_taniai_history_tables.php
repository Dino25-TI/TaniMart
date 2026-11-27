
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tani_ai_conversations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('title', 120);
            $table->timestamps();

            $table->index(['user_id', 'updated_at']);
        });

        Schema::create('tani_ai_messages', function (Blueprint $table) {
            $table->id();

            $table->foreignId('conversation_id')
                ->constrained('tani_ai_conversations')
                ->cascadeOnDelete();

            $table->string('role', 20);
            $table->longText('content');
            $table->timestamps();

            $table->index(['conversation_id', 'id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tani_ai_messages');
        Schema::dropIfExists('tani_ai_conversations');
    }
};
