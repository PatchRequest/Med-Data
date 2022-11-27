<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up() {
        Schema::create('shares', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(\App\Models\User::class, 'creator_id');
            $table->foreignIdFor(\App\Models\User::class, 'recipient_id');

            $table->foreignIdFor(\App\Models\Document::class, 'document_id');

            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('shares');
    }

};
