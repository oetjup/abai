<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Ajukan Perbaiakan ADM</title>

    <!-- Custom fonts for this template-->
    <link href="<?php echo base_url('assets/'); ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?php echo base_url('assets/'); ?>css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="<?php echo base_url('assets/'); ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <!-- Sweet Alert 2 -->
    <!-- Sweet Alert 2 -->
    <script src="<?php echo base_url('sw/'); ?>dist/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url('sw/'); ?>dist/sweetalert2.min.css">

    <style>
        .dt-body-center {
            text-align: center;
        }

        #tableTicket th,
        #tableTicket td,
        #tableUser th,
        #tableUser td {
            font-size: 14px;
        }

        #tableTicket th,
        #tableUser th {
            color: rgba(255, 255, 255, .8);
            padding: 8px;
            background-color: #4e73df;
            border: 0;
            vertical-align: middle;
        }

        #tableTicket td,
        #tableUser td {
            padding: 4px;
            vertical-align: middle;
        }

        #tableTicket th,
        #tableUser th {
            text-align: center;
        }

        #tableTicket thead tr,
        #tableUser thead tr {
            height: 20px;
        }

        #tableTicket tbody tr:hover,
        #tableUser tbody tr:hover {
            background-color: #E8F9FD;
        }

        #tableTicket tbody tr td,
        #tableUser tbody tr td {
            height: 10px;
        }

        .dataTables_info {
            font-size: 12px;
        }

        .pagination {
            font-size: 12px;
        }
    </style>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">