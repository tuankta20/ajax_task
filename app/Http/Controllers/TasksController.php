<?php

namespace App\Http\Controllers;

use App\Tasks;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    public function index()
    {
        $tasks = Tasks::orderBy('id', 'desc')->paginate(5);

        return view('index', compact('tasks'));
    }

    public function store(Request $request)
    {
        $task = new Tasks();
        $task->task = $request->input('task');
        $task->description = $request->input('description');
        $task->save();
        return response()->json(['task' => $task]);
    }

    public function update(Request $request, $id)
    {
        $task = Tasks::find($id);
        $task->task = $request->input('task');
        $task->description = $request->input('description');
        $task->save();
        return response()->json(['task' => $task]);
    }

    public function show($id)
    {
        $task = Tasks::find($id);
        return response()->json(['task' => $task]);
    }

    public function destroy($id)
    {
        $task = Tasks::find($id);
        $task->delete();
        return response()->json([$task]);
    }

    public function search(Request $request)
    {
        if ($request->ajax()) {
            $output = '';
            $task = Tasks::where('task', 'LIKE', '%' . $request->input('key') . '%')->get();
            if ($task) {
                foreach ($task as $key => $task) {
                    $output .= '<tr>
                    <td>' . $task->id . '</td>
                    <td>' . $task->task . '</td>
                    <td>' . $task->description . '</td>
                    </tr>';
                }
            }
            return response([$output]);

        }
    }
}
