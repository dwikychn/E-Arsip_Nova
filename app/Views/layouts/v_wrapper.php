<div class="wrapper">

    <?= view('layouts/v_header'); ?>
    <!-- Left side column. contains the logo and sidebar -->
    <?= view('layouts/v_sidebar'); ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            <!-- Global Flash Message -->
            <?php if (session()->getFlashdata('pesan')): ?>
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <?= session()->getFlashdata('pesan') ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <?php
                    $errors = session()->getFlashdata('error');
                    if (is_array($errors)) {
                        echo "<ul>";
                        foreach ($errors as $err) {
                            echo "<li>" . esc($err) . "</li>";
                        }
                        echo "</ul>";
                    } else {
                        echo esc($errors);
                    }
                    ?>
                </div>

                <!-- Auto open modal edit profile jika error -->
                <script>
                    $(document).ready(function() {
                        $('#editProfile').modal('show');
                    });
                </script>
            <?php endif; ?>
            <!-- End Global Flash Message -->
            <?= $this->renderSection('content'); ?>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?= view('layouts/v_footer'); ?>
    <?= view('modal/modal_edit_profile'); ?>
</div>