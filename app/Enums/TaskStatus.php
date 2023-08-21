<?php 
namespace App\Enums;

enum  TaskStatus: string{
    case TODO = 'Todo';
    case InProgress = 'In Progress';
    case Completed = 'Completed';

}
