<?php

namespace App\Actions\Task;

use App\Models\Task;
use Storage;
use App\Http\Resources\Task\TaskResources;

class TaskCreateAction
{
    public function execute($request)
    {
        $input = $request->validated();
        $newFilename = '';  
        if ($request->hasFile('file')) {
            $file = $request->file("file")[0];
            $filename = time() . '.' . $file->getClientOriginalName();
            $newFilename = 'task/'. $filename;
            $path = Storage::put($newFilename,file_get_contents($file));
        }

        $record = Task::create([
            'title'      => $input['title'],
            'description' => $input['description'],
            'status'     => $input['status'],
            'file'    => $newFilename
        ]);

        
        return new TaskResources($record);

    }
}
