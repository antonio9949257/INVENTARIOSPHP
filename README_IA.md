# Defensa del Proyecto: Sistema de Inventario con Asistente de IA (Gemini)

## 1. Introducción

Este proyecto presenta un sistema de gestión de inventario desarrollado en PHP, que va más allá de las funcionalidades tradicionales de un CRUD (Crear, Leer, Actualizar, Borrar). La principal innovación es la integración de un asistente conversacional inteligente, impulsado por el modelo de lenguaje avanzado **Gemini de Google**.

El objetivo es transformar la manera en que los usuarios interactúan con los datos del sistema, permitiéndoles realizar consultas complejas en **lenguaje natural** (por ejemplo, "¿Qué productos tenemos con bajo stock?" o "¿Quién es el proveedor de la Aspirina?") y recibir respuestas precisas basadas en la información en tiempo real de la base de datos.

## 2. Arquitectura General

El sistema se compone de tres capas principales:

1.  **Frontend (Interfaz de Usuario)**: La vista del usuario, construida con PHP y JavaScript. Aquí se encuentra la interfaz del chat (`chat_asistente.php`) que actúa como el punto de entrada para las consultas del usuario.
2.  **Backend (Lógica del Servidor)**: El cerebro de la aplicación, escrito en PHP. Se encarga de procesar la lógica de negocio, gestionar las peticiones y, lo más importante, actuar como intermediario entre el frontend y la API de Gemini.
3.  **Base de Datos (Persistencia)**: Un sistema MySQL que almacena toda la información del inventario: productos, categorías, proveedores, etc.

## 3. El Núcleo de la Innovación: El Flujo de "Function Calling"

La "magia" de este proyecto reside en no solo usar a Gemini para conversar, sino para **actuar sobre la base de datos de forma controlada y segura**. Esto se logra mediante una técnica avanzada llamada **Function Calling**.

A continuación, se detalla el flujo completo de una consulta del usuario:

---

### **Diagrama de Flujo de Interacción**

```
Usuario        Frontend         Backend (PHP)        API Gemini         Base de Datos
   |               |                 |                   |                   |
1. |---Pregunta--->|                 |                   |                   |
   |               |                 |                   |                   |
2. |               |---fetch()------>|                   |                   |
   |               |                 |                   |                   |
3. |               |                 |--1ª Llamada API-->|                   |
   |               |                 |  (Pregunta+Tools) |                   |
   |               |                 |                   |                   |
4. |               |                 |<--functionCall----|                   |
   |               |                 |  (Ejecutar func)  |                   |
   |               |                 |                   |                   |
5. |               |                 |-------------------------------------->| (Consulta SQL)
   |               |                 |                   |                   |
6. |               |                 |<--------------------------------------| (Resultado SQL)
   |               |                 |                   |                   |
7. |               |                 |--2ª Llamada API-->|                   |
   |               |                 |  (Resultado func) |                   |
   |               |                 |                   |                   |
8. |               |                 |<--Respuesta Final-|                   |
   |               |                 |    (Texto)        |                   |
   |               |                 |                   |                   |
9. |               |<--Respuesta-----|                   |                   |
   |               |                 |                   |                   |
10.|<--Mostrar Resp.|                 |                   |                   |
   |               |                 |                   |                   |
```

---

### **Explicación del Flujo**

1.  **Consulta del Usuario**: El usuario escribe una pregunta en lenguaje natural en la interfaz del chat. Por ejemplo: `¿Cuántas unidades de Paracetamol nos quedan?`

2.  **Envío al Backend**: El frontend (`chat_asistente.php`) captura esta pregunta y la envía al script del backend `api/chat.php`.

3.  **Primera Llamada a Gemini (Análisis de Intención)**: El backend no envía solo la pregunta. Prepara un paquete que incluye:
    *   La pregunta del usuario.
    *   El historial de la conversación.
    *   Una lista de **"herramientas" (`tools`)**. Estas son descripciones de las funciones PHP que el backend puede ejecutar (ej: `obtener_stock_producto`, `listar_proveedores`). Esto le permite a Gemini saber qué "poderes" tiene nuestra aplicación.

4.  **Respuesta de Gemini (Solicitud de Ejecución)**: Gemini analiza la pregunta y la compara con las herramientas disponibles. Concluye que para responder, necesita ejecutar la función `obtener_stock_producto` con el parámetro `Paracetamol`. En lugar de un texto, su respuesta es una instrucción estructurada: una **`functionCall`**.

5.  **Ejecución Segura de la Herramienta**: El backend (`api/chat.php`) recibe esta instrucción. Llama a la función PHP correspondiente, `obtener_stock_producto('Paracetamol')`, que se encuentra en `lib/tools.php`. Esta función ejecuta una consulta SQL segura contra la base de datos.

6.  **Obtención del Resultado**: La base de datos devuelve el resultado de la consulta (ej: `150`).

7.  **Segunda Llamada a Gemini (Entrega de Contexto)**: El backend vuelve a llamar a la API de Gemini, pero esta vez le dice: *"Ya ejecuté la función que me pediste, y el resultado fue 150."*

8.  **Generación de la Respuesta Final**: Ahora, Gemini tiene todo el contexto: la pregunta original (`¿Cuántas unidades...?`) y el dato clave (`150`). Con esta información, genera una respuesta final en lenguaje natural y coherente: `Nos quedan 150 unidades de Paracetamol en el inventario.`

9.  **Envío al Frontend**: El backend envía esta respuesta final a la interfaz de usuario.

10. **Visualización**: El usuario ve la respuesta del asistente en la pantalla del chat.

## 4. Ventajas Clave de esta Arquitectura

*   **Seguridad**: La IA **nunca** tiene acceso directo a la base de datos ni a las credenciales. Actúa como un "cerebro" que delega la obtención de datos al backend, que es el único con acceso.
*   **Precisión y Fiabilidad**: Las respuestas no se basan en el conocimiento general del modelo, sino en los **datos en tiempo real** del inventario. Si el stock cambia, la respuesta del asistente también lo hará.
*   **Extensibilidad**: Para añadir nuevas capacidades al asistente (ej: "listar productos por categoría"), solo se necesita:
    1.  Crear la nueva función PHP en `lib/tools.php`.
    2.  Declarar la nueva herramienta en `api/chat.php`.
    El modelo de IA aprenderá a usarla automáticamente.
*   **Mejora de la Experiencia de Usuario (UX)**: Se reemplazan formularios y filtros complejos por una interfaz de conversación simple e intuitiva, democratizando el acceso a la información.

## 5. Conclusión

Este proyecto demuestra con éxito cómo los modelos de lenguaje modernos como Gemini pueden integrarse en aplicaciones de software tradicionales para crear sistemas más inteligentes, eficientes y fáciles de usar. La arquitectura de "Function Calling" es un puente robusto y seguro entre el lenguaje humano y los datos estructurados, abriendo un nuevo paradigma para la interacción humano-computadora.
