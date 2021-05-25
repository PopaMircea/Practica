<?php

namespace App\Http\Controllers;

use App\Models\Board;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use App\Models\User;
use App\Models\BoardUser;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

/**
 * Class DashboardController
 *
 * @package App\Http\Controllers
 */
class DashboardController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $user = Auth::user();
        $users= User::query()->get('id');
        $boards = Board::query()->get('id');
        $tasksAssigned= Task::query()->whereNotNull('assignment')->get('id');  
        $taskAll= Task::query()->get('id');
        if($user->role === User::ROLE_USER){
            $boards = BoardUser::query()->where('user_id', $user->id)->get('id');
        }

        return view('dashboard.index',
    [
        'users'=>$users,
        'boards'=>$boards,
        'taskAssigned'=>$tasksAssigned,
        'taskAll'=>$taskAll

    ]);
    }
}
