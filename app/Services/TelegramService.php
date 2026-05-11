<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramService
{
    /**
     * Generate a one-time use Telegram Chat Invite Link
     *
     * @return string|null
     */
    public function generateInviteLink(): ?string
    {
        try {
            $botToken = env('TELEGRAM_BOT_TOKEN');
            $groupId = env('TELEGRAM_GROUP_ID');
            
            if (!$botToken || !$groupId) {
                Log::warning('Telegram API Error: Bot Token or Group ID is not configured in .env');
                return null;
            }

            $response = Http::post("https://api.telegram.org/bot{$botToken}/createChatInviteLink", [
                'chat_id' => $groupId,
                'member_limit' => 1,
                'creates_join_request' => false
            ]);

            if ($response->successful() && isset($response['result']['invite_link'])) {
                return $response['result']['invite_link'];
            }

            Log::error('Telegram API Error: ' . $response->body());
            return null;
            
        } catch (\Exception $e) {
            Log::error('Failed to generate Telegram Invite Link: ' . $e->getMessage());
            return null;
        }
    }
}
