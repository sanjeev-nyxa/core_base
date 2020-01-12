<?php

namespace Labs\Core\Entities;
use Illuminate\Support\Facades\Cache;

/**
 * Class Config
 * @package Labs\Core\Entities
 */
class Config extends BaseModel
{

    /**
     * @var array
     */
    protected $fillable = ['value', 'key', 'group'];

    /**
     * @return mixed
     */
    public static function loadConfigs()
    {
        return Cache::rememberForever('app_configs', function () {
            return self::all()->pluck('value', 'key');
        });
    }
}
