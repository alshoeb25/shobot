<?php

namespace App\Policies;

use App\Models\BotQuestion;
use App\Models\User;

class BotQuestionPolicy
{
    /**
     * Super Admin bypasses all permissions
     */
    public function before(User $user, $ability)
    {
        if ($user->isSuper()) {
            return true;
        }
    }

    /**
     * Can view list
     */
    public function viewAny(User $user)
    {
        return $user->organizations()->exists();
    }

    /**
     * Can view a single question
     */
    public function view(User $user, BotQuestion $question)
    {
        return $user->organizations->pluck('id')->contains($question->organization_id);
    }

    /**
     * Can create a question ONLY in assigned organizations
     */
    public function create(User $user)
    {
        //  return $user->organizations()->exists();
        return false;
    }

    /**
     * Update a question only if it belongs to user's organizations
     */
    public function update(User $user, BotQuestion $question)
    {
        //return $user->organizations->pluck('id')->contains($question->organization_id);
        return false;
    }

    /**
     * Delete — allow or restrict (typically super only)
     */
    public function delete(User $user, BotQuestion $question)
    {
        //return $user->organizations->pluck('id')->contains($question->organization_id);
        return false;
    }
}
