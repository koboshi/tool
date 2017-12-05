<?php
/**
 * 协程任务调度类
 * @author SamDing
 */
namespace koboshi\tool\Coroutine;

class Scheduler
{

    /**
     * @var \SplQueue
     */
    protected $taskQueue;

    /**
     * @var int
     */
    protected $maxTaskId = 0;

    public function __construct()
    {
        $this->taskQueue = new \SplQueue();
    }

    /**
     * @param \Generator $coroutine
     * @return int
     */
    public function newTask(\Generator $coroutine)
    {
        $tid = ++$this->maxTaskId;
        $task = new Task($this->maxTaskId, $coroutine);
        $this->schedule($task);
        return $tid;
    }

    /**
     * @param $tid
     * @return bool
     */
    public function killTask($tid)
    {
        foreach ($this->taskQueue as $i => $task) {
            $tmp = $task->getTaskId();
            if ($tmp == $tid) {
                unset($this->taskQueue[$i]);
                break;
            }
        }

        return true;
    }

    public function schedule(Task $task)
    {
        $this->taskQueue->enqueue($task);
    }

    /**
     * 开始运行
     */
    public function run()
    {
        while (!$this->taskQueue->isEmpty()) {
            $task = $this->taskQueue->dequeue();
            $res = $task->run();

            if ($res instanceof SystemCall) {
                $res($task, $this);
                continue;
            }

            if (!$task->isDone()) {
                $this->schedule($task);
            }
        }
    }
}