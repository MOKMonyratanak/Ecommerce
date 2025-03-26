<?php

namespace App\Services;

use App\Models\User;

class UserSV extends BaseService {
    public function getQuery() {
        return User::query();
    }

    public function getUser($global_id) {
        return $this->getByGlobalId($global_id);
    }


    // Take a look here once again
    public function getAllUsers() {
        $query = $this->getQuery();
        $users = $query->where('is_active', 'yes')->get();
        return $users;
    }

    public function getUserByID($id) {
        return $this->getByID($id);
    }

    public function createUser($data) {
        return $this->create($data);
    }

    public function updateUser($global_id, $data) {
        $query = $this->getQuery();
        return $this->update($data, $global_id);
    }

    public function deleteUser($global_id) {
        return $this->softDelete($global_id);
    }
}