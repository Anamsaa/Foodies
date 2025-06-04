# Foodies 

## Índice

1. [Descripción del proyecto](#descripción-del-proyecto)  
2. [Objetivos](#objetivos)  
3. [Ruta privada](#ruta-privada)  
4. [Tecnologías utilizadas](#tecnologías-utilizadas)  
5. [Diseño general de la interfaz](#diseño-general-de-la-interfaz)  
6. [Funcionamiento del sistema](#funcionamiento-del-sistema)  

---

## Descripción del proyecto 

Foodies es una red social diseñada para la exploración de restaurantes y la conexión entre usuarios a través de gustos gastronómicos. Esta web permitirá a sus usuarios interactuar entre sí, descubrir nuevos lugares para comer y participar en eventos. Además de darle visibilidad y promoción a negocios del sector de la restauración. 

---

## Objetivos

* Facilitar la búsqueda de información. 
* Diseñar una plataforma intuitiva, fácil de utilizar y eficiente.
* Implementar la lógica de perfiles y conexiones sociales. 
* Desarrollar un sistema de autenticación y registro seguro y funcional.
* Crear una funcionalidad de eventos gastronómicos (Dar visualización a eventos generados por usuarios permitiendo su conocimiento e interacción).

---

## Ruta pública
[Link a Foodies proporcionado por Railway](https://foodies-production-ed5b.up.railway.app/)

---

## Tecnologías utilizadas

### Lenguajes de Programación | Frameworks

- **Laravel** (framework PHP)
- **JavaScript**
- **Sass**

### Gestión de BBDD | Administrador de BBDD

- **MySQL / MariaDB**
- **Adminer**
- **Railway** / *Plug-in* MySQL

### Entorno de Desarrollo

- **Visual Studio Code (VSC)**

### Gestión de Versiones

- **GitHub**

### Wireframes | Diseño de Imágenes

- **Miro**
- **Canva**
- **Gimp**

### Diagramas UML | Modelo Entidad-Relación (MER)

- **Draw.io**

### API’s

- **GeoAPI España**

### Despliegue
- **Railway**

---

## Diseño general de la interfaz 

### Logo corporativo 
![Logo Foodies](/assets%20readme/logo-foodies.png)

### ¿Por qué "Foodies"? 
Foodies es un término en inglés que se usa para describir a una persona apasionada por la comida, que busca experiencias culinarias únicas y de alta calidad. Un foodie se interesa por: 
- Probar nuevos sabores, platos o cocinas de diferentes culturas. 
- Descubrir restaurantes, cafeterías, mercados o puestos de comida interesantes.
- Compartir sus vivencias a menudo en redes sociales.

### Target audience: 
El target audience de esta red social varía en función del rol del usuario dentro del programa. Las características que se reconocen según el tipo de usuario son: 

- Personas: 
    - Habita en España.
    - Mayor de 16 años. 
    - Tiene interes por la comida, compartir experiencias en redes e interactuar con otras personas. 

- Restaurantes: 
    - Se ubica en España. 
    - Negocio dedicado a la restauración.
    - Requiere de visibilidad y usa las redes sociales como medio de interacción con sus clientes.
    - Puede proporcionar un servicio de venta presencial.

### Paleta de colores 
![Paleta de colores Foodies](/assets%20readme/paleta_colores.jpg)

#### Explicación: 
1. **Colores principales:** 
Estos definen la identidad visual y se usan en elementos clave como encabezados, navegación o botones destacados.
- Primario: **#2c3143** 
Un azul oscuro-grisáceo transmite profesionalismo, confianza y elegancia. Como color base, ancla visualmente la interfaz y permite que los colores más cálidos (como el naranja y el amarillo) destaquen.
- Secundario: **#fcfef3** 
Un blanco cálido con un tinte ligeramente verdoso que aporta limpieza, frescura y luz. Representa los ingredientes frescos, el aire libre, y la claridad que se espera en una experiencia social positiva.

2. **Colores de acento:**
Se utilizan para destacar acciones importantes (botones, íconos, llamadas a la acción).
- Botones: **#ffb136**
Dorado vibrante llama la atención y genera acción. Transmite energía, calidez y apetito, tres emociones clave en gastronomía.
- Iconos: **#f27d16**
Naranja más intenso, muy relacionado con alimentos como zanahoria, calabaza o especias. Se usa en íconos porque genera asociación directa con la comida, lo artesanal y lo natural.

3. **Colores de fondo:**
Proporcionan estructura visual y separan secciones. También se usan en formularios.
- General (páginas): **#e9e8df**
Color que aporta sensación de hogar y autenticidad.
- Inputs: **#e6e8df**
Un gris claro similar al fondo, pensado para no distraer pero mantener contraste suficiente con el texto. 
- Formularios Login/Register: **#5d616b**
- Creación de perfil / índice: **#e9eae1**
Color suave, casi crema, perfecto para interfaces de perfil o administración. Comunica tranquilidad y neutralidad.
- Fondo con transparencia: **rgba(252, 254, 243, 0.7)**
Ideal para overlays, modales o tarjetas flotantes. La transparencia genera una sensación de suavidad y elegancia.

4. **Colores de texto:**
Definen la legibilidad y jerarquía textual.
- Texto general: **#4e515a**
- Títulos formularios: **#28313c**
- Títulos en login: **#ffffff**
Blanco sobre fondos oscuros genera alto contraste, esto resalta los títulos y mejora la accesibilidad visual en pantallas pequeñas.

#### Pruebas de contraste
A continuación se realizan pruebas de contraste, para evaluar la visibilidad de ciertos elementos sobre las posibles opciones de colores utilizados para el fondo.

![Prueba de contraste](/assets%20readme/contraste_1.png)
![Prueba de contraste](/assets%20readme/contraste_2.png)
![Prueba de contraste](/assets%20readme/contraste_3.png)

### Tipografía 

##### Quicksand
![Prueba de peso de fuente](/assets%20readme/font_test.png)
![Fuente Quicksand](/assets%20readme/quicksand.png)

#### Justificación de elección: 
Quicksand es una fuente creada por Andrew Paglinawan, esta fuente transmite una sensación de amabilidad, alegría y ligereza. Es válida tanto para párrafos y textos pequeños debido a que es muy legible. La intención al incluirla en el proyecto era la de trasmitirle a los usuarios esa sensación de que estaban en un espacio confiable que les permitiía conocer a otros sin consideraciones estrictas.

### Sass y Css
El diseño visual de la plataforma se basa en CSS,  un lenguaje de hojas de estilo que permite definir y  mejorar la presentación de los elementos de la web. Para optimizar el proceso se ha incorporado Sass, como preprocesador, permitiendo la escritura de estilos de manera más eficiente, organizada y mantenible.
Para la interfaz de Foodies se optó por un diseño a medida realizado por su autora, con el objetivo de mantener una identidad visual propia y tener control sobre la apariencia.  La decisión también va respaldada por el sistema de layouts y componentes reutilizables que ofrece Laravel Blade. 

### Mockups
[Vista a los Mockups](https://miro.com/app/board/uXjVI0krxWw=/?share_link_id=806314527171)

### Resultados finales y comparaciones
![Vista Ordenador Foodies](/assets%20readme/Casos_de_uso.drawio.png)
![Vista Ordenador Foodies](/assets%20readme/Casos_de_uso.drawio.png)
![Vista Ordenador Foodies](/assets%20readme/Casos_de_uso.drawio.png)
![Vista Ordenador Foodies](/assets%20readme/Casos_de_uso.drawio.png)
![Vista Ordenador Foodies](/assets%20readme/Casos_de_uso.drawio.png)

---

## Funcionamiento del sistema

### Modelo Entidad-Relación:
![Modelo Entidad Relación](/assets%20readme/Entidad-relacion.drawio.png)

### Requerimientos funcionales:
- El sistema permitirá la ***creación de cuentas*** a los usuarios.
- El sistema permitirá la ***creación de perfiles*** a los usuarios.
- El sistema permitirá ***subir una imagen a cada publicación*** a los usuarios según su propósito. Una imagen puede pertenecer a los siguientes tipos: publicación, perfil o portada.
- Cada usuario, sin importar su rol dentro del sistema, podrá ser capaz de publicar, editar y eliminar publicaciones de carácter regular que pueden incluir texto e imágenes. 
- El sistema permitirá ***eliminar cuentas*** a los usuarios. 
- El sistema le permitirá al usuario ***editar su perfil y cambiar los datos procedentes de su creación***.
- El sistema le permitirá al usuario ***ser seguido por otros usuarios*** de tipo Persona.
- Cada usuario, sin importar su rol,  ***podrá darle likes o hacer comentarios a publicaciones de otros***.
- El sistema ***guardará*** la publicación y modificación de datos. 
- El sistema solo ***permitirá crear un perfil a un usuario que ya posea una cuenta***. 
- El sistema ***podrá actualizar los datos*** en base a su fecha y hora de publicación.
- El sistema ***mostrará notificaciones de seguimiento***.

### Modelo de Casos de uso: 
![Diagrama de casos de uso](/assets%20readme/Casos_de_uso.drawio.png)

### Manejo de sesiones en el programa: 

#### Definiciones clave: 
#### Sesión 
Mecanismo que utiliza Laravel para recordar quién es el usuario que está usando el sistema.
Cada sesión almacena el ID del usuario autenticado y está asociado a una cookie en el navegador del cliente **laravel_session**

#### Guard
Define cómo se autentifica un usuario y dónde se guarda su sesión. Cada tipo de usuario en el sistema puede tener su propio guard. 

#### Provider 
Define cómo y desde dónde Laravel obtiene los datos del usuario que está intentando iniciar sesión. 

#### Drivers
Es la forma específica en que una funcionalidad se implementa o se conecta un sistema externo.

![Diagrama de sesiones](/assets%20readme/Proceso_autentificacion.jpg)

config/auth.php
```php
'guards' => [
        'user' => [
            'driver' => 'session',
            'provider' => 'users', //personas
        ],
        'restaurant' => [
            'driver' => 'session', 
            'provider' => 'restaurants', //restaurantes 
        ]
    ],
```

```php
'providers' => [
    'users' => [
        'driver' => 'eloquent',   
        'model' => App\Models\Account::class,
    
    ],
    'restaurants' => [
        'driver' => 'eloquent', 
        'model' => App\Models\Account::class,
    
    ],   
],
```
#### Ejemplo: 
`Auth::guard('restaurant')->login($restaurant);`

1. Se usa el guard **restaurant** (definido en ***auth.php***).
2. El **ID de usuario** se guarda en la sesión.
3. Genera o actualiza la cookie **laravel_session**.
4. Guarda la info en el sistema de sesiones de Laravel.

#### Estructura general de carpetas

#### Backend 
En el backend se utilizó el framework Laravel, estructurado en base a los principios MVC. La aplicación está organizada en:

- Controladores: Encargados de gestionar las peticiones HTTP, validar datos, orquestar llamadas a modelos y devolver vistas o redirecciones.
- Modelos: Representan las entidades de la base de datos. Incluyen relaciones Eloquent para conectar entidades como usuarios, publicaciones, perfiles, eventos, etc.
- Migraciones: Se usaron para definir y versionar la estructura de las tablas de la base de datos, permitiendo control de versiones en el esquema de forma automatizada y segura.

```text
app/
├── Http/
│   ├── Controllers/
│   │   ├── Auth/
│   │   │   ├── CommentController.php
│   │   │   ├── Controller.php
│   │   │   ├── CulinaryEventController.php
│   │   │   ├── FollowController.php
│   │   │   ├── LoginPeopleController.php
│   │   │   ├── LoginRestaurantController.php
│   │   │   ├── LogoutPeopleController.php
│   │   │   ├── LogoutRestaurantController.php
│   │   │   ├── PeopleProfileController.php
│   │   │   ├── PostController.php
│   │   │   ├── RegisterPeopleController.php
│   │   │   ├── RegisterRestaurantController.php
│   │   │   ├── RestaurantProfileController.php
│   │   │   └── UbicacionController.php
│   │   ├── Middleware/
│   │   │   ├── AuthenticateCustom.php
│   │   │   └── PreventBackHistory.php
│   │   └── Requests/
│
├── Models/
│   ├── Account.php
│   ├── City.php
│   ├── Comment.php
│   ├── CulinaryEvent.php
│   ├── EventParticipation.php
│   ├── Follow.php
│   ├── Like.php
│   ├── Notification.php
│   ├── Person.php
│   ├── Photo.php
│   ├── Post.php
│   ├── Profile.php
│   ├── Province.php
│   ├── Region.php
│   ├── Restaurant.php
│   ├── Review.php
│   ├── User.php
│   └── UserSession.php
│
├── Providers/
│   ├── AppServiceProvider.php
│   └── ViewComposerServiceProvider.php
│
├── View/
└── helpers.php
```
**Routes (Web.php) Gestión de rutas generales**
En lugar de separar rutas en múltiples archivos como api.php o definir rutas basadas en subdominios, decidí centralizar todas las rutas de la aplicación en el archivo web.php. Esto me permitió:

1. Tener una visión global del sistema de rutas.
2. Agrupar rutas por tipo de usuario (persona o restaurante) usando prefix() y middleware().
3. Controlar claramente los flujos de navegación y proteger rutas según roles y sesiones activas.

##### Rutas generales
- Página principal (landing).
- Visualización de perfiles ajenos (usuario - restaurante).
- Rutas de interacción: likes, comentarios, seguimiento.

##### Rutas de usuario persona
Agrupadas con:

`Route::prefix('user')->group(function () {`

Organizadas en:
**Públicas:** registro, login.
**Privadas:** dashboard, creación de perfil, publicaciones, eventos culinarios, ajustes, logout.

##### Rutas de usuario restaurante
Agrupadas con:
`Route::prefix('restaurant')->group(function () {`
División parecida a la del usuario persona, pero adaptada al flujo de creación de perfil en dos pasos, y con vistas adaptadas a ese tipo de cuenta.

También cuentan con rutas protegidas y organización clara para acciones como:

- Subida de imágenes.
- Publicaciones.
- Ajustes de cuenta.
- Eliminación de cuenta.

```text
routes/
├── auth.php
├── console.php
└── web.php
```

#### Frontend 
```text
resources/
├── css/
├── js/
│   ├── elements/
│   ├── app.js
│   ├── bootstrap.js
│   ├── comprobaciones.js
│   ├── eventos.js
│   ├── perfil.js
│   ├── posts.js
│   └── toggleMenuForPosts.js
├── sass/
│   ├── formularios/
│   ├── _comment.scss
│   ├── _eventos.scss
│   ├── _follow.scss
│   ├── _landing.scss
│   ├── _login-register.scss
│   ├── _media-queries.scss
│   ├── _mixins.scss
│   ├── _modulo.scss
│   ├── _posts.scss
│   ├── _principal.scss
│   ├── _profile.scss
│   ├── ajustes.scss
│   ├── app.css
│   ├── app.css.map
│   └── app.scss
├── views/
│   ├── auth/
│   ├── components/
│   ├── layouts/
│   ├── partials/
│   ├── personas/
│   ├── profile/
│   ├── publicaciones/
│   ├── restaurantes/
│   ├── dashboard.blade.php
│   ├── landing.blade.php
│   └── welcome.blade.php
```
En este proyecto Laravel, la carpeta resources agrupa todos los elementos relacionados con la interfaz visual y experiencia de usuario. Se organiza de forma clara para facilitar el mantenimiento del sistema, separando las vistas, componentes, estilos y scripts según su funcionalidad y rol en la aplicación.

A continuación, se detallan sus principales secciones:

1. Vistas (resources/views/)
Las vistas son archivos Blade (.blade.php) que generan la estructura HTML mostrada al usuario. Están organizadas en subcarpetas temáticas según el tipo de usuario o funcionalidad:

- **views/auth/**
Contiene las vistas relacionadas con el inicio de sesión y el registro, tanto para usuarios comunes como para restaurantes.
- **views/components/**
Almacena componentes Blade reutilizables, especialmente aquellos usados en publicaciones, como tarjetas de contenido, botones, etc.
- **views/layouts/**
Aquí se definen los layouts base, que estructuran las páginas principales (cabecera, pie de página, secciones comunes). Permiten una construcción coherente de la interfaz en diferentes tipos de vistas.
- **views/partials/**
Contiene fragmentos de HTML estáticos o de poca lógica (menús, encabezados, scripts de pie de página), que se incluyen en múltiples vistas pero no alteran la navegación principal.
- **views/personas/** y **views/restaurantes/**
Carpetas específicas con vistas dirigidas a los diferentes tipos de usuarios del sistema: personas y restaurantes. Permiten ofrecer una experiencia personalizada.
- **views/publicaciones/**
Contiene los formularios relacionadas con la creación, edición o visualización de publicaciones dentro de la red social.
- **views/landing.blade.php**
Es la vista principal de bienvenida a la red social, generalmente mostrada a usuarios no autenticados.

2. JavaScript (resources/js/)
Esta carpeta contiene los scripts del lado del cliente, que gestionan:
- Interacciones del usuario
- Validaciones de formularios
- Manejo dinámico de datos en el navegador
- Proporciona la lógica necesaria para que la experiencia sea interactiva.

3. Estilos (Sass) (resources/sass/)
Aquí se encuentran todos los estilos CSS organizados mediante Sass, que permite modularidad y reutilización de código. La estructura incluye:

- **app.scss**
Archivo principal que agrupa los estilos globales.
- **formularios.scss**
Estilos específicos para formularios, como inputs, validaciones visuales y botones.
- **Módulos adicionales**
Estilos específicos por vista o componente que se importan con _@use_, lo que mejora la organización y facilita el mantenimiento del diseño.

#### Diagrama UML 
![Diagrama UML](/assets%20readme/Nueva_bbdd.png)

**Actualizado a las tablas utilizadas a día de hoy**

### Migraciones reservadas para uso futuro: 
* **user_sessions:** Esta tabla se encarga de llevar el registro personalizada de sesiones de usuario, separadas del sistema de autentificación "Auth" de Laravel.

Aunque actualmente el sistema gestiona sesiones mediante guards diferenciados ('user', 'restaurant'), se plantea usar esta tabla para auditoría de sesiones, seguimiento de actividad visualización de historial de acceso. 

* **notifications:** Aunque el programa ya cuenta con seguimiento de interacciones (Por ejemplo, en follow, likes o comments), esta tabla fue diseñada como una estructura más flexible y escalable para implementar un sistema de notificaciones generales.

* **reviews:** Esta tabla se diseñó para una futura implementación de un sistema de reseñas de restaurantes.
Está pensada como una especialización de posts, con su propio modelo, permitiendo reutilizar componentes existentes y agregar lógica específica. Servirá para que los usuarios mantengan un historial de visitas y opiniones.

### Control de versiones
Para el control de versiones se utilizó **Git**, gestionado a través de **GitHub** como repositorio remoto. Todas las versiones del código fueron subidas a una sola rama (main), ya que el desarrollo fue individual y no se requirió trabajo colaborativo. Las operaciones básicas (commits, push) se realizaron mediante la terminal de Git Bash en Visual Studio Code, permitiendo un control ordenado del avance del proyecto.

### Despliegue
El proyecto fue desplegado utilizando Railway, una plataforma como servicio (PaaS) que proporciona una infraestructura en la nube escalable, flexible y fácil de configurar.

#### Diagrama de despliegue
![Diagrama de despliegue](/assets%20readme/diagrama_despliegue.jpg)

#### Proceso de despliegue: 
1. **Vinculación con el repositorio de GitHub**
La  desarrolladora creó un nuevo proyecto desde el panel de Railway y lo vinculó con el repositorio de GitHub que contiene el código fuente. Esto permite una integración continua y facilita la actualización del entorno de producción tras cada cambio.

2. **Configuración de variables de entorno**
Las variables del archivo **.env** fueron configuradas desde el entorno de Railway. Entre ellas se incluyen datos esenciales para la ejecución de la aplicación como APP_KEY, DB_CONNECTION, DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME y DB_PASSWORD.

3. **Conexión a la base de datos en Railway**
Railway ofrece una base de datos gestionada, cuyas credenciales se utilizaron para establecer la conexión con la aplicación a través de las variables de entorno. De esta forma, la aplicación pudo interactuar directamente con la base de datos en la nube.

4. **Configuración del Start Command**
El **start command** es un comando que se ejecuta automáticamente cada vez que la aplicación se inicia, especialmente durante el primer despliegue.

En este proyecto fue configurado con la finalidad de que el programa cuente con una base de datos estructurada y actualizada y que sea accesible a la vía web. Se especifica el **puerto 9000** porque Railway expone internamente ese puerto para aceptar conexiones HTTP.

`php artisan migrate --force && php -S 0.0.0.0:9000 -t public`

5. **Comando de construcción (Build Command)**
Railway permite ejecutar un comando personalizado al momento de construir la aplicación para producción. Se utilizó el siguiente:

`composer install --no-dev --optimize-autoloader && npm install && npm run build && php artisan storage:link && php artisan view:clear && php artisan config:clear && php artisan config:cache && php artisan route:cache`

_Este comando_:
- Instala dependencias de **Composer y NPM**.
- Compila los archivos frontend.(Ideal para la interacción y que se procesen los archivos CSS).
- Crea enlaces simbólicos para el almacenamiento.
- Limpia y cachea la configuración y las rutas para un mejor rendimiento.

_Consideraciones_: 
- Configurar correctamente estos comandos **(Start Command & Build Command)**  es fundamental para que una aplicación de Laravel se despliegue sin errores. Gracias a la visualización de los logs, es más fácil identificar cuáles van a ser requeridos por la web y cuáles son los errores que interfieren con el proceso.

- __Vista de logs__
Es importante destacar que se pueden configurar también por medio de archivos como **Railway.json**, **Dockerfile**, etc. Pero que es relativo al manejo de control del programa de cada desarrollador.

6. **Forzar HTTPS para el correcto procesamiento de imágenes**
Durante el despliegue, la diferencia de protocolos generaba bloqueos de parte del navegador por **(contenido mixto)** se detectó que muchas imágenes no se procesaban o cargaban correctamente porque estaban siendo servidas mediante enlaces HTTPS. Para resolverlo, se añadió un boot en el **AppServiceProvider** que fuerza el uso de HTTPS.

```php
class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if (env('APP_ENV') !== 'local') {
            URL::forceScheme('https');
        }
    }
} 
``` 

#### Hosting 
El hosting fue proporcionado por Railway, este proveedor de hosting en la nube genera automáticamente un dominio temporal que permite acceder a la web desde cualquier dispositivo, sin necesidad de configurar un dominio personalizado ni contratar un servicio de DNS externo. 

Railway crea dos formas de red o acceso para cada servicio: **una pública y otra privada**. 
La pública usa el puerto 9000 que se expone para que el servidor escuche solicitudes HTTP. Mientras que el segundo usa IPv6 y sirve para no exponer datos sensibles.

![Hosting de Railway](/assets%20readme/redes_railway.png)

---