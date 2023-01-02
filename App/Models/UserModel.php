<?php
namespace App\Models;

use Core\Model;
use PDO;

class UserModel extends Model{

    private $db;

    public function __construct(){
        $this->db = Model::getInstanceDB();
    }

    public function registrarDB($email, $pass, $emailToken){

        $sql = 'select * from users where email = :email';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $rows = $stmt->rowCount();

        if($rows > 0){

            return 0; //email registrado

        }else{

            $sql = 'insert into users values(:id, :email, :pass, default, :emailToken)';
            $stmt = $this->db->prepare($sql);

            $id = null;

            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':pass', $pass);
            $stmt->bindParam(':emailToken', $emailToken);

            if($stmt->execute()){
                return 2; // registro ok
            }else{
                return 1; // fallo en el registro
            }

        }


    }

    public function loginDB($email, $pass){

        $sql = 'select * from users where email = :email';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if($data['isEmailConfirmed'] == '0'){ // falta registro por email
            return 0;
        }else if($data['isEmailConfirmed'] == '1'){

            $sql = 'select * from users where email = :email and pass = :pass';
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':pass', $pass);
            $stmt->execute();

            if(!$stmt->execute()){
                return 1; // error en el login
            }else{
                $rows = $stmt->rowCount();
                if($rows == 1){ // login ok
                    return 2;
                }else{
                    return 3; //datos erroneos
                }
            }

        }
    }

    public function checkToken($email, $token){

        $sql = 'select * from users where email = :email';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if($data['isEmailConfirmed'] === '1'){ return 0; } // email ya confirmado

        elseif($data['emailToken'] === $token) { // tokens iguales

            $sql = 'update users set isEmailConfirmed = 1 where email = :email';
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':email', $email);
            if($stmt->execute()){ return 2; } // update ok
            else{ return 3; } // error update

        }else{ return 1; } // no coinciden tokens

    }


}
