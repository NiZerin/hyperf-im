<?php

/**
 * Created by YLL Co Inc.
 * User: NiZerin
 * Email: nzl199851@163.com
 * Blog: nizer.in
 * Date: 2020/7/2
 * Time: 14:12
 * FileName: UserGroupModel.php
 */


namespace App\Model;

/**
 * Class UserGroupModel
 *
 * @package App\Model
 */
class UserGroupModel extends Model
{
    protected $table = 'app_group_user';

    protected $fillable = ['id', 'uid', 'group_id', 'created_at', 'updated_at', 'deleted_at'];
}