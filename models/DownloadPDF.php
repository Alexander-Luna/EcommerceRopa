<?php
require_once '../vendor/autoload.php';
require_once '../config/Conectar.php';
require_once '../models/VentaModel.php';

use Dompdf\Dompdf;
use Dompdf\Options;
use TCPDF;

class DownloadPDF extends Conectar
{

    public function getPDFHTML()
    {
        $ventas = new VentaModel();
        $clientData = $ventas->getClienteVenta($_POST['id_client']);
        if (!empty($clientData)) {
            $clientData = $clientData[0]; 
            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('ASOTAECO');
            $pdf->SetSubject('Sales Invoice');
            $pdf->SetKeywords('TCPDF, PDF, invoice, sales, Ecuador');
            $pdf->SetTitle('ASOTAECO VENTAS');
            $pdf->AddPage();
            $pdf->SetFont('helvetica', 'B', 12);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(130, 10, 'ASOTAECO', 0, 0, 'L');
            $invoiceNumber = $clientData['ncomprobante'];
            $invoiceDate = $clientData['fecha'];
            $pdf->Cell(60, 10, "N°: $invoiceNumber", 0, 0, 'R');
            $pdf->Cell(60, 10, date('d/m/Y', strtotime($invoiceDate)), 0, 0, 'R');
            $pdf->Ln(10);

            // Agregar información del cliente
            $pdf->SetFont('helvetica', '', 10);
            $pdf->SetTextColor(80, 80, 80);
            $clientName = $clientData['name_client'];
            $clientCI = $clientData['ci'];
            $pdf->Cell(60, 10, "Cliente:", 0, 0, 'L');
            $pdf->Cell(140, 10, $clientName, 0, 1, 'L');
            $pdf->Cell(60, 10, "CI/RUC:", 0, 0, 'L');
            $pdf->Cell(140, 10, $clientCI, 0, 1, 'L');
            $clientAddress = $clientData['direccion'];
            $clientPhone = $clientData['telefono'];
            $pdf->Cell(60, 10, "Dirección:", 0, 0, 'L');
            $pdf->Cell(140, 10, $clientAddress, 0, 1, 'L');
            $pdf->Cell(60, 10, "Teléfono:", 0, 0, 'L');
            $pdf->Cell(140, 10, $clientPhone, 0, 1, 'L');
            $pdf->Ln(10);

            // Agregar tabla de productos
            $products = $ventas->getProductsVentaAdmin($_POST['id_venta']);
            $total = 0;
            $vatTotal = 0;
            $pdf->SetFont('helvetica', '', 10);
            $pdf->SetTextColor(80, 80, 80);
            $pdf->Cell(20, 10, "Cant.", 1, 0, 'C');
            $pdf->Cell(60, 10, "Descripción", 1, 0, 'L');
            $pdf->Cell(30, 10, "Precio Unitario", 1, 0, 'R');
            $pdf->Cell(30, 10, "Total", 1, 1, 'R');
            foreach ($products as $product) {
                $quantity = $product['cantidad'];
                $description = $product['desc_producto'];
                $price = $product['precio'];
                
                // Calcular el precio del producto sin IVA
                $priceExclVat = $price / 1.15; // Dividir por 1.15 para eliminar el 15% de IVA
                
                // Calcular el IVA
                $vat = $price - $priceExclVat; // El IVA es la diferencia entre el precio total y el precio sin IVA
                
                $total += $quantity * $priceExclVat; // Sumar al total el precio sin IVA
                $vatTotal += $quantity * $vat; // Sumar al total del IVA el IVA por cada producto
            
                $pdf->Cell(20, 10, $quantity, 1, 0, 'C');
                $pdf->Cell(60, 10, $description, 1, 0, 'L');
                $pdf->Cell(30, 10, number_format($priceExclVat, 2), 1, 0, 'R');
                $pdf->Cell(30, 10, number_format($quantity * $priceExclVat, 2), 1, 1, 'R');
            }
            
            // Agregar totales
            $pdf->SetFont('helvetica', 'B', 10);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(100, 10, "Subtotal:", 0, 0, 'L');
            $pdf->Cell(40, 10, number_format($total, 2), 1, 1, 'R');
            $pdf->Cell(100, 10, "IVA (15%):", 0, 0, 'L');
            $pdf->Cell(40, 10, number_format($vatTotal, 2), 1, 1, 'R');
            $pdf->Cell(100, 10, "Total:", 0, 0, 'L');
            $pdf->Cell(40, 10, number_format($total + $vatTotal, 2), 1, 1, 'R');
            

            // Generar el PDF
            $output = $pdf->Output('venta.pdf', 'S');
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="factura_venta.pdf"');
            header('Content-Length: ' . strlen($output));
            echo $output;
            http_response_code(200);
            exit;
        } else {
            http_response_code(400);
            // Si no se encontraron datos del cliente, mostrar un mensaje de error
            echo "No se encontraron datos del cliente.";
        }
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
    public function downloadStock($data)
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

        // Crear tabla HTML
        $html = '<table border="1">';
        $html .= '<thead>';
        $html .= '<tr>';
        $html .= '<th>Proveedor</th>';
        $html .= '<th>RUC</th>';
        $html .= '<th>Ocasión</th>';
        $html .= '<th>Nombre</th>';
        $html .= '<th>Email</th>';
        $html .= '<th>Teléfono</th>';
        $html .= '<th>Dirección</th>';
        $html .= '<th>Stock</th>';
        $html .= '<th>Stock Alert</th>';
        $html .= '<th>Precio</th>';
        $html .= '<th>Color</th>';
        $html .= '<th>Género</th>';
        $html .= '<th>Talla</th>';
        $html .= '<th>Imagen</th>';
        $html .= '</tr>';
        $html .= '</thead>';
        $html .= '<tbody>';

        // Recorrer los datos para crear las filas de la tabla
        foreach ($data as $row) {
            $html .= '<tr>';
            $html .= '<td>' . $row['prov_nombre'] . '</td>';
            $html .= '<td>' . $row['ruc'] . '</td>';
            $html .= '<td>' . $row['ocasion'] . '</td>';
            $html .= '<td>' . $row['nombre'] . '</td>';
            $html .= '<td>' . $row['email'] . '</td>';
            $html .= '<td>' . $row['telefono'] . '</td>';
            $html .= '<td>' . $row['direccion'] . '</td>';
            $html .= '<td>' . $row['stock'] . '</td>';
            $html .= '<td>' . $row['stock_alert'] . '</td>';
            $html .= '<td>' . $row['precio'] . '</td>';
            $html .= '<td>' . $row['color'] . '</td>';
            $html .= '<td>' . $row['genero'] . '</td>';
            $html .= '<td>' . $row['talla'] . '</td>';
            $html .= '<td><img src="' . $row['imagen'] . '" alt="Imagen del producto" style="max-width: 100px; max-height: 100px;"></td>';
            $html .= '</tr>';
        }

        $html .= '</tbody>';
        $html .= '</table>';

        // Escribir contenido HTML en el PDF
        $pdf->writeHTML($html, true, false, true, false, '');

        // Cerrar documento y devolver el PDF
        $pdf->Output('tabla_productos.pdf', 'D');
    }
}
