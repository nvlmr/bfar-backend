<?php
// app/models/ResearchTeam.php

class ResearchTeam {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    /**
     * Get all researchers with optional search
     */
    public function getAll($search = '') {
        $sql = "SELECT * FROM research_teams WHERE 1=1";
        
        if(!empty($search)) {
            $sql .= " AND (first_name LIKE :search 
                      OR last_name LIKE :search 
                      OR CONCAT(first_name, ' ', last_name) LIKE :search
                      OR designation LIKE :search
                      OR institution LIKE :search)";
        }
        
        $sql .= " ORDER BY created_at DESC";
        
        $stmt = $this->db->prepare($sql);
        
        if(!empty($search)) {
            $searchTerm = "%{$search}%";
            $stmt->bindParam(':search', $searchTerm);
        }
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    
    /**
     * Get researcher by ID
     */
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM research_teams WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
    
    /**
     * Create new researcher
     */
    public function create($data, $imageName = null) {
        $sql = "INSERT INTO research_teams (
                    user_id, first_name, middle_name, last_name, suffix, 
                    email, designation, department, institution, research_interest, 
                    image, status, created_at, updated_at
                ) VALUES (
                    :user_id, :first_name, :middle_name, :last_name, :suffix,
                    :email, :designation, :department, :institution, :research_interest,
                    :image, :status, NOW(), NOW()
                )";
        
        $stmt = $this->db->prepare($sql);
        
        // Set default user_id to 1 if not provided
        $user_id = isset($data['user_id']) ? $data['user_id'] : 1;
        
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':first_name', $data['first_name']);
        $stmt->bindParam(':middle_name', $data['middle_name']);
        $stmt->bindParam(':last_name', $data['last_name']);
        $stmt->bindParam(':suffix', $data['suffix']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':designation', $data['designation']);
        $stmt->bindParam(':department', $data['department']);
        $stmt->bindParam(':institution', $data['institution']);
        $stmt->bindParam(':research_interest', $data['research_interest']);
        $stmt->bindParam(':image', $imageName);
        
        // Handle status - default to 0 if not set
        $status = isset($data['status']) ? (int)$data['status'] : 0;
        $stmt->bindParam(':status', $status);
        
        return $stmt->execute();
    }
    
    /**
     * Update researcher
     * This ONLY updates the fields that are provided in $data
     * All other fields remain unchanged
     */
    public function update($id, $data, $imageName = null) {
        // Build the SQL dynamically based on what needs to be updated
        $fields = [];
        $params = [];
        
        // Only include fields that are provided in $data
        if(isset($data['first_name'])) {
            $fields[] = "first_name = :first_name";
            $params[':first_name'] = $data['first_name'];
        }
        
        if(isset($data['middle_name'])) {
            $fields[] = "middle_name = :middle_name";
            $params[':middle_name'] = $data['middle_name'];
        }
        
        if(isset($data['last_name'])) {
            $fields[] = "last_name = :last_name";
            $params[':last_name'] = $data['last_name'];
        }
        
        if(isset($data['suffix'])) {
            $fields[] = "suffix = :suffix";
            $params[':suffix'] = $data['suffix'];
        }
        
        if(isset($data['email'])) {
            $fields[] = "email = :email";
            $params[':email'] = $data['email'];
        }
        
        if(isset($data['designation'])) {
            $fields[] = "designation = :designation";
            $params[':designation'] = $data['designation'];
        }
        
        if(isset($data['department'])) {
            $fields[] = "department = :department";
            $params[':department'] = $data['department'];
        }
        
        if(isset($data['institution'])) {
            $fields[] = "institution = :institution";
            $params[':institution'] = $data['institution'];
        }
        
        if(isset($data['research_interest'])) {
            $fields[] = "research_interest = :research_interest";
            $params[':research_interest'] = $data['research_interest'];
        }
        
        if(isset($data['status'])) {
            $fields[] = "status = :status";
            $params[':status'] = (int)$data['status'];
        }
        
        // Add image if provided
        if($imageName) {
            $fields[] = "image = :image";
            $params[':image'] = $imageName;
        }
        
        // Always update the updated_at timestamp
        $fields[] = "updated_at = NOW()";
        
        // Build the query
        $sql = "UPDATE research_teams SET " . implode(', ', $fields) . " WHERE id = :id";
        $params[':id'] = $id;
        
        $stmt = $this->db->prepare($sql);
        
        // Bind all parameters
        foreach($params as $key => &$value) {
            if($key === ':status') {
                $stmt->bindParam($key, $value, PDO::PARAM_INT);
            } else {
                $stmt->bindParam($key, $value);
            }
        }
        
        return $stmt->execute();
    }
    
    /**
     * Delete researcher (PERMANENTLY removes from database)
     */
    public function delete($id) {
        // First get the image name to delete the file
        $researcher = $this->getById($id);
        
        $stmt = $this->db->prepare("DELETE FROM research_teams WHERE id = :id");
        $stmt->bindParam(':id', $id);
        
        if($stmt->execute()) {
            return $researcher; // Return researcher data to delete image file
        }
        return false;
    }
    
    /**
     * Check if a Director already exists (more flexible)
     */
    public function directorExists() {
        // Look for any designation that contains 'director' (case insensitive)
        $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM research_teams WHERE LOWER(designation) LIKE LOWER('%director%')");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result->total > 0;
    }
    
    /**
     * Get the current Director if exists
     */
    public function getDirector() {
        $stmt = $this->db->prepare("SELECT * FROM research_teams WHERE LOWER(designation) LIKE LOWER('%director%') LIMIT 1");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
    
    /**
     * Count total researchers
     */
    public function getTotalCount() {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM research_teams");
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result->total;
    }
    
    /**
     * Get published researchers only (for public website)
     * Director appears first if they exist and are published
     */
    public function getPublished() {
        $stmt = $this->db->prepare("SELECT * FROM research_teams WHERE status = 1 ORDER BY 
                                     CASE 
                                        WHEN LOWER(designation) LIKE LOWER('%director%') THEN 0 
                                        ELSE 1 
                                     END, created_at DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    
    /**
     * Get researchers by institution
     */
    public function getByInstitution($institution) {
        $stmt = $this->db->prepare("SELECT * FROM research_teams WHERE institution = :institution ORDER BY last_name ASC");
        $stmt->bindParam(':institution', $institution);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    
    /**
     * Check if email already exists
     */
    public function emailExists($email) {
        $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM research_teams WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result->total > 0;
    }

    /**
     * Check if email exists excluding a specific ID (for update)
     */
    public function emailExistsExcludingId($email, $id) {
        $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM research_teams WHERE email = :email AND id != :id");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result->total > 0;
    }
    
    /**
     * Search researchers for public (only published ones)
     * Director appears first if they match the search
     */
    public function search($keyword) {
        $sql = "SELECT * FROM research_teams WHERE status = 1 AND (
                    first_name LIKE :keyword 
                    OR last_name LIKE :keyword
                    OR designation LIKE :keyword
                    OR institution LIKE :keyword
                    OR research_interest LIKE :keyword
                ) ORDER BY 
                    CASE 
                        WHEN LOWER(designation) LIKE LOWER('%director%') THEN 0 
                        ELSE 1 
                    END, last_name ASC";
        
        $stmt = $this->db->prepare($sql);
        $searchTerm = "%{$keyword}%";
        $stmt->bindParam(':keyword', $searchTerm);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}