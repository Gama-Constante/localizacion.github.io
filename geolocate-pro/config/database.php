<?php

 * @author Claude
 * @version 1.0
 */

class Database {
    private $host = 'localhost';
    private $db_name = 'geolocate_db';
    private $username = 'root';
    private $password = '';
    private $charset = 'utf8mb4';
    private $pdo;
    private $error;
    
    /**
     * Constructor - Establece la conexión
     */
    public function __construct() {
        $dsn = "mysql:host={$this->host};dbname={$this->db_name};charset={$this->charset}";
        
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
            PDO::ATTR_PERSISTENT         => true,
        ];
        
        try {
            $this->pdo = new PDO($dsn, $this->username, $this->password, $options);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            throw new Exception("Error de conexión: " . $this->error);
        }
    }
    
    /**
     * Obtiene la instancia de PDO
     * @return PDO
     */
    public function getConnection() {
        return $this->pdo;
    }
    
    /**
     * Ejecuta una consulta preparada
     * @param string $query
     * @param array $params
     * @return PDOStatement
     */
    public function query($query, $params = []) {
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            throw new Exception("Error en query: " . $e->getMessage());
        }
    }
    
    /**
     * Inserta un registro
     * @param string $table
     * @param array $data
     * @return int Last Insert ID
     */
    public function insert($table, $data) {
        $fields = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        
        $sql = "INSERT INTO {$table} ({$fields}) VALUES ({$placeholders})";
        
        $this->query($sql, $data);
        return $this->pdo->lastInsertId();
    }
    
    /**
     * Actualiza un registro
     * @param string $table
     * @param array $data
     * @param string $where
     * @param array $whereParams
     * @return int Affected rows
     */
    public function update($table, $data, $where, $whereParams = []) {
        $set = [];
        foreach (array_keys($data) as $field) {
            $set[] = "{$field} = :{$field}";
        }
        $set = implode(', ', $set);
        
        $sql = "UPDATE {$table} SET {$set} WHERE {$where}";
        
        $params = array_merge($data, $whereParams);
        $stmt = $this->query($sql, $params);
        
        return $stmt->rowCount();
    }
    
    /**
     * Elimina un registro
     * @param string $table
     * @param string $where
     * @param array $params
     * @return int Affected rows
     */
    public function delete($table, $where, $params = []) {
        $sql = "DELETE FROM {$table} WHERE {$where}";
        $stmt = $this->query($sql, $params);
        return $stmt->rowCount();
    }
    
    /**
     * Selecciona registros
     * @param string $table
     * @param string $fields
     * @param string $where
     * @param array $params
     * @return array
     */
    public function select($table, $fields = '*', $where = '', $params = []) {
        $sql = "SELECT {$fields} FROM {$table}";
        if (!empty($where)) {
            $sql .= " WHERE {$where}";
        }
        
        $stmt = $this->query($sql, $params);
        return $stmt->fetchAll();
    }
    
    /**
     * Cuenta registros
     * @param string $table
     * @param string $where
     * @param array $params
     * @return int
     */
    public function count($table, $where = '', $params = []) {
        $sql = "SELECT COUNT(*) as total FROM {$table}";
        if (!empty($where)) {
            $sql .= " WHERE {$where}";
        }
        
        $stmt = $this->query($sql, $params);
        $result = $stmt->fetch();
        return (int) $result['total'];
    }
    
    /**
     * Inicia una transacción
     */
    public function beginTransaction() {
        return $this->pdo->beginTransaction();
    }
    
    /**
     * Confirma una transacción
     */
    public function commit() {
        return $this->pdo->commit();
    }
    
    /**
     * Revierte una transacción
     */
    public function rollback() {
        return $this->pdo->rollback();
    }
}

// =============================================
// EJEMPLO DE USO
// =============================================

/**
 * Clase para manejar ubicaciones de usuarios
 */
class LocationManager {
    private $db;
    
    public function __construct(Database $database) {
        $this->db = $database;
    }
    
    /**
     * Guarda una ubicación
     */
    public function saveLocation($userId, $latitude, $longitude, $accuracy = null) {
        $data = [
            'user_id' => $userId,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'accuracy' => $accuracy,
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        return $this->db->insert('user_locations', $data);
    }
    
    /**
     * Obtiene las ubicaciones de un usuario
     */
    public function getUserLocations($userId, $limit = 10) {
        return $this->db->select(
            'user_locations',
            '*',
            'user_id = :user_id ORDER BY created_at DESC LIMIT ' . (int)$limit,
            ['user_id' => $userId]
        );
    }
    
    /**
     * Obtiene la última ubicación de un usuario
     */
    public function getLastLocation($userId) {
        $results = $this->db->select(
            'user_locations',
            '*',
            'user_id = :user_id ORDER BY created_at DESC LIMIT 1',
            ['user_id' => $userId]
        );
        
        return !empty($results) ? $results[0] : null;
    }
    
    /**
     * Elimina ubicaciones antiguas
     */
    public function cleanOldLocations($days = 30) {
        $date = date('Y-m-d H:i:s', strtotime("-{$days} days"));
        
        return $this->db->delete(
            'user_locations',
            'created_at < :date',
            ['date' => $date]
        );
    }
}

?>