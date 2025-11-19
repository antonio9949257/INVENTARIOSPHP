
# INFORME DE PROYECTO FINAL

| | |
|---|---|
| **Universidad** | UNIVERSIDAD PÚBLICA DE EL ALTO |
| **Carrera** | INGENIERÍA DE SISTEMAS |
| **Asignatura** | TEW-500 - TALLER DE ELABORACIÓN DE WEBS |
| **Título del Proyecto** | **Sistema de Gestión de Inventario con Asistente de IA Basado en Google Gemini** |
| **Autor** | Bach. Armin Daniel Antonio Mendieta |
| **Docente** | Ing. (Nombre del Docente) |
| **Fecha** | 19 de noviembre de 2025 |

---

## Índice

1.  [Resumen Ejecutivo](#1-resumen-ejecutivo)
2.  [Introducción](#2-introducción)
    *   [2.1. Planteamiento del Problema](#21-planteamiento-del-problema)
    *   [2.2. Justificación](#22-justificación)
    *   [2.3. Objetivos del Proyecto](#23-objetivos-del-proyecto)
3.  [Marco Teórico](#3-marco-teórico)
    *   [3.1. Tecnologías Base del Desarrollo Web](#31-tecnologías-base-del-desarrollo-web)
    *   [3.2. Modelos de Lenguaje Grandes (LLMs)](#32-modelos-de-lenguaje-grandes-llms)
    *   [3.3. Google Gemini y su API](#33-google-gemini-y-su-api)
    *   [3.4. El Paradigma de "Function Calling"](#34-el-paradigma-de-function-calling)
4.  [Diseño y Arquitectura del Sistema](#4-diseño-y-arquitectura-del-sistema)
    *   [4.1. Arquitectura de Software](#41-arquitectura-de-software)
    *   [4.2. Diseño de la Base de Datos](#42-diseño-de-la-base-de-datos)
    *   [4.3. Arquitectura Detallada de la Integración de IA](#43-arquitectura-detallada-de-la-integración-de-ia)
5.  [Desarrollo e Implementación](#5-desarrollo-e-implementación)
    *   [5.1. Entorno y Herramientas](#51-entorno-y-herramientas)
    *   [5.2. Implementación de Módulos CRUD](#52-implementación-de-módulos-crud)
    *   [5.3. Implementación del Asistente Conversacional](#53-implementación-del-asistente-conversacional)
6.  [Pruebas y Resultados](#6-pruebas-y-resultados)
    *   [6.1. Pruebas de Funcionalidad](#61-pruebas-de-funcionalidad)
    *   [6.2. Pruebas del Asistente de IA](#62-pruebas-del-asistente-de-ia)
7.  [Conclusiones y Trabajo Futuro](#7-conclusiones-y-trabajo-futuro)
    *   [7.1. Conclusiones](#71-conclusiones)
    *   [7.2. Limitaciones](#72-limitaciones)
    *   [7.3. Trabajo Futuro](#73-trabajo-futuro)
8.  [Anexos](#8-anexos)
    *   [Anexo A: Fragmentos de Código Clave](#anexo-a-fragmentos-de-código-clave)

---

## 1. Resumen Ejecutivo

El presente proyecto aborda el diseño, desarrollo e implementación de un sistema web para la gestión de inventarios, construido sobre una base de tecnologías PHP y MySQL. La característica distintiva y el principal aporte de este trabajo es la integración de un asistente conversacional inteligente, potenciado por el modelo de lenguaje de última generación de Google, Gemini. A través del paradigma de "Function Calling", el sistema capacita al modelo de IA para interactuar de forma segura y en tiempo real con la base de datos del inventario, permitiendo a los usuarios realizar consultas complejas utilizando lenguaje natural. El resultado es una aplicación que no solo cumple con las funciones de gestión de inventario estándar (CRUD de productos, proveedores, categorías, etc.), sino que también ofrece una experiencia de usuario radicalmente mejorada, más intuitiva y eficiente, demostrando el potencial de la inteligencia artificial para modernizar aplicaciones empresariales tradicionales.

## 2. Introducción

### 2.1. Planteamiento del Problema

Los sistemas de gestión de inventario tradicionales, si bien son funcionales, a menudo presentan interfaces de usuario rígidas y poco intuitivas. La realización de consultas específicas o cruzadas (ej: "encontrar todos los productos de un proveedor específico con stock por debajo de un umbral") generalmente requiere navegar por múltiples menús, aplicar filtros complejos o, en algunos casos, tener conocimientos de lenguajes de consulta de bases de datos. Esta barrera técnica limita la agilidad en la toma de decisiones y requiere una curva de aprendizaje para los nuevos usuarios.

### 2.2. Justificación

En la era de la inteligencia artificial conversacional, los usuarios esperan interacciones más fluidas y naturales con el software. La integración de un asistente de IA en un sistema de inventario no es una mera adición estética, sino una mejora funcional que ataca directamente el problema de la usabilidad. Al permitir que un usuario simplemente "pregunte" al sistema por la información que necesita, se democratiza el acceso a los datos, se acelera la obtención de información crítica para el negocio y se reduce significativamente el tiempo de capacitación. Este proyecto se justifica en la necesidad de explorar y aplicar estas nuevas tecnologías para crear software más potente, accesible y eficiente.

### 2.3. Objetivos del Proyecto

#### 2.3.1. Objetivo General

Desarrollar un sistema web funcional para la gestión de inventarios, que integre un asistente de inteligencia artificial capaz de responder preguntas sobre los datos del sistema en tiempo real, utilizando el modelo Google Gemini.

#### 2.3.2. Objetivos Específicos

*   Diseñar y desarrollar una base de datos relacional en MySQL para almacenar la información del inventario.
*   Implementar los módulos CRUD (Crear, Leer, Actualizar, Borrar) para las entidades principales del sistema: productos, categorías, proveedores, usuarios y movimientos.
*   Integrar la API de Google Gemini en la aplicación PHP.
*   Implementar la arquitectura de "Function Calling" para permitir que la IA solicite la ejecución de funciones PHP que consulten la base de datos de forma segura.
*   Desarrollar una interfaz de chat amigable para la interacción entre el usuario y el asistente de IA.
*   Asegurar que el acceso a la API y a la base de datos se realice de manera segura, protegiendo las credenciales y evitando vulnerabilidades.

## 3. Marco Teórico

### 3.1. Tecnologías Base del Desarrollo Web

El proyecto se sustenta en un stack tecnológico probado y robusto:
*   **PHP (Hypertext Preprocessor)**: Lenguaje de scripting del lado del servidor, ampliamente utilizado para el desarrollo web, que constituye el núcleo de la lógica de negocio de la aplicación.
*   **MySQL**: Sistema de gestión de bases de datos relacional de código abierto, utilizado para la persistencia de todos los datos del inventario.
*   **HTML, CSS y JavaScript**: Tecnologías estándar del lado del cliente para la estructuración, estilización e interactividad de la interfaz de usuario. Se utiliza **Bootstrap 5** como framework CSS para un diseño responsivo y moderno.
*   **Composer**: Herramienta de gestión de dependencias para PHP, utilizada en este proyecto para administrar librerías externas como FPDF.

### 3.2. Modelos de Lenguaje Grandes (LLMs)

Los LLMs son modelos de inteligencia artificial entrenados con enormes cantidades de datos de texto para comprender, generar y responder al lenguaje humano de manera coherente y contextual. Son la base de aplicaciones como ChatGPT, Copilot y, en este caso, Google Gemini.

### 3.3. Google Gemini y su API

Gemini es la familia de modelos de IA multimodales de Google, diseñados para comprender y operar a través de diferentes tipos de información como texto, código, imágenes y más. Su API proporciona a los desarrolladores acceso programático a estas capacidades.

### 3.4. El Paradigma de "Function Calling"

Esta es la tecnología clave que habilita la funcionalidad central del proyecto. "Function Calling" es una característica de la API de Gemini que permite al desarrollador describir funciones de su propia aplicación al modelo de IA. Cuando el modelo detecta que una consulta del usuario puede ser resuelta por una de estas funciones, en lugar de inventar una respuesta, solicita al software que ejecute esa función específica con los argumentos apropiados.

Este paradigma es superior a otros enfoques por dos razones principales:
1.  **Seguridad**: La IA nunca obtiene acceso directo a la base de datos o a otros sistemas sensibles. Actúa como un cerebro que delega tareas, y es la aplicación la que las ejecuta en un entorno controlado.
2.  **Precisión**: Las respuestas se basan en datos en tiempo real obtenidos de la fuente de verdad (la base de datos), no en información potencialmente obsoleta o incorrecta del entrenamiento del modelo.

## 4. Diseño y Arquitectura del Sistema

### 4.1. Arquitectura de Software

El sistema sigue una arquitectura de N-capas, comúnmente simplificada en tres capas lógicas:
*   **Capa de Presentación**: Compuesta por los archivos PHP que renderizan el HTML y el código JavaScript (`chat_asistente.php`, módulos CRUD). Es lo que el usuario ve y con lo que interactúa.
*   **Capa de Lógica de Negocio**: El backend en PHP (`api/chat.php`, `lib/tools.php`). Aquí reside la lógica de la aplicación, la orquestación de la IA y las reglas de negocio.
*   **Capa de Datos**: La base de datos MySQL y el script de conexión (`conexion.php`). Se encarga de la persistencia y recuperación de los datos.

### 4.2. Diseño de la Base de Datos

La base de datos `inventariosphp` se compone de las siguientes tablas principales:
*   `productos`: Almacena la información de cada producto (ID, nombre, descripción, stock, precio_compra, precio_venta, id_categoria, id_proveedor).
*   `categorias`: Almacena las categorías de los productos (ID, nombre).
*   `proveedores`: Almacena los datos de los proveedores (ID, nombre, direccion, telefono, email).
*   `usuarios`: Gestiona los usuarios del sistema (ID, nombre, email, password).
*   `movimientos`: Registra cada entrada o salida de productos (ID, id_producto, tipo_movimiento, cantidad, fecha).

### 4.3. Arquitectura Detallada de la Integración de IA

El flujo de comunicación entre el usuario, el sistema y la IA es el siguiente:

1.  **Frontend (`chat_asistente.php`)**: El usuario envía una pregunta. JavaScript empaqueta la pregunta y el historial en un JSON y lo envía vía `fetch()` a `api/chat.php`.
2.  **Backend (`api/chat.php`)**:
    *   Recibe la petición.
    *   Define un array `$tools` que describe las funciones disponibles en `lib/tools.php`.
    *   Realiza una **primera llamada** a la API de Gemini, enviando los mensajes y las herramientas.
3.  **API Gemini (Análisis)**: Gemini analiza la pregunta y determina que necesita ejecutar una función (ej: `obtener_stock_producto`). Responde con una `functionCall`.
4.  **Backend (`api/chat.php`)**:
    *   Recibe la `functionCall`.
    *   Invoca a la función PHP correspondiente (ej: `obtener_stock_producto('Paracetamol')`) usando `call_user_func_array()`.
5.  **Librería de Herramientas (`lib/tools.php`)**:
    *   La función invocada se ejecuta.
    *   Se conecta a la base de datos a través de `conexion.php`.
    *   Ejecuta una consulta SQL segura (sentencia preparada) y retorna el resultado.
6.  **Backend (`api/chat.php`)**:
    *   Recibe el resultado de la función local.
    *   Realiza una **segunda llamada** a la API de Gemini, enviando el resultado de la función como nuevo contexto.
7.  **API Gemini (Síntesis)**: Gemini recibe el dato concreto y formula una respuesta en lenguaje natural.
8.  **Frontend (`chat_asistente.php`)**: El backend envía la respuesta final al frontend, que la muestra en el chat.

## 5. Desarrollo e Implementación

### 5.1. Entorno y Herramientas

*   **Servidor Local**: XAMPP (Apache, PHP 8.2, MariaDB).
*   **Editor de Código**: Visual Studio Code.
*   **Gestor de Dependencias**: Composer.
*   **Control de Versiones**: Git.

### 5.2. Implementación de Módulos CRUD

Cada módulo (productos, categorías, etc.) se implementó siguiendo un patrón similar:
*   `index.php`: Muestra la tabla de registros y los botones de acción.
*   `create_*.php`: Formulario para crear un nuevo registro y procesar el envío.
*   `edit_*.php`: Formulario para editar un registro existente.
*   `delete_*.php`: Script que procesa la eliminación de un registro.
*   `generar_pdf.php`: Utiliza la librería FPDF para generar un reporte en PDF de los registros.

### 5.3. Implementación del Asistente Conversacional

Esta fue la parte más compleja y se detalla a continuación:
*   **`chat_asistente.php`**: Se implementó una interfaz de chat simple con HTML y Bootstrap. El núcleo de la interactividad reside en una sección `<script>` que maneja el envío de mensajes, la actualización del historial y la visualización de respuestas asíncronas mediante `fetch`.
*   **`api/chat.php`**: Este script es el orquestador. Se encarga de gestionar el estado de la conversación, definir las herramientas que Gemini puede usar y manejar el ciclo de dos llamadas (pregunta -> functionCall -> resultado -> respuesta final).
*   **`lib/tools.php`**: Actúa como una capa de acceso a datos (Data Access Layer) para la IA. Cada función en este archivo es una "habilidad" que el asistente puede usar. Se puso especial énfasis en la seguridad, utilizando sentencias preparadas de MySQLi para todas las consultas y así prevenir inyección SQL.
*   **`config.php` y `.gitignore`**: Para la gestión segura de la clave de la API, se creó un archivo `config.php` que define la clave como una constante. Este archivo fue añadido explícitamente a `.gitignore` para asegurar que nunca sea subido a un repositorio público.

## 6. Pruebas y Resultados

### 6.1. Pruebas de Funcionalidad

Se realizaron pruebas manuales en todos los módulos CRUD, verificando que las operaciones de creación, lectura, actualización y borrado funcionaran como se esperaba. Se validaron los formularios y la correcta persistencia de los datos en la base de datos. La generación de PDFs también fue verificada.

### 6.2. Pruebas del Asistente de IA

Se probó el asistente con una variedad de preguntas para verificar la correcta interpretación y ejecución de las funciones:
*   **Consulta de stock simple**:
    *   *Pregunta*: `¿cuál es el stock de paracetamol?`
    *   *Resultado*: Correcta ejecución de `obtener_stock_producto` y respuesta con el número de unidades.
*   **Consulta de listado**:
    *   *Pregunta*: `lista los productos de la categoría 'analgésicos'`
    *   *Resultado*: Correcta ejecución de `obtener_productos_por_categoria` y respuesta con una lista de productos.
*   **Consulta con condición**:
    *   *Pregunta*: `¿qué productos tienen menos de 20 unidades?`
    *   *Resultado*: Correcta ejecución de `obtener_productos_bajo_stock` y respuesta con los productos correspondientes.
*   **Consulta de datos relacionados**:
    *   *Pregunta*: `dame el teléfono del proveedor de la aspirina`
    *   *Resultado*: El sistema demostró capacidad para encadenar lógicamente la información, ejecutando `obtener_info_proveedor` tras identificar el proveedor del producto.

Los resultados fueron altamente satisfactorios, demostrando que la arquitectura de "Function Calling" es robusta y efectiva.

## 7. Conclusiones y Trabajo Futuro

### 7.1. Conclusiones

El proyecto cumplió exitosamente con todos los objetivos planteados. Se logró desarrollar un sistema de inventario funcional y, lo que es más importante, se integró con éxito un asistente de IA de vanguardia. La implementación del paradigma de "Function Calling" demostró ser una solución segura, precisa y escalable para conectar modelos de lenguaje con fuentes de datos en tiempo real. El producto final no solo es una herramienta de gestión eficaz, sino también una prueba de concepto poderosa sobre cómo la IA conversacional puede revolucionar las interfaces de software tradicionales, haciéndolas más accesibles y potentes.

### 7.2. Limitaciones

*   **Dependencia de API Externa**: El funcionamiento del asistente depende de la disponibilidad y los términos de servicio de la API de Google Gemini.
*   **Alcance de Herramientas**: El conocimiento del asistente está limitado al conjunto de funciones definidas en `lib/tools.php`. No puede responder a preguntas que requieran operaciones no implementadas.
*   **Manejo de Conversaciones Complejas**: El manejo del contexto para preguntas de seguimiento muy complejas podría requerir una gestión de estado más sofisticada.

### 7.3. Trabajo Futuro

*   **Ampliación de Herramientas**: Añadir más funciones a `lib/tools.php`, como la capacidad de generar reportes (`"genera un reporte de ventas del último mes"`) o incluso realizar modificaciones en la base de datos (`"añade 50 unidades al stock de paracetamol"`), con las debidas confirmaciones de seguridad.
*   **Autenticación y Roles en la IA**: Integrar el sistema de usuarios con el asistente, de modo que la IA pueda responder de manera diferente según el rol del usuario (ej: un administrador puede preguntar por el valor total del inventario, pero un usuario normal no).
*   **Implementación de Caching**: Para consultas frecuentes, se podría implementar un sistema de caché para reducir el número de llamadas a la API y a la base de datos, mejorando el rendimiento y reduciendo costos.
*   **Despliegue**: Contenerizar la aplicación con Docker y desplegarla en un servicio en la nube para hacerla accesible globalmente.

## 8. Anexos

### Anexo A: Fragmentos de Código Clave

**`api/chat.php` (Definición de herramienta y ciclo de llamada)**
```php
// ...
$tools = [
    [
        'name' => 'obtener_stock_producto',
        'description' => 'Obtiene el stock disponible de un producto específico por su nombre.',
        'parameters' => [
            'type' => 'object',
            'properties' => [
                'nombre_producto' => [
                    'type' => 'string',
                    'description' => 'El nombre del producto a buscar.'
                ]
            ],
            'required' => ['nombre_producto']
        ]
    ],
    // ... otras herramientas
];

// ... Lógica para detectar y manejar functionCall
if (isset($functionCall)) {
    // ...
    $result = call_user_func_array($functionName, (array)$args);
    // ...
    // Segunda llamada a Gemini con el resultado
}
// ...
```

**`lib/tools.php` (Ejemplo de función-herramienta)**
```php
function obtener_stock_producto($nombre_producto) {
    require_once __DIR__ . '/../conexion.php';
    global $conexion;

    $stock = "No encontrado";
    $searchTerm = '%' . $nombre_producto . '%';

    $stmt = $conexion->prepare("SELECT stock FROM productos WHERE nombre LIKE ?");
    $stmt->bind_param("s", $searchTerm);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($fila = $resultado->fetch_assoc()) {
        $stock = $fila['stock'];
    }
    
    $stmt->close();
    return (string)$stock;
}
```
