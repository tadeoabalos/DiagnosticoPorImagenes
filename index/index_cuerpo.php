!DOCTYPE html>
<html lang="es">

<?php
$pageTitle = 'Consultorio Radiológico';
include '../utils/header.php';
?>

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

<section id="services" class="py-5">
    <div class="container">
        <h2 class="text-center mb-4">Nuestros Servicios</h2>
        <p class="text-center mb-5">Ofrecemos una variedad de servicios radiológicos, adaptados a las necesidades de cada paciente.</p>
        <div class="row text-center justify-content-center">
            <div class="col-md-4">
                <div class="card service-card mb-4">
                    <div class="card-body">
                        <h4 class="card-title">Radiología</h4>
                        <p class="card-text">Diagnóstico por imágenes para detección y análisis.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card service-card mb-4">
                    <div class="card-body">
                        <h4 class="card-title">Ecografía</h4>
                        <p class="card-text">Procedimiento seguro y sin radiación para exámenes detallados.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card service-card mb-4">
                    <div class="card-body">
                        <h4 class="card-title">Ecografía Doppler</h4>
                        <p class="card-text">Imágenes en tiempo real para estudiar el flujo sanguíneo.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card service-card mb-4">
                    <div class="card-body">
                        <h4 class="card-title">Mamografía</h4>
                        <p class="card-text">Evaluación especializada para el diagnóstico de mamas.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card service-card mb-4">
                    <div class="card-body">
                        <h4 class="card-title">Resonancia Magnética</h4>
                        <p class="card-text">Imágenes detalladas para evaluaciones complejas.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card service-card mb-4">
                    <div class="card-body">
                        <h4 class="card-title">Estudios Cardiológicos</h4>
                        <p class="card-text">Exámenes especializados para la salud cardíaca.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card service-card mb-4">
                    <div class="card-body">
                        <h4 class="card-title">Estudios Cardiológicos</h4>
                        <p class="card-text">Diagnóstico dental mediante imágenes precisas.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
<footer>
    <?php
    include '../utils/footer.php';
    ?>
</footer>

</body>

</html>
