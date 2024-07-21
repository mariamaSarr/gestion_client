<?php
require_once __DIR__ . '/../../config/database.php';

class Client
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }
   

    public function getAll($filters = [], $sort = null)
    {
        $query = "SELECT * FROM clients WHERE 1=1";
        $params = [];

        // Ajout des filtres
        if (!empty($filters['name'])) {
            $query .= " AND name LIKE :name";
            $params[':name'] = '%' . $filters['name'] . '%';
        }
        if (!empty($filters['address'])) {
            $query .= " AND address LIKE :address";
            $params[':address'] = '%' . $filters['address'] . '%';
        }
        if (!empty($filters['phone'])) {
            $query .= " AND phone LIKE :phone";
            $params[':phone'] = '%' . $filters['phone'] . '%';
        }

        // Ajout du tri
        if ($sort) {
            $allowedSorts = ['name', 'address', 'phone', 'status'];
            if (in_array($sort, $allowedSorts)) {
                $query .= " ORDER BY " . $sort;
            }
        }

        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Autres méthodes CRUD...

    public function create($data)
    {
        $stmt = $this->pdo->prepare('INSERT INTO clients (name, address, phone, email, gender, status) VALUES (:name, :address, :phone, :email, :gender, :status)');
        $stmt->execute($data);
    }

    public function getById($id)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM clients WHERE id = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $data)
    {
        $data['id'] = $id;
        $stmt = $this->pdo->prepare('UPDATE clients SET name = :name, address = :address, phone = :phone, email = :email, gender = :gender, status = :status WHERE id = :id');
        $stmt->execute($data);
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare('DELETE FROM clients WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }

    public function filterByName($name)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM clients WHERE name LIKE :name');
        $stmt->execute(['name' => '%' . $name . '%']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function sortByField($field, $order = 'ASC')
    {
        $allowedFields = ['name', 'address', 'phone', 'email', 'gender', 'status'];
        
        if (!in_array($field, $allowedFields)) {
            throw new InvalidArgumentException('Invalid field for sorting');
        }

        $stmt = $this->pdo->prepare("SELECT * FROM clients ORDER BY $field $order");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}