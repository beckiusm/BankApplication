<?php

namespace bankApp;

class UserInfo
{
    public function __construct(Database $db)
    {
        $this->db = $db->getDB();
    }
    public function getBalance($user) // get balance from one user
    {
        $stmt = $this->db->prepare("SELECT balance FROM vw_users WHERE id = ?");
        $stmt->execute([$user]);
        $result = $stmt->fetch();
        return $result["balance"];
    }
    public function getCurrency($user) // get currency type from one user
    {
        $stmt = $this->db->prepare("SELECT currency FROM account WHERE user_id = ?");
        $stmt->execute([$user]);
        $result = $stmt->fetch();
        return $result["currency"];
    }
    public function getAllUsers() // get list of all users, return as json
    {
        $stmt = $this->db->query("SELECT firstName, lastName, id, mobilephone FROM users");
        $result = $stmt->fetchAll();
        return json_encode($result);
    }
    public function getIdFromPhone($number) // get id from phone number
    {
        $stmt = $this->db->prepare("SELECT id FROM users where mobilephone = ?");
        $stmt->execute([$number]);
        $result = $stmt->fetch();
        return $result["id"];
    }
}