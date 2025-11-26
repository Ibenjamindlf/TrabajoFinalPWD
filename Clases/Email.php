<?php
require __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Email
{
    public $email;
    public $nombre;
    public $token;

    // Colores de Página
    private $colorPrincipal = '#e65100'; 
    private $colorFondo = '#f3f4f6';     
    private $colorTexto = '#1f2937';     

    public function __construct($email, $nombre, $token) {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }


    private function crearMailer(): PHPMailer {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->setFrom('vinilostruchos@tienda.com', 'Vinilos Truchos'); 
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';
        return $mail;
    }


    /**
     * Plantilla Base para el Email
     */
    private function plantillaBase($titulo, $contenido) {
        return "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <style>
                body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: {$this->colorFondo}; margin: 0; padding: 0; }
                .container { max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; margin-top: 20px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
                .header { background-color: #111827; padding: 20px; text-align: center; }
                .header h1 { color: #ffffff; margin: 0; font-size: 24px; }
                .content { padding: 30px; color: {$this->colorTexto}; line-height: 1.6; }
                .btn { display: inline-block; background-color: {$this->colorPrincipal}; color: #ffffff; padding: 12px 24px; text-decoration: none; border-radius: 5px; font-weight: bold; margin-top: 20px; }
                .footer { background-color: #f9fafb; padding: 15px; text-align: center; font-size: 12px; color: #6b7280; border-top: 1px solid #e5e7eb; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>Vinilos Truchos 🎵</h1>
                </div>
                <div class='content'>
                    <h2 style='color: {$this->colorPrincipal}; margin-top: 0;'>$titulo</h2>
                    $contenido
                </div>
                <div class='footer'>
                    <p>© " . date('Y') . " Vinilos Truchos. Todos los derechos reservados.</p>
                    <p>Si no solicitaste este correo, puedes ignorarlo.</p>
                </div>
            </div>
        </body>
        </html>";
    }

    // Confirmación de Cuenta
    public function enviarConfirmacion(): bool {
        try {
            $mail = $this->crearMailer();
            $mail->addAddress($this->email, $this->nombre);
            $mail->Subject = 'Confirma tu Cuenta - Vinilos Truchos';
            
            $url = $_ENV['APP_URL'] . "/Vista/accion/Login/accionConfirmarCuenta.php?token=" . $this->token;
            
            $mensaje = "
                <p>Hola <strong>" . htmlspecialchars($this->nombre) . "</strong>,</p>
                <p>Gracias por unirte a nuestra comunidad de amantes de la música. Para comenzar a comprar, por favor confirma tu dirección de correo electrónico.</p>
                <div style='text-align: center;'>
                    <a href='$url' class='btn'>Confirmar mi Cuenta</a>
                </div>
                <p style='margin-top: 20px; font-size: 12px;'>O copia y pega este enlace en tu navegador: <br> <a href='$url'>$url</a></p>
            ";

            $mail->Body = $this->plantillaBase('¡Bienvenido!', $mensaje);
            $mail->send();
            return true;
        } catch (Exception $e) { return false; }
    }

    // Recuperar Contraseña
    public function enviarInstrucciones(): bool {
        try {
            $mail = $this->crearMailer();
            $mail->addAddress($this->email, $this->nombre);
            $mail->Subject = 'Restablecer Contraseña - Vinilos Truchos';
            
            $url = $_ENV['APP_URL'] . "/Vista/accion/Pass/accionRecuperarPass.php?token=" . $this->token;

            $mensaje = "
                <p>Hola <strong>" . htmlspecialchars($this->nombre) . "</strong>,</p>
                <p>Hemos recibido una solicitud para restablecer la contraseña de tu cuenta. Si fuiste tú, haz clic en el botón de abajo.</p>
                <div style='text-align: center;'>
                    <a href='$url' class='btn'>Restablecer Contraseña</a>
                </div>
                <p>Si no solicitaste este cambio, tu cuenta está segura y no necesitas hacer nada.</p>
            ";

            $mail->Body = $this->plantillaBase('Recuperación de Acceso', $mensaje);
            $mail->send();
            return true;
        } catch (Exception $e) { return false; }
    }

    // Resumen de Compra
    public function enviarResumenCompra($productos, $total): bool {
        try {
            $mail = $this->crearMailer();
            $mail->addAddress($this->email, $this->nombre);
            $mail->Subject = 'Tu Compra ha sido Confirmada - Vinilos Truchos';

            $tablaProductos = "
            <table style='width: 100%; border-collapse: collapse; margin-top: 20px;'>
                <thead>
                    <tr style='background-color: #f3f4f6; text-align: left;'>
                        <th style='padding: 10px; border-bottom: 2px solid #e5e7eb;'>Producto</th>
                        <th style='padding: 10px; border-bottom: 2px solid #e5e7eb;'>Cant.</th>
                        <th style='padding: 10px; border-bottom: 2px solid #e5e7eb; text-align: right;'>Precio</th>
                    </tr>
                </thead>
                <tbody>";
            
            foreach ($productos as $p) {
                $subtotal = $p['precio'] * $p['cantidad'];
                $tablaProductos .= "
                <tr>
                    <td style='padding: 10px; border-bottom: 1px solid #e5e7eb;'>" . htmlspecialchars($p['nombre']) . "</td>
                    <td style='padding: 10px; border-bottom: 1px solid #e5e7eb;'>" . $p['cantidad'] . "</td>
                    <td style='padding: 10px; border-bottom: 1px solid #e5e7eb; text-align: right;'>$" . number_format($subtotal, 2, ',', '.') . "</td>
                </tr>";
            }
            
            $tablaProductos .= "
                <tr style='font-weight: bold; font-size: 18px;'>
                    <td colspan='2' style='padding: 15px; text-align: right;'>Total:</td>
                    <td style='padding: 15px; text-align: right; color: {$this->colorPrincipal};'>$" . number_format($total, 2, ',', '.') . "</td>
                </tr>
                </tbody>
            </table>";

            $mensaje = "
                <p>Hola <strong>" . htmlspecialchars($this->nombre) . "</strong>,</p>
                <p>¡Tu pago ha sido procesado con éxito! Estamos preparando tu pedido para enviarlo lo antes posible.</p>
                $tablaProductos
                <div style='text-align: center;'>
                    <a href='" . $_ENV['APP_URL'] . "/Vista/miCuenta.php' class='btn'>Ver mis Pedidos</a>
                </div>
            ";

            $mail->Body = $this->plantillaBase('¡Gracias por tu Compra!', $mensaje);
            $mail->send();
            return true;
        } catch (Exception $e) { return false; }
    }


    // Actualización de Estado
    public function enviarActualizacionEstado($idCompra, $nombreEstado): bool {
        try {
            $mail = $this->crearMailer();
            $mail->addAddress($this->email, $this->nombre);
            $mail->Subject = "Novedades de tu Pedido #$idCompra";

            $info = $this->obtenerInfoEstado($nombreEstado);
            $colorEstado = $info['color'];
            $textoEstado = $info['mensaje'];

            $mensaje = "
                <p>Hola <strong>" . htmlspecialchars($this->nombre) . "</strong>,</p>
                <p>Tenemos novedades sobre tu pedido <strong>#$idCompra</strong>.</p>
                
                <div style='background-color: #f9fafb; border-left: 5px solid $colorEstado; padding: 15px; margin: 20px 0; border-radius: 4px;'>
                    <h3 style='margin: 0 0 5px 0; color: $colorEstado;'>" . strtoupper($nombreEstado) . "</h3>
                    <p style='margin: 0;'>$textoEstado</p>
                </div>
                
                <div style='text-align: center;'>
                    <a href='" . $_ENV['APP_URL'] . "/Vista/miCuenta.php' class='btn'>Rastrear Pedido</a>
                </div>
            ";

            $mail->Body = $this->plantillaBase('Actualización de Estado', $mensaje);
            $mail->send();
            return true;
        } catch (Exception $e) { return false; }
    }

    // Helper para mensajes de estado
    private function obtenerInfoEstado($estado) {
        switch (strtoupper($estado)) {
            case 'PAGO': case 'PENDIENTE_PAGO': 
                return ['color' => '#3b82f6', 'mensaje' => 'Pago recibido correctamente.'];

            case 'PREPARACION': 
                return ['color' => '#f59e0b', 'mensaje' => 'Estamos preparando tu paquete con cuidado.'];

            case 'ENVIADO': 
                return ['color' => '#10b981', 'mensaje' => '¡Tu pedido está en camino!'];
            case 'ENTREGADO': 

                return ['color' => '#8b5cf6', 'mensaje' => 'El pedido ha sido entregado. ¡Que lo disfrutes!'];

            case 'CANCELADO': 
                return ['color' => '#ef4444', 'mensaje' => 'El pedido ha sido cancelado.'];

            default: 
                return ['color' => '#6b7280', 'mensaje' => 'El estado ha cambiado.'];
        }
    }
}
?>