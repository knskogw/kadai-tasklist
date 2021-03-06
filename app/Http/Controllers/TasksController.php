<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Task;

class TasksController extends Controller
{
    
    public function index()
    {
        $data = [];
        if (\Auth::check()) { // 認証済みの場合
            // 認証済みユーザを取得
            $user = \Auth::user();
          
            // ユーザの投稿の一覧を作成日時の降順で取得
            $tasks = $user->tasks()->orderBy('created_at', 'desc')->paginate(10);
            
            
            $data = [
            'user' => $user,
            'tasks' => $tasks,
            
            ];
        }
        // Welcomeビューでそれらを表示
        return view('welcome', $data);
    }
           
           /**
       // メッセージ一覧を取得
        $tasks = Task::all();
       // }
        // メッセージ一覧ビューでそれを表示
        return view('welcome', [
            'tasks' => $tasks,
        ]);
        
    }
    **/
    
    public function create()
    {
        //
        if (\Auth::check()) { // 認証済みの場合
            // 認証済みユーザを取得
            $user = \Auth::user();
            
            
        $task = new Task;
        
        return view('tasks.create', ['task' => $task,]);
        }
    }

   
    public function store(Request $request)
    {
        
        $request->validate([
            'content' => 'required|max:50',
            'status' => 'required|max:10',
            ]);
            
    /**    // メッセージを作成
        $task = new Task;
        $task->content = $request->content;
        $task->status = $request->status;
        $task->save();

        // トップページへリダイレクトさせる
        return redirect('/');
    **/
        
        $request->user()->tasks()->create([
            'content' => $request->content,
            'status' => $request->status,
        ]);

        return redirect('/');
        
    }
   
    public function show($id)
    {
        if (\Auth::check()) { // 認証済みの場合
            // 認証済みユーザを取得
            $user = \Auth::user();
            // idの値でメッセージを検索して取得
            $task = Task::findOrFail($id);
                if($user->id == $task->user_id){
                    return view('tasks.show', [
                        'task' => $task,
                   ]);
                }
            
        }
        return redirect('/');
        
        // メッセージ詳細ビューでそれを表示
    }

    
    public function edit($id)
    {
        if (\Auth::check()) { // 認証済みの場合
            // 認証済みユーザを取得
            $user = \Auth::user();
            
        // idの値でメッセージを検索して取得
        $task = Task::findOrFail($id);
            if($user->id == $task->user_id){
                return view('tasks.edit', [
                    'task' => $task,
               ]);
            }
            /**
            // メッセージ編集ビューでそれを表示
            return view('tasks.edit', [
                'task' => $task,
            ]);
            **/
        }
        return redirect('/');
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|max:50',
            'status' => 'required|max:10',
            ]);
        
            if (\Auth::check()) { // 認証済みの場合
                // 認証済みユーザを取得
                $user = \Auth::user();
                    
                $task = Task::findOrFail($id);
                 
                $task->content = $request->content;
                $task->status = $request->status;
                $task->save();
                
                /**
                $request->user()->tasks()->update([
                    'content' => $request->content,
                    'status' => $request->status,
                ]);
                **/
            }
        return redirect('/');
    }
    

    
    public function destroy($id)
    {
            if (\Auth::check()) { // 認証済みの場合
                        // 認証済みユーザを取得
                        $user = \Auth::user();
                $task = Task::findOrFail($id);
                
                $task->delete();
               
            }
        return redirect('/');
    }
}
