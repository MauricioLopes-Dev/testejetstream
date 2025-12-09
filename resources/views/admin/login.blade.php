<!DOCTYPE html>
<html>
<head>
    <title>Login Admin</title>
</head>
<body>
    <h1>Login Admin</h1>
    <form method="POST" action="{{ route('admin.login.submit') }}">
        @csrf
        <input type="email" name="email" placeholder="E-mail" required><br>
        <input type="password" name="password" placeholder="Senha" required><br>
        <button type="submit">Login</button>
    </form>
</body>
</html>
