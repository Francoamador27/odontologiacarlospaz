<?php if (isset($_GET['error'])) { ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: "<?php echo addslashes($_GET['error']); ?>"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location = "mostrar.php";
            }
        });
    </script>
<?php } ?>
<?php if (isset($_GET['success'])) { ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Exito',
            text: "<?php echo addslashes($_GET['success']); ?>"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location = "mostrar.php";
            }
        });
    </script>
<?php } ?>