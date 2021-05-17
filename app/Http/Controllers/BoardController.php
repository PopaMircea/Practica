<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\BoardUser;
use App\Models\Task;
use App\Models\User;
use DateTime;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;



/**
 * Class BoardController
 *
 * @package App\Http\Controllers
 */
class BoardController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function boards()
    {
        /** @var User $user */
        $user = Auth::user();
        $members= User::query()->get();
        $boards = Board::with(['user', 'boardUsers']);
        

        if ($user->role === User::ROLE_USER) {
            $boards = $boards->where(function ($query) use ($user) {
                //Suntem in tabele de boards in continuare
                $query->where('user_id', $user->id)
                    ->orWhereHas('boardUsers', function ($query) use ($user) {
                        //Suntem in tabela de board_users
                        $query->where('user_id', $user->id);
                    });
            });
        }

        $board= clone $boards;
        $board= $board->first(); 
        $boards = $boards->paginate(10);

        return view(
            'boards.index',
            [   
                'board'=> $board,
                'boards' => $boards,
                'members' => $members
            ]
        );
    }

    public function updateBoard(Request $request , $id): JsonResponse
    {  
        $board = Board::find($id);
        $error = '';
        $success = '';
        $dates = new DateTime(); 
        if($board){
         $board->name = $request->name;
         $board->save();
         $success= 'Board updated';
        }else{
            $error = 'Could not update the board';
        }
        if($board->save()){ 
           
         foreach($request->members as $addmember){
            $data = array( 
             'board_id'=> $id,
             'user_id' => $addmember,
             'created_at'=> $dates,
             'updated_at'=>$dates
            
            );
            BoardUser::insert($data);
            }
         } 
        
        return response()->json(['error' => $error, 'success' => $success, 'board' => $board]);
    }

    /**
     * @param  Request  $request
     * @param $id
     *
     * @return JsonResponse
     */

    public function deleteBoard(Request $request, $id): JsonResponse
    {
        $board = Board::find($id);

        $error = '';
        $success = '';

        if ($board) {
            $board->boardUsers()->delete();
            $board->tasks()->delete();
            $board->delete();

            $success = 'Board deleted';
        } else {
            $error = 'Board not found!';
        }

        return response()->json(['error' => $error, 'success' => $success]);
    }
    

    /**
     * @param $id
     *
     * @return Application|Factory|View|RedirectResponse
     */
    public function board($id)
    {
        /** @var User $user */
        $user = Auth::user();
        $boards = Board::query();
        $tasks = Task::latest()->with(['board','user'])->where('board_id',$id)->paginate(3);
        $boardUser = BoardUser::with(['board','user'])->where('board_id',$id)->get();

        if ($user->role === User::ROLE_USER) {
            $boards = $boards->where(function ($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->orWhereHas('boardUsers', function ($query) use ($user) {
                        $query->where('user_id', $user->id);
                    });
            });
        }

        $board = clone $boards;
        $board = $board->where('id', $id)->first();
        $boards = $boards->select('id', 'name')->get();

        if (!$board) {
            return redirect()->route('boards.all');
        }

        return view(
            'boards.view',
            [   
                'board' => $board,
                'boards' => $boards,
                'tasks'=> $tasks,
                'boardUser'=>$boardUser

            ]
        );
    }

}
