<?php

/**
 * Created by YLL Co Inc.
 * User: NiZerin
 * Email: nzl199851@163.com
 * Blog: nizer.in
 * Date: 2020/7/1
 * Time: 15:12
 * FileName: FriendGroupModel.php
 */


namespace App\Model;

/**
 * Class FriendGroupModel
 *
 * @package App\Model
 */
class FriendGroupModel extends Model
{
    protected $table = 'app_friend_group';

    protected $fillable = ['id', 'uid', 'name', 'type', 'created_at', 'updated_at', 'deleted_at'];
}