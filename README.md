# WishTales - Greeting Card Platform

A beautiful Laravel-based greeting card platform similar to Givingli. Create, customize, and send beautiful greeting cards for any occasion.

## Features

- 🎨 **Beautiful Card Gallery** - Browse cards by categories (Birthday, Anniversary, Love, Thank You, etc.)
- ✏️ **Card Customization** - Personalize cards with your own message
- 📧 **Send Cards** - Send cards instantly or schedule them for later
- 📱 **Responsive Design** - Works perfectly on all devices
- 👥 **Contact Management** - Save recipients for easy sending
- 📅 **Event Reminders** - Never miss an important date
- 📊 **Track Opens** - Know when your card is opened
- 💎 **Premium Cards** - Special premium designs available

## Screenshots

The app includes:
- Home page with featured cards and categories
- Card browsing with filters and search
- Card customization with envelope selection
- Send card form with scheduling
- My Gifts dashboard
- Contact management
- Upcoming events

## Requirements

- PHP 8.2+
- Composer
- SQLite (default) or MySQL

## Installation

1. **Clone the repository**
   ```bash
   cd Wishtales
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Copy environment file**
   ```bash
   cp .env.example .env
   ```

4. **Generate application key**
   ```bash
   php artisan key:generate
   ```

5. **Create database**
   ```bash
   touch database/database.sqlite
   ```

6. **Run migrations and seeders**
   ```bash
   php artisan migrate --seed
   ```

7. **Start the development server**
   ```bash
   php artisan serve
   ```

8. **Visit the app**
   Open http://localhost:8000 in your browser

## Demo Accounts

After seeding, you can login with:

- **Regular User**
  - Email: demo@wishtales.com
  - Password: password

- **Premium User**
  - Email: premium@wishtales.com
  - Password: password

## Project Structure

```
app/
├── Http/Controllers/    # Request handlers
├── Models/              # Eloquent models
├── Policies/            # Authorization policies
└── Providers/           # Service providers

database/
├── migrations/          # Database schema
└── seeders/             # Sample data

resources/views/
├── layouts/             # Base layout
├── auth/                # Login/Register
├── cards/               # Card browsing & customization
├── contacts/            # Contact management
├── events/              # Upcoming events
└── gifts/               # Gift sending & tracking
```

## Technologies Used

- **Backend**: Laravel 11
- **Frontend**: Blade Templates, Tailwind CSS (CDN)
- **Icons**: Font Awesome
- **Database**: SQLite (configurable to MySQL)

## Key Routes

| Route | Description |
|-------|-------------|
| `/` | Home page |
| `/shop` | Browse all cards |
| `/cards/{card}` | View single card |
| `/cards/{card}/customize` | Customize card |
| `/my-gifts` | View sent cards |
| `/contacts` | Manage contacts |
| `/events` | Upcoming events |

## License

MIT License
