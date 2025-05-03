# HabitaRoom 🏡

**HabitaRoom** es una plataforma web enfocada en la búsqueda y publicación de habitaciones, con el objetivo de conectar a personas que buscan compartir piso, particulares con una sola vivienda y empresas o inmobiliarias. A diferencia de otras plataformas, HabitaRoom ofrece filtros específicos que permiten a los usuarios encontrar opciones de viviendas según su categoría (habitantes, particulares, empresas) y características específicas de la vivienda.


## Tecnologías 🛠️

- **Frontend**: HTML5, CSS3, JavaScript, Bootstrap, AJAX
    ![HTML5](public/img/html5.png)![CSS3](public/img/css3.png)![JavaScript](public/img/javascript.png)![Bootstrap](public/img/bootstrap.png)


- **Control de versiones**: Git, GitHub
    ![Git](public/img/git.png)![GitHub](public/img/github.png)


- **Base de datos**: MariaDB
    ![MariaDB](public/img/mariadb.png)


- **API de mapa/ubicación**: Leaflet y OpenStreetMap Nominatim 
    ![Leaflet](public/img/leafletLogo.png)![OpenStreetMap Nominatim](public/img/OpenStreetMapLogo.png)![Nominatim](public/img/Nominatim.png)

- **Sistema de chat/mensajería**: 
    A decidir entre una solución personalizada o un servicio de chat en vivo como Tawk.to:
    ![Tawk.to](public/img/tawk.to.png)

- **Cookies**: Para usar filtros de búsqueda 🍪


## Funciones ✨

1. **Inicio de sesión de usuarios** 🔑: Los usuarios pueden iniciar sesión y mantener sus datos de sesión guardados en la base de datos.
2. **Búsqueda** 🔍: Búsqueda general por títulos de publicaciones.
3. **Filtros por categorías** 🏘️: Permite filtrar por habitantes, particulares o empresas. Los filtros adicionales están disponibles por características de la vivienda.
4. **Feed de anuncios** 📰: Los anuncios se cargan dinámicamente cada 5 publicaciones.
5. **Página de Guardados** 💾: Muestra las publicaciones guardadas por el usuario.
6. **Página de Ofertas** 📢: Los usuarios podrán ver una lista de ofertas destacadas y filtrarlas por precio.
7. **Mensajería** 💬: Los usuarios pueden comunicarse directamente con los anunciantes a través de un sistema de chat. Los mensajes son gestionados mediante una burbuja de chat que organiza los mensajes recibidos y enviados.
8. **Publicación de anuncios** 📣: Los usuarios pueden crear y publicar anuncios con detalles sobre la vivienda.

## Estructura de Carpetas 🗂️

La estructura de carpetas de **HabitaRoom** es la siguiente:

```
HabitaRoom
│── index.html  
│── .gitignore  
│── README.md  
│  
│── /public  
│   ├── /css  
│   ├── /js  
│   ├── /img  
│   ├── /fonts  
│  
│── /assets  
│   ├── /uploads  
│  
│── /includes  
│   ├── header.php  
│   ├── footer.php  
│   ├── headerIndex.php  
│  
│── /config   
│   ├── /db
│   │   ├── db.php  
│   ├── /jQuery  
│   ├── app.js  
│  
│── /routes  
│   ├── web.php  
│   ├── redireccionWeb.php  
│  
│── /controllers  
│   ├── IndexController.php  
│   ├── RegisterController.php  
│   ├── CrearPublicacionController.php  
│   ├── GuardadosController.php  
│   ├── OfertasController.php  
│   ├── LoginController.php  
│  
│── /models  
│   ├── ModelObtenerPublicaciones.php  
│   ├── RegisterModel.php  
│   ├── CrearPublicacionModel.php  
│   ├── GuardadosModel.php  
│   ├── OfertasModel.php  
│   ├── LoginModel.php  
│  
│── /views  
│   ├── IndexView.php  
│   ├── RegisterView.php  
│   ├── OfertasView.php  
│   ├── CrearPublicacionView.php  
│   ├── GuardadosView.php  
│   ├── LoginView.php  
│  
│── /chat  
│   ├── chat.js  
 

```



## ¿Por qué usar HabitaRoom? 🤔

Quienes entren a HabitaRoom podrán ver que en las publicaciones hay una sección de mensaje, si, ademas añadimos la función de **mensajería**, podran comunicarse directamente con los anunciantes a traves de la web. 

Para poder realizar ésto el usuario deberá crearse una cuenta en la web, ésto además da pie a las secciones **guardados** y  **publicación**. Permite al usuario poder guardar anuncios de alguna vivienda por si ésta buscando opciones o por si en algún futuro planea mudarse.

Para los publicistas, la sección publicación permite **crear una publicación** si así el usuario lo quisiese. Con los detalles que él usuario necesite, si es una habitación o un particular o si el usuario fuese una empresa.

**Ofertas**, la cual siempre será visible con las mejores publicaciones por precio a diferencia de **Inicio** que tendrá las publicaciones filtradas por la ubicación del usuario, la cual se solicitará al entrar a la web.

