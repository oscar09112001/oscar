# 🧩 Minucia - Sistema de Registro y Gestión de Piezas

**Minucia** es una aplicación web desarrollada con Laravel 10, Vue 3 e Inertia.js, cuyo objetivo es facilitar el registro y control de piezas técnicas asociadas a distintos proyectos. La plataforma está pensada para ser utilizada en entornos industriales, de construcción o ingeniería donde se requiera trazabilidad, precisión y facilidad de uso.

---

## 🛠️ Tecnologías utilizadas

- **Laravel 10** – Framework PHP para el backend
- **Vue 3** – Framework progresivo para el frontend
- **Inertia.js** – Enlace entre backend y frontend sin necesidad de API REST
- **Vite** – Herramienta moderna para compilación de assets
- **Tailwind CSS** – Framework de estilos CSS utility-first
- **SQLite** – Base de datos ligera ideal para entornos locales y de desarrollo

---

## 🎯 Funcionalidades principales

- Registro de piezas con datos personalizados
- Selección dinámica de piezas según el proyecto
- Validaciones en frontend y backend
- Interfaz amigable y responsive
- Sistema de autenticación de usuarios
- Panel de reportes para consulta de registros
- Flash messages para confirmaciones de acciones

---

## 📁 Estructura del proyecto

```
├── app/                    # Lógica del servidor (modelos, controladores)
├── bootstrap/             # Archivos de arranque del framework
├── config/                # Configuraciones del sistema
├── database/              # Migraciones y base de datos SQLite
├── public/                # Archivos públicos y de entrada (index.php)
├── resources/             # Frontend: componentes Vue, estilos, vistas
├── routes/                # Definición de rutas web y API
├── storage/               # Archivos temporales y logs
├── tests/                 # Pruebas del sistema
├── .env                   # Variables de entorno (configuración local)
├── artisan                # Consola de comandos de Laravel
├── composer.json          # Dependencias de PHP
├── package.json           # Dependencias de JavaScript
└── README.md              # Documentación del proyecto
```

---

## ⚙️ Instalación del proyecto

### 1. Clonar el repositorio
```bash
git clone https://github.com/oscar09112001/minucia.git
cd minucia
```

### 2. Instalar dependencias de PHP
```bash
composer install
```

### 3. Instalar dependencias de JavaScript
```bash
npm install
```

### 4. Crear archivo de entorno y clave de aplicación
```bash
cp .env.example .env
php artisan key:generate
```

### 5. Configurar SQLite en el archivo `.env`
```env
DB_CONNECTION=sqlite
DB_DATABASE=C:\Users\Usuario\Desktop\minucia\database/database.sqlite
```

Crear el archivo de base de datos vacío:
```bash
touch database/database.sqlite
```

### 6. Ejecutar migraciones (y seeders si existen)
```bash
php artisan migrate
```

### 7. Compilar assets con Vite
```bash
npm run build
```

### 8. Iniciar el servidor de desarrollo
```bash
php artisan serve
```

---

##  Autenticación y seguridad

El acceso a las rutas principales está protegido mediante middleware `auth`.  
Solo los usuarios registrados en la base de datos pueden iniciar sesión y registrar información.

---

##  Posibilidades futuras

- Exportación de registros en PDF o Excel
- Módulo de administración de usuarios con roles
- Filtros avanzados y búsqueda en reportes
- Integración con almacenamiento externo (S3, FTP, etc)
- Historial de cambios y auditorías

---

## 📄 Licencia

Este proyecto está licenciado bajo la [MIT License](https://opensource.org/licenses/MIT).

---

## 👨‍💻 Autor

Desarrollado por **Oscar Meléndez Julio**. Proyecto académico/técnico enfocado en la trazabilidad y control de piezas técnicas dentro de proyectos estructurales o industriales.
