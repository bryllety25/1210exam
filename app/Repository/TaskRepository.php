<?php
namespace App\Repository;

use App\Interfaces\TaskInterface;

use App\Actions\Task\TaskListAction;
use App\Actions\Task\TaskShowAction;
use App\Actions\Task\TaskCreateAction;
use App\Actions\Task\TaskUpdateAction;
use App\Actions\Task\TaskUpdateStatusAction;
use App\Actions\Task\TaskDeleteAction;
use App\Actions\Task\TaskDownloadAction;

class TaskRepository implements TaskInterface{

    public function index($request){
        $action = new TaskListAction();
        $data = $action->execute($request);
        return $data;
    }

    public function create($request)
    {
        $action = new TaskCreateAction();
        $data = $action->execute($request);
        return $data;
    }

    public function show($id)
    {
        $action = new TaskShowAction();
        $record = $action->execute($id);
        return $record;
    }

    public function update($request, $id)
    {
        $action = new TaskUpdateAction();
        $data = $action->execute($request,$id);
        return $data;
    }

    public function download($id)
    {
        $action = new TaskDownloadAction();
        $data = $action->execute($id);
        return $data;
    }

    public function updateStatus($request, $id)
    {
        $action = new TaskUpdateStatusAction();
        $data = $action->execute($request,$id);
        return $data;
    }

    public function delete($id)
    {
        $data = new TaskDeleteAction();
        return $data->execute($id);
    }

}
?>
