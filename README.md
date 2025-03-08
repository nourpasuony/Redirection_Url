# URL Shortener

A simple and efficient URL shortener built with Laravel. This application allows users to shorten long URLs, track redirections, and view analytics for each shortened URL.

---

## Features

- **Shorten URLs**: Convert long URLs into short, easy-to-share links.
- **Redirection**: Redirect users from the short URL to the original URL.
- **Analytics**: Track the number of redirections and view detailed logs.
- **Caching**: Improve performance with Redis or in-memory caching.
- **Custom Aliases**: Optionally provide a custom alias for the short URL.
- **Rate Limiting**: Prevent abuse with built-in rate limiting.

---

## Technologies Used

- **Laravel**: PHP framework for web applications.
- **MySQL**: Relational database for storing URLs and logs.
- **Redis**: In-memory caching for faster lookups.
- **PHPUnit**: For testing the application.

---

## Installation

### Prerequisites

- PHP 8.0 or higher
- Composer
- MySQL
- Redis (optional, for caching)

### Steps

1. **Clone the repository**:
   ```bash
   git clone https://github.com/your-username/url-shortener.git
   cd url-shortener
