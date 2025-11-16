#!/bin/bash

clear

echo "======================================================"
echo "   Prueba de API Key para Google Gemini"
echo "======================================================"
echo ""
echo "Por favor, pega tu API Key de Google y presiona Enter:"
read -p "API Key: " apiKey

if [ -z "$apiKey" ]; then
    echo ""
    echo "❌ Error: No se ingresó ninguna API key. Abortando."
    exit 1
fi

echo ""
echo "--------------------------------------------------"
echo "Probando la clave..."
echo "--------------------------------------------------"
echo ""

curl -s -H 'Content-Type: application/json' \
     -d '{"contents":[{"parts":[{"text":"Hola"}]}]}' \
     "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=${apiKey}"

echo ""
echo ""
echo "--------------------------------------------------"
echo "Prueba finalizada."
echo "--------------------------------------------------"
echo "Si ves un bloque de JSON con 'error', la clave o tu proyecto de Google tienen un problema."
echo "Si ves un bloque de JSON con 'candidates', ¡la clave funciona!"
echo ""
