# Star Wars Wiki

This is a full-stack web application built as an exercise. It allows users to search characters and movies from the [Star Wars API (SWAPI)](https://swapi.tech), explore their details, and view statistics about past queries.

The project is built using:

- **Frontend**: Vue.js 3 with TailwindCSS
- **Backend**: Laravel 12 (PHP 8.4)
- **Database**: MySQL (via Docker)
- **Queue**: Laravel queue with scheduled jobs
- **Containerization**: Laravel Sail (Docker)

## Features

- Search and explore Star Wars **people** and **movies**
- Detailed view of movies with **clickable characters**
- Backend **caching** using Laravel Cache
- Endpoint and job system to calculate **statistics**:
    - Top queried endpoints
    - Average query duration
    - Most active search hour
    - Popular browsers
    - Locations (All unknown)

---

## Setup Instructions

> **Requirements:**
> - Docker installed
> - Node.js (v18 recommended)
> - Composer

### 1. Clone the repo

```bash
git clone https://github.com/eric-mendoza/star-wars-wiki.git
cd star-wars-wiki
```

### 2. Copy environment variables

```bash
cp .env.example .env
```

### 3. Start the Docker containers (Laravel Sail)

```bash
./vendor/bin/sail up -d

    If sail is not available yet, run:

    composer install
    ./vendor/bin/sail up -d
```

### 4. Install Node dependencies

```bash
npm install
```

### 5. Run the frontend (Vite dev server)

```bash
npm run dev
```

### 6. Run Laravel migrations

```bash
./vendor/bin/sail artisan migrate
```

---

## Scheduled Statistics Job

The app includes a scheduled job that recomputes statistics every 5 minutes using Laravel's scheduler and queue system.

To ensure it works in your local environment, the scheduler is registered inside AppServiceProvider via:

```php
$schedule->call(function () {
event(new StatisticsUpdateRequested());
})->everyMinute(); // for testing, change to everyFiveMinutes() for production
```
---
## Testing the API

Once up and running, you can hit the API from your browser or use tools like Postman.

Example endpoints:

```
    /api/v1/search?type=people&term=luke

    /api/v1/people/{id}

    /api/v1/movies/{id}

    /api/v1/statistics
```

---
## Notes

    The frontend uses Inertia.js to bridge Vue and Laravel.

    Caching is used to reduce unnecessary calls to SWAPI.

    Statistics use the QueryLog model to track endpoint usage and performance.



