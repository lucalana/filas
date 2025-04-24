<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filas</title>
</head>

<body>
    <h1>Repositórios</h1>
    @foreach ($githubRepositories as $repository)
        <div>
            <ul>
                <li>Nome: {{ $repository->repository_name }}</li>
                <li>Nome completo: {{ $repository->repository_full_name }}</li>
                <li><a href="{{ $repository->repository_html_url }}">Link para lá</a></li>
                <li>É um fork: {{ $repository->is_fork ? 'Sim' : 'Não' }}</li>
            </ul>
        </div>
    @endforeach
</body>

</html>
