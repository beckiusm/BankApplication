<?php

namespace bankApp;

use bankApp\Database;

class UserInfo
{
    public function __construct(Database $db)
    {
        $this->db = $db;
    }
    public function getBalance($user)
    {
        $stmt = $this->db->prepare("SELECT balance FROM vw_users WHERE id = ?");
        $stmt->execute([$user]);
        $result = $stmt->fetch();
        return $result["balance"];
    }
    public function getCurrency($user)
    {
        $stmt = $this->db->prepare("SELECT currency FROM account WHERE user_id = ?");
        $stmt->execute([$user]);
        $result = $stmt->fetch();
        return $result["currency"];
    }
}
