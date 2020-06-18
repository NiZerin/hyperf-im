<?php

/**
 * Created by YLL Co Inc.
 * User: NiZerin
 * Email: nzl199851@163.com
 * Blog: nizer.in
 * Date: 6/13/2020
 * Time: 3:47 PM
 * FileName: UserReg.php
 */


namespace Src\Home\validated;



use App\Request\BaseRequest;

class UserReg extends BaseRequest
{

    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|alpha_dash|min:3|max:16',
            'pwd' => 'required|alpha_dash|min:6|max:16|confirmed',
            'pwd_confirmation ' => 'alpha_dash|min:6|max:16',
            'phone' => 'required|digits:11|unique:app_users,phone',
        ];
    }
}