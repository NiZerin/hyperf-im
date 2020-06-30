<?php

/**
 * Created by YLL Co Inc.
 * User: NiZerin
 * Email: nzl199851@163.com
 * Blog: nizer.in
 * Date: 2020/6/30
 * Time: 15:17
 * FileName: Tools.php
 */


namespace Src\Home\api;


use App\Controller\AbstractController;
use App\Tools\Oss;
use Hyperf\HttpMessage\Upload\UploadedFile;

/**
 * Class Tools
 *
 * @package Src\Home\api
 */
class Tools extends AbstractController
{
    /**
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function uploadImg()
    {
        $file = $this->request->file('image');

        if (empty($file)) {
            return $this->response->json(data('please upload image'));
        }

        return $this->saveOss($file, 5);
    }

    /**
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function uploadFile()
    {
        $file = $this->request->file('file');

        if (empty($file)) {
            return $this->response->json(data('please upload file'));
        }

        return $this->saveOss($file, 50);
    }

    /**
     * @param $file null|UploadedFile|UploadedFile[]
     *
     * @param  int  $size
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function saveOss($file, int $size)
    {
        $fileSize = $file->getSize();

        if ($fileSize / 1024 / 1024 > $size) {
            return $this->response->json(data('file size too max, only 5 mb'));
        }

        $content = $file->getStream()->getContents();

        $extName = $file->getExtension();

        $fileName = 'image/' . date('Ymd') . '/' . time() . rand(1000, 9999) . '.' .$extName;

        try {
            (new Oss())->upload($fileName, $content);
            return $this->response->json(data('upload success', 0, ['url' => env('OSS_URL') . $fileName]));
        } catch (\Exception $exception) {
            return $this->response->json(data('upload failed, please try again'));
        }
    }
}