<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Share extends Model {

    protected $guarded = [];

    public function creator() {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function recipient() {
        return $this->belongsTo(User::class, 'recipient_id');
    }

    public function documents() {
        return $this->hasMany(Document::class);
    }

}
