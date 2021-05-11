<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

/**
 * Class AdminController
 *
 * @package App\Http\Controllers
 */
class AdminController extends Controller
{
    public function users()
    {
        $users = DB::table('users')->paginate(10);

        return view(
            'users.index',
            [
                'users' => $users
            ]
        );
    }

    public function boards()
    {
      
        $boards = Board::with('user')->paginate(10);
       
        return view(
            'boards.index',
            [   
                'boards' => $boards
            ]
        );
    }


  
  
    public function editUser(Request $request){
        $user= User::find($request->id);
        $user->id = $request->id;
        $user->role = $request->role;
        $user->save();
        return response()->json($user);
    }
}

   
