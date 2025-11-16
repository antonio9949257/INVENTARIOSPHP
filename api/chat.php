<?php
header("Content-Type: application/json");

$config = require __DIR__ . '/../config.php';
require_once __DIR__ . '/../lib/tools.php';

$apiKey = $config["GEMINI_API_KEY"];
if (!$apiKey || $apiKey === "TU_API_KEY_AQUI") {
    http_response_code(500);
    echo json_encode(["error" => "API key no configurada. Revisa tu archivo config.php"]);
    exit;
}

$input = json_decode(file_get_contents("php://input"), true);
$history = $input['history'] ?? [];
$mensajeUsuario = $input["mensaje"] ?? "";

if (empty($mensajeUsuario)) {
    http_response_code(400);
    echo json_encode(["error" => "El mensaje no puede estar vacío."]);
    exit;
}

$tools = [
    [
        "functionDeclarations" => [
            [
                "name" => "obtener_stock_producto",
                "description" => "Devuelve el stock de un producto específico buscado por su nombre.",
                "parameters" => [
                    "type" => "object",
                    "properties" => [
                        "nombre" => ["type" => "string", "description" => "Nombre del producto a buscar"]
                    ],
                    "required" => ["nombre"]
                ]
            ],
            [
                "name" => "listar_proveedores",
                "description" => "Devuelve una lista con todos los proveedores disponibles en la base de datos."
            ],
            [
                "name" => "obtener_ultimos_movimientos",
                "description" => "Devuelve una lista de los movimientos de inventario más recientes.",
                "parameters" => [
                    "type" => "object",
                    "properties" => [
                        "limite" => ["type" => "integer", "description" => "Número de movimientos a obtener. Por defecto 5."]
                    ]
                ]
            ],
            [
                "name" => "obtener_productos_por_categoria",
                "description" => "Devuelve una lista de productos que pertenecen a una categoría específica.",
                "parameters" => [
                    "type" => "object",
                    "properties" => [
                        "nombre_categoria" => ["type" => "string", "description" => "Nombre de la categoría de productos a buscar (ej. 'Medicamentos sin receta')."]
                    ],
                    "required" => ["nombre_categoria"]
                ]
            ],
            [
                "name" => "obtener_productos_bajo_stock",
                "description" => "Devuelve una lista de todos los productos cuyo stock actual es igual o inferior a su stock mínimo definido."
            ],
            [
                "name" => "obtener_info_proveedor",
                "description" => "Devuelve la información de contacto completa (teléfono, email, dirección) de un proveedor específico.",
                "parameters" => [
                    "type" => "object",
                    "properties" => [
                        "nombre_proveedor" => ["type" => "string", "description" => "Nombre del proveedor a buscar (ej. 'PharmaGlobal')."]
                    ],
                    "required" => ["nombre_proveedor"]
                ]
            ],
            [
                "name" => "obtener_valor_inventario_total",
                "description" => "Calcula y devuelve el valor monetario total de todo el inventario, ya sea a precio de compra o de venta.",
                "parameters" => [
                    "type" => "object",
                    "properties" => [
                        "tipo_valor" => ["type" => "string", "enum" => ["compra", "venta"], "description" => "Tipo de precio a usar para el cálculo: 'compra' o 'venta'. Por defecto es 'compra'."]
                    ]
                ]
            ]
        ]
    ]
];

$contents = [];
foreach ($history as $entry) {
    $contents[] = [
        'role' => $entry['role'],
        'parts' => [['text' => $entry['text']]]
    ];
}
$contents[] = [
    'role' => 'user',
    'parts' => [['text' => $mensajeUsuario]]
];

$payload = [
    "contents" => $contents,
    "tools" => $tools
];

$responseJson = enviarA_Gemini($payload, $apiKey);
$response = json_decode($responseJson, true);

if (isset($response['error'])) {
    http_response_code(500);
    $errorMessage = $response['error']['message'] ?? 'Error desconocido de la API de Gemini.';
    echo json_encode(["error" => "Error de la API: " . $errorMessage]);
    exit;
}

if (!isset($response['candidates'][0]['content'])) {
    http_response_code(500);
    echo json_encode(["error" => "La respuesta de la API no tiene el formato esperado. Asegúrate de que tu API Key es correcta y tiene permisos."]);
    exit;
}

$functionCall = $response["candidates"][0]["content"]["parts"][0]["functionCall"] ?? null;

if ($functionCall) {
    $nombreFuncion = $functionCall["name"];
    $args = $functionCall["args"] ?? [];

    if (function_exists($nombreFuncion)) {
        $resultado = call_user_func_array($nombreFuncion, $args);

        $contents[] = [
            'role' => 'model',
            'parts' => [['functionCall' => $functionCall]]
        ];
        $contents[] = [
            'role' => 'tool',
            'parts' => [[
                'functionResponse' => [
                    'name' => $nombreFuncion,
                    'response' => ['result' => $resultado] 
                ]
            ]]
        ];

        $followupPayload = [
            "contents" => $contents,
            "tools" => $tools
        ];

        $finalResponseJson = enviarA_Gemini($followupPayload, $apiKey);
        $finalResponse = json_decode($finalResponseJson, true);
        
        $respuestaFinal = $finalResponse["candidates"][0]["content"]["parts"][0]["text"] ?? "No pude procesar la respuesta de la herramienta.";
        echo json_encode(["respuesta" => $respuestaFinal]);

    } else {
        $respuestaError = "La herramienta '{$nombreFuncion}' no está disponible.";
        echo json_encode(["respuesta" => $respuestaError]);
    }
} else {
    $respuestaDirecta = $response["candidates"][0]["content"]["parts"][0]["text"] ?? "No he podido procesar tu solicitud.";
    echo json_encode(["respuesta" => $respuestaDirecta]);
}

function enviarA_Gemini($body, $apiKey) {
    $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=" . $apiKey;
    
    $ch = curl_init($url);

    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($body),
        CURLOPT_HTTPHEADER => ["Content-Type: application/json"],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => true
    ]);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        $error_msg = curl_error($ch);
        curl_close($ch);
        return json_encode(["error" => "Error de cURL: " . $error_msg]);
    }

    curl_close($ch);
    return $response;
}
