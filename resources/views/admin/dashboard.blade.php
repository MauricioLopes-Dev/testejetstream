<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6f9;
        }
        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            background: #343a40;
            color: white;
        }
        .sidebar a {
            color: #ddd;
            text-decoration: none;
            display: block;
            padding: 12px 20px;
        }
        .sidebar a:hover {
            background: #495057;
        }
        .content {
            margin-left: 260px;
            padding: 20px;
        }
        .navbar {
            margin-left: 250px;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h4 class="p-3">Admin</h4>
        <a href="#">Dashboard</a>
        <a href="#">Usuários</a>
        <a href="#">Relatórios</a>
        <a href="#">Configurações</a>
        <a href="#">Sair</a>
    </div>

    <!-- Navbar -->
    <nav class="navbar navbar-light bg-white shadow-sm">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">Painel Administrativo</span>
        </div>
    </nav>

    <!-- Conteúdo -->
    <div class="content">
        <h2>Visão Geral</h2>
        <p>Bem-vindo ao painel administrativo.</p>

        <div class="row mt-4">

            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Usuários</h5>
                        <h3>120</h3>
                        <p class="text-muted">Total registrados</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Vendas</h5>
                        <h3>R$ 8.940</h3>
                        <p class="text-muted">Este mês</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Acessos</h5>
                        <h3>32.480</h3>
                        <p class="text-muted">Últimos 30 dias</p>
                    </div>
                </div>
            </div>

        </div>

        <div class="card mt-4 shadow-sm">
            <div class="card-header">
                Últimas atividades
            </div>
            <div class="card-body">
                <ul>
                    <li>Novo usuário registrado: João</li>
                    <li>Venda realizada: Pedido #1022</li>
                    <li>Configuração alterada por Admin</li>
                </ul>
            </div>
        </div>
    </div>

</body>
</html>
