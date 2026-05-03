<?php
ob_start();
session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    header('location: ../login.php');

    $id = $_SESSION['id'];
}
?>
<!DOCTYPE html>
<html lang="es">
<?php include('../componentes/header.php') ?>

<body>

  <!-- SIDEBAR -->
  <?php include('../componentes/sidebar.php') ?>
    <!-- SIDEBAR -->

    <!-- NAVBAR -->
    <section id="content">

        <!-- NAVBAR -->

        <!-- NAVBAR -->

        <!-- MAIN -->

        <main>
            <h1 class="title">Bienvenido <?php echo '<strong>' . $_SESSION['username'] . '</strong>'; ?></h1>
            <ul class="breadcrumbs">
                <li><a href="../admin/escritorio.php">Home</a></li>
                <li class="divider">></li>
                <li><a href="../pacientes/mostrar.php">Listado de los pacientes</a></li>
                <li class="divider">></li>
                <li><a href="#" class="active">Nuevos pacientes</a></li>
            </ul>

            <!-- multistep form -->


            <form action="" enctype="multipart/form-data" method="POST" autocomplete="off"
                onsubmit="return validacion()">
                <div class="containerss">
                    <h1>Nuevos pacientes</h1>
                    <div class="alert-danger">
                        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                        <strong>Importante!</strong> Es importante rellenar los campos con &nbsp;<span
                            class="badge-warning">*</span>
                    </div>
                    <hr>

                    <label for="email"><b>DNI del paciente</b></label><span class="badge-warning">*</span>
                    <input type="text" placeholder="ejm: 77114578" name="nhi" maxlength="8" required>

                    <label for="psw"><b>Nombre del paciente</b></label><span class="badge-warning">*</span>
                    <input type="text" placeholder="ejm: Juan Raul" name="namp" required>

                    <label for="psw"><b>Apellido del paciente</b></label><span class="badge-warning">*</span>
                    <input type="text" placeholder="ejm: Ramirez Requena" name="apep" required>

                    <label for="psw"><b>Dirección del paciente</b></label><span class="badge-warning">*</span>
                    <input type="text" placeholder="ejm: calle los medanos" name="dip" required>

                    <label for="psw"><b>Género del paciente</b></label><span class="badge-warning">*</span>
                    <select required name="gep" id="gep">
                        <option>Seleccione</option>
                        <option value="Masculino">Masculino</option>
                        <option value="Femenino">Femenino</option>
                    </select>

                    <label for="psw"><b>Grupo sanguíneo del paciente</b></label><span class="badge-warning">*</span>
                    <select required name="grp" id="grp">
                        <option value="" disabled selected>No especifica</option>
                        <option value="A+">A+</option>
                        <option value="A-">A-</option>
                        <option value="B+">B+</option>
                        <option value="B-">B-</option>
                        <option value="AB+">AB+</option>
                        <option value="AB-">AB-</option>
                        <option value="O+">O+</option>
                        <option value="O-">O-</option>
                    </select>


                    <label for="psw"><b>Teléfono del paciente</b></label><span class="badge-warning">*</span>
                    <input type="text" maxlength="25" placeholder="ejm: +51 999 888 111" name="telp" required>

                    <label for="psw"><b>Email del paciente</b></label>
                    <input type="email" placeholder="ejemplo@hotmail.com" name="email_p">

                    <label for="psw"><b>Fecha de nacimiento del paciente</b></label><span class="badge-warning">*</span>
                    <input type="date" name="cump" required>

                    <hr>

                    <button type="submit" name="add_patiens" class="registerbtn">Guardar</button>
                </div>

            </form>

        </main>
        <!-- MAIN -->
    </section>
    <script src="../../backend/js/jquery.min.js"></script>
    <?php include_once '../../backend/php/add_patiens.php' ?>

    <!-- NAVBAR -->

    <script src="../../backend/js/script.js"></script>
    <script src="../../backend/js/multistep.js"></script>
    <script src="../../backend/js/vpat.js"></script>


    <script type="text/javascript">
        let popUp = document.getElementById("cookiePopup");
        //When user clicks the accept button
        document.getElementById("acceptCookie").addEventListener("click", () => {
            //Create date object
            let d = new Date();
            //Increment the current time by 1 minute (cookie will expire after 1 minute)
            d.setMinutes(2 + d.getMinutes());
            //Create Cookie withname = myCookieName, value = thisIsMyCookie and expiry time=1 minute
            document.cookie = "myCookieName=thisIsMyCookie; expires = " + d + ";";
            //Hide the popup
            popUp.classList.add("hide");
            popUp.classList.remove("shows");
        });
        //Check if cookie is already present
        const checkCookie = () => {
            //Read the cookie and split on "="
            let input = document.cookie.split("=");
            //Check for our cookie
            if (input[0] == "myCookieName") {
                //Hide the popup
                popUp.classList.add("hide");
                popUp.classList.remove("shows");
            } else {
                //Show the popup
                popUp.classList.add("shows");
                popUp.classList.remove("hide");
            }
        };
        //Check if cookie exists when page loads
        window.onload = () => {
            setTimeout(() => {
                checkCookie();
            }, 2000);
        };
    </script>

</body>

</html>