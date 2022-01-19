<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public static function getByName($name,$default = null)
    {
        $setting = self::where('name',$name)->first();
        if(isset($setting))
        {
            return $setting->value ;
        }
        else
        {
            return $default ;
        }
    }


     /**
     * Set a value for setting
     *
     * @param $key
     * @param $value
     * @return bool
     */
    public static function set($key, $value)
    {
        if ($setting = self::getAllSettings()->where('name', $key)->first()) {
            return $setting->update([
                'name' => $key,
                'value' => $value]) ? $value : false;
        }
        return self::add($key, $value);
    }
}
