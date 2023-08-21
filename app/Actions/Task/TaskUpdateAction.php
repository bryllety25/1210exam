<?php

namespace App\Actions\Task;

use App\Models\Task;
use App\Models\TaskSchedule;
use App\Models\Room;
use App\Http\Resources\Task\TaskResources;
use Storage;

class TaskUpdateAction
{

    public function execute($request, $id)
    {
        $record = Task::find($id);
        $input = $request->validated();


        if(!$record)
        return response()->json(['error'=>'Unauthorized'],401);

        
        $newFilename = $record->file;
        if ($request->hasFile('file')) {
            $file = $request->file("file")[0];
            $filename = time() . '.' . $file->getClientOriginalName();
            $newFilename = 'task/'. $filename;
            $path = Storage::put($newFilename,file_get_contents($file));
        }


        $record->update([
            'title'      => $input['title'],
            'description' => $input['description'],
            'status'     => $input['status'],
            'file'    => $newFilename
        ]);
       
        $record->save();


        return new TaskResources($record);

    }
}
