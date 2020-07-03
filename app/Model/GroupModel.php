<?php

/**
 * Created by YLL Co Inc.
 * User: NiZerin
 * Email: nzl199851@163.com
 * Blog: nizer.in
 * Date: 2020/7/2
 * Time: 14:07
 * FileName: GroupModel.php
 */


namespace App\Model;

/**
 * Class GroupModel
 *
 * @package App\Model
 */
class GroupModel extends Model
{
    protected $table = 'app_group';

    protected $fillable = ['id', 'uid', 'name', 'cover', 'notice', 'validation', 'size', 'desc', 'created_at', 'updated_at', 'deleted_at'];
}