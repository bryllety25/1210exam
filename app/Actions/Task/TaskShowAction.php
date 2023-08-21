<?php

namespace App\Actions\Task;

use App\Models\Task;
use App\Http\Resources\Task\TaskResources;

class TaskShowAction
{
    public function execute($id)
    {
        $record = Task::find($id);

        if($record){

            return new TaskResources($record);
        }
        else{
            return response()->json(null,401);
        }
    }
}
