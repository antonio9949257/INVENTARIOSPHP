#!/bin/bash


echo "Este script borrará la base de datos 'bdprueba' y la volverá a crear con los datos de FarmaCorp."
echo "Se te pedirá la contraseña de MySQL para el usuario 'root' a continuación."
echo

read -sp "Introduce la contraseña de MySQL para 'root': " MYSQL_PASSWORD
echo
echo "------------------------------------"

echo "Paso 1/6: Borrando la base de datos 'bdprueba'..."
mysql -u root -p"$MYSQL_PASSWORD" -e "DROP DATABASE IF EXISTS bdprueba;"

if [ $? -ne 0 ]; then
    echo "Error al conectar a MySQL o al borrar la base de datos. Verifica tu contraseña. Abortando."
    exit 1
fi

echo "Paso 2/6: Importando estructura principal y usuarios..."
mysql -u root -p"$MYSQL_PASSWORD" < /home/devadam/INVENTARIOSPHP/database/bd.sql

echo "Paso 3/6: Importando categorías..."
mysql -u root -p"$MYSQL_PASSWORD" bdprueba < /home/devadam/INVENTARIOSPHP/database/inventory_sql/categorias.sql

echo "Paso 4/6: Importando proveedores..."
mysql -u root -p"$MYSQL_PASSWORD" bdprueba < /home/devadam/INVENTARIOSPHP/database/inventory_sql/proveedores.sql

echo "Paso 5/6: Importando productos..."
mysql -u root -p"$MYSQL_PASSWORD" bdprueba < /home/devadam/INVENTARIOSPHP/database/inventory_sql/productos.sql

echo "Paso 6/6: Importando movimientos..."
mysql -u root -p"$MYSQL_PASSWORD" bdprueba < /home/devadam/INVENTARIOSPHP/database/inventory_sql/movimientos.sql

echo "------------------------------------"
echo "✅ ¡Importación completada con éxito!"
echo "La base de datos 'bdprueba' ha sido cargada con los datos de FarmaCorp."
