<?php
require __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Email
{
    public $email;
    public $nombre;
    public $token;

    public function __construct($email, $nombre, $token) {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    /**
     * Método privado para crear y configurar la instancia de PHPMailer
     * @return PHPMailer
     * @throws Exception
     */
    private function crearMailer(): PHPMailer {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];
        
        $mail->setFrom('vinilostruchos@tienda.com', 'VinilosTruchos'); 

        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';
        
        return $mail;
    }

    //Envía el email de confirmación de cuenta
    public function enviarConfirmacion(): bool {
        try {
            $mail = $this->crearMailer();

            $mail->addAddress($this->email, $this->nombre);
            
            $mail->Subject = 'Confirma tu Cuenta';
            $contenido = "<html>";
            $contenido .= "<p><strong>Hola " . htmlspecialchars($this->nombre) . "</strong> Has Creado tu Cuenta en Vinilos Truchos, solo debes confirmarla presionando en el siguiente enlace:</p>";
            $contenido .= "<p>Presiona Aquí: <a href='" . $_ENV['APP_URL'] . "/auth/confirmarCuenta.php?token=" . $this->token . "'>Confirmar Cuenta</a></p>";
            $contenido .= "<p>Si tu no solicitaste esta cuenta, puedes ignorar el mensaje</p>";
            $contenido .= "</html>";
            $mail->Body = $contenido;

            $mail->send();
            return true;

        } catch (Exception $e) {
            return false;
        }
    }


    //Envía el email para reestablecer la contraseña
    public function enviarInstrucciones(): bool
    {
         try {
            $mail = $this->crearMailer();

            $mail->addAddress($this->email, $this->nombre);

            // 3. Contenido
            $mail->Subject = 'Reestablece tu Password';
            $contenido = "<html>";
            $contenido .= "<p><strong>Hola " . htmlspecialchars($this->nombre) . "</strong> Has solicitado reestablecer tu password, sigue el siguiente enlace para hacerlo. </p>";
            $contenido .= "<p>Presiona Aquí: <a href='" . $_ENV['APP_URL'] . "/recuperarPass.php?token=" . $this->token . "'>Reestablecer Password</a></p>";
            $contenido .= "<p>Si tu no solicitaste esta cuenta, puedes ignorar el mensaje</p>";
            $contenido .= "</html>";
            $mail->Body = $contenido;

            // 4. Enviar
            $mail->send();
            return true;

        } catch (Exception $e) {
            return false;
        }
    }
}

?>
