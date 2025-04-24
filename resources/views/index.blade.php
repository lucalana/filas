<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filas</title>
</head>

<body>
    <h1>Digite o usuário no github</h1>
    <form action="{{ route('search.repositories') }}" method="POST">
        @csrf
        <input type="text" name="user" id="user">
        <button>Pesquisar</button>
    </form>
    @foreach ($githubUsers as $user)
        <ul>
            <li><a href="{{ route('list.repositories', $user->github_user) }}">{{ $user->github_user }}</a></li>
        </ul>
    @endforeach
</body>

</html>
