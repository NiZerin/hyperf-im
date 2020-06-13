<?php

/**
 * Created by YLL Co Inc.
 * User: NiZerin
 * Email: nzl199851@163.com
 * Blog: nizer.in
 * Date: 6/13/2020
 * Time: 5:55 PM
 * FileName: UserLogin.php
 */


namespace Src\Home\validated;


use App\Request\FooRequest;

class UserLogin extends FooRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'phone' => 'required|digits:11|exists:app_users,phone',
            'pwd' => 'required|alpha_dash|min:6|max:16',
        ];
    }

}