<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Task;

use App\Repositories\TaskRepository;

class Taskcontroller extends Controller     //extendsは継承を意味する。この場合、Controller.phpの処理も実行されていることになる。
{

    /**
     * タスクリポジトリ
     * @var TaskRepository
     */
    protected $tasks;

    /**
     * コンストラクタ
     * @return void
     */
    public function __construct(TaskRepository $tasks)
    {
        $this->middleware('auth');

        $this->tasks = $tasks;
    }

    /**
     * タスク一覧
     * 
     * @param Request $request
     * @return Response
     */

    public function index(Request $request)
    {
        // $tasks = Task::orderby('created_at', 'asc')->get();     //Task::orderby('created_at', 'asc')->get()はTaskモデルを呼びだし、getメソッドでモデルから実行結果を取得している。
        // $tasks = $request->user()->tasks()->get();      //  $request->user()メソッドにて認証済みのユーザーを取得、そのユーザーが保持するタスク一覧を取得
        return view('tasks.index', [        //'tasks.index'の意味はviewディレクトリ内のtasksディレクトリのindex.blade.phpを表す。その時に配列で'tasks' => $tasksも一緒に持っていく。
            'tasks' => $this->tasks->forUser($request->user()),
        ]);
    }

    /**
     * タスク登録
     * @param Request $request
     * @return Response
     */
    
    public function store(Request $request)
    {
        $this->validate($request, [         //validateメソッドはパラメーターが有効かバリデーション(検証)している。この場合、nameパラメーターが必須で最小255文字であることのチェックをしている
            'name' => 'required|max:255',
        ]);

        // //タスク作成
        // Task::create([
        //     'user_id' => 0,
        //     'name' => $request->name        //  ここの$request->nameのnameはindex.blade.phpの19行目name="name"に対応している
        // ]);
        // dd($request->user()->tasks());
        $request->user()->tasks()->create([
            'name' => $request->name
        ]);

        return redirect('/tasks');
    }

    /**
    * タスク削除
    *
    * @param Request $request
    * @param Task $task
    * @return Response
    */
    public function destroy(Request $request, Task $task)
    {

        $this->authorize('destroy', $task);     // ユーザー自身のタスクしか削除できないようにした

        $task->delete();
        return redirect('/tasks');
    }

}
