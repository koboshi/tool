<?php
/**
 * Htt客户端工具类
 * 基于CURL
 * @author SamDing
 */
namespace koboshi\Tool;

class HttpClient
{
    private $config = array();

    public static function simpleGet()
    {

    }

    public static function simpleMultiGet()
    {

    }

    public static function simplePost()
    {

    }

    public static function simpleMultiPost()
    {

    }

    public function __construct($url = null)
    {
        if (!empty($url)) {
            $this->config['url'] = trim($url);
        }
    }

    public function url($url)
    {
        $this->config['url'] = trim($url);
    }

    public function auth()
    {

    }

    public function userAgent()
    {

    }

    public function headers()
    {

    }

    public function proxy()
    {

    }

    public function cookie()
    {

    }

    public function timeout()
    {

    }

    public function connectionTimeout()
    {

    }

    public function method()
    {

    }

    public function request()
    {

    }

    public function download(callable $callback, $size = 1024)
    {

    }
}