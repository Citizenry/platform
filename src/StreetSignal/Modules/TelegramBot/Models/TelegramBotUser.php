<?php

namespace StreetSignal\Modules\TelegramBot\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use StreetSignal\Modules\V5\Models\User\User;

class TelegramBotUser extends Model
{
    protected $table = 'telegram_bot_users';

    protected $fillable = [
        'telegram_user_id',
        'telegram_username',
        'user_id',
        'authentication_type',
        'oauth_token'
    ];

    protected $casts = [
        'telegram_user_id' => 'integer'
    ];

    protected $hidden = [
        'oauth_token'
    ];

    const AUTHENTICATION_ANONYMOUS = 'anonymous';
    const AUTHENTICATION_AUTHENTICATED = 'authenticated';

    /**
     * Get the linked StreetSignal user
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the user's conversations
     */
    public function conversations(): HasMany
    {
        return $this->hasMany(TelegramConversation::class, 'telegram_user_id', 'telegram_user_id');
    }

    /**
     * Check if user is authenticated
     */
    public function isAuthenticated(): bool
    {
        return $this->authentication_type === self::AUTHENTICATION_AUTHENTICATED && $this->user_id !== null;
    }

    /**
     * Check if user is anonymous
     */
    public function isAnonymous(): bool
    {
        return $this->authentication_type === self::AUTHENTICATION_ANONYMOUS;
    }

    /**
     * Link user to StreetSignal account
     */
    public function linkAccount(int $userId, string $oauthToken): void
    {
        $this->user_id = $userId;
        $this->oauth_token = $oauthToken;
        $this->authentication_type = self::AUTHENTICATION_AUTHENTICATED;
        $this->save();
    }

    /**
     * Unlink user from StreetSignal account
     */
    public function unlinkAccount(): void
    {
        $this->user_id = null;
        $this->oauth_token = null;
        $this->authentication_type = self::AUTHENTICATION_ANONYMOUS;
        $this->save();
    }

    /**
     * Find or create telegram bot user
     */
    public static function findOrCreateByTelegramId(int $telegramUserId, ?string $username = null): self
    {
        return static::firstOrCreate(
            ['telegram_user_id' => $telegramUserId],
            [
                'telegram_username' => $username,
                'authentication_type' => self::AUTHENTICATION_ANONYMOUS
            ]
        );
    }
}