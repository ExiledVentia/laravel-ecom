<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User Dashboard</title>
</head>

<body>
    <h1>User Dashboard</h1>
    <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label for="name">Name:</label><br>
            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>
        </div>

        <br>

        <div>
            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
        </div>

        <br>

        <fieldset>
            <legend>Change Password</legend>
            <div>
                <label for="password">New Password:</label><br>
                <input type="password" id="password" name="password">
            </div>

            <br>

            <div>
                <label for="password_confirmation">Confirm New Password:</label><br>
                <input type="password" id="password_confirmation" name="password_confirmation">
            </div>
        </fieldset>

        <br>

        <div>
            <button type="submit">Update Profile</button>
        </div>
    </form>

    <br>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>

</body>

</html>
