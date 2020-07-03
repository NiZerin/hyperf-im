<?php

/**
 * Created by YLL Co Inc.
 * User: NiZerin
 * Email: nzl199851@163.com
 * Blog: nizer.in
 * Date: 2020/7/1
 * Time: 17:49
 * FileName: GroupCreate.php
 */


namespace Src\Home\validated;


use App\Request\BaseRequest;

class GroupCreate extends BaseRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'name' => 'required|min:3|max:16',
            'cover' => 'required|url',
            'notice' => 'required',
            'desc' => 'required'
        ];
    }
}