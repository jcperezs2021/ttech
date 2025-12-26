#!/bin/bash

# ============================================
# Script de Instalación - Organigramas Personalizados
# ============================================

echo "=========================================="
echo "Instalación de Organigramas Personalizados"
echo "=========================================="
echo ""

# Colores para output
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Directorio del proyecto
PROJECT_DIR="/var/www/ttech"

# Verificar que estamos en el directorio correcto
if [ ! -f "$PROJECT_DIR/spark" ]; then
    echo -e "${RED}Error: No se encuentra el archivo spark en $PROJECT_DIR${NC}"
    echo "Por favor, ajusta la variable PROJECT_DIR en el script"
    exit 1
fi

cd "$PROJECT_DIR" || exit 1

echo -e "${YELLOW}[1/4] Verificando archivos...${NC}"
# Verificar que los archivos existen
FILES=(
    "app/Controllers/CustomOrganigram.php"
    "app/Models/CustomOrganigramModel.php"
    "app/Models/CustomOrganigramUserModel.php"
    "app/Database/Migrations/2025-12-25-000001_create_custom_organigramas_table.php"
    "app/Views/pages/admin/custom-organigram/index.php"
    "app/Views/pages/admin/custom-organigram/create.php"
    "app/Views/pages/admin/custom-organigram/edit.php"
    "app/Views/pages/admin/custom-organigram/view.php"
)

MISSING_FILES=0
for file in "${FILES[@]}"; do
    if [ ! -f "$file" ]; then
        echo -e "${RED}✗ Falta: $file${NC}"
        MISSING_FILES=$((MISSING_FILES + 1))
    else
        echo -e "${GREEN}✓ Encontrado: $file${NC}"
    fi
done

if [ $MISSING_FILES -gt 0 ]; then
    echo -e "${RED}Error: Faltan $MISSING_FILES archivos. Por favor, verifica la instalación.${NC}"
    exit 1
fi

echo ""
echo -e "${YELLOW}[2/4] Ejecutando migraciones...${NC}"
# Ejecutar migraciones
php spark migrate

if [ $? -eq 0 ]; then
    echo -e "${GREEN}✓ Migraciones ejecutadas exitosamente${NC}"
else
    echo -e "${RED}✗ Error al ejecutar migraciones${NC}"
    echo -e "${YELLOW}Intenta ejecutar manualmente:${NC}"
    echo "  cd $PROJECT_DIR"
    echo "  php spark migrate"
    exit 1
fi

echo ""
echo -e "${YELLOW}[3/4] Verificando tablas en base de datos...${NC}"
# Verificar que las tablas existen (requiere acceso a MySQL)
echo "Verifica manualmente que las siguientes tablas existan:"
echo "  - custom_organigramas"
echo "  - custom_organigrama_users"

echo ""
echo -e "${YELLOW}[4/4] Verificando permisos...${NC}"
# Verificar permisos de escritura
if [ -w "writable" ]; then
    echo -e "${GREEN}✓ Directorio writable tiene permisos de escritura${NC}"
else
    echo -e "${RED}✗ El directorio writable no tiene permisos de escritura${NC}"
    echo "Ejecuta: sudo chmod -R 777 writable"
fi

echo ""
echo "=========================================="
echo -e "${GREEN}✓ Instalación completada!${NC}"
echo "=========================================="
echo ""
echo "Accede al módulo en:"
echo "  http://tu-dominio.com/custom-organigram"
echo ""
echo "Usuarios con rol 'admin' podrán:"
echo "  - Crear organigramas personalizados"
echo "  - Editar y eliminar organigramas"
echo "  - Visualizar organigramas gráficamente"
echo ""
echo "Para más información, consulta:"
echo "  - ORGANIGRAMAS_PERSONALIZADOS_README.md"
echo "  - RESUMEN_IMPLEMENTACION.md"
echo ""
echo -e "${YELLOW}¡Listo para usar!${NC}"
