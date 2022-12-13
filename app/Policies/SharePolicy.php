<?php

namespace App\Policies;

use App\Models\Share;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SharePolicy {

    use HandlesAuthorization;

    public function viewAny(User $user): bool {
        return false;
    }

    public function view(User $user, Share $share): bool {
        return $user->id === $share->creator_id || $user->id === $share->recipient_id;
    }

    public function create(User $user): bool {
        return true;
    }

    public function update(User $user, Share $share): bool {
        return $user->id === $share->creator_id;
    }

    public function delete(User $user, Share $share): bool {
        return $user->id === $share->creator_id;
    }

    public function restore(User $user, Share $share): bool {
        return false;
    }

    public function forceDelete(User $user, Share $share): bool {
        return false;
    }

}
