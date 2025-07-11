<?php
    include_once $_SERVER["DOCUMENT_ROOT"] . "/Proyecto-LBD-Grupo-5/Controller/LoginController.php";
    include_once $_SERVER["DOCUMENT_ROOT"] . "/Proyecto-LBD-Grupo-5/View/layoutExterno.php";
?>

<!DOCTYPE html>
<html lang="en">

<?php PrintCss(); ?>

<body>
    <section class="h-100 gradient-form" style="background-color: #eee;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-xl-10">
                    <div class="card rounded-3 text-black shadow">
                        <div class="row g-0">
                            <div class="col-lg-6">
                                <div class="card-body p-md-5 mx-md-4">
                                    <div class="text-center mb-4">
                                        <img src="../assets/img/logo2.jpg" style="width:150px;" alt="Logo">
                                        <h4 class="mt-3">Salud Integral CR</h4>
                                        <hr>
                                    </div>

                                    <?php
                                        if(isset($_POST["Message"])){
                                            echo '<div class="alert alert-warning Mensajes">' 
                                                  . $_POST["Message"] . 
                                                  '</div>';                                   
                                        }
                                    ?>

                                    <form action="" method="POST">
                                        <h5 class="mb-4 text-center">Recupera tu contraseña</h5>


                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="txtCorreo">Correo Electrónico</label>
                                            <input 
                                                type="email" 
                                                id="txtCorreo" 
                                                name="txtCorreo" 
                                                class="form-control"
                                                placeholder="Ingresa tu correo electrónico" 
                                                required
                                            />
                                        </div>


                                        <div class="text-center pt-1 mb-2 pb-2">
                                            <button 
                                                id="recuperarCuentaBtn" 
                                                name="recuperarCuentaBtn"
                                                class="btn btn-brand btn-lg w-100"
                                                type="submit"
                                            >
                                                Recuperar la Contraseña
                                            </button>
                                        </div>

                                        <div class="text-center mb-3">
                                            <span>¿Ya tienes cuenta? 
                                                <a class="text-muted" href="login.php">
                                                    Inicia Sesión
                                                </a>
                                            </span>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
                                <div class="text-black px-3 py-4 p-md-5 mx-md-4">
                                    <h4 class="mb-4">¡Salud Integral CR, tu bienestar primero!</h4>
                                    <p class="small mb-0">
                                        +10 años de experiencia en consultas médicas, prevención, nutrición y salud mental,
                                        todo con respaldo profesional y tecnología de punta.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php PrintScript(); ?>
</body>
</html>
