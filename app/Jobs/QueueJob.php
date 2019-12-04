<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Task;
use App\Processor;
use App\Transaction;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class QueueJob extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
      $this->runMe();
    }

    public function runMe() {
      $task = $this->getTaskForProcessing();
      $processor = $this->getAvailableProcessor();
      $transactionId = $this->assignProcessor($task[0]->id, $processor[0]->processor_id);
      $result = $this->executeCommand($transactionId[0]->id);
      return response()->json($result, 200);
    }

    private function getTaskForProcessing() {
      return Task::where('processed_flag',0)->take(1)->get();
    }

    private function getAvailableProcessor() {
      return Processor::where('active',0)->take(1)->get();
    }

    private function assignProcessor($taskId, $processorId) {
      // mark the processor as active
      $this->toggleProcessor($processorId, 1);
      // add the transaction to the transaction table
      $transaction = new Transaction;
      $transaction->task_id = $taskId;
      $transaction->processor_id = $processorId;
      $transaction->save();
      $transaction = Transaction::where([
        ['task_id', $taskId],
        ['processor_id', $processorId]
      ])->get();
      return $transaction;
    }

    private function executeCommand($transactionId) {
      $randomTime = rand(1,35);
      sleep($randomTime);
      $transactionObj = Transaction::where('id', $transactionId)->take(1)->get();
      // find out the processing time
      // $currentTime = date('Y-m-d H:i:s');
      // $diff = date_diff($currentTime, $transactionObj[0]->created_at);
      Transaction::where('id', $transactionId)->update(['total_time' => $randomTime]);
      $this->toggleProcessor($transactionObj[0]->processor_id, 0);
      return $transactionObj;
    }

    private function toggleProcessor($processorId, $value) {
      Processor::updateOrInsert(
        ['processor_id' => $processorId],
        ['active' => $value]
      );
    }
}
