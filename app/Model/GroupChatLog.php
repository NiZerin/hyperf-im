<?php
/**
 * Created by anlingxinxi INC.
 * User : Crazy_Ning
 * Date : 8/11/2020
 * Time : 5:15 PM
 * Email: nzl199851@163.com
 * Blog : nizer.in
 * FileName: GroupChatLog.php
 */


namespace App\Model;

/**
 * Class GroupChatLog
 * @package App\Model
 */
class GroupChatLog extends Model
{
    protected $table = 'app_group_chat_log';

    protected $fillable = [
        'id', 'from_uid', 'target_gid', 'msg_id', 'msg_time', 'msg_type', 'msg_status', 'msg_body', 'created_at', 'updated_at', 'deleted_at'
    ];
}