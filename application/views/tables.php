<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <!-- <h1 class="h3 mb-2 text-gray-800">Tables</h1>
    <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
        For more information about DataTables, please visit the <a target="_blank" href="https://datatables.net">official DataTables documentation</a>.</p> -->

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
        </div>
        <div class="card-body">
            <!-- <form id="form-filter" class="mb-4">
                <div class="row">
                    <div class="col">
                        <input type="text" class="form-control form-control-sm" id="nama" placeholder="Nama">
                    </div>
                    <div class="col">
                        <input type="text" class="form-control form-control-sm" id="alamat" placeholder="Alamat">
                    </div>
                    <div class="col">
                        <input type="text" class="form-control form-control-sm" id="email" placeholder="Email">
                    </div>
                </div>
            </form>
            <button type="button" id="btn-filter" class="btn btn-primary btn-sm">Filter</button>
            <button type="button" id="btn-reset" class="btn btn-warning btn-sm">Reset</button> -->
            <div class="row">
                <div class="col-auto mr-auto">
                    <div class="form-row align-items-center">
                        <div class="col-auto my-1">
                            <button type="button" id="btnAdd" class="btn btn-outline-primary btn-sm"><i class="fa fa-plus-circle"></i> <span>Add</span></button>
                        </div>
                    </div>
                </div>
                <div class="col-auto">
                    <form id="form-filter">
                        <div class="form-row align-items-center">
                            <div class="col-auto my-1">
                                <input type="text" class="form-control form-control-sm" id="nama" placeholder="Nama">
                            </div>
                            <div class="col-auto my-1">
                                <input type="text" class="form-control form-control-sm" id="alamat" placeholder="Alamat">
                            </div>
                            <div class="col-auto my-1">
                                <input type="text" class="form-control form-control-sm" id="email" placeholder="Email">
                            </div>
                            <div class="col-auto my-1">
                                <button type="button" id="btn-filter" class="btn btn-primary btn-circle btn-sm"><i class="fa fa-search"></i></button>
                                <button type="button" id="btn-reset" class="btn btn-warning btn-circle btn-sm"><i class="fa fa-sync" aria-hidden="true"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="table-responsive">
                <!-- <div class="row">
                    <div class="col-auto mr-auto">
                        .col-auto .mr-auto
                    </div>
                    <div class="col-auto">
                        <form id="form-filter">
                            <div class="form-row align-items-center">
                                <div class="col-auto my-1">
                                    <input type="text" class="form-control form-control-sm" id="nama" placeholder="Nama">
                                </div>
                                <div class="col-auto my-1">
                                    <input type="text" class="form-control form-control-sm" id="alamat" placeholder="Alamat">
                                </div>
                                <div class="col-auto my-1">
                                    <input type="text" class="form-control form-control-sm" id="email" placeholder="Email">
                                </div>
                                <div class="col-auto my-1">
                                    <button type="button" id="btn-filter" class="btn btn-primary btn-circle btn-sm"><i class="fa fa-search"></i></button>
                                    <button type="button" id="btn-reset" class="btn btn-warning btn-circle btn-sm"><i class="fa fa-sync" aria-hidden="true"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div> -->
                <table class="table table-bordered" id="tableMahasiswa" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>NAMA</th>
                            <th>ALAMAT</th>
                            <th>EMAIL</th>
                            <th></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Footer -->
<footer class="sticky-footer bg-white">
    <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span>Copyright &copy; Your Website 2020</span>
        </div>
    </div>
</footer>
<!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<div class="viewmodal" style="display: none;"></div>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="login.html">Logout</a>
            </div>
        </div>
    </div>
</div>
<script>
    function edit(id) {
        $.ajax({
            type: "post",
            url: "<?php echo base_url('tables/formedit'); ?>",
            data: {
                id: id
            },
            dataType: 'json',
            success: function(response) {
                if (response.sukses) {
                    $('.viewmodal').html(response.sukses).show();
                    $('#editModal').on('shown.bs.modal', function(e) {
                        $('#inputNama').focus();
                    });
                    $('#editModal').modal('show');
                }
            },
            error: function(xhr, ajaxOptions, throwError) {
                alert(xhr.status + "\n" + xhr.responText + "\n" + throwError);
            }
        });
    }

    function hapus(id) {
        Swal.fire({
            title: 'Hapus',
            text: "Yakin mengahapus data mahasiswa " + id + "?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "post",
                    url: "tables/deletedata",
                    data: {
                        id: id
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.sukses) {
                            table.ajax.reload();
                            Swal.fire(
                                'Deleted!',
                                response.sukses,
                                'success'
                            )
                        }
                    },
                    error: function(xhr, ajaxOptions, throwError) {
                        alert(xhr.status + "\n" + xhr.responText + "\n" + throwError);
                    }
                });
            }
        })
    }
</script>