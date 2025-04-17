<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SynTask - @yield('title', 'Task Management')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .navbar-brand img {
            height: 40px;
        }

        .auth-container {
            max-width: 500px;
            margin: 80px auto;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .password-strength {
            height: 5px;
            transition: all 0.3s ease;
        }

        .sidebar {
            min-height: calc(100vh - 56px);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar .nav-link {
            color: #333;
            padding: 0.5rem 1rem;
            border-radius: 0.25rem;
            margin-bottom: 0.25rem;
        }

        .sidebar .nav-link:hover {
            background-color: #f8f9fa;
        }

        .sidebar .nav-link.active {
            background-color: #e9ecef;
            font-weight: 500;
        }

        .sidebar .nav-link i {
            width: 25px;
        }

        .progress-thin {
            height: 5px;
        }

        @media (max-width: 768px) {
            .sidebar {
                min-height: auto;
            }
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('images/syntask-logo.png') }}" alt="SynTask Logo">
                <span class="ms-2">SynTask</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Sign Up</a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown">
                                {{ Auth::user()->first_name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li><a class="dropdown-item" href="{{ route('profile') }}">Profile</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="{{ route('logout') }}">Logout</a></li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    @auth
        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar -->
                <div class="col-md-3 col-lg-2 d-md-block bg-light sidebar py-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                                href="{{ route('dashboard') }}">
                                <i class="fas fa-tachometer-alt"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('projects.*') ? 'active' : '' }}"
                                href="{{ route('projects.index') }}">
                                <i class="fas fa-project-diagram"></i> Projects
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('tasks.*') ? 'active' : '' }}"
                                href="{{ route('tasks.index') }}">
                                <i class="fas fa-tasks"></i> Tasks
                            </a>
                        </li>
                        {{-- <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('reports') ? 'active' : '' }}"
                                href="{{ route('reports') }}">
                                <i class="fas fa-chart-bar"></i> Reports
                            </a>
                        </li> --}}
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('profile') ? 'active' : '' }}"
                                href="{{ route('profile') }}">
                                <i class="fas fa-user"></i> Profile
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Main Content -->
                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-3">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @yield('content')
                </main>
            </div>
        </div>
    @else
        <div class="container">
            @yield('content')
        </div>
    @endauth

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>

</html>
