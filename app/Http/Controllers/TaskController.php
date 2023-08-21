<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Task\TaskCreateRequest;
use App\Http\Requests\Task\TaskUpdateRequest;
use App\Http\Requests\Task\TaskUpdateStatusRequest;

use App\Interfaces\TaskInterface;

class TaskController extends Controller
{
    private TaskInterface $repository;

    public function __construct(TaskInterface $repository){
        $this->repository = $repository;
    }

    public function index(Request $request){
        return $this->repository->index($request);
    }

    public function show($id){
        return $this->repository->show($id);
    }

    public function create(TaskCreateRequest $request){
        return $this->repository->create($request);
    }

    public function update(TaskUpdateRequest $request, $id){
        return $this->repository->update($request,$id);
    }
    
    public function download($id){
        return $this->repository->download($id);
    }

    public function updateStatus(TaskUpdateStatusRequest $request, $id){
        return $this->repository->updateStatus($request,$id);
    }

    public function delete($id){
      return $this->repository->delete($id);
    }
}
