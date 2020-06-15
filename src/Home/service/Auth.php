<?php

/**
 * Created by YLL Co Inc.
 * User: NiZerin
 * Email: nzl199851@163.com
 * Blog: nizer.in
 * Date: 6/15/2020
 * Time: 11:07 AM
 * FileName: Auth.php
 */


namespace Src\Home\service;


use App\Model\UserModel;
use App\Tools\Jwt;

class Auth
{

    /**
     * 成 token
     * @param  object  $user
     *
     * @return string
     */
    public function makeToken(object $user): string
    {
        $data = [
            'user_id'   => $user->id,
            'code'      => $user->code,
            'exp_time'  => time() + 86400
        ];

        $token = Jwt::encode($data);

        $this->tokenToRides((string)$user->id, $token);

        return 'Bearer ' . $token;
    }

    /**
     * 检查 token
     * @param  string  $token
     *
     * @return bool
     */
    public function checkToken(string $token): bool
    {
        [, $token] = explode(' ', $token);

        $data = Jwt::decode($token);

        if (time() > $data['exp_time']) {
            return false;
        }

        $user = UserModel::query()->find($data->id);

        if (is_null($user)) {
            return false;
        }

        return true;
    }

    /**
     * @param  string  $userId
     * @param  string  $token
     *
     * @return int
     */
    protected function tokenToRides(string $userId, string $token): int
    {
        return redis()->hSet('user_token', $userId, $token);
    }

    /**
     * @param  int  $userId
     *
     * @return string
     */
    protected function tokenFromRides(int $userId): string
    {
        return redis()->hGet('user_token', $userId);
    }
}