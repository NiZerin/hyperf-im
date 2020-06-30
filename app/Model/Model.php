<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

namespace App\Model;

use Hyperf\Database\Model\SoftDeletes;
use Hyperf\DbConnection\Model\Model as BaseModel;
use Hyperf\ModelCache\Cacheable;
use Hyperf\ModelCache\CacheableInterface;

abstract class Model extends BaseModel implements CacheableInterface
{
    use Cacheable, SoftDeletes;

    /**
     * 自动写入时间戳
     * @var bool
     */
    public $timestamps = true;
    /**
     * 写入时间格式
     * @var string
     */
    protected $dateFormat = 'U';

    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';

    /**
     * 自增
     * @var bool
     */
    public $incrementing = true;

    /**
     * @var string[]
     */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * @param $value
     *
     * @return false|string
     */
    public function getUpdatedAtAttribute($value)
    {
        return $this -> getDateTime($value);
    }

    /**
     * @param $value
     *
     * @return false|string
     */
    public function getCreatedAtAttribute($value)
    {
        return $this -> getDateTime($value);
    }

    /**
     * @param $value
     *
     * @return false|string
     */
    protected function getDateTime($value)
    {
        if (is_string($value)) $value = strtotime($value);
        return date("Y-m-d H:i:s", $value);
    }
}
