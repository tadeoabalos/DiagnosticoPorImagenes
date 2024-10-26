<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultorio Radiológico</title>    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>        
        body {
            font-family: Arial, sans-serif;
        }
        .carousel-inner img {
            height: 500px;
            object-fit: cover;
        }
        .services, .footer {
            padding: 40px;
        }
        .footer {
            background-color: #333;
            color: white;
        }
        .footer a {
            color: #a9a9a9;
            text-decoration: none;
        }
        .footer a:hover {
            color: white;
        }
        .btn-appointment {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>
<body>
    <header class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Consultorio Radiológico</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#home">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="#services">Servicios</a></li>
                    <li class="nav-item"><a class="nav-link" href="#gallery">Galería</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact">Contacto</a></li>
                </ul>
                <a href="../alta_turno/alta_turno_form.php" class="btn btn-primary">Pedir un turno</a>
                <a href="../login/login.php" class="btn btn-secondary" style="margin-left: 5px;">Acceso Profesional</a>                
            </div>
        </div>
    </header>
    <section id="gallery" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="https://centromedicobuenosairesmedellin.com/wp-content/uploads/2019/01/tomografia_en_medellin.jpg" class="d-block w-100" alt="Imagen 1">
            </div>
            <div class="carousel-item">
                <img src="https://irp-cdn.multiscreensite.com/58b0f5df/DESKTOP/jpg/548693-consultorio-radiologico-moreno-s.r.l.-header419f.jpg?1449878687117&v=7.3.45002" class="d-block w-100" alt="Imagen 2">
            </div>
            <div class="carousel-item">
                <img src="https://www.iconicasports.com/wp-content/uploads/2015/03/consulta-medicina-deportiva-iconica-sports.jpg" class="d-block w-100" alt="Imagen 3">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#gallery" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Anterior</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#gallery" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Siguiente</span>
        </button>
    </section>
    <section id="services" class="services text-center">
        <div class="container">
                    <h2>Nuestros Servicios</h2>
                    <p>Ofrecemos una variedad de servicios radiológicos, adaptados a las necesidades de cada paciente.</p>
                    <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h4>Radiología</h4>
                    <p>Diagnóstico por imágenes para detección y análisis.</p>
                </div>
                <div class="col-md-4">
                    <h4>Ecografía</h4>
                    <p>Procedimiento seguro y sin radiación para exámenes detallados.</p>
                </div>
                <div class="col-md-4">
                    <h4>Ecografía Doppler</h4>
                    <p>Imágenes en tiempo real para estudiar el flujo sanguíneo.</p>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-4">
                    <h4>Mamografía</h4>
                    <p>Evaluación especializada para el diagnóstico de mamas.</p>
                </div>
                <div class="col-md-4">
                    <h4>Resonancia Magnética</h4>
                    <p>Imágenes detalladas para evaluaciones complejas.</p>
                </div>
                <div class="col-md-4">
                    <h4>Estudios Cardiológicos</h4>
                    <p>Exámenes especializados para la salud cardíaca.</p>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-6">
                    <h4>Imágenes Dentales</h4>
                    <p>Diagnóstico dental mediante imágenes precisas.</p>
                </div>
            </div>
        </div>
        </div>
    </section>
    <footer id="contact" class="footer text-center">
        <div class="container">
            <p>Consultorio Radiológico - Contacto: info@consultorioradiologico.com | Tel: (123) 456-7890</p>
            <p><a href="#">Política de Privacidad</a> | <a href="#">Términos y Condiciones</a></p>
            <p>Síguenos en:
                <a href="#">Facebook</a> |
                <a href="#">Instagram</a> |
                <a href="#">LinkedIn</a>
            </p>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
