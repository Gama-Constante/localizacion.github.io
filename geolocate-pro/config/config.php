<?php
/**
 * Configuration File
 * GeoLocate Pro - Geolocation Educational Portal
 * 
 * Este archivo contiene todas las configuraciones principales del sitio.
 * Modifica estos valores según tus necesidades.
 */

// ============================================
// CONFIGURACIÓN GENERAL
// ============================================

define('SITE_NAME', 'GeoLocate Pro');
define('SITE_DESCRIPTION', 'Portal Educativo de Geolocalización');
define('SITE_VERSION', '1.0.0');
define('SITE_AUTHOR', 'Gama');

// ============================================
// API KEYS
// ============================================

// Google Maps API Key
// Obtén tu clave en: https://console.cloud.google.com
define('GOOGLE_MAPS_API_KEY', 'AIzaSyDmWVEvbBHzZYtXeZfwOzAZ--l03XkGSzI');

// ============================================
// UBICACIÓN PREDETERMINADA
// ============================================

// Coordenadas para el mapa (por defecto: Saltillo, Coahuila)
define('DEFAULT_LAT', 25.4232);
define('DEFAULT_LNG', -100.9931);
define('DEFAULT_LOCATION_NAME', 'Saltillo, Coahuila, México');
define('DEFAULT_ZOOM', 13);

// ============================================
// CONFIGURACIÓN DE COLORES (CSS Variables)
// ============================================

$theme_colors = [
    'primary' => '#0a192f',
    'secondary' => '#172a45',
    'accent' => '#64ffda',
    'accent_dark' => '#00d4aa',
    'text' => '#8892b0',
    'text_light' => '#ccd6f6',
    'text_bright' => '#e6f1ff',
];

// ============================================
// FUENTES
// ============================================

$fonts = [
    'heading' => 'Playfair Display',  // Fuente para títulos
    'body' => 'DM Sans',              // Fuente para texto
];

// ============================================
// CONTENIDO DINÁMICO
// ============================================

// Aplicaciones que utilizan geolocalización
$geo_applications = [
    [
        'name' => 'Uber',
        'description' => 'Conecta conductores y pasajeros en tiempo real usando GPS',
        'icon' => '🚗',
        'category' => 'Transporte'
    ],
    [
        'name' => 'Google Maps',
        'description' => 'Navegación y mapas con ubicación en tiempo real',
        'icon' => '🗺️',
        'category' => 'Navegación'
    ],
    [
        'name' => 'Instagram',
        'description' => 'Etiquetado de ubicación en fotos y stories',
        'icon' => '📸',
        'category' => 'Redes Sociales'
    ],
    [
        'name' => 'Pokémon GO',
        'description' => 'Realidad aumentada basada en ubicación geográfica',
        'icon' => '🎮',
        'category' => 'Juegos'
    ],
    [
        'name' => 'Waze',
        'description' => 'Navegación colaborativa con tráfico en tiempo real',
        'icon' => '🚦',
        'category' => 'Navegación'
    ]
];

// Tipos de ubicación / tecnologías
$location_technologies = [
    [
        'type' => 'GPS (Sistema de Posicionamiento Global)',
        'description' => 'Utiliza satélites para determinar posición exacta con coordenadas lat/long',
        'precision' => 'Alta (5-10 metros)',
        'technology' => 'Señales satelitales',
        'pros' => 'Muy preciso, funciona globalmente',
        'cons' => 'Requiere línea de vista al cielo, consumo de batería'
    ],
    [
        'type' => 'Cell ID (Identificación de Celda)',
        'description' => 'Basado en torres de telefonía celular más cercanas',
        'precision' => 'Media (100-1000 metros)',
        'technology' => 'Redes celulares',
        'pros' => 'Funciona en interiores, bajo consumo',
        'cons' => 'Menor precisión en áreas rurales'
    ],
    [
        'type' => 'Wi-Fi Positioning',
        'description' => 'Triangulación mediante puntos de acceso Wi-Fi conocidos',
        'precision' => 'Media-Alta (20-50 metros)',
        'technology' => 'Redes inalámbricas',
        'pros' => 'Excelente en áreas urbanas, funciona en interiores',
        'cons' => 'Depende de bases de datos de puntos de acceso'
    ],
    [
        'type' => 'IP Geolocation',
        'description' => 'Estimación basada en la dirección IP del dispositivo',
        'precision' => 'Baja (Ciudad/Región)',
        'technology' => 'Base de datos IP',
        'pros' => 'No requiere hardware especial',
        'cons' => 'Muy impreciso, fácil de falsificar'
    ],
    [
        'type' => 'Bluetooth Beacons',
        'description' => 'Micro-localización en espacios interiores',
        'precision' => 'Muy Alta (1-5 metros)',
        'technology' => 'Señales Bluetooth Low Energy',
        'pros' => 'Excelente precisión en interiores',
        'cons' => 'Requiere infraestructura de beacons'
    ]
];

// Pasos para generar una API Key
$api_key_steps = [
    [
        'title' => 'Crear una Cuenta en Google Cloud Platform',
        'description' => 'Visita console.cloud.google.com y crea una cuenta o inicia sesión con tu cuenta de Google existente.',
        'link' => 'https://console.cloud.google.com',
        'difficulty' => 'Fácil'
    ],
    [
        'title' => 'Crear un Nuevo Proyecto',
        'description' => 'En el panel de Google Cloud, haz clic en "Crear Proyecto" y asígnale un nombre descriptivo a tu proyecto.',
        'link' => null,
        'difficulty' => 'Fácil'
    ],
    [
        'title' => 'Habilitar APIs Necesarias',
        'description' => 'Ve a "APIs y Servicios" > "Biblioteca" y habilita las APIs que necesites: Maps JavaScript API, Geocoding API, Places API, etc.',
        'link' => null,
        'difficulty' => 'Medio'
    ],
    [
        'title' => 'Crear Credenciales',
        'description' => 'En "APIs y Servicios" > "Credenciales", haz clic en "Crear Credenciales" y selecciona "Clave de API".',
        'link' => null,
        'difficulty' => 'Fácil'
    ],
    [
        'title' => 'Restringir y Proteger tu Clave',
        'description' => 'Configura restricciones de aplicación y API para proteger tu clave de usos no autorizados. Puedes limitar por dominio, dirección IP o referente HTTP.',
        'link' => null,
        'difficulty' => 'Medio'
    ]
];

// ============================================
// CONFIGURACIÓN SEO
// ============================================

$seo_config = [
    'meta_title' => 'GeoLocate Pro - Portal Educativo de Geolocalización',
    'meta_description' => 'Aprende todo sobre geolocalización: GPS, APIs, aplicaciones y tecnologías de ubicación. Portal educativo interactivo con mapas y ejemplos prácticos.',
    'meta_keywords' => 'geolocalización, GPS, API, mapas, ubicación, tecnología, educación',
    'meta_author' => 'GeoLocate Pro Team',
    'og_image' => '/assets/og-image.jpg', // Imagen para redes sociales
];

// ============================================
// CONFIGURACIÓN DE MAPA
// ============================================

$map_config = [
    'default_zoom' => DEFAULT_ZOOM,
    'min_zoom' => 3,
    'max_zoom' => 20,
    'enable_geolocation' => true,  // Intentar obtener ubicación del usuario
    'map_type' => 'roadmap',       // roadmap, satellite, hybrid, terrain
    'enable_controls' => true,
    'enable_marker_animation' => true,
];

// Estilo personalizado del mapa (dark theme)
$map_styles = [
    [
        "elementType" => "geometry",
        "stylers" => [["color" => "#0a192f"]]
    ],
    [
        "elementType" => "labels.text.fill",
        "stylers" => [["color" => "#8892b0"]]
    ],
    [
        "elementType" => "labels.text.stroke",
        "stylers" => [["color" => "#0a192f"]]
    ],
    [
        "featureType" => "administrative",
        "elementType" => "geometry.stroke",
        "stylers" => [["color" => "#64ffda"]]
    ],
    [
        "featureType" => "road",
        "elementType" => "geometry",
        "stylers" => [["color" => "#172a45"]]
    ],
    [
        "featureType" => "water",
        "elementType" => "geometry",
        "stylers" => [["color" => "#0e2439"]]
    ]
];

// ============================================
// CONFIGURACIÓN DE NAVEGACIÓN
// ============================================

$navigation_menu = [
    ['text' => '¿Qué es?', 'href' => '#que-es', 'icon' => '📍'],
    ['text' => 'Tipos', 'href' => '#tipos', 'icon' => '🛰️'],
    ['text' => 'Aplicaciones', 'href' => '#aplicaciones', 'icon' => '📱'],
    ['text' => 'API', 'href' => '#api', 'icon' => '🔑'],
    ['text' => 'Ubicaciones', 'href' => '#ubicaciones', 'icon' => '🗺️'],
];

// ============================================
// CONFIGURACIÓN DE ANIMACIONES
// ============================================

$animation_config = [
    'enable_scroll_animations' => true,
    'animation_duration' => '0.8s',
    'animation_delay_increment' => '0.1s',
    'animation_easing' => 'cubic-bezier(0.16, 1, 0.3, 1)',
];

// ============================================
// MENSAJES DEL SISTEMA
// ============================================

$system_messages = [
    'geolocation_error' => 'No se pudo obtener tu ubicación. Mostrando ubicación predeterminada.',
    'geolocation_denied' => 'Permiso de ubicación denegado. Por favor, habilita la geolocalización en tu navegador.',
    'map_load_error' => 'Error al cargar el mapa. Por favor, verifica tu conexión a internet.',
    'api_key_missing' => 'Advertencia: Configura tu clave API de Google Maps para usar el mapa interactivo.',
];

// ============================================
// RECURSOS EXTERNOS
// ============================================

$external_resources = [
    'google_fonts' => 'https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=DM+Sans:wght@400;500;700&display=swap',
    'google_maps_api' => 'https://maps.googleapis.com/maps/api/js',
];

// ============================================
// ESTADÍSTICAS Y ANALYTICS (opcional)
// ============================================

$analytics_config = [
    'google_analytics_id' => '', // Tu ID de Google Analytics (ej: G-XXXXXXXXXX)
    'enable_tracking' => false,
];

// ============================================
// CONFIGURACIÓN DE DESARROLLO
// ============================================

define('DEBUG_MODE', true);  // Cambiar a false en producción
define('SHOW_ERRORS', true);  // Cambiar a false en producción

if (DEBUG_MODE && SHOW_ERRORS) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// ============================================
// FUNCIONES AUXILIARES
// ============================================

/**
 * Función para sanitizar salida HTML
 */
function safe_output($text) {
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

/**
 * Función para generar URLs relativas
 */
function url($path = '') {
    return rtrim($_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']), '/') . '/' . ltrim($path, '/');
}

/**
 * Función para verificar si la API key está configurada
 */
function is_api_key_configured() {
    if (!defined('GOOGLE_MAPS_API_KEY')) {
        return false;
    }
    return constant('GOOGLE_MAPS_API_KEY') !== 'YOUR_API_KEY_HERE' && !empty(constant('GOOGLE_MAPS_API_KEY'));
}

?>