<?php
/**
 * Save Location Script
 * GeoLocate Pro - Guarda ubicaciones de usuarios en la base de datos
 * 
 * @author Claude
 * @version 1.0
 */

// Iniciar sesión para identificar usuarios
session_start();

// Incluir archivo de base de datos
require_once 'database.php';

// Configurar headers para JSON
header('Content-Type: application/json');

// Función para enviar respuestas JSON
function jsonResponse($success, $message, $data = null) {
    echo json_encode([
        'success' => $success,
        'message' => $message,
        'data' => $data
    ]);
    exit;
}

// Verificar que sea una petición POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(false, 'Método no permitido');
}

try {
    // Crear conexión a la base de datos
    $database = new Database();
    $locationManager = new LocationManager($database);
    
    // Obtener datos del POST
    $action = isset($_POST['action']) ? $_POST['action'] : '';
    
    switch ($action) {
        case 'save':
            // Guardar nueva ubicación
            $userId = session_id(); // Identificador único del usuario
            $latitude = filter_input(INPUT_POST, 'latitude', FILTER_VALIDATE_FLOAT);
            $longitude = filter_input(INPUT_POST, 'longitude', FILTER_VALIDATE_FLOAT);
            $accuracy = filter_input(INPUT_POST, 'accuracy', FILTER_VALIDATE_FLOAT);
            
            // Validar datos
            if ($latitude === false || $longitude === false) {
                jsonResponse(false, 'Coordenadas inválidas');
            }
            
            // Validar rangos de coordenadas
            if ($latitude < -90 || $latitude > 90 || $longitude < -180 || $longitude > 180) {
                jsonResponse(false, 'Coordenadas fuera de rango');
            }
            
            // Guardar en base de datos
            $id = $locationManager->saveLocation($userId, $latitude, $longitude, $accuracy);
            
            jsonResponse(true, 'Ubicación guardada correctamente', [
                'id' => $id,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'accuracy' => $accuracy
            ]);
            break;
            
        case 'get_last':
            // Obtener última ubicación del usuario
            $userId = session_id();
            $location = $locationManager->getLastLocation($userId);
            
            if ($location) {
                jsonResponse(true, 'Ubicación encontrada', $location);
            } else {
                jsonResponse(false, 'No se encontró ubicación guardada');
            }
            break;
            
        case 'get_history':
            // Obtener historial de ubicaciones
            $userId = session_id();
            $limit = isset($_POST['limit']) ? (int)$_POST['limit'] : 10;
            $locations = $locationManager->getUserLocations($userId, $limit);
            
            jsonResponse(true, 'Historial obtenido', [
                'count' => count($locations),
                'locations' => $locations
            ]);
            break;
            
        case 'save_visit':
            // Guardar visita al sitio
            $visitData = [
                'ip_address' => $_SERVER['REMOTE_ADDR'],
                'user_agent' => $_SERVER['HTTP_USER_AGENT'],
                'page_url' => isset($_POST['page_url']) ? $_POST['page_url'] : '',
                'referrer' => isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '',
                'visited_at' => date('Y-m-d H:i:s')
            ];
            
            $id = $database->insert('visits', $visitData);
            jsonResponse(true, 'Visita registrada', ['id' => $id]);
            break;
            
        case 'save_comment':
            // Guardar comentario con ubicación
            $userName = isset($_POST['user_name']) ? trim($_POST['user_name']) : '';
            $userEmail = isset($_POST['user_email']) ? trim($_POST['user_email']) : '';
            $comment = isset($_POST['comment']) ? trim($_POST['comment']) : '';
            $latitude = filter_input(INPUT_POST, 'latitude', FILTER_VALIDATE_FLOAT);
            $longitude = filter_input(INPUT_POST, 'longitude', FILTER_VALIDATE_FLOAT);
            
            // Validar datos requeridos
            if (empty($userName) || empty($comment)) {
                jsonResponse(false, 'Nombre y comentario son requeridos');
            }
            
            $commentData = [
                'user_name' => $userName,
                'user_email' => $userEmail,
                'comment' => $comment,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'is_approved' => 0,
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            $id = $database->insert('comments', $commentData);
            jsonResponse(true, 'Comentario guardado (pendiente de aprobación)', ['id' => $id]);
            break;
            
        default:
            jsonResponse(false, 'Acción no válida');
    }
    
} catch (Exception $e) {
    // Log del error (en producción, usar un sistema de logs apropiado)
    error_log('Error en save_location.php: ' . $e->getMessage());
    jsonResponse(false, 'Error al procesar la solicitud: ' . $e->getMessage());
}
?>