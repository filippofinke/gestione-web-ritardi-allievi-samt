<?php

$path = explode("/", $_SERVER["REQUEST_URI"]);
$pageTitle = "";
if (!empty($path[1])) {
    $pageTitle = " - " . str_replace("-", " ", ucfirst($path[1]));
}

?>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="author" content="Filippo Finke">
<!-- Template: SB Admin 2 -> https://startbootstrap.com/themes/sb-admin-2/ -->

<title>Ritardi <?php echo $pageTitle; ?></title>

<base href="<?php echo BASE; ?>">
<link rel="shortcut icon" href="assets/img/icon.ico" type="image/x-icon">
<link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
<link href="assets/css/sb-admin-2.min.css" rel="stylesheet">