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

        $this->tokenToRedis((string)$user->id, $token);

        return 'Bearer ' . $token;
    }

    /**
     * 检查 token
     *
     * @param  string  $bearerToken
     *
     * @return false|\Hyperf\Database\Model\Builder|\Hyperf\Database\Model\Builder[]|\Hyperf\Database\Model\Collection|\Hyperf\Database\Model\Model
     */
    public function checkToken(string $bearerToken)
    {
        if (is_int(strpos($bearerToken, 'Bearer'))) {
            [, $token] = explode(' ', $bearerToken);
        } else {
            return false;
        }

        if (is_null($token)) {
            return false;
        }

        try {
            $data = Jwt::decode($token);
        } catch (\Exception $exception) {
            return false;
        }

        if (time() > $data->exp_time) {
            return false;
        }

        $user = UserModel::query()->find($data->user_id);

        if (is_null($user)) {
            return false;
        } else {
            return $user;
        }
    }

    /**
     * @param  string  $userId
     * @param  string  $token
     *
     * @return void
     */
    public function tokenToRedis(string $userId, string $token): void
    {
        redis()->hSet('user_token', $userId, $token);
    }

    /**
     * @param  int  $userId
     *
     * @return string
     */
    public function tokenFromRedis(int $userId): string
    {
        return redis()->hGet('user_token', $userId);
    }
}