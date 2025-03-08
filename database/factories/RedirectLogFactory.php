<?php
namespace Database\Factories;

use App\Models\RedirectLog;
use Illuminate\Database\Eloquent\Factories\Factory;

class RedirectLogFactory extends Factory
{
    protected $model = RedirectLog::class;

    public function definition()
    {
        return [
            'url_id' => \App\Models\Url::factory(),
            'ip_address' => $this->faker->ipv4,
            'user_agent' => $this->faker->userAgent,
            'referrer' => $this->faker->url,
        ];
    }
}