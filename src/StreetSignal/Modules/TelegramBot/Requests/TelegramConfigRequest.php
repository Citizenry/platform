<?php

namespace StreetSignal\Modules\TelegramBot\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TelegramConfigRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Authorization handled by middleware
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'bot_token' => 'sometimes|string|regex:/^\d+:[A-Za-z0-9_-]+$/',
            'webhook_url' => 'sometimes|nullable|url',
            'is_enabled' => 'sometimes|boolean',
            'default_survey_id' => 'sometimes|nullable|integer|exists:forms,id',
            'settings' => 'sometimes|array',
            'settings.welcome_message' => 'sometimes|string|max:1000',
            'settings.help_message' => 'sometimes|string|max:1000',
            'settings.auto_publish' => 'sometimes|boolean',
            'settings.require_location' => 'sometimes|boolean',
            'settings.max_media_files' => 'sometimes|integer|min:0|max:10'
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'bot_token.regex' => 'The bot token format is invalid. It should be in format: 123456789:ABC-DEF1234ghIkl-zyx57W2v1u123ew11',
            'default_survey_id.exists' => 'The selected survey does not exist.',
            'settings.welcome_message.max' => 'The welcome message may not be greater than 1000 characters.',
            'settings.help_message.max' => 'The help message may not be greater than 1000 characters.',
            'settings.max_media_files.max' => 'Maximum media files cannot exceed 10.'
        ];
    }
}