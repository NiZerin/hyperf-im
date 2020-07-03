<?php

/**
 * Created by YLL Co Inc.
 * User: NiZerin
 * Email: nzl199851@163.com
 * Blog: nizer.in
 * Date: 2020/7/3
 * Time: 14:24
 * FileName: GroupJoin.php
 */


namespace Src\Home\validated;


use Hyperf\Validation\Request\FormRequest;

/**
 * Class GroupJoin
 *
 * @package Src\Home\validated
 */
class GroupJoin extends FormRequest
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
            'id' => 'required|exists:app_group,id'
        ];
    }
}