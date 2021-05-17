<?php
namespace App\Http\Middleware;

use App\Models\User;
use App\Models\Board;
use Closure;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
class BoardMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return Application|RedirectResponse|Redirector|mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        $boards = Board::with(['user', 'boardUsers']);

        if ($user->role === User::ROLE_ADMIN) {
            return $next($request);
        }if ($user->role === User::ROLE_USER) {
            $boards = $boards->where(function ($query) use ($user) {
                //Suntem in tabele de boards in continuare
                $query->where('user_id', $user->id);
                    
            });
            return $next($request);
        }

        return redirect(route('dashboard'));
    }
    }

