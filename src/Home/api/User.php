<?php

/**
 * Created by YLL Co Inc.
 * User: NiZerin
 * Email: nzl199851@163.com
 * Blog: nizer.in
 * Date: 6/13/2020
 * Time: 1:34 PM
 * FileName: User.php
 */


namespace Src\Home\api;



use App\Controller\AbstractController;
use App\Model\UserModel;
use Src\Home\validated\UserLogin;
use Src\Home\validated\UserReg;

/**
 * 用户模块
 * Class User
 *
 * @package App\Controller\api
 */
class User extends AbstractController
{

    /**
     * 注册
     *
     * @param  \Src\Home\validated\UserReg  $userReg
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function reg(UserReg $userReg)
    {
        $data = $userReg->validated();
        $data['pwd'] = sha1($data['pwd']);

        try {
            UserModel::query()->create($data);
            return $this->response->json(data('注册成功'));
        } catch (\Exception $exception) {
            return $this->response->json(data($exception->getMessage()));
        }
    }

    /**
     * 登录
     *
     * @param  \Src\Home\validated\UserLogin  $userLogin
     */
    public function login(UserLogin $userLogin)
    {
        $data = $userLogin->validated();

        $userInfo = UserModel::query()->where('phone', $data['phone'])->first();

        if (sha1($data['pwd']) != $userInfo->pwd) {
            $this->response->json(data('密码错误'));
        }
    }
}