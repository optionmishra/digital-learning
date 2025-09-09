<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserApprovalAndTrial
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // Check if user is authenticated
        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'Authentication required',
                'error_code' => 'UNAUTHENTICATED',
            ], 401);
        }

        // Get user profile
        $userProfile = $user->profile; // Assuming you have a profile relationship

        if (! $userProfile) {
            return response()->json([
                'success' => false,
                'message' => 'User profile not found',
                'error_code' => 'PROFILE_NOT_FOUND',
            ], 404);
        }

        // Check if user is approved
        if ($userProfile->status !== 'approved') {
            $message = match ($userProfile->status) {
                'pending' => 'Your account is pending approval',
                'rejected' => 'Your account has been rejected',
                default => 'Your account is not approved'
            };

            return response()->json([
                'success' => false,
                'message' => $message,
                'error_code' => 'ACCOUNT_NOT_APPROVED',
                'status' => $userProfile->status,
            ], 403);
        }

        // Check trial period if trial_end is set
        if ($userProfile->trial_end) {
            $trialEndDate = Carbon::parse($userProfile->trial_end);
            $today = Carbon::today();

            if ($today->gt($trialEndDate)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Your trial period has ended',
                    'error_code' => 'TRIAL_EXPIRED',
                    'trial_end_date' => $userProfile->trial_end,
                ], 403);
            }
        }

        return $next($request);
    }
}
