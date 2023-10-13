<?php

namespace App\Controllers;

use App\Models\Clientes;
use Illuminate\Support\Facades\Response;

class ClientesController
{
    public $client;

    public function __construct()
    {
        $this->client = new Clientes();
    }

    public function get()
    {
        return json_encode($this->client->getClientes());
    }

    public function createController()
    {
        return $this->client->create();
    }

    public function deleteControler($id)
    {
        if ($id) {
            return json_encode($this->client->delete($id));
        }
    }

    public function detailController($id)
    {
        if ($id) {
            return json_encode($this->client->detail($id));
        }
    }

    public function updateController($id)
    {
        if ($id) {
            return $this->client->update($id);
        }
    }
}
