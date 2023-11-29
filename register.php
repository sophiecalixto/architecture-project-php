<?php

require 'vendor/autoload.php';
require 'src/Infrastructure/Database/pdo_connection.php';

use SophieCalixto\App\Domain\Student\Document;
use SophieCalixto\App\Infrastructure\Student\PDOStudentRepository;

$pdo = pdo_connection::pdo();
$repository = new PDOStudentRepository($pdo);
$id = null;
$student = null;
if(isset($_POST['document'])) {
    $id = $_POST['document'];
    $student = $repository->getByDocument(new Document($id));

    if ($student) {
        $phones = $student->phones();
        $firstPhone = $phones[0];
        $countryCode = $firstPhone->countryCode();
        $ddd = $firstPhone->ddd();
        $number = $firstPhone->number();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Register</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block" style="background: url('https://wakke.co/wp-content/uploads/2018/08/escolaweb-capas-artigos-5-maneiras-de-engajar-os-alunos-nas-atividades-escolares-1.jpg'); background-size: cover; background-repeat: no-repeat; background-position: center;"></div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Registrar aluno</h1>
                            </div>
                            <form action="<?= $id !=null ? 'edit.php' : 'register-user.php' ?>" method="post" class="user">
                                <div class="form-group row">
                                    <div class="col-sm-12 mb-3 mb-sm-0">
                                        <input value="<?= $student ? $student->name() : ''?>" type="text" name="name" class="form-control form-control-user"
                                            placeholder="Nome completo">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input value="<?= $student ? $student->email() : ''?>" type="email" name="email" class="form-control form-control-user"
                                        placeholder="E-mail">
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" name="password" class="form-control form-control-user"
                                             placeholder="Senha">
                                    </div>
                                    <div class="col-sm-6">
                                        <input value="<?= $student ? $student->document() : ''?>" type="text" name="document" class="form-control form-control-user"
                                            placeholder="Documento">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-2 mb-3 mb-sm-0">
                                        <input value="<?= $student ? $countryCode : ''?>" type="text" name="country_code" class="form-control form-control-user"
                                               placeholder="Número do país">
                                    </div>
                                    <div class="col-sm-2">
                                        <input value="<?= $student ? $ddd : ''?>" type="text" name="ddd" class="form-control form-control-user"
                                                placeholder="DDD">
                                    </div>
                                    <div class="col-sm-8">
                                        <input value="<?= $student ? $number : ''?>" type="text" name="number" class="form-control form-control-user"
                                               placeholder="Número">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    <?= $id !=null ? 'Editar' : 'Registrar' ?>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>