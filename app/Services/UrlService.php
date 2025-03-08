<?php

namespace App\Services;

use App\Models\Url;
use App\Models\RedirectLog;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class UrlService
{
    /**
     * Shorten a URL.
     *
     * @param string $originalUrl
     * @return array
     */
    public function shortenUrl($originalUrl)
    {
        $shortCode = $this->generateUniqueShortCode();

        $url = $this->createUrl($originalUrl, $shortCode);

        $this->cacheUrl($shortCode, $url->original_url);

        return [
            'short_url' => $this->buildShortUrl($shortCode),
        ];
    }

    /**
     * Redirect to the original URL.
     *
     * @param string $shortCode
     * @return string|null
     */
    public function redirectUrl($shortCode)
    {
        $originalUrl = $this->getOriginalUrl($shortCode);

        if (!$originalUrl) {
            return null;
        }

        $this->logRedirection($shortCode);

        return $originalUrl;
    }

    /**
     * Generate a unique short code.
     *
     * @return string
     */
    protected function generateUniqueShortCode()
    {
        do {
            $shortCode = Str::random(6);
        } while (Url::where('short_code', $shortCode)->exists());

        return $shortCode;
    }

    /**
     * Create a URL record.
     *
     * @param string $originalUrl
     * @param string $shortCode
     * @return Url
     */
    protected function createUrl($originalUrl, $shortCode)
    {
        return Url::create([
            'original_url' => $originalUrl,
            'short_code' => $shortCode,
        ]);
    }

    /**
     * Cache the URL.
     *
     * @param string $shortCode
     * @param string $originalUrl
     */
    protected function cacheUrl($shortCode, $originalUrl)
    {
        Cache::put("url:$shortCode", $originalUrl, now()->addHours(5));
    }

    /**
     * Build the short URL.
     *
     * @param string $shortCode
     * @return string
     */
    protected function buildShortUrl($shortCode)
    {
        return url('/') . '/' . $shortCode;
    }

    /**
     * Get the original URL from cache or database.
     *
     * @param string $shortCode
     * @return string|null
     */
    protected function getOriginalUrl($shortCode)
    {
        $originalUrl = Cache::get("url:$shortCode");

        if (!$originalUrl) {
            $url = Url::where('short_code', $shortCode)->first();

            if (!$url) {
                return null;
            }

            $originalUrl = $url->original_url;

            $this->cacheUrl($shortCode, $originalUrl);
        }

        return $originalUrl;
    }

    /**
     * Log the redirection.
     *
     * @param string $shortCode
     */
    protected function logRedirection($shortCode)
    {
        $url = Url::where('short_code', $shortCode)->first();

        if ($url) {
            RedirectLog::create([
                'url_id' => $url->id,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'referrer' => request()->header('referer'),
            ]);

            Log::info('URL Redirection', [
                'short_code' => $shortCode,
                'original_url' => $url->original_url,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'referrer' => request()->header('referer'),
            ]);
        }
    }
}