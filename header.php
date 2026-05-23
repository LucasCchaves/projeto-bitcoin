
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projeto_bitcoin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
   <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <link href="./style.css" rel="stylesheet">
</head>
<body>
  <header>
    <nav class="navbar fixed-top navbar-expand-lg collor shadow">
        <div class="container">
            
            <!-- Logo / Nome -->
            <a class="navbar-brand fw-bold" href="index.php">Gestor Bitcoin</a>

            <!-- Botão mobile -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Menu -->
            <div class="collapse navbar-collapse" id="menuNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">Início</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cadastrar.php">Cadastrar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="listar.php">Ver Investimento</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="..classes/Usuario.php">
                            <?= htmlspecialchars($_SESSION['nome']) ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="logout.php">Sair</a>
                    </li>
                </ul>
            </div>

        </div>
    </nav>
</header>