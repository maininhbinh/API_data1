<?php

namespace App\Models;

use App\connection\connection;
use Exception;

class Clientes extends connection
{
    private $table = "clientes";

    public function  getClientes()
    {
        try {
            $sql = "SELECT * FROM {$this->table}";

            $this->setQuery($sql);
            $clientes = $this->loadAllRow();
            $datas = [];

            if (count($clientes) > 0) {

                foreach ($clientes as $client) {
                    extract($client);
                    $data_item = [
                        "id" => $id,
                        'name_client' => $name_client,
                        'email' => $email,
                        'birth_day' => $birth_day,
                        'roles' => $roles,
                        'avatar' => $avatar
                    ];
                    array_push($datas, $data_item);
                }
            }
        } catch (Exception $e) {
            $datas = [
                'status' => 405,
                'message' => "không thể lấy dữ liệu {$e}"
            ];
        }

        return $datas;
    }

    public function detail($id)
    {
        try {
            $sql = "SELECT * FROM {$this->table} WHERE id = ?";

            $this->setQuery($sql);
            $data = $this->loadRow([$id]);
        } catch (Exception $e) {
            $data = [
                'status' => 405,
                'message' => "không thể lấy dữ liệu {$e}"
            ];
        }

        return $data;
    }

    public function create()
    {
        try {
            $newClient = json_decode($_POST['newClient']);

            if ($newClient != null) {
                $name_client = htmlspecialchars(strip_tags($newClient->name_client));
                $email = htmlspecialchars(strip_tags($newClient->email));
                $birth_day = htmlspecialchars(strip_tags($newClient->birth_day));
                $roles = htmlspecialchars(strip_tags($newClient->roles));
                $avatar_name = '';

                if (isset($_FILES['file'])) {
                    $dinhDang = [
                        "png",
                        "jpg",
                        "jpeg",
                        "pdf"
                    ];

                    $file_name = $_FILES['file']['name'];
                    if (!empty($file_name)) {
                        $file_size = $_FILES['file']['size'];
                        $file_tmp = $_FILES['file']['tmp_name'];
                        $avatar_name = time() . "-" . $file_name;
                        $path_name = "public/upload/avatar/" . $avatar_name;

                        $file_extension = explode('.', $file_name);
                        $file_extension = strtolower(end($file_extension));

                        if (in_array($file_extension, $dinhDang)) {
                            if ($file_size <= 1000000) {
                                move_uploaded_file($file_tmp, $path_name);
                            } else {
                                return json_encode(
                                    [
                                        "status" => 405,
                                        "message" => "tệp tin quá lớn"
                                    ]
                                );
                            }
                        }
                    }
                }

                $sql = "INSERT INTO clientes VALUES (NULL,?,?,?,?,?)";

                $this->setQuery($sql);
                $this->execute([$name_client, $email, $birth_day, $roles, $avatar_name]);
            }
        } catch (Exception $e) {
            return $data = [
                'status' => 405,
                'message' => "tạo mới thất bại {$e}",
            ];
        }
    }

    public function delete($id)
    {
        try {
            $sql = "DELETE FROM {$this->table} WHERE id = ?";

            $this->setQuery($sql);
            $this->execute([$id]);

            $data = [
                'status' => 200,
                'message' => "xóa thành công"
            ];
        } catch (Exception $e) {
            $data = [
                'status' => 405,
                'message' => "xóa thất bại {$e}"
            ];
        }

        return $data;
    }

    public function update($id)
    {
        $datas = json_decode(file_get_contents('php://input'));

        if ($datas != null) {

            $name_client = htmlspecialchars(strip_tags($datas->name_client));
            $email = htmlspecialchars(strip_tags($datas->email));
            $birth_day = htmlspecialchars(strip_tags($datas->birth_day));
            $roles = htmlspecialchars(strip_tags($datas->roles));

            $sql = "UPDATE clientes SET name_client = ?,email = ?, birth_day = ?, roles = ? WHERE id = ?";
            $this->setQuery($sql);
            $this->execute([$name_client, $email, $birth_day, $roles, $id]);
        }
    }
}
