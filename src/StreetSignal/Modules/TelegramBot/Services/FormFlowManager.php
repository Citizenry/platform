<?php

namespace StreetSignal\Modules\TelegramBot\Services;

use StreetSignal\Modules\TelegramBot\Models\TelegramBotUser;
use StreetSignal\Modules\TelegramBot\Models\TelegramConversation;
use StreetSignal\Modules\TelegramBot\Models\TelegramBotConfig;
use StreetSignal\Modules\V5\Models\Survey\Survey;
use TelegramBot\Api\Types\Message;
use TelegramBot\Api\Types\Inline\InlineKeyboardMarkup;
use TelegramBot\Api\Types\Inline\InlineKeyboardButton;
use Illuminate\Support\Facades\Log;

class FormFlowManager
{
    protected $botService;
    protected ConversationManager $conversationManager;
    protected StreetSignalApiClient $apiClient;

    public function __construct(ConversationManager $conversationManager, StreetSignalApiClient $apiClient)
    {
        $this->conversationManager = $conversationManager;
        $this->apiClient = $apiClient;
    }

    /**
     * Set the bot service (called from service provider)
     */
    public function setBotService(TelegramBotService $botService): void
    {
        $this->botService = $botService;
    }

    /**
     * Start the report submission flow
     */
    public function startReportFlow(int $chatId, TelegramBotUser $botUser, TelegramConversation $conversation): void
    {
        $config = TelegramBotConfig::first();
        
        // If there's a default survey, use it directly
        if ($config && $config->default_survey_id) {
            $this->selectSurvey($chatId, $config->default_survey_id, $botUser, $conversation);
            return;
        }

        // Otherwise, show available surveys
        $this->showAvailableSurveys($chatId, $botUser, $conversation);
    }

    /**
     * Show available surveys for selection
     */
    public function showAvailableSurveys(int $chatId, TelegramBotUser $botUser, TelegramConversation $conversation): void
    {
        try {
            $surveys = $this->apiClient->getSurveys();
            
            if (empty($surveys)) {
                $this->botService->sendMessage($chatId, "No report types are currently available. Please try again later.");
                return;
            }

            $conversation->updateState([
                'current_state' => 'awaiting_survey_selection',
                'available_surveys' => $surveys
            ]);

            // Create inline keyboard with survey options
            $buttons = [];
            foreach ($surveys as $survey) {
                $buttons[] = [new InlineKeyboardButton($survey['name'], null, "survey_{$survey['id']}")];
            }

            $keyboard = new InlineKeyboardMarkup($buttons);

            $message = "📋 Select a report type:\n\n" .
                      "Choose the type of report you'd like to submit:";

            $this->botService->sendMessage($chatId, $message, $keyboard);

        } catch (\Exception $e) {
            Log::error('Failed to fetch surveys for Telegram bot', [
                'error' => $e->getMessage(),
                'chat_id' => $chatId
            ]);

            $this->botService->sendMessage($chatId, "Sorry, I couldn't load the available report types. Please try again later.");
        }
    }

    /**
     * Select a survey and start form collection
     */
    public function selectSurvey(int $chatId, int $surveyId, TelegramBotUser $botUser, TelegramConversation $conversation): void
    {
        try {
            $survey = $this->apiClient->getSurvey($surveyId);
            
            if (!$survey) {
                $this->botService->sendMessage($chatId, "Sorry, that report type is not available.");
                return;
            }

            $conversation->updateState([
                'current_state' => 'collecting_form_data',
                'selected_survey' => $survey,
                'form_data' => [],
                'current_field_index' => 0
            ]);

            $this->botService->sendMessage($chatId, 
                "📝 Starting: {$survey['name']}\n\n" .
                "{$survey['description']}\n\n" .
                "I'll guide you through the submission process. Type 'cancel' at any time to stop."
            );

            // Start collecting form data
            $this->collectNextField($chatId, $botUser, $conversation);

        } catch (\Exception $e) {
            Log::error('Failed to select survey for Telegram bot', [
                'error' => $e->getMessage(),
                'survey_id' => $surveyId,
                'chat_id' => $chatId
            ]);

            $this->botService->sendMessage($chatId, "Sorry, I couldn't load that report type. Please try again.");
        }
    }

    /**
     * Collect the next form field
     */
    protected function collectNextField(int $chatId, TelegramBotUser $botUser, TelegramConversation $conversation): void
    {
        $survey = $conversation->getState('selected_survey');
        $currentFieldIndex = $conversation->getState('current_field_index', 0);
        $fields = $survey['fields'] ?? [];

        // Check if we've collected all fields
        if ($currentFieldIndex >= count($fields)) {
            $this->showSubmissionPreview($chatId, $botUser, $conversation);
            return;
        }

        $field = $fields[$currentFieldIndex];
        $this->promptForField($chatId, $field, $conversation);
    }

    /**
     * Prompt user for a specific field
     */
    protected function promptForField(int $chatId, array $field, TelegramConversation $conversation): void
    {
        $fieldType = $field['type'] ?? 'text';
        $fieldLabel = $field['label'] ?? 'Field';
        $isRequired = $field['required'] ?? false;
        $requiredText = $isRequired ? ' (required)' : ' (optional)';

        $message = "📝 {$fieldLabel}{$requiredText}\n\n";

        switch ($fieldType) {
            case 'text':
            case 'textarea':
                $message .= "Please enter your response:";
                break;
                
            case 'location':
                $message .= "Please share your location or enter an address:";
                break;
                
            case 'photo':
                $message .= "Please send a photo:";
                break;
                
            case 'select':
                $options = $field['options'] ?? [];
                $message .= "Please choose one of the following options:\n\n";
                foreach ($options as $index => $option) {
                    $message .= ($index + 1) . ". {$option['label']}\n";
                }
                $message .= "\nReply with the number of your choice.";
                break;
                
            case 'date':
                $message .= "Please enter a date (YYYY-MM-DD format):";
                break;
                
            default:
                $message .= "Please enter your response:";
        }

        if (!$isRequired) {
            $message .= "\n\nType 'skip' to leave this field empty.";
        }

        $this->botService->sendMessage($chatId, $message);
    }

    /**
     * Handle form input from user
     */
    public function handleFormInput(int $chatId, Message $message, TelegramBotUser $botUser, TelegramConversation $conversation): void
    {
        $text = trim($message->getText());
        
        if (strtolower($text) === 'cancel') {
            $conversation->clearState();
            $this->botService->sendMessage($chatId, "Report submission cancelled.");
            return;
        }

        $survey = $conversation->getState('selected_survey');
        $currentFieldIndex = $conversation->getState('current_field_index', 0);
        $formData = $conversation->getState('form_data', []);
        $fields = $survey['fields'] ?? [];

        if ($currentFieldIndex >= count($fields)) {
            $this->botService->sendMessage($chatId, "Form submission is complete. Please use the confirmation buttons.");
            return;
        }

        $field = $fields[$currentFieldIndex];
        $fieldKey = $field['key'] ?? "field_{$currentFieldIndex}";

        // Handle skip for optional fields
        if (strtolower($text) === 'skip' && !($field['required'] ?? false)) {
            $formData[$fieldKey] = null;
        } else {
            // Validate and process the input
            $processedValue = $this->processFieldInput($message, $field);
            
            if ($processedValue === false) {
                $this->botService->sendMessage($chatId, "Invalid input. Please try again.");
                return;
            }
            
            $formData[$fieldKey] = $processedValue;
        }

        // Update conversation state
        $conversation->updateState([
            'form_data' => $formData,
            'current_field_index' => $currentFieldIndex + 1
        ]);

        // Collect next field or show preview
        $this->collectNextField($chatId, $botUser, $conversation);
    }

    /**
     * Process field input based on field type
     */
    protected function processFieldInput(Message $message, array $field)
    {
        $fieldType = $field['type'] ?? 'text';
        $text = trim($message->getText());

        switch ($fieldType) {
            case 'text':
            case 'textarea':
                return $text;
                
            case 'location':
                if ($message->getLocation()) {
                    return [
                        'lat' => $message->getLocation()->getLatitude(),
                        'lon' => $message->getLocation()->getLongitude()
                    ];
                }
                // Try to parse as address
                return $text;
                
            case 'photo':
                if ($message->getPhoto()) {
                    // Handle photo upload
                    return $this->handlePhotoUpload($message);
                }
                return false;
                
            case 'select':
                $options = $field['options'] ?? [];
                $choice = (int) $text - 1;
                if ($choice >= 0 && $choice < count($options)) {
                    return $options[$choice]['value'] ?? $options[$choice]['label'];
                }
                return false;
                
            case 'date':
                if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $text)) {
                    return $text;
                }
                return false;
                
            default:
                return $text;
        }
    }

    /**
     * Handle photo upload
     */
    protected function handlePhotoUpload(Message $message): ?array
    {
        try {
            $photos = $message->getPhoto();
            if (empty($photos)) {
                return null;
            }

            // Get the largest photo
            $photo = end($photos);
            $fileId = $photo->getFileId();

            // Download and upload to StreetSignal
            $mediaId = $this->apiClient->uploadTelegramPhoto($fileId);
            
            return [
                'telegram_file_id' => $fileId,
                'media_id' => $mediaId
            ];

        } catch (\Exception $e) {
            Log::error('Failed to handle photo upload in Telegram bot', [
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Show submission preview
     */
    protected function showSubmissionPreview(int $chatId, TelegramBotUser $botUser, TelegramConversation $conversation): void
    {
        $survey = $conversation->getState('selected_survey');
        $formData = $conversation->getState('form_data', []);

        $message = "📋 Review your submission:\n\n";
        $message .= "Report Type: {$survey['name']}\n\n";

        foreach ($survey['fields'] as $index => $field) {
            $fieldKey = $field['key'] ?? "field_{$index}";
            $value = $formData[$fieldKey] ?? 'Not provided';
            
            if (is_array($value)) {
                if (isset($value['lat'], $value['lon'])) {
                    $value = "Location: {$value['lat']}, {$value['lon']}";
                } elseif (isset($value['media_id'])) {
                    $value = "Photo uploaded";
                } else {
                    $value = json_encode($value);
                }
            }
            
            $message .= "{$field['label']}: {$value}\n";
        }

        $message .= "\nIs this correct?";

        // Create confirmation buttons
        $buttons = [
            [
                new InlineKeyboardButton("✅ Submit", null, "confirm_submit"),
                new InlineKeyboardButton("❌ Cancel", null, "confirm_cancel")
            ]
        ];

        $keyboard = new InlineKeyboardMarkup($buttons);

        $conversation->updateState(['current_state' => 'awaiting_confirmation']);
        $this->botService->sendMessage($chatId, $message, $keyboard);
    }

    /**
     * Handle confirmation response
     */
    public function handleConfirmation(int $chatId, string $action, TelegramBotUser $botUser, TelegramConversation $conversation): void
    {
        if ($action === 'cancel') {
            $conversation->clearState();
            $this->botService->sendMessage($chatId, "Report submission cancelled.");
            return;
        }

        if ($action === 'submit') {
            $this->submitReport($chatId, $botUser, $conversation);
            return;
        }

        $this->botService->sendMessage($chatId, "Unknown action. Please use the buttons provided.");
    }

    /**
     * Submit the report to StreetSignal
     */
    protected function submitReport(int $chatId, TelegramBotUser $botUser, TelegramConversation $conversation): void
    {
        try {
            $survey = $conversation->getState('selected_survey');
            $formData = $conversation->getState('form_data', []);

            $postData = $this->transformFormDataToPost($survey, $formData, $botUser);
            
            $authToken = $botUser->isAuthenticated() ? $botUser->oauth_token : null;
            $postId = $this->apiClient->createPost($postData, $authToken);

            $conversation->clearState();

            $this->botService->sendMessage($chatId, 
                "✅ Report submitted successfully!\n\n" .
                "Report ID: #{$postId}\n" .
                "Thank you for helping improve your community!"
            );

            Log::info('Report submitted via Telegram bot', [
                'post_id' => $postId,
                'telegram_user_id' => $botUser->telegram_user_id,
                'survey_id' => $survey['id']
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to submit report via Telegram bot', [
                'error' => $e->getMessage(),
                'telegram_user_id' => $botUser->telegram_user_id
            ]);

            $this->botService->sendMessage($chatId, 
                "❌ Failed to submit report. Please try again later or contact support."
            );
        }
    }

    /**
     * Transform form data to post format
     */
    protected function transformFormDataToPost(array $survey, array $formData, TelegramBotUser $botUser): array
    {
        $postContent = [];
        
        foreach ($survey['fields'] as $index => $field) {
            $fieldKey = $field['key'] ?? "field_{$index}";
            $value = $formData[$fieldKey] ?? null;
            
            if ($value !== null) {
                $postContent[] = [
                    'fields' => [$field['id']],
                    'value' => $value
                ];
            }
        }

        return [
            'form_id' => $survey['id'],
            'title' => $this->generatePostTitle($formData, $survey),
            'content' => $this->generatePostContent($formData, $survey),
            'status' => 'published',
            'source' => 'telegram',
            'post_content' => $postContent,
            'metadata' => [
                'telegram_user_id' => $botUser->telegram_user_id,
                'telegram_username' => $botUser->telegram_username,
                'submitted_via' => 'telegram_bot'
            ]
        ];
    }

    /**
     * Generate post title from form data
     */
    protected function generatePostTitle(array $formData, array $survey): string
    {
        // Try to find a title field
        foreach ($survey['fields'] as $index => $field) {
            if (in_array(strtolower($field['label']), ['title', 'subject', 'summary'])) {
                $fieldKey = $field['key'] ?? "field_{$index}";
                $value = $formData[$fieldKey] ?? null;
                if ($value) {
                    return substr($value, 0, 100);
                }
            }
        }

        // Fallback to survey name with timestamp
        return $survey['name'] . ' - ' . date('Y-m-d H:i');
    }

    /**
     * Generate post content from form data
     */
    protected function generatePostContent(array $formData, array $survey): string
    {
        $content = "Report submitted via Telegram Bot\n\n";
        
        foreach ($survey['fields'] as $index => $field) {
            $fieldKey = $field['key'] ?? "field_{$index}";
            $value = $formData[$fieldKey] ?? null;
            
            if ($value !== null) {
                $content .= "{$field['label']}: ";
                
                if (is_array($value)) {
                    if (isset($value['lat'], $value['lon'])) {
                        $content .= "Location: {$value['lat']}, {$value['lon']}";
                    } else {
                        $content .= json_encode($value);
                    }
                } else {
                    $content .= $value;
                }
                
                $content .= "\n";
            }
        }

        return $content;
    }
}