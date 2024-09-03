<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Element;
use App\Models\Category;

class ElementsSeeder extends Seeder
{
    public function run()
    {
        // Recupera todas las categorías para usar sus IDs
        $categories = Category::all()->pluck('id', 'name');

        // Datos de ejemplo para los elementos
        $elements = [
            // Software
            ['name' => 'Licencia de Microsoft Office 2021', 'description' => 'Licencia para el paquete de software Microsoft Office 2021', 'category_id' => $categories['Software']],
            ['name' => 'Actualización de Adobe Creative Cloud', 'description' => 'Actualización para el conjunto de aplicaciones Adobe Creative Cloud', 'category_id' => $categories['Software']],
            ['name' => 'Antivirus ESET NOD32', 'description' => 'Licencia de antivirus ESET NOD32', 'category_id' => $categories['Software']],
            ['name' => 'Implementación de Sistema de Gestión ERP', 'description' => 'Implementación del sistema de planificación de recursos empresariales (ERP)', 'category_id' => $categories['Software']],
            ['name' => 'Suscripción a Herramienta de Monitoreo de Redes', 'description' => 'Suscripción para herramienta de monitoreo y gestión de redes', 'category_id' => $categories['Software']],
            ['name' => 'Licencia para Software de Contabilidad', 'description' => 'Licencia para el software de contabilidad empresarial', 'category_id' => $categories['Software']],
            ['name' => 'Desarrollo de Aplicación Interna', 'description' => 'Desarrollo de una aplicación personalizada para la empresa', 'category_id' => $categories['Software']],
            ['name' => 'Actualización de Sistema Operativo Windows 11', 'description' => 'Actualización a la última versión del sistema operativo Windows 11', 'category_id' => $categories['Software']],
            ['name' => 'Otros', 'description' => 'Otros requerimientos relacionados con software que no encajan en las categorías específicas', 'category_id' => $categories['Software']],

            // Hardware
            ['name' => 'Compra de Computadora de Escritorio HP Elite', 'description' => 'Adquisición de una computadora de escritorio HP Elite para la oficina', 'category_id' => $categories['Hardware']],
            ['name' => 'Servidor Dell PowerEdge R740', 'description' => 'Compra de servidor Dell PowerEdge R740 para el centro de datos', 'category_id' => $categories['Hardware']],
            ['name' => 'Adquisición de Impresora Epson EcoTank', 'description' => 'Compra de impresora Epson EcoTank para la oficina', 'category_id' => $categories['Hardware']],
            ['name' => 'Monitor UltraWide LG 34"', 'description' => 'Adquisición de monitor UltraWide LG de 34 pulgadas', 'category_id' => $categories['Hardware']],
            ['name' => 'Compra de Router TP-Link Archer AX20', 'description' => 'Compra de router TP-Link Archer AX20 para la red de la oficina', 'category_id' => $categories['Hardware']],
            ['name' => 'Reemplazo de Disco Duro en Servidor', 'description' => 'Reemplazo del disco duro defectuoso en servidor', 'category_id' => $categories['Hardware']],
            ['name' => 'Adquisición de Estación de Trabajo para Diseño', 'description' => 'Compra de estación de trabajo para diseño gráfico y edición', 'category_id' => $categories['Hardware']],
            ['name' => 'Compra de Teclado Mecánico Logitech', 'description' => 'Compra de teclado mecánico Logitech para uso en oficina', 'category_id' => $categories['Hardware']],
            ['name' => 'Otros', 'description' => 'Otros requerimientos relacionados con hardware que no encajan en las categorías específicas', 'category_id' => $categories['Hardware']],

            // Conectividad
            ['name' => 'Instalación de Red LAN en Oficina', 'description' => 'Instalación de red LAN para la oficina', 'category_id' => $categories['Conectividad']],
            ['name' => 'Configuración de Red Inalámbrica WiFi', 'description' => 'Configuración de red inalámbrica WiFi para la oficina', 'category_id' => $categories['Conectividad']],
            ['name' => 'Implementación de VPN para Empleados Remotos', 'description' => 'Implementación de VPN para permitir acceso remoto seguro', 'category_id' => $categories['Conectividad']],
            ['name' => 'Compra de Switch de Red Cisco 24 Puertos', 'description' => 'Compra de switch de red Cisco con 24 puertos para expansión de red', 'category_id' => $categories['Conectividad']],
            ['name' => 'Configuración de Firewall de Red Fortinet', 'description' => 'Configuración de firewall Fortinet para protección de red', 'category_id' => $categories['Conectividad']],
            ['name' => 'Instalación de Puntos de Acceso WiFi Mesh', 'description' => 'Instalación de puntos de acceso WiFi Mesh para cobertura completa', 'category_id' => $categories['Conectividad']],
            ['name' => 'Actualización de Firmware de Router', 'description' => 'Actualización del firmware del router para mejorar el rendimiento', 'category_id' => $categories['Conectividad']],
            ['name' => 'Soporte para Problemas de Conexión de Red', 'description' => 'Soporte para resolver problemas de conexión de red', 'category_id' => $categories['Conectividad']],
            ['name' => 'Otros', 'description' => 'Otros requerimientos relacionados con conectividad que no encajan en las categorías específicas', 'category_id' => $categories['Conectividad']],

            // Consultas y Sugerencias
            ['name' => 'Consulta sobre Nuevas Funcionalidades en Software', 'description' => 'Consulta sobre la adición de nuevas funcionalidades en el software actual', 'category_id' => $categories['Consultas y Sugerencias']],
            ['name' => 'Sugerencia para Mejorar la Experiencia del Usuario en el Portal Web', 'description' => 'Sugerencia para mejorar la usabilidad y la experiencia en el portal web', 'category_id' => $categories['Consultas y Sugerencias']],
            ['name' => 'Consulta sobre Políticas de Seguridad de Datos', 'description' => 'Consulta sobre las políticas de seguridad de datos en la empresa', 'category_id' => $categories['Consultas y Sugerencias']],
            ['name' => 'Sugerencia para Implementar Nuevas Herramientas de Productividad', 'description' => 'Sugerencia para la implementación de nuevas herramientas que aumenten la productividad', 'category_id' => $categories['Consultas y Sugerencias']],
            ['name' => 'Consulta sobre Actualización de Hardware en el Centro de Datos', 'description' => 'Consulta sobre las necesidades de actualización de hardware en el centro de datos', 'category_id' => $categories['Consultas y Sugerencias']],
            ['name' => 'Sugerencia para Mejorar el Soporte Técnico', 'description' => 'Sugerencia para mejorar la calidad del soporte técnico', 'category_id' => $categories['Consultas y Sugerencias']],
            ['name' => 'Consulta sobre Nuevas Políticas de Trabajo Remoto', 'description' => 'Consulta sobre nuevas políticas para el trabajo remoto', 'category_id' => $categories['Consultas y Sugerencias']],
            ['name' => 'Sugerencia para Mejorar la Comunicación Interna', 'description' => 'Sugerencia para mejorar la comunicación dentro de la empresa', 'category_id' => $categories['Consultas y Sugerencias']],
            ['name' => 'Otros', 'description' => 'Otros requerimientos relacionados con consultas y sugerencias que no encajan en las categorías específicas', 'category_id' => $categories['Consultas y Sugerencias']],

            // Reclamos
            ['name' => 'Reclamo por Deficiencias en el Servicio de Soporte', 'description' => 'Reclamo relacionado con deficiencias en el servicio de soporte técnico', 'category_id' => $categories['Reclamos']],
            ['name' => 'Reclamo por Retrasos en la Entrega de Equipos', 'description' => 'Reclamo por retrasos en la entrega de equipos solicitados', 'category_id' => $categories['Reclamos']],
            ['name' => 'Reclamo por Problemas con el Sistema de Backup', 'description' => 'Reclamo relacionado con problemas en el sistema de respaldo de datos', 'category_id' => $categories['Reclamos']],
            ['name' => 'Reclamo por Equipos Defectuosos Entregados', 'description' => 'Reclamo por equipos defectuosos entregados a la empresa', 'category_id' => $categories['Reclamos']],
            ['name' => 'Reclamo por Error en Facturación de Servicios', 'description' => 'Reclamo relacionado con errores en la facturación de servicios', 'category_id' => $categories['Reclamos']],
            ['name' => 'Reclamo por Incidencias en el Sistema de Correo Electrónico', 'description' => 'Reclamo por incidencias y problemas en el sistema de correo electrónico', 'category_id' => $categories['Reclamos']],
            ['name' => 'Reclamo por Fallos en la Actualización de Software', 'description' => 'Reclamo relacionado con fallos tras una actualización de software', 'category_id' => $categories['Reclamos']],
            ['name' => 'Reclamo por Inadecuado Funcionamiento del Nuevo Hardware', 'description' => 'Reclamo por problemas con el funcionamiento del nuevo hardware adquirido', 'category_id' => $categories['Reclamos']],
            ['name' => 'Otros', 'description' => 'Otros reclamos que no encajan en las categorías específicas', 'category_id' => $categories['Reclamos']],
        ];

        foreach ($elements as $element) {
            Element::create($element);
        }
    }
}