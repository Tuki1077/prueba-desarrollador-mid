#!/usr/bin/env python3
"""
Sección 4: Python - Análisis de Productos CSV
Script que lee productos_1000.csv y muestra:
- Promedio de precios
- Producto con mayor stock  
- Total de productos
"""

import csv
import sys
from statistics import mean

def analizar_productos(archivo_csv):
    """
    Analiza el archivo CSV de productos y retorna estadísticas
    """
    productos = []
    
    try:
        with open(archivo_csv, 'r', encoding='utf-8') as file:
            reader = csv.DictReader(file)
            
            # Leer todos los productos
            for row in reader:
                producto = {
                    'nombre': row['nombre'],
                    'precio': float(row['precio']),
                    'stock': int(row['stock'])
                }
                productos.append(producto)
        
        return productos
    
    except FileNotFoundError:
        print(f"❌ Error: No se encontró el archivo '{archivo_csv}'")
        return None
    except ValueError as e:
        print(f"❌ Error en los datos: {e}")
        return None
    except Exception as e:
        print(f"❌ Error inesperado: {e}")
        return None

def calcular_estadisticas(productos):
    """
    Calcula las estadísticas requeridas de los productos
    """
    if not productos:
        return None
    
    # 1. Promedio de precios
    precios = [p['precio'] for p in productos]
    promedio_precios = mean(precios)
    
    # 2. Producto con mayor stock
    producto_mayor_stock = max(productos, key=lambda x: x['stock'])
    
    # 3. Total de productos
    total_productos = len(productos)
    
    # Estadísticas adicionales útiles
    precio_minimo = min(precios)
    precio_maximo = max(precios)
    stock_total = sum(p['stock'] for p in productos)
    stock_promedio = mean([p['stock'] for p in productos])
    
    return {
        'promedio_precios': promedio_precios,
        'producto_mayor_stock': producto_mayor_stock,
        'total_productos': total_productos,
        'precio_minimo': precio_minimo,
        'precio_maximo': precio_maximo,
        'stock_total': stock_total,
        'stock_promedio': stock_promedio
    }

def mostrar_resultados(estadisticas):
    """
    Muestra los resultados del análisis de forma clara
    """
    print("=" * 60)
    print("📊 ANÁLISIS DE PRODUCTOS CSV")
    print("=" * 60)
    
    print("\n🔢 RESULTADOS REQUERIDOS:")
    print(f"• Promedio de precios: ${estadisticas['promedio_precios']:.2f}")
    print(f"• Producto con mayor stock: {estadisticas['producto_mayor_stock']['nombre']}")
    print(f"  - Stock: {estadisticas['producto_mayor_stock']['stock']} unidades")
    print(f"  - Precio: ${estadisticas['producto_mayor_stock']['precio']:.2f}")
    print(f"• Total de productos: {estadisticas['total_productos']}")
    
    print("\n📈 ESTADÍSTICAS ADICIONALES:")
    print(f"• Precio mínimo: ${estadisticas['precio_minimo']:.2f}")
    print(f"• Precio máximo: ${estadisticas['precio_maximo']:.2f}")
    print(f"• Stock total: {estadisticas['stock_total']:,} unidades")
    print(f"• Stock promedio: {estadisticas['stock_promedio']:.1f} unidades")
    
    print("=" * 60)

def main():
    """
    Función principal del script
    """
    archivo_csv = "productos_1000 (1).csv"
    
    print("🐍 Iniciando análisis de productos...")
    print(f"📁 Archivo: {archivo_csv}")
    
    # Leer y analizar productos
    productos = analizar_productos(archivo_csv)
    
    if productos is None:
        print("❌ No se pudo completar el análisis")
        sys.exit(1)
    
    # Calcular estadísticas
    estadisticas = calcular_estadisticas(productos)
    
    if estadisticas is None:
        print("❌ No se pudieron calcular las estadísticas")
        sys.exit(1)
    
    # Mostrar resultados
    mostrar_resultados(estadisticas)
    
    # Mostrar algunos productos de ejemplo
    print("\n💡 PRODUCTOS DE EJEMPLO:")
    print("Primeros 5 productos:")
    for i, producto in enumerate(productos[:5], 1):
        print(f"{i}. {producto['nombre']} - ${producto['precio']:.2f} - Stock: {producto['stock']}")
    
    print("\nÚltimos 5 productos:")
    for i, producto in enumerate(productos[-5:], len(productos) - 4):
        print(f"{i}. {producto['nombre']} - ${producto['precio']:.2f} - Stock: {producto['stock']}")

if __name__ == "__main__":
    main()