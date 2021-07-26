<?php
namespace App;

use App\Database;

class User extends Database {


    /**
     * We only simulate here real database queries
     */
    public function getUser($id)
    {
        return $this->fetchUser($id);
    }
}