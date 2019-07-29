<?php

namespace App\Model;



class LiveImInfo extends Model
{

    protected $fillable = [
        'id',
        'im_id',
        'im_name',
        'im_icon',
        'im_token',
        'im_sign',
        'im_type',
        'im_title',
        'im_email',
        'im_birth',
        'im_mobile',
        'im_status',
        'im_gender',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $datas = ['deleted_at'];


    // im_id
    public function setImIdAttribute($value)
    {
        if (empty($value)) {
            $this->attributes['im_id'] = '';
        } else {
            $this->attributes['im_id'] = $value;
        }
    }

    // im_name
    public function setImNameAttribute($value)
    {
        if (empty($value)) {
            $this->attributes['im_name'] = '';
        } else {
            $this->attributes['im_name'] = $value;
        }
    }

    // im_icon
    public function setImIconAttribute($value)
    {
        if (empty($value)) {
            $this->attributes['im_icon'] = '';
        } else {
            $this->attributes['im_icon'] = $value;
        }
    }

    // im_token
    public function setImTokenAttribute($value)
    {
        if (empty($value)) {
            $this->attributes['im_token'] = '';
        } else {
            $this->attributes['im_token'] = $value;
        }
    }

    // im_sign
    public function setImSignAttribute($value)
    {
        if (empty($value)) {
            $this->attributes['im_sign'] = '';
        } else {
            $this->attributes['im_sign'] = $value;
        }
    }

    // im_title
    public function setImTitleAttribute($value)
    {
        if (empty($value)) {
            $this->attributes['im_title'] = '';
        } else {
            $this->attributes['im_title'] = $value;
        }
    }

    // im_email
    public function setImEmailAttribute($value)
    {
        if (empty($value)) {
            $this->attributes['im_email'] = '';
        } else {
            $this->attributes['im_email'] = $value;
        }
    }

    // im_birth
    public function setImBirthAttribute($value)
    {
        if (empty($value)) {
            $this->attributes['im_birth'] = '';
        } else {
            $this->attributes['im_birth'] = $value;
        }
    }

    // im_mobile
    public function setImMobileAttribute($value)
    {
        if (empty($value)) {
            $this->attributes['im_mobile'] = '';
        } else {
            $this->attributes['im_mobile'] = $value;
        }
    }

    // im_status
    public function setImStatusAttribute($value)
    {
        if (empty($value)) {
            $this->attributes['im_status'] = '';
        } else {
            $this->attributes['im_status'] = $value;
        }
    }

    // im_type
    public function setImTypeAttribute($value)
    {
        if (empty($value)) {
            $this->attributes['im_type'] = 1;
        } else {
            $this->attributes['im_type'] = $value;
        }
    }

    // im_gender
    public function setImGenderAttribute($value)
    {
        if (empty($value)) {
            $this->attributes['im_gender'] = '';
        } else {
            $this->attributes['im_gender'] = $value;
        }
    }

    // created_by
    public function setCreatedByAttribute($value)
    {
        if (is_numeric($value)) {
            $this->attributes['created_by'] = $_SERVER['UID'] ?? 0;
        } else {
            $this->attributes['created_by'] = $_SERVER['UID'] ?? 0;
        }
    }

    // updated_by
    public function setUpdatedByAttribute($value)
    {
        if (is_numeric($value)) {
            $this->attributes['updated_by'] = $_SERVER['UID'] ?? 0;
        } else {
            $this->attributes['updated_by'] = $_SERVER['UID'] ?? 0;
        }
    }


}
