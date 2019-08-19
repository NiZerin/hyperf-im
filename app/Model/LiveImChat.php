<?php

namespace App\Model;


class LiveImChat extends Model
{

    public $table = 'live_im_chats';

    protected $fillable = [
        'id',
        'im_id',
        'to_im_id',
        'to_type',
        'from_type',
        'from_im_id',
        'msg_content',
        'msg_id',
        'msg_type',
        'msg_time',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    // im_id

    public function setImIdAttribute($value)
    {
        if (empty($value)) {
            $this->attributes['im_id'] = '';
        } else {
            $this->attributes['im_id'] = $value;
        }
    }

    // to_im_id
    public function setToImIdAttribute($value)
    {
        if (empty($value)) {
            $this->attributes['to_im_id'] = '';
        } else {
            $this->attributes['to_im_id'] = $value;
        }
    }

    // to_type
    public function setToTypeAttribute($value)
    {
        if (empty($value)) {
            $this->attributes['to_type'] = $value;
        } else {
            $this->attributes['to_type'] = $value;
        }
    }

    // from_im_id
    public function setFromImIdAttribute($value)
    {
        if (empty($value)) {
            $this->attributes['from_im_id'] = '';
        } else {
            $this->attributes['from_im_id'] = $value;
        }
    }

    // msg_content
    public function setMsgContentAttribute($value)
    {
        if (empty($value)) {
            $this->attributes['msg_content'] = '';
        } else {
            $this->attributes['msg_content'] = $value;
        }
    }

    // msg_id
    public function setMsgIdAttribute($value)
    {
        if (empty($value)) {
            $this->attributes['msg_id'] = '';
        } else {
            $this->attributes['msg_id'] = $value;
        }
    }

    // msg_type
    public function setMsgTypeAttribute($value)
    {
        if (empty($value)) {
            $this->attributes['msg_type'] = '';
        } else {
            $this->attributes['msg_type'] = $value;
        }
    }

    // msg_time
    public function setMsgTimeAttribute($value)
    {
        if (empty($value)) {
            $this->attributes['msg_time'] = '';
        } else {
            $this->attributes['msg_time'] = $value;
        }
    }


}
