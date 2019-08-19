<?php

namespace App\Model;


class LiveImRoom extends Model
{

    protected $fillable = [
        'id',
        'room_id',
        'room_ow',
        'room_admin',
        'room_name',
        'room_type',
        'room_tips',
        'room_cover',
        'course_id',
        'media_id',
        'room_block',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
        'deleted_at'
    ];


    // room_id
    public function setRoomIdAttribute($value)
    {
        if (empty($value)) {
            $this->attributes['room_id'] = '';
        } else {
            $this->attributes['room_id'] = $value;
        }
    }

    // room_ow
    public function setRoomOwAttribute($value)
    {
        if (empty($value)) {
            $this->attributes['room_ow'] = '';
        } else {
            $this->attributes['room_ow'] = $value;
        }
    }

    // room_admin
    public function setRoomAdminAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['room_admin'] = json_encode($value, 256);
        } else {
            $this->attributes['room_admin'] = $value;
        }
    }

    // room_name
    public function setRoomNameAttribute($value)
    {
        if (empty($value)) {
            $this->attributes['room_name'] = '';
        } else {
            $this->attributes['room_name'] = $value;
        }
    }

    // room_tips
    public function setRoomTipsAttribute($value)
    {
        if (empty($value)) {
            $this->attributes['room_tips'] = '';
        } else {
            $this->attributes['room_tips'] = $value;
        }
    }

    // room_cover
    public function setRoomCoverAttribute($value)
    {
        if (empty($value)) {
            $this->attributes['room_cover'] = '';
        } else {
            $this->attributes['room_cover'] = $value;
        }
    }

    // room_block
    public function setRoomBlockAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['room_block'] = json_encode($value, 256);
        } else {
            $this->attributes['room_block'] = $value ?? '';
        }
    }

    // room_type
    public function setRoomTypeAttribute($value)
    {
        if (is_numeric($value)) {
            $this->attributes['room_type'] = $value;
        } else {
            $this->attributes['room_type'] = 2;
        }
    }

    // media_id
    public function setMediaIdAttribute($value)
    {
        if (empty($value)) {
            $this->attributes['media_id'] = '';
        } else {
            $this->attributes['media_id'] = $value;
        }
    }

    // course_id
    public function setCourseIdAttribute($value)
    {
        if (empty($value)) {
            $this->attributes['course_id'] = '';
        } else {
            $this->attributes['course_id'] = $value;
        }
    }


    public function getRoomAdminAttribute($value)
    {
        if (is_null($value)) {
            return $value;
        } else {
            return json_decode($value, true);
        }
    }

    public function getRoomBlockAttribute($value)
    {
        if (is_null($value)) {
            return $value;
        } else {
            return json_decode($value, true);
        }
    }

}
