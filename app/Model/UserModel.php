<?php

/**
 * Created by YLL Co Inc.
 * User: NiZerin
 * Email: nzl199851@163.com
 * Blog: nizer.in
 * Date: 6/13/2020
 * Time: 1:47 PM
 * FileName: UserModel.php
 */


namespace App\Model;


/**
 * Class UserModel
 *
 * @package App\Model
 */
class UserModel extends Model
{

    protected $table = 'app_users';
    protected $fillable = ['id', 'name', 'pwd', 'code', 'sex', 'addr', 'intro', 'phone', 'cover',];

}