<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editModalLabel">Edit Ticket</h5>
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
                        <label for="nainputNamama">Ticket</label>
                        <input type="hidden" class="form-control" id="inputId" name="id" value="<?php echo $id; ?>">
                        <input type="text" class="form-control" id="inputTicket" name="noTicket" value='<?php echo $noTicket; ?>' readonly>
                        <!-- <div class="invalid-feedback" id="namaInvalidMsg">
                        </div> -->
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputLokasi">Lokasi ADM</label>
                        <input type="text" class="form-control" id="inputLokasi" name="lokasi" value='<?php echo $adm_loc; ?>' readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputContent">Permasalahan Mesin ADM</label>
                    <input type="text" class="form-control" id="inputContent" name="content" value="<?php echo $content; ?>">
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="input File">Foto Permasalahan</label>
                        <input type="file" name="file" class="form-control-file" id="exampleFormControlFile1" value="<?php echo $file_ticket; ?>">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputEmail">Preview</label>
                        <div>
                            <img src="<?php echo base_url('assets') ?>/images/<?php echo $file_ticket; ?>" class="rounded img-thumbnail">
                        </div>
                    </div>
                </div>
                <!-- Tampilan Admin -->
                <?php if ($this->session->userdata('role') !== '3') { ?>
                    <div class="form-group">
                        <label for="inputStatus">Status</label>
                        <br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="status" id="inlineRadio1" value="0" <?php echo ($status == '0') ?  "checked" : "";  ?>>
                            <label class="form-check-label" for="inlineRadio1"><span class="badge badge-danger">Open</span></label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="status" id="inlineRadio2" value="1" <?php echo ($status == '1') ?  "checked" : "";  ?>>
                            <label class="form-check-label" for="inlineRadio2">
                                <span class="badge badge-warning">Process</span>
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="status" id="inlineRadio3" value="2" <?php echo ($status == '2') ?  "checked" : "";  ?>>
                            <label class="form-check-label" for="inlineRadio3"><span class="badge badge-success">Done</span></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputReply">Keterangan Penyelesaian</label>
                        <input type="text" class="form-control" id="inputReply" name="reply" value="<?php echo $reply_ticket; ?>">
                    </div>
                <?php
                }
                ?>
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