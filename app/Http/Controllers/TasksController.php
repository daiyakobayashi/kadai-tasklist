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
        //タスクを作成
        $task = new Task;
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
        //
    }

    //putまたはpatchでtasks/(id)にアクセスされた場合の更新処理
    public function update(Request $request, $id)
    {
        //
    }

        //deleteでtasks/(id)にアクセスされた場合の削除処理
    public function destroy($id)
    {
        //
    }
}