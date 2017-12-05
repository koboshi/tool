<?php
/**
 * 分布式锁
 * 基于redis
 * @author SamDing
 */
namespace koboshi\tool\Redis;

class DistributedLock
{

    /**
     * redis连接
     * @var \Redis
     */
    private $redis;

    /**
     * DistributedLock constructor.
     * @param $host
     * @param $port
     * @param int $db
     */
    public function __construct($host, $port, $db = 0)
    {
        $this->redis = new \Redis($host, $port);
        $this->redis->select($db);
    }

    /**
     * 加锁
     * @param $name
     * @param int $duration
     * @return bool|mixed
     */
    public function lock($name, $duration = 60)
    {
        $microTime = microtime(false);
        $flag = $this->redis->setnx($name, $microTime);
        if ($flag) {
            return $microTime;//成功获得锁
        }
        //获取当前锁的数值
        $lockVal = $this->redis->get($name);
        //检查锁是否已经超时
        if ($lockVal + $duration * 1000 > $microTime) {
            //已经锁定了60秒，超时了,获取锁
            $oldVal = $this->redis->getSet($name, $microTime);
            if ($oldVal == $lockVal) {
                //前后旧锁值一致，获得锁成功
                return $microTime;
            }
        }
        //获得锁失败
        return false;
    }

    /**
     * 释放锁
     * @param $name
     */
    public function release($name)
    {
        $this->redis->del($name);
    }
}