<?php

namespace App\Actions\Task;

use App\Models\Task;
use App\Http\Resources\Task\TaskResources;

class TaskListAction
{

    public function execute($request)
    {
        $records = new Task();

        if($request->has('search') && $request->get('search')){
          $records = $records->where(function($q)use($request){
            $q->where('title','like','%'.$request->get('search').'%');
            $q->orWhere('description','like','%'.$request->get('search').'%');
            $q->orWhere('status','like','%'.$request->get('search').'%');
          });
        }
        
        if($request->has('sort') && $request->get('sort'))
        $records = $records->orderBy('created_at',$request->get('sort'));
        else
        $records = $records->orderBy('created_at','DESC');
        if($request->limit)
          $records = $records->paginate($request->limit)->appends(request()->query());
        else{
          $records = $records->get();

        }

        return TaskResources::collection($records);
    }
}
