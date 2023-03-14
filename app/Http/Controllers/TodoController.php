<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Todo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TodoController extends Controller
{
    #delete
    public function deletetodo(Request $request)
    {
        if (Auth::check()) {
            $validator = Validator::make($request->all(), [
                'id' => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json($validator->errors()->toJson(), 400);
            }
            Todo::where('id', $request->id)->update(['updated_by' => auth()->user()->name]);
            Todo::where('id', $request->id)->delete();
            $data=[
                    "id"=> auth()->user()->id,
                    "deleted_by"=>auth()->user()->name
                ];
            Log::create($data);
            return "Deleted Sucessfully";
        } else {
            return response()->json(["message" => "Not Login"], 401);
        }
    }

    #update
    public function updatetodo(Request $request)
    {
        if (Auth::check()) {
            $user = Todo::where('created_by', auth()->user()->name)->get();
            if ($user->count() != 0) {
                $validator = Validator::make($request->all(), [
                'id' => 'required',
                'title' => 'required|string',
                'description' => 'required|string',
                'workstatus' => 'required|string'
            ]);
            if ($validator->fails()) {
                return response()->json($validator->errors()->toJson(), 400);
            }
            if ($request->workstatus == "assigned" && $request->assigned_to == "") {
                return "assigned_to name is also required";
            }
            if ($request->workstatus == "completed") {
                return ('Congratulation you did itttttt!!!!!');
            }
            if ($request->workstatus == "assigned") {
                Todo::where('id', $request->id)->update([
                    'title' => $request->title,
                    'description' => $request->description,
                    'workstatus' => $request->workstatus,
                    'assigned_to' => $request->assigned_to]);
                $user = Todo::where('created_by', auth()->user()->name)->get();
                $data=[
                    "id"=> auth()->user()->id,
                    "updated_by"=>auth()->user()->name
                ];
                Log::create($data);
                return "Updated Sucessfully";

            } else {
                Todo::where('id', $request->id)->update(['title' => $request->title, 'description' => $request->description, 'workstatus' => $request->workstatus, 'assigned_to' => NULL]);
                Todo::where('id', $request->id)->update(['updated_by' => auth()->user()->name]);

                $data=[
                    "id"=> auth()->user()->id,
                    "updated_by"=>auth()->user()->name
                ];
                Log::create($data);
                return "Updated Sucessfully";
            }
        } else {
            return response()->json(["message" => "Not Login"], 401);
        }
            } else {
                return response()->json(["message" => "Not Updated"], 401);
            }
        }


    #create
    public function store(Request $request)
    {
        if (Auth::check()) {
            $data=[
                "id"=> auth()->user()->id,
                "created_by"=>auth()->user()->name
            ];
            Log::create($data);
            if ($request->workstatus == "assigned" && $request->assigned_to == "") {
                return "assigned_to name is also required";
            } else {
                try {
                    $assgn_check = User::where('name', $request->assigned_to)->first();
                    if ($assgn_check->name != null) {
                        $validtor = Validator::make($request->all(), [
                            'title' => 'required|string',
                            'description' => 'required|string',
                            'workstatus' => 'required|string'
                        ]);

                        if($validtor->fails()){
                            return response()->json([
                                'status' => 0,
                                'message' => $validtor->errors()
                            ],403);
                        }
                        Todo::create(array_merge($request->all(),
                            ['created_by' => auth()->user()->name]));
                        $msg="TodoList Created by ".auth()->user()->name;
//                        event(new \App\Events\NotificationTodo("hello"));
                        event(new \App\Events\TodoCreate($msg));

//                        if(auth()->user()->name==$request->assigned_to){
//                            $this->notification(auth()->user()->name);
//                        }

                        return "created Sucessfully";
                    }
                } catch (\Exception $e) {
                    return response()->json(["message" => $e->getMessage()], 401);
                }


            }
        }
    }
//    public function notification($name){
//        event(new \App\Events\NotificationTodo("task assigned to you!!"));
//    }
    #search
    public function search(Request $request)
    {
        if (Auth::check()) {
            $users = Todo::where('created_by',auth()->user()->name)->where('title', $request->search)->orWhere('id', $request->search)->get();
            if( $users->count()!=0) {
            foreach ($users as $user) {
                event(new \App\Events\OverallNotice($user->id,$user->title,$user->description,$user->workstatus,$user->assigned_to,$user->created_at,$user->updated_at, $user->created_by));
                return [
                    "id" => $user->id,
                    "title" => $user->title,
                    "description" => $user->description,
                    "workstatus" => $user->workstatus,
                    "assigned_to" => $user->assigned_to,
                    "created_at" => $user->created_at,
                    "updated_at" => $user->updated_at,
                    "created_by" => $user->created_by,
                ];
            }
            }
        else {
                return response()->json(["message" => "Search not Found"], 401);
            }
    }
    }

    #search own work
    public function search_own_work(Request $request){
        if (Auth::check()) {
            $todo = Todo::all()->where('assigned_to',$request->search);
            if ($todo == NULL) {
                return "List Not Found";
            }
            return $todo;

        } else {
            return response()->json(["message" => "Not Login"], 401);
        }
    }
    public  function classSearch(Request $request){
        if($request->class=="9"){
            $this->notification();
        }
        return $request->class;
    }
    public function notification(){
        event(new \App\Events\NotificationTodo("task assigned to you!!"));
    }
    public function resultpubilshed(){
        if(auth()->user()->name=="rita"){
            event(new \App\Events\OverallNotice(auth()->user()->name));
        }

        return [
            'user'=>auth()->user()->name,
        ];
//        return (auth()->user()->name);
//
    }
}

