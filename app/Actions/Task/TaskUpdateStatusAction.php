<?php

namespace App\Actions\Task;

use App\Models\Task;
use App\Models\TaskSchedule;
use App\Models\Room;
use App\Http\Resources\Task\TaskResources;
use Storage;

class TaskUpdateStatusAction
{

    public function execute($request, $id)
    {
        $record = Task::find($id);
        $input = $request->validated();

        if(!$record)
        return response()->json(['error'=>'Unauthorized'],401);

        $record->update([
            'status'     => $input['status'],
        ]);
       
        $record->save();

        return new TaskResources($record);

    }
}
