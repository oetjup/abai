<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editModalLabel">Edit Mahasiswa</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php echo form_open('tables/updatedata', ['class' => 'formedit']);
            ?>
            <div class="pesan" style="display:none;"></div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="nainputNamama">Nama</label>
                        <input type="hidden" class="form-control" id="inputId" name="id" value="<?php echo $id; ?>">
                        <input type="text" class="form-control" id="inputNama" name="nama" value="<?php echo $nama; ?>">
                        <!-- <div class="invalid-feedback" id="namaInvalidMsg">
                        </div> -->
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputEmail">Email</label>
                        <input type="text" class="form-control" id="inputEmail" name="email" value="<?php echo $email; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputAlamat">Alamat</label>
                    <input type="text" class="form-control" id="inputAlamat" name="alamat" value="<?php echo $alamat; ?>">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary btn-sm">Update</button>
            </div>
            <?php echo form_close();
            ?>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('.formedit').submit(function(e) {
            e.preventDefault();

            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json",
                success: function(response) {
                    if (response.error) {
                        // $('.pesan').html(response.error).show();
                        $(".invalid-feedback").remove();

                        if (response.nama_invalid != '') {
                            $("#inputNama").addClass("is-invalid");
                            $("#inputNama").after(response.nama_invalid)
                        } else {
                            $("#inputNama").removeClass("is-invalid");
                            $(".invalid-feedback.nama").remove();
                        }

                        if (response.email_invalid != '') {
                            $("#inputEmail").addClass("is-invalid");
                            $("#inputEmail").after(response.email_invalid)
                        } else {
                            $("#inputEmail").removeClass("is-invalid");
                            $(".invalid-feedback.email").remove();
                        }

                        if (response.alamat_invalid != '') {
                            $("#inputAlamat").addClass("is-invalid");
                            $("#inputAlamat").after(response.alamat_invalid)
                        } else {
                            $("#inputAlamat").removeClass("is-invalid");
                            $(".invalid-feedback.alamat").remove();
                        }
                    }

                    if (response.sukses) {
                        // alert(response.sukses);
                        $('#editModal').modal('hide')
                        Swal.fire({
                            // title: 'Error!',
                            text: response.sukses,
                            icon: 'success'
                        });
                        table.ajax.reload();
                    }
                },
                error: function(xhr, ajaxOptions, throwError) {
                    alert(xhr.status + "\n" + xhr.responText + "\n" + throwError);
                }
            });
        });
    });
</script>