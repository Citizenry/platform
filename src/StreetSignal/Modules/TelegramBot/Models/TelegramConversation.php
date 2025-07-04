<?php

namespace StreetSignal\Modules\TelegramBot\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class TelegramConversation extends Model
{
    protected $table = 'telegram_conversations';

    protected $fillable = [
        'telegram_user_id',
        'conversation_state',
        'expires_at'
    ];

    protected $casts = [
        'telegram_user_id' => 'integer',
        'conversation_state' => 'array',
        'expires_at' => 'datetime'
    ];

    const DEFAULT_EXPIRY_HOURS = 24;

    /**
     * Get the telegram bot user
     */
    public function telegramUser(): BelongsTo
    {
        return $this->belongsTo(TelegramBotUser::class, 'telegram_user_id', 'telegram_user_id');
    }

    /**
     * Check if conversation is expired
     */
    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }

    /**
     * Extend conversation expiry
     */
    public function extendExpiry(int $hours = self::DEFAULT_EXPIRY_HOURS): void
    {
        $this->expires_at = Carbon::now()->addHours($hours);
        $this->save();
    }

    /**
     * Get conversation state value
     */
    public function getState(string $key, $default = null)
    {
        return data_get($this->conversation_state, $key, $default);
    }

    /**
     * Set conversation state value
     */
    public function setState(string $key, $value): void
    {
        $state = $this->conversation_state ?? [];
        data_set($state, $key, $value);
        $this->conversation_state = $state;
    }

    /**
     * Update conversation state
     */
    public function updateState(array $updates): void
    {
        $state = $this->conversation_state ?? [];
        $this->conversation_state = array_merge($state, $updates);
        $this->extendExpiry();
        $this->save();
    }

    /**
     * Clear conversation state
     */
    public function clearState(): void
    {
        $this->conversation_state = [];
        $this->save();
    }

    /**
     * Find or create active conversation
     */
    public static function findOrCreateActive(int $telegramUserId): self
    {
        // Clean up expired conversations first
        static::where('expires_at', '<', Carbon::now())->delete();

        // Find existing active conversation
        $conversation = static::where('telegram_user_id', $telegramUserId)
            ->where('expires_at', '>', Carbon::now())
            ->first();

        if ($conversation) {
            $conversation->extendExpiry();
            return $conversation;
        }

        // Create new conversation
        return static::create([
            'telegram_user_id' => $telegramUserId,
            'conversation_state' => [],
            'expires_at' => Carbon::now()->addHours(self::DEFAULT_EXPIRY_HOURS)
        ]);
    }

    /**
     * Scope for active conversations
     */
    public function scopeActive($query)
    {
        return $query->where('expires_at', '>', Carbon::now());
    }

    /**
     * Scope for expired conversations
     */
    public function scopeExpired($query)
    {
        return $query->where('expires_at', '<=', Carbon::now());
    }
}