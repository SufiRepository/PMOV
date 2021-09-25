<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use App\Models\SnipeModel;
use DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Parsedown;
use Watson\Validating\ValidatingTrait;

/**
 * Settings model.
 */
class EmailSetting extends SnipeModel
{
    /**
    * The database table used by the model.
    *
    * @var string
    */
    protected $table = 'emails';
    protected $guarded = 'id';

    /**
     * Whether the model should inject it's identifier to the unique
     * validation rules before attempting validation. If this property
     * is not set in the model it will default to true.
     *
     * @var bool
     */
    protected $injectUniqueIdentifier = true;

    /**
     * Model rules.
     *
     * @var array
     */
    protected $rules = [
        'env_email'                                => 'email|nullable',
        'env_password'                             => 'string|nullable',
        'env_name'                                 => 'min:2|max:255|string|nullable',
        'env_driver'                               => 'string|nullable',
        'env_host'                                 => 'string|nullable',
        'env_port'                                 => 'integer|nullable',
        'env_mailfromaddr'                         => 'string|nullable',
        'env_replytoaddr'                          => 'string|nullable',
        'env_replytoname'                          => 'string|nullable',
    ];

    protected $fillable = [
        'env_email',
        'env_password',
        'env_name',
        'env_driver',
        'env_host',
        'env_port',
        'env_mailfromaddr',
        'env_replytoaddr',
        'env_replytoname',
    ];

    public static function getSettings(): ?EmailSetting
    {
        return Cache::rememberForever(self::APP_SETTINGS_KEY, function () {
            // Need for setup as no tables exist
            try {
                return self::first();
            } catch (\Throwable $th) {
                return null;
            }
        });
        }

}
