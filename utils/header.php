<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <link href="../assets/styles.css" rel="stylesheet">
    <link rel="icon" href="../favicon.ico" type="image/x-icon">
</head>

<body>
    <header class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="../index/index.php">
                <img width="45" height="45" src="https://img.icons8.com/emoji/48/x-ray-emoji.png" alt="x-ray-emoji" class="me-2" />
                <span>Consultorio Radiológico</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item me-3"><a class="nav-link" href="../index/index.php">Inicio</a></li>
                    <li class="nav-item me-3"><a class="nav-link" href="../index/index.php#services">Servicios</a></li>
                    <li class="nav-item me-3"><a class="nav-link" href="../index/index.php#gallery">Galería</a></li>
                    <li class="nav-item me-3"><a class="nav-link" href="../index/index.php#contact">Contacto</a></li>
                </ul>
                <a href="../login/login_form.php" class="btn btn-primary me-3">Acceso Paciente</a>
                <a href="../alta/alta_form.php" class="btn btn-secondary">Acceso Profesional</a>
            </div>
        </div>
    </header>