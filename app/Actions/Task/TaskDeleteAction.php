<?php

namespace App\Actions\Task;

use App\Models\Task;

class TaskDeleteAction
{
    public function execute($id)
    {
      $record = Task::find($id);
      if($record){
        $record = $record->delete();
        return response()->json(null, 200);
      }
      else{
          return response()->json(null,404);
      }
    }
}
