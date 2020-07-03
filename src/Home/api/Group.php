<?php

/**
 * Created by YLL Co Inc.
 * User: NiZerin
 * Email: nzl199851@163.com
 * Blog: nizer.in
 * Date: 2020/7/1
 * Time: 16:01
 * FileName: Group.php
 */


namespace Src\Home\api;


use App\Controller\AbstractController;
use Src\Home\validated\GroupCreate;
use Src\Home\validated\GroupJoin;
use Src\Home\service\Group as GroupService;

/**
 * Class Group
 *
 * @package Src\Home\api
 */
class Group extends AbstractController
{
    /**
     * @param  GroupCreate  $groupCreate
     */
    public function create(GroupCreate $groupCreate)
    {
        $data = $groupCreate->validated();
        $user = $this->request->getAttribute('user');
        $data['uid'] = $user->id;

        try {
            GroupService::create($data, $user);
            return $this->response->json(data('create success'));
        } catch (\Exception $exception) {
            return $this->response->json(data($exception->getMessage()));
        }
    }

    /**
     * @param  GroupJoin  $groupJoin
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function join(GroupJoin $groupJoin)
    {
        $data = $groupJoin->validated();
        $user = $this->request->getAttribute('user');

        try {
            GroupService::join($data, $user);
            return $this->response->json(data('join success'));
        } catch (\Exception $exception) {
            return $this->response->json(data($exception->getMessage()));
        }
    }
}