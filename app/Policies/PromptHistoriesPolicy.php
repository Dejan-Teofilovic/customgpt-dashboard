<?php

namespace App\Policies;

use App\Models\User;
use App\Models\prompt_histories;
use Illuminate\Auth\Access\HandlesAuthorization;

class PromptHistoriesPolicy
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
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\prompt_histories  $promptHistories
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, prompt_histories $promptHistories)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\prompt_histories  $promptHistories
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, prompt_histories $promptHistories)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\prompt_histories  $promptHistories
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, prompt_histories $promptHistories)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\prompt_histories  $promptHistories
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, prompt_histories $promptHistories)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\prompt_histories  $promptHistories
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, prompt_histories $promptHistories)
    {
        //
    }
}
