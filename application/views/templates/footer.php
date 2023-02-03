    <!-- Bootstrap core JavaScript-->
    <script src="<?php echo base_url('assets/'); ?>vendor/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url('assets/'); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?php echo base_url('assets/'); ?>vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?php echo base_url('assets/'); ?>js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="<?php echo base_url('assets/'); ?>vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="<?php echo base_url('assets/'); ?>js/demo/chart-area-demo.js"></script>
    <script src="<?php echo base_url('assets/'); ?>js/demo/chart-pie-demo.js"></script>

    <!-- Page level plugins -->
    <script src="<?php echo base_url('assets/'); ?>vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url('assets/'); ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="<?php echo base_url('assets/'); ?>js/demo/datatables-demo.js"></script>

    <script>
        var table;

        //setting datatables
        table = $('#tableTicket').DataTable({
            // "language": {
            //     "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
            // },
            "searching": false,
            "processing": true,
            "serverSide": true,
            "lengthChange": false,
            "order": [],
            "ajax": {
                //panggil method ajax list dengan ajax
                "url": 'ticket/ajax_list',
                "type": "POST",
                "data": function(data) {
                    // data.Nama = $('#nama').val();
                    // data.Alamat = $('#alamat').val();
                    data.keyword = $('#keyword').val();
                }
            },
            "columnDefs": [{
                "targets": [0], //first column / numbering column
                "orderable": false //set not orderable
            }, {
                "targets": [5], //last column / action column
                "orderable": false, //set not orderable
                "className": "dt-body-center"
            }, {
                "targets": [6], //last column / action column
                "orderable": false, //set not orderable
                "className": "dt-body-center"
            }],
        });

        $('#btn-filter').click(function() { //button filter event click
            table.ajax.reload(); //just reload table
        });

        $('#btn-reset').click(function() { //button reset event click
            $('#form-filter')[0].reset();
            table.ajax.reload(); //just reload table
        });

        $('#btnAdd').click(function(e) {
            $.ajax({
                url: "<?php echo base_url('ticket/formadd'); ?>",
                dataType: 'json',
                success: function(response) {
                    if (response.sukses) {
                        $('.viewmodal').html(response.sukses).show();
                        $('#exampleModal').on('shown.bs.modal', function(e) {
                            $('#inputNama').focus();
                        });
                        $('#exampleModal').modal('show');
                    }
                }
            });
        });

        $('.logout').click(function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Logout',
                text: "Yakin keluar dari aplikasi ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, logout',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        // type: "post",
                        url: "auth/logout",
                        dataType: "json",
                        success: function(response) {
                            if (response.sukses) {
                                // Swal.fire(
                                //     'Logout',
                                //     response.sukses,
                                //     'success'
                                // )
                                window.location.href = response.url;
                            }
                        },
                        error: function(xhr, ajaxOptions, throwError) {
                            alert(xhr.status + "\n" + xhr.responText + "\n" + throwError);
                        }
                    });
                }
            })
        });

        var tableuser;

        tableuser = $('#tableUser').DataTable({
            // "language": {
            //     "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
            // },
            "searching": false,
            "processing": true,
            "serverSide": true,
            "lengthChange": false,
            "order": [],
            "ajax": {
                //panggil method ajax list dengan ajax
                "url": 'user/ajax_list',
                "type": "POST",
                "data": function(data) {
                    // data.Nama = $('#nama').val();
                    // data.Alamat = $('#alamat').val();
                    data.keyword = $('#keyword').val();
                }
            },
            "columnDefs": [{
                "targets": [0], //first column / numbering column
                "orderable": false //set not orderable
            }, {
                "targets": [5], //last column / action column
                "orderable": false, //set not orderable
                "className": "dt-body-center"
            }],
        });

        $('#btn-filter-user').click(function() { //button filter event click
            tableuser.ajax.reload(); //just reload table
        });

        $('#btn-reset-user').click(function() { //button reset event click
            $('#form-filter-user')[0].reset();
            tableuser.ajax.reload(); //just reload table
        });

        $('#btnAddUser').click(function(e) {
            $.ajax({
                url: "<?php echo base_url('user/formadd'); ?>",
                dataType: 'json',
                success: function(response) {
                    if (response.sukses) {
                        $('.viewmodal').html(response.sukses).show();
                        $('#exampleModal').on('shown.bs.modal', function(e) {
                            $('#inputNama').focus();
                        });
                        $('#exampleModal').modal('show');
                    }
                }
            });
        });
    </script>

    </body>

    </html>