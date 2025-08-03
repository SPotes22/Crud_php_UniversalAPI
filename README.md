# CRUD PHP Conectado a API Flask 🔌🐘

Este proyecto es un CRUD web en PHP que se conecta a una API Flask alojada en `http://localhost:5000/transacciones/`. Está diseñado con un enfoque **minimalista**, priorizando la **funcionalidad sobre la estética**.

##  Características

- Conexión directa con API Flask para operaciones CRUD
- Manejo de sesiones con autenticación de usuarios
- Gestión de usuarios, roles y estados
- Arquitectura desacoplada (PHP como frontend, Flask como backend)
- Código ligero, ideal para entornos internos o pruebas

##  Instalación

1. Clona este repo y colócalo en tu servidor local (XAMPP, Laragon, etc.)
2. Asegúrate de que tu API Flask esté corriendo en `http://localhost:5000/transacciones/`
3. No se necesita base de datos local: todos los datos provienen de la API
4. Abre `http://localhost/crud/login.php` en tu navegador

##  Requisitos

- PHP >= 7.4
- cURL habilitado
- Servidor corriendo en `localhost`
- API Flask funcional con rutas como `/login`, `/usuarios`, etc.

##  Estructura
```
crud/
├── login.php # Inicia sesión vía API
├── index.php # Listado y edición de usuarios
├── agregar.php # Crear nuevos usuarios
├── conexion.php # Cliente cURL para la API
├── css/ # Estilos Bootstrap  
...
```
##  Por qué este enfoque

Este CRUD prioriza la lógica funcional en lugar del diseño visual. Es ideal para entornos donde:

- Se necesita un panel interno rápido
- La lógica de negocio está en una API externa
- Se desea desacoplar UI y backend

##  Licencia

MIT ©
- Santiago Potes Giraldo
- Victor Camilo Castanieda Salazar
