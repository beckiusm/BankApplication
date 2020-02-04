<?php

// Klassen som hanterar överföringar ska ta emot ett typehintat interface i konstruktorn för olika betalningslösningar och låta minst två klasser implementera interfacet (t ex swish, banköverföring, betalkort).

namespace bankApp;

class SwishTransaction extends Transaction implements Transactions
{
    public $typeOfTransaction = "Swish";

    public function __construct(Database $db, UserInfo $userInfo)
    {
        $this->db = $db->getDB();
        $this->userInfo = $userInfo;
    }
}
