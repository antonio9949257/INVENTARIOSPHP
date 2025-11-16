#!/bin/bash

clear

echo "======================================================"
echo "   Listado de Modelos Gemini Disponibles"
echo "======================================================"
echo ""
echo "Pega tu API Key de Google para ver los modelos a los que tienes acceso:"
read -p "API Key: " apiKey

if [ -z "$apiKey" ]; then
    echo ""
    echo "❌ Error: No se ingresó ninguna API key. Abortando."
    exit 1
fi

echo ""
echo "--------------------------------------------------"
echo "Buscando modelos disponibles para tu clave..."
echo "--------------------------------------------------"
echo ""

curl -s "https://generativelanguage.googleapis.com/v1beta/models?key=${apiKey}" | (command -v jq >/dev/null && jq . || cat)


echo ""
echo "--------------------------------------------------"
echo "Listado finalizado."
echo "--------------------------------------------------"
echo "Busca en la lista un modelo que soporte 'generateContent', por ejemplo 'gemini-pro'."
echo ""
