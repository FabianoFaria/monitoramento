<!DOCTYPE html>
<html lang="en" class="no-js">
    <head>
                <meta charset="utf-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <meta name="description" content="">
                <meta name="author" content="">
                <title>Eficaz System - Monitoramento |<?php echo $this->title;?></title>
	</head>

        <!-- FAVICON -->
        <link rel="shortcut icon" href="<?php echo HOME_URI; ?>/views/_images/favicon2.ico">
        <link rel="apple-touch-icon" href="<?php echo HOME_URI; ?>/views/_images/apple-icon.png">

        <!-- Font Files -->
        <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Gudea:400,700' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>

        <!-- Bootstrap -->
        <link href="<?php echo HOME_URI; ?>/views/_css/bootstrap.css" rel="stylesheet" type="text/css">
        <link href="<?php echo HOME_URI; ?>/views/_css/bootstrap-switch.min.css" rel="stylesheet" type="text/css">
        <!-- <link href="<?php echo HOME_URI; ?>/views/_css/bootstrap-reset.css" rel="stylesheet" type="text/css"> -->


        <!-- MetisMenu CSS -->
        <link href="<?php echo HOME_URI; ?>/views/_css/metisMenu.css" rel="stylesheet" type="text/css">

        <!-- Custom CSS -->
        <link href="<?php echo HOME_URI; ?>/views/_css/sb-admin-2.css" rel="stylesheet" type="text/css">

        <!-- Morris Charts CSS -->
        <link href="<?php echo HOME_URI; ?>/views/_css/morris.css" rel="stylesheet" type="text/css">

        <!-- Custom Fonts -->
        <link href="<?php echo HOME_URI; ?>/views/_css/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

        <!-- SweetAlert CSS-->
        <link rel="stylesheet" type="text/css" href="<?php echo HOME_URI; ?>/views/_css/sweetalert.css">

        <!-- Jquery file -->
        <script src="<?php echo HOME_URI; ?>/views/_js/jquery.js"></script>
        <script src="<?php echo HOME_URI; ?>/views/_js/jquery.mask.js"></script>

        <script src="<?php echo HOME_URI; ?>/views/_js/jquery.validate.js"></script>
        <script src="<?php echo HOME_URI; ?>/views/_js/additional-methods.js"></script>

        

        <!-- Jquery UI CSS -->
        <!-- <link rel="stylesheet" type="text/css" href="<?php //echo HOME_URI; ?>/views/_css/jquery.css"> -->


        <!-- SETTAR TIME ZONE -->
        <?php

            //date_default_timezone_set('America/Sao_Paulo');

            // echo date_default_timezone_get();

            /*
            * PARA UMA DATA E HORARIO DE UM UTC DIFERENTE
            */
            // $timezone = 'UTC';
            // if (is_link('/etc/localtime')) {
            //     // Mac OS X (and older Linuxes)
            //     // /etc/localtime is a symlink to the
            //     // timezone in /usr/share/zoneinfo.
            //     $filename = readlink('/etc/localtime');
            //     if (strpos($filename, '/usr/share/zoneinfo/') === 0) {
            //         $timezone = substr($filename, 20);
            //     }
            // } elseif (file_exists('/etc/timezone')) {
            //     // Ubuntu / Debian.
            //     $data = file_get_contents('/etc/timezone');
            //     if ($data) {
            //         $timezone = $data;
            //     }
            // } elseif (file_exists('/etc/sysconfig/clock')) {
            //     // RHEL / CentOS
            //     $data = parse_ini_file('/etc/sysconfig/clock');
            //     if (!empty($data['ZONE'])) {
            //         $timezone = $data['ZONE'];
            //     }
            // }
            //
            // date_default_timezone_set($timezone);
        ?>

    <body>
