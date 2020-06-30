<?php

/**
 * Created by YLL Co Inc.
 * User: NiZerin
 * Email: nzl199851@163.com
 * Blog: nizer.in
 * Date: 2020/6/30
 * Time: 15:53
 * FileName: Oss.php
 */


namespace App\Tools;


use OSS\OssClient;

class Oss
{
    protected $accessKeyId;
    protected $accessKeySecret;
    protected $endpoint;
    protected $bucket;
    /** @var OssClient  */
    protected $client;

    public function __construct()
    {
        $this->accessKeyId      = env('OSS_ACCESS_KEY_ID');
        $this->accessKeySecret  = env('OSS_ACCESS_KEY_SECRET');
        $this->bucket           = env('OSS_BUCKET');
        $this->endpoint         = env('OSS_ENDPOINT');
        $this->client           = new OssClient($this->accessKeyId, $this->accessKeySecret, $this->endpoint);
    }

    public function upload($object, $content)
    {
        $this->client->putObject($this->bucket, $object, $content);
    }
}