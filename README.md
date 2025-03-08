# URL Shortener

A simple and efficient URL shortener built with Laravel. This application allows users to shorten long URLs, track redirections, and view analytics for each shortened URL.

---

## Features

- **Shorten URLs**: Convert long URLs into short, easy-to-share links.
- **Redirection**: Redirect users from the short URL to the original URL.
- **Analytics**: Track the number of redirections and view detailed logs.
- **Caching**: Improve performance with Redis.
- **Custom Aliases**: Optionally provide a custom alias for the short URL.

---

## Technologies Used

- **Laravel**: PHP framework for web applications.
- **MySQL**: Relational database for storing URLs and logs.
- **Redis**: In-memory caching for faster lookups.
- **PHPUnit**: For testing the application.

---

## Installation

### Prerequisites

- PHP V8.2.12 
- Composer V2.8.6 
- MySQL
- Redis for caching

### Steps

1. **Clone the repository**:
   ```bash
   git clone https://github.com/your-username/url-shortener.git
   cd url-shortener
   ```
2. **Install dependencies**:
   ```bash
   composer install
   ```
3. **Set up the environment**:
   - Copy the `.env.example` file to `.env`:
     ```bash
     cp .env.example .env
     ```
   - Update the `.env` file with your database and cache settings:
     ```env
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=url_shortener
     DB_USERNAME=root
     DB_PASSWORD=

     CACHE_DRIVER=redis
     REDIS_HOST=127.0.0.1
     REDIS_PASSWORD=null
     REDIS_PORT=6379
     ```
4. **Generate an application key**:
   ```bash
   php artisan key:generate
   ```
5. **Run migrations**:
   ```bash
   php artisan migrate
   ```
6. **Start the development server**:
   ```bash
   php artisan serve
   ```
7. **Access the application**:
   Open your browser and navigate to `http://localhost:8000`.

---

## Usage

### Shorten a URL
**Endpoint**: `POST /shorten`

**Request**:
```json
{
    "original_url": "https://example.com"
}
```

**Response**:
```json
{
    "short_url": "http://localhost/abc123"
}
```

### Redirect to Original URL
**Endpoint**: `GET /{shortCode}`

**Example**:
```
GET http://localhost/abc123
```

**Response**:
Redirects to `https://example.com`.

### View Analytics
**Endpoint**: `GET /analytics/{shortCode}`

**Example**:
```
GET http://localhost/analytics/abc123
```

**Response**:
```json
{
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
}
```
