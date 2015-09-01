<?php
ini_set("display_errors",1);
error_reporting(E_ALL);

session_start(); //inicia sesiones

/**
 * Abreviados
 * Rapport Applications
 */
include_once ("clase.php");// incluyo las clases a ser usadas
require_once("menu.php");

$action='index';

//if(isset($_SESSION['action']))
//{$action=$_SESSION['action'];}

if(isset($_POST['action']))
{$action=$_POST['action'];}



$view= new stdClass(); // creo una clase standard para contener la vista
$view->disableLayout=false;// marca si usa o no el layout , si no lo usa imprime directamente el template

switch ($action)
{
    case 'index':
        if ($result=getUserByEmailAndPassword($_GET['email'], $_GET['password'], 1)) {
            echo "<br><br><center><img src='images/UNOCOMASEIS_B_color.jpg'></center>";
            $menu->show($_GET['email'], $_GET['password']);
            if ($_GET['op'] == 1){
                $view->clientes=Abreviados::getClientes(); // tree todos los clientes
                $view->contentTemplate="templates/abreviadosGrid.php"; // seteo el template que se va a mostrar
            } else {
                $view->clientes=Usuarios::getClientes(); // tree todos los clientes
                //$key = multidimensional_search($view->clientes, array('0'=>0, '0'=>$result['id']));
                //if ($result['adm'] == "1") { $view->key = "1"; } else { $view->key = "0"; }
                $_SESSION['key'] =$result['adm'];
                $_SESSION['id'] = $result['id'];

                $view->contentTemplate="templates/usuariosGrid.php"; // seteo el template que se va a mostrar
            }
            break;
        } else {
            echo '<br>Error API-PHP: Login Erroneo';
            exit;
        }
    case 'refreshGrid':
        $view->disableLayout=true; // no usa el layout
        $view->clientes=Abreviados::getClientes();
        $view->contentTemplate="templates/abreviadosGrid.php"; // seteo el template que se va a mostrar
        break;
    case 'refresh2Grid':
        $view->disableLayout=true; // no usa el layout
        $view->clientes=Usuarios::getClientes();
        $view->contentTemplate="templates/usuariosGrid.php"; // seteo el template que se va a mostrar
        break;
    case 'saveClient':
        // limpio todos los valores antes de guardarlos
        // por ls dudas venga algo raro

            $id=intval($_POST['id']);
            $nombre=cleanString($_POST['nombre']);
            $apellido=cleanString($_POST['apellido']);
            $empresa=cleanString($_POST['empresa']);
            $departamento=cleanString($_POST['departamento']);
            $n_corto=cleanString($_POST['n_corto']);
            $n_largo=cleanString($_POST['n_largo']);
            $saldo=cleanString($_POST['saldo']);
            $cliente=new Abreviados($_POST['id']);
            $cliente->setNombre($nombre);
            $cliente->setApellido($apellido);
            $cliente->setEmpresa($empresa);
            $cliente->setDepartamento($departamento);
            $cliente->setn_corto($n_corto);
            $cliente->setn_largo($n_largo);
            $cliente->setSaldo($saldo);
            $cliente->save();
            break;
    case 'save2Client':
            $id=intval($_POST['id']);
            $nombre=cleanString($_POST['nombre']);
            $apellido=cleanString($_POST['apellido']);
            $email=cleanString($_POST['email']);
            $encrypted_password=cleanString($_POST['encrypted_password']);
            $adm=cleanString($_POST['adm']);
            //$salt=cleanString($_POST['salt']);
            //$created_at=cleanString($_POST['created_at']);
            $cliente=new Usuarios($_POST['id']);
            $cliente->setNombre($nombre);
            $cliente->setApellido($apellido);
            $cliente->setEmail($email);
            $cliente->setEncrypted_password($encrypted_password);
            $cliente->setadm($adm);
            //$cliente->setSalt($salt);
            //$cliente->setCreated_at($created_at);
        $cliente->save();
        break;
    case 'newClient':
            $view->client=new Abreviados();
            $view->label='Nuevo Cliente';
            $view->disableLayout=true;
            $view->contentTemplate="templates/abreviadosForm.php"; // seteo el template que se va a mostrar
            break;
    case 'new2Client':
            $view->client=new Usuarios();
            $view->label='Nuevo Usuario';
            $view->disableLayout=true;
            $view->contentTemplate="templates/usuariosForm.php"; // seteo el template que se va a mostrar
            break;
    case 'editClient':
        $editId=intval($_POST['id']);
        $view->label='Editar Cliente';
        $view->client=new Abreviados($editId);
        $view->disableLayout=true;
        $view->contentTemplate="templates/abreviadosForm.php"; // seteo el template que se va a mostrar
        break;
    case 'edit2Client':
        $editId=intval($_POST['id']);
        $view->label='Editar Usuario';
        $view->client=new Usuarios($editId);
        $view->disableLayout=true;
        $view->contentTemplate="templates/usuariosForm.php"; // seteo el template que se va a mostrar
        break;
    case 'deleteClient':
        $id=intval($_POST['id']);
        $client=new Abreviados($id);
        $client->delete();
        die; // no quiero mostrar nada cuando borra , solo devuelve el control.
        break;
    case 'delete2Client':
        $id=intval($_POST['id']);
        $client=new Usuarios($id);
        $client->delete();
        die; // no quiero mostrar nada cuando borra , solo devuelve el control.
        break;
    case 'pass':
			$forgotpassword = $_POST['email'];
            //$id=intval($_POST['id']);
            //$client=new Usuarios($id);

			$randomcode = random_string();


			$hash = hashSSHA($randomcode);
			$encrypted_password = $hash["encrypted"]; // encrypted password
			$salt = $hash["salt"];
			$subject = "Recuperacion de password";                      //"Password Recovery";
			$message = "Bienvenido Usuario,\n\nTu nuevo Password se ha generado correctamente. Tu nuevo password es $randomcode . Entra con tu nuevo password y accede en el panel de usuario.\n\nSaludos, \nunocomaseis.com Team.";
			//"Hello User,\n\nYour Password is sucessfully changed. Your new Password is $randomcode . Login with your new Password and change it in the User Panel.\n\nRegards,\nfuturesoft.es Team.";
			$from = "admin@unocomaseis.com";
			$headers = "From:" . $from;
			if (isUserExisted($forgotpassword)) {

				$user = forgotPassword($forgotpassword, $encrypted_password, $salt);
				if ($user) {
					$response["success"] = 1;
					mail($forgotpassword,$subject,$message,$headers);
					$response["Correcto"] = "Password creado. Revise su email.";                    //"JSON Error occured in Registartion";
					//echo json_encode($response);
                    alr('Password creado. Revise su email');

				} else {
					$response["error"] = 1;
					//echo json_encode($response);
                    alr('Error');
				}

				// user is already existed - error response

			} else {

				$response["error"] = 2;
				$response["error_msg"] = "Usuario no existe";                      //"User not exist";
				//echo json_encode($response);
                alr('Usuario no existe');

			}
        break;
    default :
}



// si esta deshabilitado el layout solo imprime el template
if ($view->disableLayout==true)
{
    include_once ($view->contentTemplate);
}  else {

    if ($_GET['op'] == 1){
        include_once ('templates/layout_abreviados.php');
    } else {
        include_once ('templates/layout_usuarios.php');
    }

    //include_once ('templates/layout.php');
} // el layout incluye el template adentro
