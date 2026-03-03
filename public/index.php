<?php

use App\Model\Task;
use App\Model\User;

require '../vendor/autoload.php';

$user = new User('John Doe');
$task1 = new Task('Task 1', 'Description for Task 1');
$task2 = new Task('Task 2', 'Description for Task 2');

$user->assignTask($task1);
$user->assignTask($task2);

foreach ($user->getTasks() as $task) {
    echo "Task: " . $task->getTitle() . " - " . $task->getDescription() . "
";
}