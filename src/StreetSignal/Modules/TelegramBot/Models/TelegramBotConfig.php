<?php

namespace StreetSignal\Modules\TelegramBot\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use StreetSignal\Modules\V5\Models\Survey\Survey;

class TelegramBotConfig extends Model
{
    protected $table = 'telegram_bot_config';

    protected $fillable = [
        'bot_token',
        'webhook_url',
        'is_enabled',
        'default_survey_id',
        'settings'
    ];

    protected $casts = [
        'is_enabled' => 'boolean',
        'settings' => 'array'
    ];

    protected $hidden = [
        'bot_token'
    ];

    /**
     * Get the default survey for the bot
     */
    public function defaultSurvey(): BelongsTo
    {
        return $this->belongsTo(Survey::class, 'default_survey_id');
    }

    /**
     * Get a setting value
     */
    public function getSetting(string $key, $default = null)
    {
        return data_get($this->settings, $key, $default);
    }

    /**
     * Set a setting value
     */
    public function setSetting(string $key, $value): void
    {
        $settings = $this->settings ?? [];
        data_set($settings, $key, $value);
        $this->settings = $settings;
    }
}