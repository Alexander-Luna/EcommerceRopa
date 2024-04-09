<?php
require_once '../vendor/autoload.php';
require_once '../config/Conectar.php';

use Dompdf\Dompdf;
use Dompdf\Options;

class DownloadPDF extends Conectar
{


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
}
