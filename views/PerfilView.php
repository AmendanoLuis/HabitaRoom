<div class="container-fluid text-dark mt-5 ">
    <div class="row ">
        <div class="col">
        Vista perfil usuario
        </div>
    </div>
    <form action="controllers/LoginController.php" method="POST">
        <input type="hidden" name="logout" value="1">
        <button type="submit" class="btn btn-danger">Cerrar sesión</button>
    </form>
</div>