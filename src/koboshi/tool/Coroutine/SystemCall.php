<?php
/**
 * 系统调用
 * @author SamDing
 */
namespace koboshi\tool\Coroutine;

class SystemCall
{
    /**
     * @var callable
     */
    protected $callback;

    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }

    public function __invoke(Task $task, Scheduler $scheduler)
    {
        $callback = $this->callback;
        return $callback($task, $scheduler);
    }
}