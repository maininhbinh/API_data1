<?php

namespace App\connection;

use Exception;
use PDO;

class connection
{
    protected $connect = null;
    protected $sql = "";
    protected $sta = null;

    // hàm connect
    public function __construct()
    {
        try {
            $this->connect = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . ";charset=" . db_charset, userName, password);
        } catch (Exception $e) {
            echo "kết nối bị gián đoạn " . $e->getMessage();
        }
    }

    public function getData($query, $getAll = true)
    {
        $stmt = $this->connect->prepare($query);

        if ($getAll) {
            return $stmt->fetchAll();
        }

        return $stmt->fetch();
    }

    public function setQuery($sql)
    {
        $this->sql = $sql;
    }

    public function execute($options = [])
    {
        $this->sta = $this->connect->prepare($this->sql);
        if ($options) {
            for ($i = 0; $i < count($options); $i++) {
                $this->sta->bindParam($i + 1, $options[$i]);
            }
        }

        $this->sta->execute();

        return $this->sta;
    }

    public function loadAllRow($options = [])
    {
        if (!$options) {
            if (!$result = $this->execute()) {
                return false;
            }
        } else {
            if (!$result = $this->execute($options)) {
                return false;
            }
        }

        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function loadRow($options = [])
    {
        if (!$options) {
            if (!$result = $this->execute()) {
                return false;
            }
        } else {
            if (!$result = $this->execute($options)) {
                return false;
            }
        }

        return $result->fetch(PDO::FETCH_ASSOC);
    }

    public function getLastId()
    {
        return $this->connect->lastInsertId();
    }

    public function disconnect()
    {
        $this->sta = NULL;
        $this->connect = NULL;
    }
}
