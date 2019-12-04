<?php

namespace App\Http\Controllers;

use App\Jobs\QueueJob;
use App\Task;
use App\Processor;
use App\Transaction;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;

use DB;

class TaskController extends Controller implements ShouldQueue
{

    public function showAllTasks() {
      // $result = Task::orderBy('priority', 'desc')->take(10)->get();
      $result = $this->getTask();
      return response()->json($result);
      // return response()->json(Task::all());
    }

    public function showOneTask($id) {
      return response()->json(Task::find($id));
    }

    public function create(Request $request) {
      $this->validate($request, [
        'submitter_id' => 'required',
        'priority' => 'required|integer|between:1,9',
        'command' => 'required',
      ]);
      $task = Task::create($request->all());
      $this->dispatch(new QueueJob());
      return response()->json($task, 201);
    }

    public function update($id, Request $request) {
      $task = Task::findOrFail($id);
      $task->update($request->all());

      return response()->json($task, 200);
    }

    public function delete($id) {
      Task::findOrFail($id)->delete();
      return response('Deleted Successfully', 200);
    }

    public function getAverageProcessing() {
      $sql = 'SELECT processor_id , AVG(total_time) as avg_value FROM transactions GROUP BY processor_id';
      $result = DB::select(DB::raw($sql));
      return response()->json($result);
    }

}