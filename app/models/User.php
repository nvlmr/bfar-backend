<?php

class User extends Database
{
    /* ================= BASIC FETCH ================= */

    public function findByEmail($email)
    {
        $this->query("SELECT * FROM users WHERE email = :email LIMIT 1");
        $this->bind(':email', $email);
        return $this->single();
    }

    public function findById($id)
    {
        $this->query("SELECT * FROM users WHERE id = :id LIMIT 1");
        $this->bind(':id', $id);
        return $this->single();
    }

    /* ================= PASSWORD RESET ================= */

    public function saveResetToken($email, $token, $expires)
    {
        $this->query("
            UPDATE users 
            SET reset_token = :token,
                reset_expires = :expires
            WHERE email = :email
        ");

        $this->bind(':token', $token);
        $this->bind(':expires', $expires);
        $this->bind(':email', $email);

        return $this->execute();
    }

    public function findByResetToken($token)
    {
        $this->query("
            SELECT *
            FROM users
            WHERE reset_token = :token
            AND reset_expires > NOW()
            LIMIT 1
        ");

        $this->bind(':token', $token);

        return $this->single();
    }

    public function clearResetToken($userId)
    {
        $this->query("
            UPDATE users 
            SET reset_token = NULL,
                reset_expires = NULL
            WHERE id = :id
        ");

        $this->bind(':id', $userId);

        return $this->execute();
    }

    public function updatePassword($id, $hashedPassword)
    {
        $this->query("
            UPDATE users
            SET password = :password,
                reset_token = NULL,
                reset_expires = NULL
            WHERE id = :id
        ");

        $this->bind(':password', $hashedPassword);
        $this->bind(':id', $id);

        return $this->execute();
    }

    /* ================= COUNTING METHODS ================= */

    public function countByRole($role)
    {
        $this->query("SELECT COUNT(*) as total FROM users WHERE role = :role");
        $this->bind(':role', $role);
        return $this->single()['total'];
    }

    public function countByStatusAndRole($status, $role)
    {
        $this->query("
            SELECT COUNT(*) as total 
            FROM users 
            WHERE status = :status AND role = :role
        ");

        $this->bind(':status', $status);
        $this->bind(':role', $role);

        return $this->single()['total'];
    }

    /* ================= DASHBOARD STATS ================= */

    public function getDashboardStats()
    {
        $this->query("
            SELECT 
                SUM(role = 'user') as totalUsers,
                SUM(role = 'admin') as totalAdmins,

                SUM(role = 'user' AND status = 'active') as activeUsers,
                SUM(role = 'user' AND status = 'inactive') as inactiveUsers,

                SUM(role = 'admin' AND status = 'active') as activeAdmins,
                SUM(role = 'admin' AND status = 'inactive') as inactiveAdmins

            FROM users
            WHERE role != 'super_admin'
        ");

        return $this->single();
    }

    /* ================= FETCH METHODS ================= */

    public function getByRole($role)
    {
        $this->query("
            SELECT *
            FROM users
            WHERE role = :role
            ORDER BY created_at DESC
        ");

        $this->bind(':role', $role);

        return $this->resultSet();
    }

    public function getRecentUsers($limit = 5)
    {
        $limit = (int)$limit;

        $this->query("
            SELECT 
                first_name,
                middle_name,
                last_name,
                role,
                status,
                created_at
            FROM users
            ORDER BY created_at DESC
            LIMIT $limit
        ");

        return $this->resultSet();
    }

    /* ================= UPDATE ================= */

    public function updateStatus($id, $status)
    {
        $this->query("
            UPDATE users
            SET status = :status
            WHERE id = :id
        ");

        $this->bind(':status', $status);
        $this->bind(':id', $id);

        return $this->execute();
    }

    /* ================= PAGINATION + SEARCH ================= */

    public function getPaginatedByRole($role, $search = '', $limit = 10, $offset = 0)
    {
        $limit  = (int)$limit;
        $offset = (int)$offset;

        $this->query("
            SELECT *
            FROM users
            WHERE role = :role
            AND (
                first_name LIKE :search
                OR middle_name LIKE :search
                OR last_name LIKE :search
                OR email LIKE :search
            )
            ORDER BY created_at DESC
            LIMIT $limit OFFSET $offset
        ");

        $this->bind(':role', $role);
        $this->bind(':search', "%$search%");

        return $this->resultSet();
    }

    public function countPaginatedByRole($role, $search = '')
    {
        $this->query("
            SELECT COUNT(*) as total
            FROM users
            WHERE role = :role
            AND (
                first_name LIKE :search
                OR middle_name LIKE :search
                OR last_name LIKE :search
                OR email LIKE :search
            )
        ");

        $this->bind(':role', $role);
        $this->bind(':search', "%$search%");

        return $this->single()['total'];
    }

    /* ================= CREATE USER ================= */

    public function create($data)
    {
        $this->query("
            INSERT INTO users 
            (first_name, middle_name, last_name, suffix,
            designation, institution, department, research_interest,
            email, password, role, status, created_at)
            VALUES
            (:first_name, :middle_name, :last_name, :suffix,
            :designation, :institution, :department, :research_interest,
            :email, :password, :role, :status, NOW())
        ");

        // Explicit binding (safer than loop)
        $this->bind(':first_name', $data['first_name']);
        $this->bind(':middle_name', $data['middle_name'] ?? null);
        $this->bind(':last_name', $data['last_name']);
        $this->bind(':suffix', $data['suffix'] ?? null);
        $this->bind(':designation', $data['designation'] ?? null);
        $this->bind(':institution', $data['institution'] ?? null);
        $this->bind(':department', $data['department'] ?? null);
        $this->bind(':research_interest', $data['research_interest'] ?? null);
        $this->bind(':email', $data['email']);
        $this->bind(':password', $data['password']);
        $this->bind(':role', $data['role']);
        $this->bind(':status', $data['status']);

        return $this->execute();
    }

    /* ================= EMAIL CHECK ================= */

    public function emailExists($email)
    {
        $this->query("SELECT id FROM users WHERE email = :email LIMIT 1");
        $this->bind(':email', $email);

        return $this->single() ? true : false;
    }
    
    
}