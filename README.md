# SynTask - Task Management Application

SynTask is a comprehensive task and project management web application built with Laravel. It provides an intuitive interface for managing tasks, projects, and team collaboration efficiently.

## Features

- **User Authentication**: Secure login and registration system
- **Task Management**: Create, edit, categorize, and track tasks
- **Project Management**: Organize tasks into projects with deadlines and milestones
- **Dashboard**: Visual overview of tasks, projects, and productivity metrics
- **Profile Management**: Update personal information and preferences
- **Responsive Design**: Works seamlessly on desktop and mobile devices

## Screenshots

### Authentication Pages
![Authentication Pages](screenshots/auth-pages.png)

### Dashboard
![Dashboard](screenshots/dashboard.png)

### Task Management
![Task Management](screenshots/task-management.png)

## Requirements

- PHP 8.1 or higher
- Composer
- MySQL or compatible database
- Node.js and NPM (for asset compilation)
- Laravel 10.x

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/yourusername/syntask.git
   cd syntask
   ```

2. Install PHP dependencies:
   ```bash
   composer install
   ```

3. Create and configure your environment file:
   ```bash
   cp .env.example .env
   ```

4. Generate application key:
   ```bash
   php artisan key:generate
   ```

5. Configure your database in the `.env` file:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=syntask
   DB_USERNAME=root
   DB_PASSWORD=
   ```

6. Run database migrations and seed the database:
   ```bash
   php artisan migrate --seed
   ```

7. Set up storage symbolic link:
   ```bash
   php artisan storage:link
   ```

8. Start the development server:
   ```bash
   php artisan serve
   ```

Visit `http://localhost:8000` in your browser to access the application.

## Project Structure

```
syntask/
├── app/                  # Application logic
│   ├── Http/             # Controllers, Middleware, Requests
│   ├── Models/           # Eloquent models
│   └── Services/         # Business logic services
├── config/               # Configuration files
├── database/             # Migrations and seeders
├── public/               # Publicly accessible files
│   ├── css/              # Compiled CSS
│   ├── js/               # Compiled JavaScript
│   └── images/           # Image assets
├── resources/            # Views and uncompiled assets
│   ├── js/               # JavaScript source files
│   ├── sass/             # SASS source files
│   └── views/            # Blade templates
├── routes/               # Route definitions
└── tests/                # Automated tests
```

## Authentication Routes

```php
// Auth routes
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\LoginController@login');
Route::get('/register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('/register', 'Auth\RegisterController@register');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

// Password reset routes
Route::get('/password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('/password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
```

## Main Application Routes

```php
// Dashboard and main application routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    Route::resource('projects', 'ProjectController');
    Route::resource('tasks', 'TaskController');
    Route::get('/profile', 'ProfileController@edit')->name('profile');
    Route::put('/profile', 'ProfileController@update')->name('profile.update');
});

Route::get('/', 'HomeController@index')->name('home');
```

## Future Enhancements

- Email verification for new user registrations
- Social authentication (Google, GitHub)
- Enhanced reporting and analytics
- Team collaboration features
- API access for third-party integrations

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Acknowledgements

- [Laravel](https://laravel.com)
- [Bootstrap](https://getbootstrap.com)
- [Font Awesome](https://fontawesome.com)
