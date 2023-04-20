<!DOCTYPE html>
<html>

<head>
    <title>List user</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-light navbar-expand-lg mb-5" style="background-color: #e3f2fd;">
        <div class="container">
            <a class="navbar-brand mr-auto" href="#">PositronX</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('listuser') }}">List user</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register-user') }}">Register</a>
                    </li>
                    @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('signout') }}">Logout</a>
                    </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
    <section class="container">
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th class="align-middle">ID</th>
                    <th class="align-middle">Name</th>
                    <th class="align-middle">Email</th>
                    <th class="align-middle">Phone</th>
                    <th class="align-middle">Avatar</th>
                    <th class="align-middle"></th>
                </tr>
            </thead>
            <tbody>
                <!-- Lặp qua danh sách user và xuất thông tin của mỗi user vào một dòng của table -->
                @foreach($users as $user)
                <tr>
                    <td class="align-middle">{{ $user->id }}</td>
                    <td class="align-middle">{{ $user->name }}</td>
                    <td class="align-middle">{{ $user->email }}</td>
                    <td class="align-middle">{{ $user->phone }}</td>
                    <td class="align-middle"><img style="width: 120px" src="{{ asset('uploads/' . $user->image) }}"
                            alt="avatar"></td>
                    <td class="align-middle"><a href="{{ route('detail', $user->id) }}">View detail</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div>{{ $users->links('pagination::bootstrap-4') }}</div>
    </section>
    @yield('content')
</body>

</html>