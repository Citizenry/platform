<?php

namespace StreetSignal\Modules\TelegramBot\Services;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use TelegramBot\Api\BotApi;

class StreetSignalApiClient
{
    protected string $baseUrl;
    protected ?string $serviceToken;
    protected BotApi $telegramBot;

    public function __construct()
    {
        $this->baseUrl = config('app.url') . '/api/v5';
        $this->serviceToken = config('telegram.service_token');
    }

    /**
     * Set the Telegram bot instance for file downloads
     */
    public function setTelegramBot(BotApi $telegramBot): void
    {
        $this->telegramBot = $telegramBot;
    }

    /**
     * Get all available surveys
     */
    public function getSurveys(): array
    {
        try {
            $response = $this->makeRequest('GET', '/forms', null, $this->serviceToken);
            
            if ($response->successful()) {
                $data = $response->json();
                return $data['data'] ?? [];
            }

            Log::warning('Failed to fetch surveys from API', [
                'status' => $response->status(),
                'response' => $response->body()
            ]);

            return [];

        } catch (\Exception $e) {
            Log::error('Exception while fetching surveys', [
                'error' => $e->getMessage()
            ]);
            return [];
        }
    }

    /**
     * Get a specific survey by ID
     */
    public function getSurvey(int $surveyId): ?array
    {
        try {
            $response = $this->makeRequest('GET', "/forms/{$surveyId}", null, $this->serviceToken);
            
            if ($response->successful()) {
                $data = $response->json();
                return $data['data'] ?? null;
            }

            Log::warning('Failed to fetch survey from API', [
                'survey_id' => $surveyId,
                'status' => $response->status(),
                'response' => $response->body()
            ]);

            return null;

        } catch (\Exception $e) {
            Log::error('Exception while fetching survey', [
                'survey_id' => $surveyId,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Create a new post
     */
    public function createPost(array $postData, ?string $userToken = null): int
    {
        $token = $userToken ?? $this->serviceToken;
        
        $response = $this->makeRequest('POST', '/posts', $postData, $token);
        
        if ($response->successful()) {
            $data = $response->json();
            return $data['data']['id'] ?? throw new \Exception('Post ID not returned');
        }

        $errorMessage = $this->extractErrorMessage($response);
        throw new \Exception("Failed to create post: {$errorMessage}");
    }

    /**
     * Upload a photo from Telegram to StreetSignal
     */
    public function uploadTelegramPhoto(string $telegramFileId): int
    {
        try {
            // Get file info from Telegram
            $file = $this->telegramBot->getFile($telegramFileId);
            $filePath = $file->getFilePath();
            
            // Download file from Telegram
            $telegramToken = config('telegram.bot_token');
            $fileUrl = "https://api.telegram.org/file/bot{$telegramToken}/{$filePath}";
            
            $fileResponse = Http::get($fileUrl);
            
            if (!$fileResponse->successful()) {
                throw new \Exception('Failed to download file from Telegram');
            }

            // Generate unique filename
            $extension = pathinfo($filePath, PATHINFO_EXTENSION) ?: 'jpg';
            $filename = 'telegram_' . uniqid() . '.' . $extension;
            
            // Store file temporarily
            $tempPath = "temp/{$filename}";
            Storage::put($tempPath, $fileResponse->body());

            // Upload to StreetSignal media API
            $response = Http::withToken($this->serviceToken)
                ->attach('file', Storage::get($tempPath), $filename)
                ->post($this->baseUrl . '/media');

            // Clean up temp file
            Storage::delete($tempPath);

            if ($response->successful()) {
                $data = $response->json();
                return $data['data']['id'] ?? throw new \Exception('Media ID not returned');
            }

            $errorMessage = $this->extractErrorMessage($response);
            throw new \Exception("Failed to upload media: {$errorMessage}");

        } catch (\Exception $e) {
            Log::error('Failed to upload Telegram photo', [
                'telegram_file_id' => $telegramFileId,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Get user information by OAuth token
     */
    public function getUserByToken(string $token): ?array
    {
        try {
            $response = $this->makeRequest('GET', '/user', null, $token);
            
            if ($response->successful()) {
                $data = $response->json();
                return $data['data'] ?? null;
            }

            return null;

        } catch (\Exception $e) {
            Log::error('Exception while fetching user by token', [
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Validate an OAuth token
     */
    public function validateToken(string $token): bool
    {
        try {
            $response = $this->makeRequest('GET', '/user', null, $token);
            return $response->successful();

        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Get posts for a user (for authenticated users)
     */
    public function getUserPosts(string $userToken, int $limit = 10): array
    {
        try {
            $response = $this->makeRequest('GET', '/posts', [
                'limit' => $limit,
                'user_posts_only' => true
            ], $userToken);
            
            if ($response->successful()) {
                $data = $response->json();
                return $data['data'] ?? [];
            }

            return [];

        } catch (\Exception $e) {
            Log::error('Exception while fetching user posts', [
                'error' => $e->getMessage()
            ]);
            return [];
        }
    }

    /**
     * Get post details by ID
     */
    public function getPost(int $postId, ?string $userToken = null): ?array
    {
        try {
            $token = $userToken ?? $this->serviceToken;
            $response = $this->makeRequest('GET', "/posts/{$postId}", null, $token);
            
            if ($response->successful()) {
                $data = $response->json();
                return $data['data'] ?? null;
            }

            return null;

        } catch (\Exception $e) {
            Log::error('Exception while fetching post', [
                'post_id' => $postId,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Update post status (for authenticated users)
     */
    public function updatePostStatus(int $postId, string $status, string $userToken): bool
    {
        try {
            $response = $this->makeRequest('PATCH', "/posts/{$postId}", [
                'status' => $status
            ], $userToken);
            
            return $response->successful();

        } catch (\Exception $e) {
            Log::error('Exception while updating post status', [
                'post_id' => $postId,
                'status' => $status,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Search posts (for authenticated users)
     */
    public function searchPosts(array $filters, string $userToken): array
    {
        try {
            $response = $this->makeRequest('GET', '/posts', $filters, $userToken);
            
            if ($response->successful()) {
                $data = $response->json();
                return $data['data'] ?? [];
            }

            return [];

        } catch (\Exception $e) {
            Log::error('Exception while searching posts', [
                'filters' => $filters,
                'error' => $e->getMessage()
            ]);
            return [];
        }
    }

    /**
     * Get statistics for authenticated user
     */
    public function getUserStats(string $userToken): ?array
    {
        try {
            $response = $this->makeRequest('GET', '/user/stats', null, $userToken);
            
            if ($response->successful()) {
                $data = $response->json();
                return $data['data'] ?? null;
            }

            return null;

        } catch (\Exception $e) {
            Log::error('Exception while fetching user stats', [
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Make an HTTP request to the StreetSignal API
     */
    protected function makeRequest(string $method, string $endpoint, ?array $data = null, ?string $token = null): Response
    {
        $url = $this->baseUrl . $endpoint;
        
        $request = Http::timeout(30);
        
        if ($token) {
            $request = $request->withToken($token);
        }

        $request = $request->withHeaders([
            'Accept' => 'application/json',
            'User-Agent' => 'StreetSignal-TelegramBot/1.0'
        ]);

        switch (strtoupper($method)) {
            case 'GET':
                return $request->get($url, $data ?? []);
            case 'POST':
                return $request->post($url, $data ?? []);
            case 'PUT':
                return $request->put($url, $data ?? []);
            case 'PATCH':
                return $request->patch($url, $data ?? []);
            case 'DELETE':
                return $request->delete($url, $data ?? []);
            default:
                throw new \InvalidArgumentException("Unsupported HTTP method: {$method}");
        }
    }

    /**
     * Extract error message from API response
     */
    protected function extractErrorMessage(Response $response): string
    {
        try {
            $data = $response->json();
            
            if (isset($data['message'])) {
                return $data['message'];
            }
            
            if (isset($data['error'])) {
                return is_string($data['error']) ? $data['error'] : json_encode($data['error']);
            }
            
            if (isset($data['errors'])) {
                if (is_array($data['errors'])) {
                    $errors = [];
                    foreach ($data['errors'] as $field => $fieldErrors) {
                        if (is_array($fieldErrors)) {
                            $errors[] = implode(', ', $fieldErrors);
                        } else {
                            $errors[] = $fieldErrors;
                        }
                    }
                    return implode('; ', $errors);
                }
                return $data['errors'];
            }
            
            return "HTTP {$response->status()}";
            
        } catch (\Exception $e) {
            return "HTTP {$response->status()} - Unable to parse error response";
        }
    }

    /**
     * Check API health
     */
    public function checkHealth(): bool
    {
        try {
            $response = Http::timeout(10)->get($this->baseUrl . '/health');
            return $response->successful();
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Get API version info
     */
    public function getApiVersion(): ?array
    {
        try {
            $response = Http::timeout(10)->get($this->baseUrl . '/version');
            
            if ($response->successful()) {
                return $response->json();
            }
            
            return null;
        } catch (\Exception $e) {
            return null;
        }
    }
}