<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Task;

class TasksController extends Controller
{
    
     //getでtasks/にアクセスされた場合の一覧表示処理
    public function index()
    {
        $tasks = Task::all();
        
        return view("tasks.index",["tasks" => $tasks,
        ]);
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
        //タスクを作成
        $task = new Task;
        $task->status = $request->status;
        $task->content = $request->content;
        $task->save();
        
        //トップページへリダイレクト
        return redirect("/");
    }

    //getでtasks/(id)にアクセスされた場合の取得表示処理
    public function show($id)
    {
        //idの値でタスクを検索して取得
        $task = Task::findOrFail($id);
        
        //メッセージ詳細ビューでそれを表示
        return view("tasks.show",[
            "task" => $task,
            ]);
    }

    //getでtasks/(id)/editにアクセスされた場合の更新画面表示処理
    public function edit($id)
    {
        
        //idの値でタスクを検索して取得
        $task = Task::findOrFail($id);
        
        //タスク編集ビューでそれを表示
        return view("tasks.edit",[
            "task" => $task,
            ]);
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
        //タスクを更新
        $task->status = $request->status;
        $task->content = $request->content;
        $task->save();
        
        //トップページへリダイレクト
        return redirect("/");
    }

        //deleteでtasks/(id)にアクセスされた場合の削除処理
    public function destroy($id)
    {
        //idの値でタスクを検索して取得
        $task = Task::findOrFail($id);
        //タスクを削除
        $task->delete();
        
        //トップページへリダイレクト
        return redirect("/");
    }
}
