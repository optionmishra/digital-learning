<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\JsonResponse
     */
    public function handle(Request $request, Closure $next): Response
    {
        // For API routes, token should already be validated by auth:sanctum middleware
        $user = $request->user();
        
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized access',
                'data' => null
            ], Response::HTTP_UNAUTHORIZED);
        }

        $profile = $user->profile;

        if (!$profile) {
            return response()->json([
                'status' => false,
                'message' => 'Profile incomplete',
                'data' => [
                    'error_code' => 'PROFILE_INCOMPLETE',
                    'description' => 'Please complete your profile to continue.'
                ]
            ], Response::HTTP_FORBIDDEN);
        }

        switch ($profile->status) {
            case 'pending':
                if (Carbon::parse($profile->trial_end)->isPast()) {
                    // Revoke all tokens for this user
                    $user->tokens()->delete();
                    
                    return response()->json([
                        'status' => false,
                        'message' => 'Trial expired',
                        'data' => [
                            'error_code' => 'TRIAL_EXPIRED',
                            'description' => 'Your trial period has expired. Please contact support.',
                            'trial_ended_at' => $profile->trial_end
                        ]
                    ], Response::HTTP_FORBIDDEN);
                }
                
                if ($this->isRestrictedContent($request)) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Content restricted',
                        'data' => [
                            'error_code' => 'TRIAL_RESTRICTION',
                            'description' => 'This content is not available in trial mode. Only Chapter 1 content is accessible.'
                        ]
                    ], Response::HTTP_FORBIDDEN);
                }
                break;

            case 'rejected':
                // Revoke all tokens for this user
                $user->tokens()->delete();
                
                return response()->json([
                    'status' => false,
                    'message' => 'Account rejected',
                    'data' => [
                        'error_code' => 'ACCOUNT_REJECTED',
                        'description' => 'Your account access has been rejected. Please contact support.'
                    ]
                ], Response::HTTP_FORBIDDEN);

            case 'approved':
                // Allow normal access
                break;

            default:
                // Revoke all tokens for this user
                $user->tokens()->delete();
                
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid status',
                    'data' => [
                        'error_code' => 'INVALID_STATUS',
                        'description' => 'Invalid account status. Please contact support.'
                    ]
                ], Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }

    /**
     * Check if the requested content is restricted for trial users
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    private function isRestrictedContent(Request $request): bool
    {
        // Get the topic ID from the request
        $topicId = $request->route('topic') ?? 
                   $request->input('topic_id') ?? 
                   ($request->input('content.topic_id') ?? null);

        if (!$topicId) {
            return false;
        }

        // Check if the topic belongs to chapter 1
        $topic = \App\Models\Topic::find($topicId);
        return $topic && $topic->serial > 1; // Assuming serial 1 represents chapter 1
    }
}
