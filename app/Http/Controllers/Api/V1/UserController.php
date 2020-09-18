<?php

namespace App\Http\Controllers\Api\V1;


use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;



class UserController extends Controller
{
    private  $user;

     public function  __construct(User $user)
     {
         $this->user = $user;
     }


    public function index()
    {
        $users = $this->user->paginate('25');

        //$da = formatDateAndTime();;

        return response()->json($users, 200);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        try
        {
           $user = $this->user->create($data);

            return response()->json([
                'data' => [
                    'msg' =>  'ok'
                ]
            ],200);
        }
        catch(\Exception $e)
        {
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }


}
