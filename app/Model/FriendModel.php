<?php

/**
 * Created by YLL Co Inc.
 * User: NiZerin
 * Email: nzl199851@163.com
 * Blog: nizer.in
 * Date: 2020/7/1
 * Time: 15:04
 * FileName: FirendModel.php
 */


namespace App\Model;

/**
 * Class FriendModel
 *
 * @package App\Model
 */
class FriendModel extends Model
{
    protected $table = 'app_friend';

    protected $fillable = ['id', 'uid', 'friend_id', 'friend_group_id', 'created_at', 'updated_at', 'deleted_at'];
}