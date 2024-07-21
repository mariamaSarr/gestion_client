<?php

require_once __DIR__ . '/../models/Client.php';
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../vendor/tecnickcom/tcpdf/tcpdf.php';



class ClientController
{
    private $pdo;
    private $clientModel;

    public function __construct()
    {
        $dbConfig = require __DIR__ . '/../../config/database.php';

        if (!is_array($dbConfig)) {
            throw new Exception('Invalid database configuration');
        }

        $this->pdo = new PDO(
            'mysql:host=' . $dbConfig['host'] . ';dbname=' . $dbConfig['dbname'],
            $dbConfig['user'],
            $dbConfig['pass']
        );

        $this->clientModel = new Client($this->pdo);
    }

    public function index()
    {
        $filters = [
            'name' => $_GET['name'] ?? '',
            'address' => $_GET['address'] ?? '',
            'phone' => $_GET['phone'] ?? ''
        ];

        $sort = $_GET['sort'] ?? '';

        $clients = $this->clientModel->getAll($filters, $sort);
        

        require __DIR__ . '/../../views/ClientsView/index.php';
    }
    

    public function create()
    {
        require __DIR__ . '/../../views/ClientsView/create.php';
    }

    public function store()
    {
        $data = [
            'name' => $_POST['name'],
            'address' => $_POST['address'],
            'phone' => $_POST['phone'],
            'email' => $_POST['email'],
            'gender' => $_POST['gender'],
            'status' => $_POST['status']
        ];
        $this->clientModel->create($data);
        header('Location: /gestion_clients/publics ');
    }

    public function edit($id)
    {
        $client = $this->clientModel->getById($id);
        require __DIR__ . '/../../views/ClientsView/edit.php';
    }

    public function update($id)
    {
        $data = [
            'name' => $_POST['name'],
            'address' => $_POST['address'],
            'phone' => $_POST['phone'],
            'email' => $_POST['email'],
            'gender' => $_POST['gender'],
            'status' => $_POST['status']
        ];
        $this->clientModel->update($id, $data);
        header('Location: /gestion_clients/publics');
    }

    public function destroy($id)
    {
        $this->clientModel->delete($id);
        header('Location: /gestion_clients/publics');
    }
    public function export($format)
{
    $clients = $this->clientModel->getAll();

    if ($format == 'csv') {
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="clients.csv"');

        $output = fopen('php://output', 'w');
        fputcsv($output, ['ID', 'Nom', 'Adresse', 'Téléphone', 'Email', 'Sexe', 'Statut']);

        foreach ($clients as $client) {
            fputcsv($output, $client);
        }

        fclose($output);
        exit();
    } elseif ($format == 'pdf') {
        // Utilisation de la librairie TCPDF pour générer un fichier PDF

        $pdf = new TCPDF();
        $pdf->AddPage();
        $pdf->SetFont('helvetica', '', 12);

        $html = '<h1>Liste des Clients</h1><table border="1"><thead><tr>
                    <th>ID</th><th>Nom</th><th>Adresse</th><th>Téléphone</th><th>Email</th><th>Sexe</th><th>Statut</th>
                 </tr></thead><tbody>';

        foreach ($clients as $client) {
            $html .= '<tr>
                        <td>' . htmlspecialchars($client['id']) . '</td>
                        <td>' . htmlspecialchars($client['name']) . '</td>
                        <td>' . htmlspecialchars($client['address']) . '</td>
                        <td>' . htmlspecialchars($client['phone']) . '</td>
                        <td>' . htmlspecialchars($client['email']) . '</td>
                        <td>' . htmlspecialchars($client['gender']) . '</td>
                        <td>' . htmlspecialchars($client['status']) . '</td>
                      </tr>';
        }

        $html .= '</tbody></table>';
        $pdf->writeHTML($html, true, false, true, false, '');

        $pdf->Output('clients.pdf', 'D');
        exit();
    }
}

}
?>
