<?php
require_once 'UserRepositoryInterface.php';

class UserRepository implements UserRepositoryInterface {
    private $db;

    public function __construct(ConnectionInterface $db) {
        $this->db = $db;
    }

    public function userExists($user_id) {
        $user_id = $this->db->getConnection()->real_escape_string($user_id);

        $sql = "SELECT COUNT(*) as count FROM USERS WHERE user_id = '$user_id'";

        $result = $this->db->getConnection()->query($sql);

        if ($result) {
            $row = $result->fetch_assoc();
            return $row['count'] > 0;
        } else {
            return false;
        }
    }
}