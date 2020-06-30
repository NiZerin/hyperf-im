<?php

/**
 * Created by YLL Co Inc.
 * User: NiZerin
 * Email: nzl199851@163.com
 * Blog: nizer.in
 * Date: 2020/6/30
 * Time: 14:30
 * FileName: FriendChatLogModel.php
 */


namespace App\Model;


class FriendChatLogModel extends Model
{
    protected $table = 'app_friend_chat_log';
    protected $fillable = [
            'id', 'from_uid', 'target_uid', 'msg_id', 'msg_body', 'msg_time', 'msg_type', 'created_at', 'updated_at', 'deleted_at'
        ];
}