# Facebook API

API REST desarrollada con Laravel para administrar publicaciones, imágenes, comentarios y reacciones de tipo «Me gusta».

## Tecnologías utilizadas

- PHP
- Laravel
- MySQL
- Postman
- Git

## Requisitos

- PHP y Composer instalados.
- Un motor de base de datos compatible y configurado.
- Postman para probar los endpoints.

## Instalación

1. Clonar o descargar el repositorio.
2. Instalar las dependencias:

   ```bash
   composer install
   ```

3. Crear el archivo de configuración:

   ```bash
   copy .env.example .env
   ```

4. Generar la clave de la aplicación:

   ```bash
   php artisan key:generate
   ```

5. Configurar las credenciales de la base de datos en el archivo `.env`.
6. Ejecutar las migraciones:

   ```bash
   php artisan migrate
   ```

7. Crear el enlace para almacenar imágenes públicamente:

   ```bash
   php artisan storage:link
   ```

8. Iniciar el servidor:

   ```bash
   php artisan serve
   ```

La API estará disponible normalmente en `http://127.0.0.1:8000`.

## Endpoints

| Método | Endpoint | Descripción |
|---|---|---|
| GET | `/api/posts` | Listar publicaciones |
| GET | `/api/posts/{id}` | Consultar una publicación |
| POST | `/api/posts` | Crear una publicación con imágenes opcionales |
| DELETE | `/api/posts/{id}` | Eliminar una publicación |
| POST | `/api/posts/{id}/like` | Añadir un «Me gusta» |
| GET | `/api/posts/{postId}/comments` | Consultar comentarios |
| POST | `/api/posts/{postId}/comments` | Crear un comentario |

## Crear una publicación

Enviar una petición `POST` a `/api/posts` usando `Body → form-data` con los campos:

- `title`: título de la publicación.
- `content`: contenido de la publicación.
- `images[]`: archivo de imagen; se pueden adjuntar varias imágenes.

Las imágenes admitidas por la validación son JPEG, PNG, JPG, GIF y WebP, con un máximo de 5 MB por imagen.

## Probar con Postman

La colección de pruebas exportada se encuentra en:

`facebook-api-postman-collection.json`

Importa el archivo en Postman para consultar y ejecutar las peticiones de la API.