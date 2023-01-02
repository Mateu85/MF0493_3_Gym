<?php
namespace App\Controllers;
// use: va unido a los namespaces. Funciona como un require, include...
use Core\Controller;
use Core\View;
use App\Models\UserModel;
use Core\Security;

class UserController extends Controller{

    public function renderContactUsAction(){
        View::renderTwig('User/contact_us.html');
    }

    public function renderLoginRegAction(){
        View::renderTwig('User/login_reg.html');
    }

    public function registroAction($params){

        sleep(1);


        $email = Security::secure_input($params['reg_email']);
        $pass = Security::secure_input($params['reg_pass']);
        $pass = Security::en_de_cryptIt($pass, 'en');
        $token = Security::tokenGen(20);

        $registro = new UserModel();
        $check = $registro->registrarDB($email, $pass, $token);

        switch ($check) {

            case 0:
            echo json_encode('email allready registered in our app');
            break;

            case 1:
            echo json_encode('Registration failed');
            break;

            case 2:

            // gestion de email
            $href = $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
            $href = substr($href, 0, -9) . '/eConfirm';

            ob_start();
            View::renderTwig('Email/registro.html', array('href'=>$href, 'token'=>$token, 'email'=>$email));
            $body = ob_get_contents();
            ob_end_clean();
            $subject = 'Por favor, confirma el registro (Mateu)';

            if(!Security::email($email, $subject, $body)){
                echo json_encode('No se ha podido enviar el email de confirmación de registro. Inténtalo más tarde');
            }else{
                echo json_encode('Usuario registrado con éxito, verifica tu email para confirmar el registro ');
            }
            break;

            default:
            echo json_encode('Error en la base de datos');
            break;
        }

    }

    public function loginAction($params){

        sleep(1);

        $email = Security::secure_input($params['lg_email']);
        $pass = Security::secure_input($params['lg_pass']);
        $pass = Security::en_de_cryptIt($pass, 'en');

        $login = new UserModel;
        $check = $login->loginDB($email, $pass);


        switch ($check) {

            case 0:
            echo json_encode('Falta confirmar registro por email');
            break;
            case 1:
            echo json_encode('Error en el login');
            break;

            case 2:
            echo json_encode('Login OK');
            break;
            case 3:
            echo json_encode('Datos erroneos');
            break;
            default:
            echo json_encode('Error en la base de datos');
            break;
        }

    }
    public function emailConfirmAction($params){


       $model = new UserModel;
       $check = $model->checkToken($params['email'], $params['token']);
       $model->closeDB();

       switch($check) {
           case 0:
               echo json_encode('El registro se ha confirmado anteriormente');
               break;
           case 1:
               echo json_encode('No se ha podido confirmar el registro');
               break;
           case 2:
               echo json_encode('Registro confirmado correctamente');


               break;
           case 3:
               echo json_encode('Error en la conexión a la base de datos');
               break;
           default:
               echo json_encode('Error en la base de datos');
               break;
       }

   }
    public function contactoSendAction($params){

        $nombre = Security::secure_input($params['nombre']);
        $apellido = Security::secure_input($params['apellido']);


        // gestion de email

        ob_start();
        View::renderTwig('Email/contacto.html', array('nombre'=>$nombre, 'apellido'=>$apellido));
        $body = ob_get_contents();
        ob_end_clean();
        $subject = 'Datos del formulario de contacto';

        $email = 'pruebascifovioleta20@gmail.com';

        if(!Security::email($email, $subject, $body)){
            echo json_encode('No se ha podido enviar el email de confirmación de registro. Inténtalo más tarde');
        }else{
            echo json_encode('Se ha enviado tus datos correctamente');
        }


    }


}
