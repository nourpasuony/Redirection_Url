<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>URL Shortener - README</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            line-height: 1.6;
            background-color: #f4f4f4;
            color: #333;
        }
        h1, h2 {
            color: #2c3e50;
        }
        pre {
            background: #333;
            color: #fff;
            padding: 10px;
            border-radius: 5px;
            overflow-x: auto;
        }
        code {
            color: #e74c3c;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>URL Shortener</h1>
        <p>A simple and efficient URL shortener built with Laravel.</p>

        <h2>Features</h2>
        <ul>
            <li><strong>Shorten URLs:</strong> Convert long URLs into short, easy-to-share links.</li>
            <li><strong>Redirection:</strong> Redirect users from the short URL to the original URL.</li>
            <li><strong>Analytics:</strong> Track the number of redirections and view detailed logs.</li>
            <li><strong>Caching:</strong> Improve performance with Redis or in-memory caching.</li>
            <li><strong>Custom Aliases:</strong> Optionally provide a custom alias for the short URL.</li>
            <li><strong>Rate Limiting:</strong> Prevent abuse with built-in rate limiting.</li>
        </ul>

        <h2>Technologies Used</h2>
        <ul>
            <li><strong>Laravel:</strong> PHP framework for web applications.</li>
            <li><strong>MySQL:</strong> Relational database for storing URLs and logs.</li>
            <li><strong>Redis:</strong> In-memory caching for faster lookups.</li>
            <li><strong>PHPUnit:</strong> For testing the application.</li>
        </ul>

        <h2>Installation</h2>
        <h3>Prerequisites</h3>
        <ul>
            <li>PHP 8.0 or higher</li>
            <li>Composer</li>
            <li>MySQL</li>
            <li>Redis (optional, for caching)</li>
        </ul>

        <h3>Steps</h3>
        <pre><code>git clone https://github.com/your-username/url-shortener.git
cd url-shortener
composer install
</code></pre>
        <p>Set up the environment:</p>
        <pre><code>cp .env.example .env</code></pre>
        <p>Update the <code>.env</code> file with database settings:</p>
        <pre><code>DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=url_shortener
DB_USERNAME=root
DB_PASSWORD=

CACHE_DRIVER=redis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379</code></pre>

        <p>Generate an application key:</p>
        <pre><code>php artisan key:generate</code></pre>
        <p>Run migrations:</p>
        <pre><code>php artisan migrate</code></pre>
        <p>Start the development server:</p>
        <pre><code>php artisan serve</code></pre>
        <p>Access the application at <a href="http://localhost:8000">http://localhost:8000</a>.</p>

        <h2>Usage</h2>
        <h3>Shorten a URL</h3>
        <p><strong>Endpoint:</strong> <code>POST /shorten</code></p>
        <pre><code>{
    "original_url": "https://example.com"
}</code></pre>
        <p>Response:</p>
        <pre><code>{
    "short_url": "http://localhost/abc123"
}</code></pre>

        <h3>Redirect to Original URL</h3>
        <p><strong>Endpoint:</strong> <code>GET /{shortCode}</code></p>
        <p>Example:</p>
        <pre><code>GET http://localhost/abc123</code></pre>
        <p>Response: Redirects to <code>https://example.com</code></p>

        <h3>View Analytics</h3>
        <p><strong>Endpoint:</strong> <code>GET /analytics/{shortCode}</code></p>
        <p>Example:</p>
        <pre><code>GET http://localhost/analytics/abc123</code></pre>
        <p>Response:</p>
        <pre><code>{
    "original_url": "https://example.com",
    "short_url": "http://localhost/abc123",
    "redirect_count": 5,
    "redirects": [
        {
            "id": 1,
            "url_id": 1,
            "ip_address": "127.0.0.1",
            "user_agent": "PostmanRuntime/7.26.8",
            "referrer": null,
            "created_at": "2023-10-01T12:34:56.000000Z",
            "updated_at": "2023-10-01T12:34:56.000000Z"
        }
    ]
}</code></pre>
    </div>
</body>
</html>
