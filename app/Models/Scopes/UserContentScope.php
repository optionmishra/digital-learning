<?php

namespace App\Models\Scopes;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class UserContentScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        // Skip if no authenticated user
        if (! auth()->check() || auth()->user()->hasRole('admin')) {
            return;
        }

        $user = auth()->user();
        $profile = $user->profile;

        if (! $profile) {
            $builder->whereRaw('1 = 0');

            return;
        }

        // Base query to check book assignment
        $builder->whereExists(function ($query) use ($user) {
            $query->from('user_books')
                ->whereColumn('user_books.book_id', 'contents.book_id')
                ->where('user_books.user_id', $user->id);
        });

        switch ($profile->status) {
            case 'pending':
                if (Carbon::parse($profile->trial_end)->isPast()) {
                    $builder->whereRaw('1 = 0');
                } else {
                    // Only allow Chapter 1 content from assigned books
                    $builder->whereHas('topic', function ($query) {
                        $query->where('serial', 1);
                    });
                }
                break;

            case 'rejected':
                $builder->whereRaw('1 = 0');
                break;

            case 'approved':
                // Only show content from assigned books (already handled by the base query)
                break;

            default:
                $builder->whereRaw('1 = 0');
        }
    }
}
