<?php
namespace App\Interfaces;

interface TaskInterface {
    public function index($request);
    public function create($request);
    public function show($id);
    public function download($id);
    public function update($request,$id);
    public function updateStatus($request,$id);
    public function delete($id);
}
?>
