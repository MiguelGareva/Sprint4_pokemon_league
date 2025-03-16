# 🏆 Liga Pokémon - Sistema de Gestión de Entrenadores y Combates

![Banner de Liga Pokémon](https://i.imgur.com/JGyswQh.png)

## 📋 Descripción

Liga Pokémon es una aplicación web desarrollada con Laravel y Tailwind CSS que simula un sistema de gestión para una liga de entrenadores Pokémon. Permite registrar entrenadores, capturar y entrenar Pokémon, y organizar combates para determinar quién es el mejor entrenador.

## ✨ Características principales

- 👤 **Gestión de entrenadores**: Registro, visualización, edición y eliminación de perfiles de entrenadores.
- 🐲 **Gestión de Pokémon**: Captura, visualización, asignación a entrenadores, edición y liberación de Pokémon.
- ⚔️ **Sistema de combates**: Organización de enfrentamientos entre entrenadores con un sistema automático de evaluación basado en estadísticas de los Pokémon.
- 📊 **Sistema de puntuación**: Asignación de puntos basada en resultados de combates que permite establecer un ranking de entrenadores.
- 🏅 **Ranking**: Visualización de los mejores entrenadores según sus puntos acumulados.

## 🖥️ Capturas de pantalla

<div align="center">
  <img src="https://i.imgur.com/VdTQVfw.png" alt="Dashboard" width="45%">
  <img src="https://i.imgur.com/l1KgQKo.png" alt="Combate" width="45%">
</div>

## 🛠️ Tecnologías utilizadas

- **[Laravel](https://laravel.com/)**: Framework PHP para el backend
- **[Tailwind CSS](https://tailwindcss.com/)**: Framework CSS para la interfaz
- **[Alpine.js](https://alpinejs.dev/)**: Framework JS minimalista para interacciones
- **MySQL**: Sistema de base de datos relacional

## 🚀 Instalación y configuración

### Requisitos previos
- PHP >= 8.1
- Composer
- MySQL
- Node.js y npm

### Pasos de instalación

1. **Clonar el repositorio**
   ```bash
   git clone https://github.com/tuusuario/pokemon-league.git
   cd pokemon-league
   ```

2. **Instalar dependencias PHP**
   ```bash
   composer install
   ```

3. **Configurar variables de entorno**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configurar la base de datos**
   - Edita el archivo `.env` con tus credenciales de MySQL

5. **Ejecutar migraciones y seeders**
   ```bash
   php artisan migrate --seed
   ```

6. **Iniciar el servidor de desarrollo**
   ```bash
   php artisan serve
   ```

7. **Acceder a la aplicación**
   - Visita `http://localhost:8000` en tu navegador

## 📝 Estructura del proyecto

- **app/Models**: Contiene los modelos Eloquent (Entrenador, Pokemon, Combate)
- **app/Http/Controllers**: Controladores para las diferentes entidades
- **app/Services**: Servicios para la lógica de negocio (ej: CombateService)
- **resources/views**: Vistas Blade organizadas por secciones
  - **/entrenadores**: Vistas relacionadas con entrenadores
  - **/pokemon**: Vistas relacionadas con Pokémon
  - **/combates**: Vistas relacionadas con combates
  - **/components**: Componentes reutilizables
  - **/layouts**: Plantillas base

## 💼 Casos de uso

1. **Registro de entrenadores**:
   - Crear perfiles con datos básicos
   - Asignación automática de avatar basado en la inicial del nombre

2. **Gestión de Pokémon**:
   - Capturar nuevos Pokémon para un entrenador
   - Visualizar estadísticas y detalles
   - Liberar Pokémon que ya no se deseen

3. **Organización de combates**:
   - Seleccionar dos entrenadores con al menos 3 Pokémon cada uno
   - Sistema automático de determinación del ganador
   - Asignación de puntos según el resultado

## 🔄 Flujo de trabajo

1. Registrar entrenadores en el sistema
2. Capturar y asignar Pokémon a los entrenadores
3. Organizar combates entre entrenadores con equipos completos
4. Visualizar resultados y ranking en el dashboard

## 👥 Contribución

Las contribuciones son bienvenidas. Para contribuir:

1. Haz un fork del proyecto
2. Crea una rama para tu característica (`git checkout -b feature/nueva-caracteristica`)
3. Haz commit de tus cambios (`git commit -am 'Añade nueva característica'`)
4. Haz push a la rama (`git push origin feature/nueva-caracteristica`)
5. Abre un Pull Request

## 📄 Licencia

Este proyecto está licenciado bajo la [Licencia MIT](LICENSE).

## 📞 Contacto

Para cualquier consulta o sugerencia, puedes contactarme a través de:

- Email: miguel.gareva@gmail.com
- Twitter: próximamente.
- LinkedIn: próximamente.

---

<div align="center">
  
  **¡Conviértete en el mejor entrenador Pokémon!**
  
  ![Pokeball](https://i.imgur.com/2Fxa3Py.png)
  
</div>