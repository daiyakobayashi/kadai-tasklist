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

    //getでtasks/createにアクセスされた場合の新規登録画面表示処理
    public function create()
    {
        $task = new Task;
        
        return view("tasks.create",[
            "task" => $task,
            ]);
    }

    //postでtasks/にアクセスされた場合の新規登録処理
    public function store(Request $request)
    {
        //バリデーション
        $request->validate([
            "status" => "required|max:10",
            "content" => "required|max:255",
            ]);
        
        //認証済みユーザの投稿として作成（リクエストされた値を元に作成）
        $request->user()->tasks()->create([
            "content" => $request->content,
            "status" => $request->status,
            ]);
        
        //トップページへリダイレクト
        return redirect("/");
    }

    //getでtasks/(id)にアクセスされた場合の取得表示処理
    public function show($id)
    {
        //idの値でタスクを検索して取得
        $task = Task::findOrFail($id);
        if (\Auth::id() === $task->user_id){
        
        //メッセージ詳細ビューでそれを表示
        return view("tasks.show",[
            "task" => $task,
            ]);
        
        }
        else{
            return redirect("/");
        }
    }

    //getでtasks/(id)/editにアクセスされた場合の更新画面表示処理
    public function edit($id)
    {
        
        //idの値でタスクを検索して取得
        $task = Task::findOrFail($id);
        
        if (\Auth::id() === $task->user_id){
        //タスク編集ビューでそれを表示
        return view("tasks.edit",[
            "task" => $task,
            ]);
        }
        else{
            return redirect("/");
        }
    }

    //putまたはpatchでtasks/(id)にアクセスされた場合の更新処理
    public function update(Request $request, $id)
    {
        //バリデーション
        $request->validate([
            "status" => "required|max:10",
            "content" => "required|max:255",
            ]);
        //idの値でタスクを検索して取得
        $task = Task::findOrFail($id);
        //認証済みユーザがその投稿の所有者である場合は、投稿を更新
        if (\Auth::id() === $task->user_id){
            $task->status = $request->status;
            $task->content = $request->content;
            $task->save(); 
        }
        
        
        //トップページへリダイレクト
        return redirect("/");
    }

        //deleteでtasks/(id)にアクセスされた場合の削除処理
    public function destroy($id)
    {
        //idの値でタスクを検索して取得
        $task = Task::findOrFail($id);
        //認証済みユーザがその投稿の所有者である場合は、投稿を削除
        if (\Auth::id() === $task->user_id){
            $task->delete();
        }
        
        //トップページへリダイレクト
        return redirect("/");
    }
}
