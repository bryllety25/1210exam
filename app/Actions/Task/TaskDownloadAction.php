<?php

namespace App\Actions\Task;

use App\Models\Task;
use App\Http\Resources\Task\TaskResources;
use Storage;

class TaskDownloadAction
{
    public function execute($id)
    {
        $record = Task::find($id);

        if($record){

            return Storage::download($record->file);
        }
        else{
            return response()->json(null,401);
        }
    }
}
