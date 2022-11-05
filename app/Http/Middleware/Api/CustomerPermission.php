<?php

namespace App\Http\Middleware\Api;

use Closure;
use App\User;

class CustomerPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = User::find($request->user()->id);

        if ($user->role != "Customer") {
            
            return response()->json([
                "message" => "Please Verify Email Please!",
                "status" => 422,
            ]);
        }

        return $next($request);
    }
}
