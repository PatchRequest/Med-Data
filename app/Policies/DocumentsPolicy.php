<?php

namespace App\Policies;

use App\Models\Document;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DocumentsPolicy {

    use HandlesAuthorization;

    public function viewAny(User $user): bool {
        return false;
    }

    public function view(User $user, Document $document): bool {
        $document->shares->each(function ($share) use ($user) {
            if ($user->id === $share->creator_id || $user->id === $share->recipient_id) {
                return true;
            }
        });
    }

    public function create(User $user): bool {
        return true;
    }

    public function update(User $user, Document $document): bool {
        return $user->id === $document->owner_id;
    }

    public function delete(User $user, Document $document): bool {
        return $user->id === $document->owner_id;
    }

    public function restore(User $user, Document $document): bool {

    }

    public function forceDelete(User $user, Document $document): bool {

    }

}
