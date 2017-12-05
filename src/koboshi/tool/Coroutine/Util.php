<?php
/**
 * 工具类
 * @author SamDing
 */
namespace koboshi\tool\Coroutine;

class Util
{
    public static function getTaskId()
    {
        return new SystemCall(function (Task $task, Scheduler $scheduler) {
            $task->setSendData($task->getTaskId());
            $scheduler->schedule($task);
        });
    }

    public static function newTask(\Generator $coroutine)
    {
        return new SystemCall(function (Task $task, Scheduler $scheduler) use ($coroutine) {
            $task->setSendData($scheduler->newTask($coroutine));
            $scheduler->schedule($task);
        });
    }

    public static function killTask($tid)
    {
        return new SystemCall(function (Task $task, Scheduler $scheduler) use ($tid) {
            $task->setSendData($scheduler->killTask($tid));
            if ($task->getTaskId() != $tid) {
                $scheduler->schedule($task);
            }
        });
    }
}
