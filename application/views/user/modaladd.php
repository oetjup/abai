<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="exampleModalLabel"><?php echo $modalTitle; ?></h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php echo form_open('user/savedata', ['class' => 'formsave']);
            ?>
            <div class="pesan" style="display:none;"></div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputNama">Nama Lengkap</label>
                        <input type="text" class="form-control" id="inputNama" name="nama">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputUsername">Username</label>
                        <input type="text" class="form-control" id="inputUsername" name="username">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputPassword1">Pasword</label>
                        <input type="password" class="form-control" id="inputPassword1" name="password1">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputPassword2">Ulangi Pasword</label>
                        <input type="password" class="form-control" id="inputPassword2" name="password2">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputRole">Role</label>
                        <select class="custom-select" id="inputRole" name="role" onchange="roleChange()">
                            <option value="">-- Pilih Satu --</option>
                            <option value="1">Admin</option>
                            <option value="2">Dinas</option>
                            <option value="3">Desa</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6" id="lokasiAdm" style="display:none;">
                        <label for="inputLokasi">Lokasi ADM</label>
                        <select class="custom-select" id="inputLokasi" name="lokasi">
                            <option value="" selected>-- Pilih Satu --</option>
                            <?php foreach ($listDesa as $ld) : ?>
                                <option value="<?php echo $ld; ?>"><?php echo $ld; ?></option>
                            <?php endforeach; ?>
                            <!-- <option value="Desa Soreang">Desa Soreang</option>
                            <option value="Desa Bandasari">Desa Bandasari</option>
                            <option value="Desa Margahayu Selatan">Desa Margahayu Selatan</option> -->
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary btn-sm">Save</button>
            </div>
            <?php echo form_close();
            ?>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('.formsave').submit(function(e) {
            e.preventDefault();

            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                // data: $(this).serialize(),
                data: new FormData(this),
                processData: false,
                contentType: false,
                cache: false,
                async: false,
                dataType: "json",
                success: function(response) {
                    if (response.error) {
                        // $('.pesan').html(response.error).show();
                        $(".invalid-feedback").remove();

                        if (response.nama_invalid != '') {
                            $("#inputNama").addClass("is-invalid");
                            $("#inputNama").after(response.nama_invalid);
                        } else {
                            $("#inputNama").removeClass("is-invalid");
                            $(".invalid-feedback.nama").remove();
                        }

                        if (response.username_invalid != '') {
                            $("#inputUsername").addClass("is-invalid");
                            $("#inputUsername").after(response.username_invalid);
                        } else {
                            $("#inputUsername").removeClass("is-invalid");
                            $(".invalid-feedback.username").remove();
                        }

                        if (response.password1_invalid != '') {
                            $("#inputPassword1").addClass("is-invalid");
                            $("#inputPassword1").after(response.password1_invalid);
                        } else {
                            $("#inputPassword1").removeClass("is-invalid");
                            $(".invalid-feedback.password1").remove();
                        }

                        if (response.password2_invalid != '') {
                            $("#inputPassword2").addClass("is-invalid");
                            $("#inputPassword2").after(response.password2_invalid);
                        } else {
                            $("#inputPassword2").removeClass("is-invalid");
                            $(".invalid-feedback.password2").remove();
                        }

                        if (response.role_invalid != '') {
                            $("#inputRole").addClass("is-invalid");
                            $("#inputRole").after(response.role_invalid);
                        } else {
                            $("#inputRole").removeClass("is-invalid");
                            $(".invalid-feedback.role").remove();
                        }

                        if (response.lokasi_invalid != '') {
                            $("#inputLokasi").addClass("is-invalid");
                            $("#inputLokasi").after(response.lokasi_invalid);
                        } else {
                            $("#inputLokasi").removeClass("is-invalid");
                            $(".invalid-feedback.lokasi").remove();
                        }
                    }

                    if (response.sukses) {
                        // alert(response.sukses);
                        $('#exampleModal').modal('hide')
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

    function roleChange() {
        var x = document.getElementById("inputRole").value;
        if (x == 3) {
            document.getElementById("lokasiAdm").style.display = "block";
        } else {
            document.getElementById("lokasiAdm").style.display = "none";
        }
    }
</script>