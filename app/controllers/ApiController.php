<?php
// app/controllers/ApiController.php

require_once __DIR__ . '/../models/ResearchTeam.php';

class ApiController extends Controller
{
    private $researchTeamModel;
    
    public function __construct($db) {
        parent::__construct();
        $this->researchTeamModel = new ResearchTeam($db);
    }
    
    /**
     * Get all published researchers
     * Endpoint: GET /api/research-team
     */
    public function getResearchTeam()
    {
        // Set headers for JSON response and CORS
        $this->setHeaders();
        
        // Get search parameter if any
        $search = $_GET['search'] ?? '';
        
        // Get published researchers
        if (!empty($search)) {
            $researchers = $this->researchTeamModel->search($search);
        } else {
            $researchers = $this->researchTeamModel->getPublished();
        }
        
        // Get director
        $director = $this->researchTeamModel->getDirector();
        
        // Return JSON response
        echo json_encode([
            'success' => true,
            'data' => [
                'researchers' => $researchers,
                'director' => $director
            ]
        ]);
        exit;
    }
    
    /**
     * Get single researcher by ID
     * Endpoint: GET /api/research-team/{id}
     */
    public function getResearcher($id)
    {
        $this->setHeaders();
        
        $researcher = $this->researchTeamModel->getById($id);
        
        if (!$researcher || $researcher->status != 1) {
            http_response_code(404);
            echo json_encode([
                'success' => false,
                'message' => 'Researcher not found'
            ]);
            exit;
        }
        
        echo json_encode([
            'success' => true,
            'data' => $researcher
        ]);
        exit;
    }
    
    /**
     * Get all projects (if you have projects table)
     * Endpoint: GET /api/projects
     */
    public function getProjects()
    {
        $this->setHeaders();
        
        // Load your Project model here
        // $projectModel = $this->model('Project');
        // $projects = $projectModel->getPublished();
        
        echo json_encode([
            'success' => true,
            'data' => [] // Add your data here
        ]);
        exit;
    }
    
    /**
     * Get all publications (if you have publications table)
     * Endpoint: GET /api/publications
     */
    public function getPublications()
    {
        $this->setHeaders();
        
        // Load your Publication model here
        // $publicationModel = $this->model('Publication');
        // $publications = $publicationModel->getPublished();
        
        echo json_encode([
            'success' => true,
            'data' => [] // Add your data here
        ]);
        exit;
    }
    
    /**
     * Set CORS headers
     */
    private function setHeaders()
    {
        // Allow from any origin (for development)
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type");
        header('Content-Type: application/json');
        
        // Handle preflight requests
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            http_response_code(200);
            exit;
        }
    }
}