<?php
require_once '../vendor/autoload.php';
require_once '../config/Conectar.php';
require_once '../models/CorreosModel.php';

use Dompdf\Dompdf;
use Dompdf\Options;
use TCPDF;

class PDFModel extends Conectar
{
    public function generarEstiloCSS()
    {
        $css = '
            <style>
                .container {
                    text-align: center;
                    margin-top: 20px;
                }
                .logo img {
                    max-height: 150px;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-top: 20px;
                    border: 1px solid #000; /* Ejemplo de estilo de borde para la tabla */
                }
                th, td {
                    padding: 8px;
                    text-align: left;
                }
                th {
                    background-color: #f2f2f2;
                }
                img.producto {
                    max-width: 150px;
                    max-height: 150px;
                }
            </style>';
        return $css;
    }

    public function getVentaUser()
    {
        try {
            $id = $_GET["id"];
            $conexion = parent::Conexion();
            $sql = "SELECT 
                dv.id, 
                dv.id_venta, 
                dv.cantidad, 
                dv.precio_unitario, 
                p.nombre AS nombre_producto,
                ip.url_imagen AS imagen,
                i.id_color,
                i.id_talla,
                c.color,
                t.talla,
                v.fecha,
                v.total,
                v.envio,
                r.nombre as receptor_nombre,
                r.telefono as receptor_telefono,
                r.email as receptor_email,
                r.direccion as receptor_direccion,
                r.ci as receptor_ci
                
            FROM 
                detalles_venta dv
            JOIN 
                inventario i ON dv.id_variante_producto = i.id
            JOIN 
                ventas v ON dv.id_venta = v.id
            JOIN 
                colores c ON i.id_color = c.id
                JOIN 
                recibe r ON v.id_recibe = r.id
            JOIN 
                tallas t ON i.id_talla = t.id
            JOIN 
                productos p ON i.id_producto = p.id
            LEFT JOIN 
                imagenes_producto ip ON p.id = ip.id_producto AND ip.orden = 1 WHERE dv.id_venta=?;
            ";
            $stmt = $conexion->prepare($sql);
            $stmt->bindValue(1, $id);
            $stmt->execute();
            $ventas = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $html = '<div>';
            $html .= '<p>Fecha: ' . $ventas[0]['fecha'] . '</p>';
            $html .= '<p>Número de factura: ' . $ventas[0]['id_venta'] . '</p>';
            $html .= '<p>Cliente: ' . $ventas[0]['receptor_nombre'] . '</p>';
            $html .= '<p>Teléfono: ' . $ventas[0]['receptor_telefono'] . '</p>';
            $html .= '<p>Email: ' . $ventas[0]['receptor_email'] . '</p>';
            $html .= '<p>Dirección: ' . $ventas[0]['receptor_direccion'] . '</p>';
            $html .= '</div>';
            $html .= '<table>';
            $html .= '<tr><th>Producto</th><th>Cantidad</th><th>Precio Unitario</th></tr>';
            foreach ($ventas as $venta) {
                $html .= '<tr>';
                $html .= '<td>' . $venta['nombre_producto'] . '</td>';
                $html .= '<td>' . $venta['cantidad'] . '</td>';
                $html .= '<td>$' . $venta['precio_unitario'] . '</td>';
                $html .= '</tr>';
            }

            $html .= '</table>';
            $html .= '<p>Subtotal: $' . $ventas[0]['total'] . '</p>';
            $html .= '<p>Envío: $' . $ventas[0]['envio'] . '</p>';
            $html .= '<p>Total: $' . ($ventas[0]['total'] + $ventas[0]['envio']) . '</p>';
            $dompdf = new Dompdf();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            $output = $dompdf->output();
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="factura_venta.pdf"');
            header('Content-Length: ' . strlen($output));
            echo $output;
            exit;
        } catch (Exception $e) {
            http_response_code(400);
            return $e;
        }
    }
    public function alertaPDF($data)
    {
        // Crear instancia de TCPDF
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // Establecer información del documento
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Autor');
        $pdf->SetTitle('Tabla de productos');
        $pdf->SetSubject('Tabla de productos');
        $pdf->SetKeywords('TCPDF, PDF, tabla, productos');

        // Establecer márgenes
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // Establecer auto página de ajuste
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // Establecer el formato de página
        $pdf->AddPage();

        $html = '<img src="../public/images/icons/logo.png" alt="Logo de Asotaeco" style="width: 150px; height: 150px;max-width: 150px; max-height: 150px;">
        ';
        $html .= '<h1>Proforma de productos</h1>';
        $html .= '<table>';
        $html .= '<thead>';
        $html .= '<tr>';
        $html .= '<th>Nombre</th>';
        $html .= '<th>Descripción</th>';
        $html .= '<th>Talla</th>';
        $html .= '<th>Color</th>';
        $html .= '<th>Cantidad</th>';
        $html .= '<th>Imagen</th>';
        $html .= '</tr>';
        $html .= '</thead>';
        $html .= '<tbody>';
        foreach ($data as $row) {
            $html .= '<tr>';
            $html .= '<td>' . $row['nombre_producto'] . '</td>';
            $html .= '<td>' . $row['descripcion_producto'] . '</td>';
            $html .= '<td>' . $row['talla'] . '</td>';
            $html .= '<td>' . $row['color'] . '</td>';
            $html .= '<td>' . $row['cant_pred'] . '</td>';
            $url = "../../public/images/products/661f3eb34bce6.webp";
            $html .= '<td ><img src="' . substr($url, 3) . '" alt="Imagen del producto"></td>';
            $html .= '</tr>';
        }
        $html .= '</tbody>';
        $html .= '</table>';

        // Agregar logo de la empresa

        // Escribir contenido HTML en el PDF
        $pdf->writeHTML($this->generarEstiloCSS() . $html, true, false, true, false, '');

        // Obtener contenido del PDF como cadena
        $pdfContent = $pdf->Output('proforma_proveedor.pdf', 'S');

        // Enviar correo electrónico con el PDF adjunto
        $correosModel = new CorreosModel();
        $data1 = json_decode(file_get_contents('php://input'), true);
        $mensajeHTML = "<html><body><h1 style='text-align: center;'>Proforma de Productos</h1><p>Este es un correo electrónico con una proforma de productos adjunta.</p></body></html>";
        $result = $correosModel->enviarCorreoPDF($data1['email_proveedor'], "Pedido ASOTAECO", $mensajeHTML, $pdfContent);

        // Mostrar mensaje de éxito o error
        if ($result === "El correo se ha enviado correctamente.") {
            echo $result;
        } else {
            echo $result;
        }
    }
}
