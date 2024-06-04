<?php
// Rutas absolutas a cada autoload de cada librería ocupada en el proyecto
require_once 'D:/xampp/htdocs/Judas/LibreriasWord/vendor/autoload.php';
require_once 'D:/xampp/htdocs/Judas/PHPmailer/vendor/autoload.php';
require_once 'D:\xampp\htdocs\Judas\PDF\vendor\autoload.php';

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\SimpleType\Jc;
use PhpOffice\PhpWord\Style\Image;
use PhpOffice\PhpWord\Settings;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Crear un nuevo documento de Word
$phpWord = new PhpWord();

// Agregamos las imágenes de la empresa
$section = $phpWord->addSection();
$header = $section->addHeader();
// Imagen en la esquina superior derecha
$header->addImage(
    'D:/xampp/htdocs/Judas/Style/cidtes.png',  // Ruta absoluta
    array(
        'width'            => 100,
        'height'           => 100,
        'positioning'      => Image::POSITION_ABSOLUTE,
        'posHorizontal'    => Image::POSITION_HORIZONTAL_RIGHT,
        'posHorizontalRel' => Image::POSITION_RELATIVE_TO_RMARGIN,
        'posVertical'      => Image::POSITION_VERTICAL_TOP,
        'posVerticalRel'   => Image::POSITION_RELATIVE_TO_PAGE,
        'marginTop'        => 0,
        'marginLeft'       => 0,
        'wrappingStyle'    => 'infront'
    )
);

// Recibir datos del formulario
$departamento = $_POST['departamento'] ?? 'No especificado';
$actividad = $_POST['Actividad'] ?? 'No especificado';
$tipo = $_POST['tipo'] ?? 'No especificado';
$incidenciaPrevia = $_POST['incidencia_previa'] ?? 'No';
$mensaje = $_POST['mensaje'] ?? 'No especificado';

// Añadir texto al documento
$section->addText(
    htmlspecialchars(
    "Buzón de Sugerencias y Quejas"
    ),
    array('name' => 'Amasis MT Pro', 'size' => '22', 'bold' => true, 'italic' => true),
    array('alignment' => Jc::CENTER)
);
$section->addTextBreak(2);

$section->addText(
    htmlspecialchars(
    "Departamento: " . $departamento
    ),
    array('name' => 'Amasis MT Pro', 'size' => '12', 'bold' => true)
);    

$section->addText(
    htmlspecialchars(
    "Actividad: " . $actividad
    ),
    array('name' => 'Amasis MT Pro', 'size' => '12', 'bold' => true)
);

$section->addText(
    htmlspecialchars(
    "Tipo: " . $tipo
    ),
    array('name' => 'Amasis MT Pro', 'size' => '12', 'bold' => true)
);

$section->addText(
    htmlspecialchars(    
    "¿Incidencia previa?: " . $incidenciaPrevia
    ),
    array('name' => 'Amasis MT Pro', 'size' => '12', 'bold' => true)
);

if ($incidenciaPrevia == 'si') {
    $seguimiento = $_POST['seguimiento'] ?? 'No especificado';
    $section->addText(
        htmlspecialchars(
        "¿Se le dio seguimiento?: " . $seguimiento
        ),
        array('name' => 'Amasis MT Pro', 'size' => '12', 'bold' => true)
    );
}

$section->addText(
    htmlspecialchars(
    "Mensaje: " . $mensaje
    ),
    array('name' => 'Amasis MT Pro', 'size' => '12', 'bold' => true)
);

// Configurar la ruta y el nombre del renderizador PDF
Settings::setPdfRendererPath('D:/xampp/htdocs/Judas/PDF/vendor/tecnickcom/tcpdf');
Settings::setPdfRendererName('TCPDF');

// Guardar el documento como Word y PDF
$writer = IOFactory::createWriter($phpWord, 'Word2007');
$writer->save('Buzon_Sugerencias_Quejas_CIDTES.docx');

try {
    $writer = IOFactory::createWriter($phpWord, 'PDF');
    $writer->save('Buzon_Sugerencias_Quejas_CIDTES.pdf');
} catch (Exception $e) {
    echo 'Error al generar el PDF: ',  $e->getMessage(), "\n";
}

// Configuración del correo electrónico
$mail = new PHPMailer(true);
try {
    // Configuración del servidor
    $mail->isSMTP();                                      // Usar SMTP
    $mail->Host       = 'smtp.office365.com';             // Especificar el servidor SMTP
    $mail->SMTPAuth   = true;                             // Habilitar autenticación SMTP
    $mail->Username   = 'buzonccidtes@hotmail.com';       // Usuario de SMTP
    $mail->Password   = 'buzonsistemas2024.';             // Contraseña de SMTP
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;   // Habilitar encriptación TLS;
    $mail->Port       = 587;                              // Puerto TCP para conectarse

    // Emisor
    $mail->setFrom('buzonccidtes@hotmail.com', 'CCIDTES');

    // Destinatario(s)
    $mail->addAddress('rhcidtes@gmail.com', 'RRHH');

    // Contenido del correo
    $mail->isHTML(true);                                  // Configurar el correo por medio de HTML
    $mail->Subject = 'Buzón interno de quejas y sugerencias.';
    $mail->Body    = '
    <html>
    <body>
    <b>Muy buenos días</b>, a quien corresponda:
    En el presente correo, te presento el formulario el cual fue contestado por un miembro de nuestro servicio social.
    Es de interés leerlo con detenimiento y darle seguimiento a cualquier caso presentado por este medio.
    Sin más por el momento, que tenga buen día.
    </body>
    </html>';
    // En caso de no querer ocupar HTML, descomentar lo siguiente y generar el cuerpo del correo
    // $mail->AltBody = 'Este es el cuerpo del mensaje para clientes de correo no HTML';

    // Adjuntar el archivo generado
    $mail->addAttachment('Buzon_Sugerencias_Quejas_CIDTES.pdf'); // Asegúrate de que la ruta al archivo sea accesible
    $mail->addAttachment('Buzon_Sugerencias_Quejas_CIDTES.docx');
    
    $mail->send();
    echo 'Tu opinión ya fue enviada al área de Recursos Humanos, te agradecemos tu participación.<br>';
    echo 'Ya puedes cerrar la ventana de tu navegador, que tengas buen día.';
} catch (Exception $e) {
    echo "El mensaje no pudo ser enviado. Error del Mailer: {$mail->ErrorInfo}";
}

// Eliminar el archivo después de enviarlo
unlink('Buzon_Sugerencias_Quejas_CIDTES.pdf');
unlink('Buzon_Sugerencias_Quejas_CIDTES.docx');
?>
