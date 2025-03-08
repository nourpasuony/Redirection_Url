<?php
namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Url;
use App\Models\RedirectLog;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UrlShortenerTest extends TestCase
{
    use RefreshDatabase;

    public function test_url_shortening()
    {
        $response = $this->postJson('/api/shorten', [
            'original_url' => 'https://www.google.com/',
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure(['short_url']);

        $shortCode = json_decode($response->getContent())->short_url;
        $shortCode = basename($shortCode);
        $this->assertTrue(Cache::has("url:$shortCode"));
    }

    public function test_url_redirection()
    {
        
        $url = Url::factory()->create([
            'original_url' => 'https://google.com',
            'short_code' => 'JFybkd',
        ]);

        Cache::put("url:JFybkd", $url->original_url, now()->addMinutes(30));

        $response = $this->get('/api/JFybkd');

        $response->assertRedirect('https://google.com');

        $this->assertDatabaseHas('redirect_logs', [
            'url_id' => $url->id,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'referrer' => request()->header('referer'),
        ]);

        Log::shouldReceive('info')
            ->once()
            ->with('URL Redirection', [
                'short_code' => 'JFybkd',
                'original_url' => 'https://google.com',
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'referrer' => request()->header('referer'),
            ]);
    }

    public function test_analytics()
    {
        $url = Url::factory()->create([
            'original_url' => 'https://www.google.com/',
            'short_code' => 'abc123',
        ]);

        RedirectLog::factory()->create([
            'url_id' => $url->id,
        ]);

        Cache::put("analytics:abc123", [
            'original_url' => $url->original_url,
            'short_url' => url('/') . '/' . $url->short_code,
            'redirect_count' => 1,
            'redirects' => RedirectLog::where('url_id', $url->id)->get(),
        ], now()->addMinutes(10));

        $response = $this->getJson('/api/analytics/abc123');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'original_url',
                'short_url',
                'redirect_count',
                'redirects',
            ]);

        $this->assertEquals('https://www.google.com/', $response->json('original_url'));
        $this->assertEquals(1, $response->json('redirect_count'));
    }

    public function test_cache_miss_falls_back_to_database()
    {
        $url = Url::factory()->create([
            'original_url' => 'https://www.google.com/',
            'short_code' => 'abc123',
        ]);

        Cache::forget("url:abc123");

        $response = $this->get('/abc123');

        $response->assertRedirect('https://www.google.com/');

        $this->assertTrue(Cache::has("url:abc123"));
    }
}