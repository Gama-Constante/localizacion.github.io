<?php
session_start();

// Load configuration file
require_once 'config/config.php';

// Use configuration variables
$geoApps = $geo_applications;
$locationTypes = $location_technologies;
$navMenu = $navigation_menu;

// Registrar visita (opcional)
try {
    if (file_exists('database.php')) {
        require_once 'database.php';
        $db = new Database();
        $visitData = [
            'ip_address' => $_SERVER['REMOTE_ADDR'],
            'user_agent' => $_SERVER['HTTP_USER_AGENT'],
            'page_url' => $_SERVER['REQUEST_URI'],
            'referrer' => isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '',
            'visited_at' => date('Y-m-d H:i:s')
        ];
        $db->insert('visits', $visitData);
    }
} catch (Exception $e) {
    // Silenciosamente fallar si la BD no está configurada
    error_log('No se pudo registrar visita: ' . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME; ?> - <?php echo SITE_DESCRIPTION; ?></title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
    <!-- CSS Stylesheet -->
    <link rel="stylesheet" href="css/css.css">

</head>
<body>
    <div class="animated-bg"></div>
    
    <header>
        <nav>
            <a href="#" class="logo"><?php echo SITE_NAME; ?></a>
            <ul class="nav-links">
                <?php foreach ($navMenu as $item): ?>
                <li><a href="<?php echo $item['href']; ?>"><?php echo $item['text']; ?></a></li>
                <?php endforeach; ?>
            </ul>
        </nav>
    </header>
    
    <section class="hero">
        <div class="hero-content">
            <h1>Geolocalización</h1>
            <p>Descubre el fascinante mundo de la tecnología de ubicación y cómo está transformando nuestras vidas</p>
            <a href="#que-es" class="cta-button">Explorar</a>
        </div>
    </section>
    
    <section id="que-es" class="fade-in">
        <h2 class="section-title">¿Qué es Geolocalización?</h2>
        <p class="section-subtitle">Fundamentos de la tecnología de ubicación</p>
        
        <div class="info-box">
            <h3>Definición</h3>
            <p>
                La <strong>geolocalización</strong> es el proceso de identificar la ubicación geográfica real de un objeto, 
                como un dispositivo móvil, computadora o cualquier dispositivo conectado a Internet. Esta tecnología utiliza 
                diversos métodos para determinar la posición mediante coordenadas geográficas (latitud y longitud), 
                permitiendo situar con precisión cualquier punto en la superficie terrestre.
            </p>
        </div>
        
        <div class="info-box">
            <h3>¿Cómo funciona?</h3>
            <p>
                La geolocalización combina múltiples tecnologías: sistemas satelitales (GPS, GLONASS, Galileo), 
                redes de telefonía celular, puntos de acceso Wi-Fi y direcciones IP. Los dispositivos modernos 
                utilizan varios de estos métodos simultáneamente para mejorar la precisión y velocidad de localización, 
                adaptándose automáticamente según las condiciones y disponibilidad de señales.
            </p>
        </div>
    </section>
    
    <section id="tipos" class="fade-in">
        <h2 class="section-title">Tipos de Geolocalización</h2>
        <p class="section-subtitle">Los métodos más utilizados en la actualidad</p>
        
        <div class="cards-grid">
            <div class="card">
                <div class="card-icon">🛰️</div>
                <h3>GPS (Global Positioning System)</h3>
                <p>Sistema satelital que proporciona ubicación precisa mediante triangulación de señales de múltiples satélites en órbita.</p>
            </div>
            
            <div class="card">
                <div class="card-icon">📱</div>
                <h3>A-GPS (Assisted GPS)</h3>
                <p>Versión mejorada que utiliza datos de red celular para acelerar el tiempo de adquisición de señal satelital.</p>
            </div>
            
            <div class="card">
                <div class="card-icon">📡</div>
                <h3>Cell Tower Triangulation</h3>
                <p>Determina la ubicación basándose en la señal de las torres de telefonía celular más cercanas al dispositivo.</p>
            </div>
            
            <div class="card">
                <div class="card-icon">📶</div>
                <h3>Wi-Fi Positioning</h3>
                <p>Utiliza bases de datos de puntos de acceso Wi-Fi conocidos para estimar la ubicación con alta precisión en áreas urbanas.</p>
            </div>
            
            <div class="card">
                <div class="card-icon">🌐</div>
                <h3>IP Geolocation</h3>
                <p>Método basado en la dirección IP del dispositivo, útil para determinar ubicación aproximada a nivel de ciudad o región.</p>
            </div>
            
            <div class="card">
                <div class="card-icon">📍</div>
                <h3>Bluetooth Beacons</h3>
                <p>Dispositivos de baja energía que permiten micro-localización en espacios interiores como centros comerciales o museos.</p>
            </div>
        </div>
    </section>
    
    <section id="aplicaciones" class="fade-in">
        <h2 class="section-title">Aplicaciones que Utilizan Geolocalización</h2>
        <p class="section-subtitle">5 ejemplos populares en nuestra vida diaria</p>
        
        <div class="cards-grid">
            <?php foreach ($geoApps as $app): ?>
            <div class="card">
                <div class="card-icon"><?php echo $app['icon']; ?></div>
                <h3><?php echo $app['name']; ?></h3>
                <p><?php echo $app['description']; ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </section>
    
    <section id="api" class="fade-in">
        <h2 class="section-title">¿Qué es una API?</h2>
        <p class="section-subtitle">Interfaz de Programación de Aplicaciones</p>
        
        <div class="info-box">
            <h3>Concepto de API</h3>
            <p>
                Una <strong>API (Application Programming Interface)</strong> es un conjunto de reglas y protocolos que permite 
                que diferentes aplicaciones de software se comuniquen entre sí. En el contexto de geolocalización, las APIs 
                permiten a los desarrolladores integrar servicios de mapas y ubicación en sus aplicaciones sin necesidad de 
                crear toda la infraestructura desde cero.
            </p>
        </div>
        
        <h3 style="color: var(--text-bright); margin: 3rem 0 1.5rem; font-size: 1.8rem;">Cómo Generar una Clave API</h3>
        
        <div class="steps">
            <div class="step">
                <h4>Crear una Cuenta en Google Cloud Platform</h4>
                <p>Visita <a href="https://console.cloud.google.com" style="color: var(--accent);">console.cloud.google.com</a> y crea una cuenta o inicia sesión con tu cuenta de Google existente.</p>
            </div>
            
            <div class="step">
                <h4>Crear un Nuevo Proyecto</h4>
                <p>En el panel de Google Cloud, haz clic en "Crear Proyecto" y asígnale un nombre descriptivo a tu proyecto.</p>
            </div>
            
            <div class="step">
                <h4>Habilitar APIs Necesarias</h4>
                <p>Ve a "APIs y Servicios" > "Biblioteca" y habilita las APIs que necesites: Maps JavaScript API, Geocoding API, Places API, etc.</p>
            </div>
            
            <div class="step">
                <h4>Crear Credenciales</h4>
                <p>En "APIs y Servicios" > "Credenciales", haz clic en "Crear Credenciales" y selecciona "Clave de API".</p>
            </div>
            
            <div class="step">
                <h4>Restringir y Proteger tu Clave</h4>
                <p>Configura restricciones de aplicación y API para proteger tu clave de usos no autorizados. Puedes limitar por dominio, dirección IP o referente HTTP.</p>
            </div>
        </div>
        
        <div class="code-block">
            <pre>// Ejemplo de uso de API de Geolocalización en JavaScript
if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(
        function(position) {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;
            console.log(`Ubicación: ${lat}, ${lng}`);
        },
        function(error) {
            console.error('Error al obtener ubicación:', error);
        }
    );
}</pre>
        </div>
    </section>
    
    <section id="ubicaciones" class="fade-in">
        <h2 class="section-title">Tipos de Ubicación</h2>
        <p class="section-subtitle">Comparativa de tecnologías de posicionamiento</p>
        
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Tipo</th>
                        <th>Descripción</th>
                        <th>Precisión</th>
                        <th>Tecnología</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($locationTypes as $location): ?>
                    <tr>
                        <td><strong style="color: var(--accent);"><?php echo $location['type']; ?></strong></td>
                        <td><?php echo $location['description']; ?></td>
                        <td><?php echo $location['precision']; ?></td>
                        <td><?php echo $location['technology']; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <h3 style="color: var(--text-bright); margin: 4rem 0 2rem; font-size: 1.8rem; text-align: center;">Mapa Interactivo</h3>
        
        <div id="locationStatus" class="location-status">
            🌍 Obteniendo tu ubicación...
        </div>
        
        <div id="map"></div>
        
        <div style="text-align: center;">
            <button id="saveLocationBtn" class="cta-button save-location-btn" style="margin-top: 2rem;">
                💾 Guardar Mi Ubicación en la Base de Datos
            </button>
        </div>
    </section>
    
    <footer>
        <p>&copy; 2026 <?php echo SITE_NAME; ?>. Proyecto Educativo de Geolocalización. Todos los derechos reservados.</p>
    </footer>
    
    <script>
        // Global variables
        let currentPosition = null;
        
        // Scroll Animation Observer
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -100px 0px'
        };
        
        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, observerOptions);
        
        document.querySelectorAll('.fade-in').forEach(el => {
            observer.observe(el);
        });
        
        // Smooth Scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    const headerOffset = 80;
                    const elementPosition = target.getBoundingClientRect().top;
                    const offsetPosition = elementPosition + window.pageYOffset - headerOffset;
                    
                    window.scrollTo({
                        top: offsetPosition,
                        behavior: 'smooth'
                    });
                }
            });
        });
        
        // Initialize Map
        function initMap() {
            const statusElement = document.getElementById('locationStatus');
            const defaultLocation = { lat: <?php echo DEFAULT_LAT; ?>, lng: <?php echo DEFAULT_LNG; ?> };
            
            const map = new google.maps.Map(document.getElementById('map'), {
                zoom: <?php echo DEFAULT_ZOOM; ?>,
                center: defaultLocation,
                styles: <?php echo json_encode($map_styles); ?>
            });
            
            const marker = new google.maps.Marker({
                position: defaultLocation,
                map: map,
                title: '<?php echo DEFAULT_LOCATION_NAME; ?>',
                animation: google.maps.Animation.DROP
            });
            
            const infoWindow = new google.maps.InfoWindow({
                content: '<div style="color: #0a192f; padding: 10px;"><h3 style="margin: 0 0 5px 0;"><?php echo DEFAULT_LOCATION_NAME; ?></h3><p style="margin: 0;">Ubicación predeterminada</p></div>'
            });
            
            marker.addListener('click', function() {
                infoWindow.open(map, marker);
            });
            
            // Try to get user's actual location
            if (navigator.geolocation) {
                statusElement.innerHTML = '🔍 Buscando tu ubicación...';
                
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        currentPosition = position; // Guardar para uso posterior
                        
                        const userLocation = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude
                        };
                        
                        map.setCenter(userLocation);
                        marker.setPosition(userLocation);
                        marker.setAnimation(google.maps.Animation.BOUNCE);
                        
                        setTimeout(() => marker.setAnimation(null), 2000);
                        
                        const accuracy = position.coords.accuracy;
                        infoWindow.setContent(
                            '<div style="color: #0a192f; padding: 10px; font-family: DM Sans, sans-serif;">' +
                            '<h3 style="margin: 0 0 10px 0;">📍 Tu Ubicación</h3>' +
                            '<p style="margin: 5px 0; font-size: 0.9rem;">' +
                            '<strong>Latitud:</strong> ' + userLocation.lat.toFixed(6) + '<br>' +
                            '<strong>Longitud:</strong> ' + userLocation.lng.toFixed(6) + '<br>' +
                            '<strong>Precisión:</strong> ±' + Math.round(accuracy) + ' metros' +
                            '</p></div>'
                        );
                        
                        infoWindow.open(map, marker);
                        
                        statusElement.innerHTML = '✅ Ubicación obtenida - Lat: ' + 
                            userLocation.lat.toFixed(4) + ', Lng: ' + userLocation.lng.toFixed(4);
                        statusElement.style.background = 'rgba(100, 255, 218, 0.2)';
                    },
                    function(error) {
                        let errorMsg = '⚠️ ';
                        switch(error.code) {
                            case error.PERMISSION_DENIED:
                                errorMsg += 'Permiso denegado. Permite el acceso a tu ubicación.';
                                break;
                            case error.POSITION_UNAVAILABLE:
                                errorMsg += 'Ubicación no disponible.';
                                break;
                            case error.TIMEOUT:
                                errorMsg += 'Tiempo de espera agotado.';
                                break;
                            default:
                                errorMsg += 'Error desconocido.';
                        }
                        
                        statusElement.innerHTML = errorMsg;
                        statusElement.style.background = 'rgba(255, 107, 107, 0.2)';
                        statusElement.style.color = '#ff6b6b';
                        infoWindow.open(map, marker);
                    },
                    {
                        enableHighAccuracy: true,
                        timeout: 10000,
                        maximumAge: 0
                    }
                );
            } else {
                statusElement.innerHTML = '❌ Geolocalización no soportada';
                statusElement.style.background = 'rgba(255, 107, 107, 0.2)';
                statusElement.style.color = '#ff6b6b';
            }
        }
        
        // Save location to database
        document.getElementById('saveLocationBtn').addEventListener('click', function() {
            if (!currentPosition) {
                alert('⚠️ Primero permite el acceso a tu ubicación');
                return;
            }
            
            const button = this;
            button.disabled = true;
            button.textContent = '💾 Guardando...';
            
            const formData = new FormData();
            formData.append('action', 'save');
            formData.append('latitude', currentPosition.coords.latitude);
            formData.append('longitude', currentPosition.coords.longitude);
            formData.append('accuracy', currentPosition.coords.accuracy);
            
            fetch('actions/save_location.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('✅ ' + data.message);
                    button.textContent = '✅ Ubicación Guardada';
                    button.style.background = 'linear-gradient(135deg, #10b981 0%, #059669 100%)';
                } else {
                    alert('❌ Error: ' + data.message);
                    button.disabled = false;
                    button.textContent = '💾 Guardar Mi Ubicación';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('❌ Error al guardar la ubicación');
                button.disabled = false;
                button.textContent = '💾 Guardar Mi Ubicación';
            });
        });
    </script>
    
    <!-- Google Maps API -->
    <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo GOOGLE_MAPS_API_KEY; ?>&callback=initMap" async defer></script>
</body>
</html>