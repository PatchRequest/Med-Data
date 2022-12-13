<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up() {
        Schema::create('documents', function (Blueprint $table) {
            $table->uuid('id');

            $table->text('path');
            $table->foreignIdFor(\App\Models\Share::class, 'share_id');
            $table->foreignIdFor(\App\Models\User::class, 'owner_id');

            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('documents');
    }

};
