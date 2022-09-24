<?php

namespace App\Policies;

use App\Models\Assignee;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AssigneePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Assignee  $assignee
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Assignee $assignee)
    {
        return $assignee->project->user_id === $user->id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Assignee  $assignee
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Assignee $assignee)
    {
        return $assignee->project->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Assignee  $assignee
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Assignee $assignee)
    {
        return $assignee->project->user_id === $user->id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Assignee  $assignee
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Assignee $assignee)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Assignee  $assignee
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Assignee $assignee)
    {
        return false;
    }
}
