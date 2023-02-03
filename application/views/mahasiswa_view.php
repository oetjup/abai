<!DOCTYPE html>
<html lang="en">

<head>
    <title><?= $title ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 4.5.2-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Fontawesome 5.15.3-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Datatables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" integrity="sha512-RXf+QSDCUQs5uwRKaDoXt55jygZZm2V++WUZduaU/Ui/9EGp3f/2KZVahFZBKGH0s774sd3HmrhUy+SgOFQLVQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
</head>

<body>
    <nav class="navbar navbar-expand-md bg-dark navbar-dark">
        <!-- Brand -->
        <a class="navbar-brand" href="#">Datatables CI</a>

        <!-- Toggler/collapsibe Button -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar links -->
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="<?= base_url('mahasiswa'); ?>">Mahasiswa</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container pt-5">
        <h3><?= $title ?></h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb ">
                <li class="breadcrumb-item"><a>Mahasiswa</a></li>
                <li class="breadcrumb-item active" aria-current="page">List Data</li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-md-12">
                <a class="btn btn-primary mb-2" href="<?= base_url('mahasiswa/insert_dummy'); ?>">Buat Data Dummy</a>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title" >Custom Filter : </h3>
                    </div>
                    <div class="panel-body">
                        <form id="form-filter" class="form-horizontal">
                            <!-- <div class="form-group">
                                <label for="country" class="col-sm-2 control-label">Country</label>
                                <div class="col-sm-4">
                                    <?php //echo $form_country; ?>
                                </div>
                            </div> -->
                            <div class="form-group">
                                <label for="Nama" class="col-sm-2 control-label">Nama</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="nama">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="Alamat" class="col-sm-2 control-label">Alamat</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="alamat">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="Email" class="col-sm-2 control-label">Email</label>
                                <div class="col-sm-4">
                                    <textarea class="form-control" id="email"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="LastName" class="col-sm-2 control-label"></label>
                                <div class="col-sm-4">
                                    <button type="button" id="btn-filter" class="btn btn-primary">Filter</button>
                                    <button type="button" id="btn-reset" class="btn btn-warning">Reset</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div mb-2>
                    <!-- Menampilkan flashh data (pesan saat data berhasil disimpan)-->
                    <?php if ($this->session->flashdata('message')) :
                        echo $this->session->flashdata('message');
                    endif; ?>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="tableMahasiswa">
                                <thead>
                                    <tr class="table-success">
                                        <th></th>
                                        <th>NAMA</th>
                                        <th>ALAMAT</th>
                                        <th>EMAIL</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var table;

        //setting datatables
        table = $('#tableMahasiswa').DataTable({
            // "language": {
            //     "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
            // },
            "searching": false,
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                //panggil method ajax list dengan ajax
                "url": 'mahasiswa/ajax_list',
                "type": "POST",
                "data": function ( data ) {
                        data.Nama = $('#nama').val();
                        data.Alamat = $('#alamat').val();
                        data.Email = $('#email').val();
                    }
            },
            "columnDefs": [
                { 
                    "targets": [0], //first column / numbering column
                    "orderable": false, //set not orderable
                }
            ],
        });

        $('#btn-filter').click(function(){ //button filter event click
            table.ajax.reload();  //just reload table
        });

        $('#btn-reset').click(function(){ //button reset event click
            $('#form-filter')[0].reset();
            table.ajax.reload();  //just reload table
        });
    </script>

</body>

</html>