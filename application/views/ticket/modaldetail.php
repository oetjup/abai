<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <?php if ($status == '0') {
                    $classBadge = 'badge-danger';
                    $textBadge = 'Open';
                } elseif ($status == '1') {
                    $classBadge = 'badge-warning';
                    $textBadge = 'Process';
                } elseif ($status == '2') {
                    $classBadge = 'badge-success';
                    $textBadge = 'Done';
                } ?>
                <h5 class="modal-title" id="editModalLabel">Detail Ticket #<?php echo $noTicket; ?> <span class="badge <?php echo $classBadge; ?>"><?php echo $textBadge; ?></span></h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php echo form_open('ticket/updatedata', ['class' => 'formedit']);
            ?>
            <div class="pesan" style="display:none;"></div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="nainputNamama"><strong>Ticket</strong></label>
                        <input type="hidden" class="form-control" id="inputId" name="id" value="<?php echo $id; ?>">
                        <input type="text" class="form-control" id="inputTicket" name="noTicket" value='<?php echo $noTicket; ?>' readonly>
                        <!-- <div class="invalid-feedback" id="namaInvalidMsg">
                        </div> -->
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputContent"><strong>Lokasi ADM</strong></label>
                        <input type="text" class="form-control" id="inputLokasi" name="lokasi" value='<?php echo $adm_loc; ?>' readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputContent"><strong>Permasalahan Mesin ADM</strong></label>
                    <p><?php echo $content; ?></p>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="inputEmail"><strong>Foto Permasalahan</strong></label>
                        <div>
                            <img src="<?php echo base_url('assets') ?>/images/<?php echo $file_ticket; ?>" class="rounded img-thumbnail">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputContent"><strong>Penyelesaian Masalah</strong></label>
                    <p><?php echo $reply_ticket; ?></p>
                </div>
                <!-- Tampilan Admin -->
                <div class="form-group">
                    <label for="inputStatus"><strong>Status</strong></label>
                    <div class="form-check form-check-inline">
                        <?php
                        if ($status == '0') {
                        ?>
                            <label class="form-check-label" for="inlineRadio1"><span class="badge badge-danger">Open</span></label>
                        <?php
                        } elseif ($status == '1') {
                        ?>
                            <label class="form-check-label" for="inlineRadio1"><span class="badge badge-warning">Process</span></label>
                        <?php
                        } elseif ($status == '2') {
                        ?>
                            <label class="form-check-label" for="inlineRadio1"><span class="badge badge-success">Done</span></label>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                <!-- <button type="submit" class="btn btn-primary btn-sm">Update</button> -->
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