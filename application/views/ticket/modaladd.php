<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="exampleModalLabel"><?php echo $modalTitle; ?></h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php echo form_open('ticket/savedata', ['class' => 'formsave']);
            ?>
            <div class="pesan" style="display:none;"></div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputTicket">Ticket</label>
                        <input type="text" class="form-control" id="inputTicket" name="noTicket" value='<?php echo date('Ymd') . $noTicket; ?>' readonly>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputLokasi">Lokasi ADM</label>
                        <input type="text" class="form-control" id="inputLokasi" name="lokasi" value="<?php echo $this->session->userdata('adm_loc') ?>" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputContent">Permasalahan Mesin ADM</label>
                    <input type="text" class="form-control" id="inputContent" name="content">
                </div>
                <?php //echo form_open_multipart('ticket/file_preview', ['class' => 'formpreview']);
                ?>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="input File">Foto Permasalahan</label>
                        <input type="file" name="file" class="form-control-file" id="exampleFormControlFile1">
                    </div>
                </div>
                <!-- <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="input File">File</label>
                        <input type="file" name="file" class="form-control-file" id="exampleFormControlFile1">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputEmail">Preview</label>
                        <div>
                            <img src="..." class="rounded img-thumbnail" alt="...">
                        </div>
                    </div>
                </div> -->
                <?php //echo form_close();
                ?>
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
                //data: $(this).serialize(),
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

                        if (response.noTicket_invalid != '') {
                            $("#inputTicket").addClass("is-invalid");
                            $("#inputTicket").after(response.noTicket_invalid)
                        } else {
                            $("#inputTicket").removeClass("is-invalid");
                            $(".invalid-feedback.noTicket").remove();
                        }

                        if (response.content_invalid != '') {
                            $("#inputContent").addClass("is-invalid");
                            $("#inputContent").after(response.content_invalid)
                        } else {
                            $("#inputContent").removeClass("is-invalid");
                            $(".invalid-feedback.content").remove();
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
</script>