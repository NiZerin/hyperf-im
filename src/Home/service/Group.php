<?php

/**
 * Created by YLL Co Inc.
 * User: NiZerin
 * Email: nzl199851@163.com
 * Blog: nizer.in
 * Date: 2020/7/1
 * Time: 17:48
 * FileName: Group.php
 */


namespace Src\Home\service;


use App\Model\GroupModel;
use App\Model\UserGroupModel;

/**
 * Class Group
 *
 * @package Src\Home\service
 */
class Group
{
    /**
     * @param  array  $data
     * @param  object  $user
     *
     * @throws \Exception
     */
    public static function create(array $data, object $user)
    {
        try {
            $group = GroupModel::query()->create($data);
            UserGroupModel::query()->create(['uid' => $user->id, 'group_id' => $group->id]);
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    /**
     * @param  array  $data
     * @param  object  $user
     *
     * @throws \Exception
     */
    public static function join(array $data, object $user)
    {
        $check = UserGroupModel::query()
            ->where('uid', $user['id'])
            ->where('group_id', $data['id'])
            ->first();

        if (!is_null($check)) {
            throw new \Exception('You are already a member of the group.');
        }

        try {
            UserGroupModel::query()->create(['uid' => $user->id, 'group_id' => $data['id']]);
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }
}