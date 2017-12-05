<?php
/**
 * 协程任务封装类
 * @author SamDing
 */
namespace koboshi\tool\Coroutine;

class Task {
    /**
     * 任务ID
     * @var int
     */
    protected $taskId;

    /**
     * @var mixed
     */
    protected $sendData = null;

    /**
     * 协程(生成器)
     * @var \Generator
     */
    protected $coroutine;

    /**
     * @var bool
     */
    protected $beforeFirstYield = true;

    /**
     * Task constructor.
     * @param $taskId
     * @param \Generator $coroutine
     */
    public function __construct($taskId, \Generator $coroutine) {
        $this->taskId = intval($taskId);
        $this->coroutine = $coroutine;
    }

    /**
     * @return int
     */
    public function getTaskId() {
        return $this->taskId;
    }

    /**
     * 设置要发送给生成器的数据
     * @param mixed $data
     */
    public function setSendData($data) {
        $this->sendData = $data;
    }

    /**
     * 返回当前协程(生成器)时候已经执行完成
     * @return bool
     */
    public function isDone() {
        return !$this->coroutine->valid();
    }

    public function run() {
        if ($this->beforeFirstYield) {
            //生成器首次执行要调用current，不然会自动跳过第一个yield
            $this->beforeFirstYield = false;
            return $this->coroutine->current();
        }else {
            $res = $this->coroutine->send($this->sendData);
            $this->sendData = null;
            return $res;
        }
    }
}