# HabitaRoom 🏡

**HabitaRoom** es una plataforma web enfocada en la búsqueda y publicación de habitaciones, con el objetivo de conectar a personas que buscan compartir piso, particulares con una sola vivienda y empresas o inmobiliarias. A diferencia de otras plataformas, HabitaRoom ofrece filtros específicos que permiten a los usuarios encontrar opciones de viviendas según su categoría (habitantes, particulares, empresas) y características específicas de la vivienda.


## Tecnologías 🛠️

- **Frontend**: 
    - ![HTML5](public/img/html5.png)
    - ![CSS3](public/img/css3.png)
    - ![JavaScript](public/img/javascript.png)
    - ![Bootstrap](public/img/bootstrap.png)

- **Control de versiones**: 
    - ![Git](public/img/git.png)
    - ![GitHub](public/img/github.png)

- **Base de datos**: 
    - ![MariaDB](public/img/mariadb.png)

- **API de mapa/ubicación**: Leaflet + 
    - ![Leaflet](public/img/mariadb.png)
    - ![OpenStreetMap Nominatim](public/img/mariadb.png)

- **Sistema de chat/mensajería**: 
    A decidir entre una solución personalizada o un servicio de chat en vivo como:
    - ![Tawk.to](public/img/mariadb.png)

- **Cookies**: Para usar filtros de búsqueda 🍪


## Funciones ✨

1. **Inicio de sesión de usuarios** 🔑: Los usuarios pueden iniciar sesión y mantener sus datos de sesión guardados en la base de datos.
2. **Búsqueda** 🔍: Búsqueda general por títulos de publicaciones.
3. **Filtros por categorías** 🏘️: Permite filtrar por habitantes, particulares o empresas. Los filtros adicionales están disponibles por características de la vivienda.
4. **Feed de anuncios** 📰: Los anuncios se cargan dinámicamente cada 5 publicaciones.
5. **Página de Guardados** 💾: Muestra las publicaciones guardadas por el usuario.
6. **Página de Novedades** 📢: Muestra las notificaciones de nuevas habitaciones libres en función de la ubicación del usuario.
7. **Mensajería** 💬: Los usuarios pueden comunicarse directamente con los anunciantes a través de un sistema de chat. Los mensajes son gestionados mediante una burbuja de chat que organiza los mensajes recibidos y enviados.
8. **Publicación de anuncios** 📣: Los usuarios pueden crear y publicar anuncios con detalles sobre la vivienda.

## Estructura de Carpetas 🗂️

La estructura de carpetas de **HabitaRoom** es la siguiente:

```
HabitaRoom
├── index.html  → Página principal  
│── .gitignore  
│── README.md  
│── /public  
│   ├── /css  → Archivos de estilos   
│   ├── /js  → Scripts   
│   ├── /img  → Imágenes y recursos gráficos  
│   ├── /fonts  → Tipografías usadas en la web  
│  
│── /includes  
│   ├── header.html  → Cabecera común  
│   ├── footer.html  → Pie de página común  
│   ├── navbar.html  → Menú de navegación  
│   ├── navbar.html  → Menú de navegación para página inicio, incluye filtros
│  
│── /config  
│   ├── config.php  → Configuración global (credenciales, constantes, etc.)  
│   │── /db  → Conexión con base de datos
│   │── app.js -> Funcionalidad responsiva de la web
│        
│── /controllers  
│   ├── novedadesController.js  → Controlador para gestionar novedades  
│   ├── guardadosController.js  → Controlador para gestionar guardados  
│  
│── /models  
│   ├── novedadesModel.php  → Modelo de datos para novedades  
│   ├── guardadosModel.php  → Modelo de datos para guardados  
│   ├── publicacionesModel.php  → Modelo de datos para publicaciones
│  
│── /views  
│   ├── novedades.html  → Página de novedades  
│   ├── guardados.html  → Página de guardados  
│   ├── publicacion.html  → Página de creación de publicaciones  
│   ├── login.html  → Página de login
```



## ¿Por qué usar HabitaRoom? 🤔

Quienes entren a HabitaRoom podrán ver que en las publicaciones hay una sección de mensaje, si, ademas añadimos la función de **mensajería**, podran comunicarse directamente con los anunciantes a traves de la web. 

Para poder realizar ésto el usuario deberá crearse una cuenta en la web, ésto además da pie a las secciones **guardados** y  **publicación**. Permite al usuario poder guardar anuncios de alguna vivienda por si ésta buscando opciones o por si en algún futuro planea mudarse.

Para los publicistas, la sección publicación permite **crear una publicación** si así el usuario lo quisiese. Con los detalles que él usuario necesite, si es una habitación o un particular o si el usuario fuese una empresa.

**Novedades**, la cual siempre será visible con lás útlimas publicaciónes en toda España a diferencia de **Inicio** que tendrá las publicaciones filtradas por la ubicación del usuario, la cual se solicitará al entrar a la web.


## Pasos de Creación 🔨

1. Pensar la idea 💡
2. Pensar el diseño 🎨
3. Realizar boceto de diseño en NinjaMock 🖌️
4. Crear la estructura e idea de la web desde cero usando HTML5, CSS, CSS3 y JavaScript.
5. Integrar Bootstrap y realizar la estructura final de las webs.
6. Crear archivos y codificar las funciones de la web.
7. Configuración, conexión a la base de datos y creación de las tablas.
8. Integrar API de mapa y mensajería.
9. Finalizar el diseño de la web, el dinamismo, colores y elección de color representativo.
10. Documentar 📝
