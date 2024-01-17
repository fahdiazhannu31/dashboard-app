<?= $this->extend('layout/page_layout') ?>
<?= $this->section('content') ?>

<section class="panel">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url() ?>laporan/qs">LAPORAN BULANAN</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" id="info1-tab" data-toggle="tab" href="#info1" role="tab" aria-controls="info1" aria-selected="true">PERMASALAHAN</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url() ?>laporan/monitoring-karyawan-qs">MONITORING KARYAWAN</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url() ?>laporan/monitoring-dcr-qs">MONITORING DCR</a>
        </li>

    </ul>

    <div class="tab-content" id="myTabContent">

        <!---MASALAH--->
        <div class="tab-pane active" id="info2" role="tabpanel" aria-labelledby="info2-tab">
            <div>
                <div class="d-flex flex-row pull-right">

                    <div class="m-l-10 align-self-center">
                        <h6 class="text-muted m-b-0">Diperbaharui :
                            <?php if ($proyek->tgl_ubah_masalah > 0) { ?>
                                <b><?= (date('d-M-Y', strtotime(esc($proyek->tgl_ubah_masalah)))) ?>
                                <?php } ?> </b>
                        </h6>
                        <?php
                        if (level_user('qs', 'index', $kategoriQNS, 'read') > 0) {
                        ?>
                            <div id="userbox" class="userbox">
                                <a class="btn btn-success" data-toggle="modal" data-target="#tambahData" style="font-size: 12px;color:white"> UPD. MASALAH</a>

                                <a class="btn btn-info" data-toggle="dropdown" style="font-size: 12px;color:black">EXPORT

                                </a>
                                <div class="dropdown-menu">
                                    <ul class="list-unstyled">
                                        <li class="divider"></li>
                                        <li>
                                            <a class="btn btn-info" href="<?= base_url() ?>proyek/xls2/<?= $proyek->id_pkp ?>" target="_blank" style="font-size: 12px;color:black"> XLS</a>
                                        </li>
                                        <li>
                                            <a class="btn btn-info" href="<?= base_url() ?>proyek/pdf1/<?= $proyek->id_pkp ?>" style="font-size: 12px;color:black" target="_blank"> PDF</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        <?php } ?>

                    </div>

                </div>

                <h4 class="card-subtitle" style="margin-bottom: 5px;font-size:15px">DATA PERMASALAHAN POKOK</h4>
                <div class="table-scrollable" style="height: 580px;width:100%">
                    <table cellspacing="0" id="table-basic" class="table table-sm table-bordered table-striped" style="min-width: 1200px;">
                        <thead style="background-color:#1b3a59;color:white;">
                            <tr>
                                <th style="text-align:center;width: 3%">NO.</th>
                                <th style="text-align:center;width: 20%">URAIAN</th>
                                <th style="text-align:center;width: 20%">PENYEBAB</th>
                                <th style="text-align:center;width: 20%">DAMPAK</th>
                                <th style="text-align:center;width: 20%">TINDAK LANJUT/SOLUSI</th>
                                <th style="text-align:center;width: 10%">PIC</th>
                                <th style="text-align:center;width: 7%">TARGET</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr style="background-color: #FFEFD5;">
                                <td colspan="7"><b><strong>EKSTERNAL</strong></b></td>
                            </tr>
                            <?php
                            $noA = 1;
                            $noB = 1;
                            foreach ($solusi as $sol) { ?>
                                <tr>
                                    <td style="text-align:left;width: 3%"><?= $noA++ ?></td>
                                    <td style="text-align:left;width: 20%"><?= $sol->masalah ?></td>
                                    <td style="text-align:left;width: 20%"><?= $sol->penyebab ?></td>
                                    <td style="text-align:left;width: 20%"><?= $sol->dampak ?></td>
                                    <td style="text-align:left;width: 20%"><?= $sol->solusi ?></td>
                                    <td style="text-align:left;width: 10%"><?= $sol->pic ?></td>

                                    <td style="text-align:left;width: 5%"><?= $sol->target ?></td>
                                </tr>
                            <?php
                            } ?>
                            <tr style="background-color: #FFEFD5;">
                                <td colspan="7"><b><strong>INTERNAL</strong></b></td>
                            </tr>
                            <?php
                            $nomor = 0;
                            foreach ($solusi2 as $sol2) {
                            ?>
                                <tr>
                                    <td style="text-align:left;width: 5%"><?= $noB++ ?></td>
                                    <td style="text-align:left;width: 25%"><?= $sol2->masalah ?></td>
                                    <td style="text-align:left;width: 25%"><?= $sol2->penyebab ?></td>
                                    <td style="text-align:left;width: 25%"><?= $sol2->dampak ?></td>
                                    <td style="text-align:left;width: 25%"><?= $sol2->solusi ?></td>
                                    <td style="text-align:left;width: 25%"><?= $sol2->pic ?></td>

                                    <td style="text-align:left;width: 25%"><?= $sol2->target ?></td>
                                </tr>
                            <?php
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
<!-- end: page -->


<!--IMPORT SOLUSI-->
<div class="modal fade" id="tambahData" tabindex="1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width:90%">
        <div class="modal-content">
            <section class="panel panel-primary">
                <?= form_open('proyek/proses_upload_solusi', ' id="FormulirTambah"'); ?>
                <header class="panel-heading">
                    <h2 class="panel-title">Migrasi Permasalahan & Solusi</h2>
                </header>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group excelfile">
                                <label class="col-sm-3 control-label">Upload File Excel</label>
                                <div class="col-sm-9">
                                    <input type="file" name="excelfile" class="form-control" required />
                                    <input type="hidden" name="id_pkp58" value="<?= esc($proyek->id_pkp) ?>" class="form-control" required />
                                    <input type="hidden" name="id_ubah" value="<?= session('idadmin'); ?>" class="form-control" required />
                                </div>
                            </div>
                            <div class="form-group excelfile">
                                <label class="col-sm-3 control-label">Format EXCEL</label>
                                <a style="font-size:12px;" class="btn btn-warning" href="<?= base_url() ?>excel/formatMIGmasalah.xlsx" target="_blank"><i class="fa fa-download"></i> Download Format</a>
                            </div>
                        </div>
                    </div>
                </div>

                <footer class="panel-footer">
                    <div class="row">
                        <div class="col-md-12 text-right">
                            <button class="btn btn-primary modal-confirm" style="font-size: 12px;vertical-align: middle" type="submit" id="submitform">Submit</button>
                            <button class="btn btn-default" style="font-size: 12px;vertical-align: middle" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </footer>
                </form>
            </section>
        </div>
    </div>
</div>

<!-- JS -->

<script type="text/javascript">
    $(".table-scrollable").freezeTable({
        'scrollable': true,
        'columnNum': 2,
    });

    $(document).ready(function() {
        $('ul li a').click(function() {
            $('li a').removeClass("active");
            $(this).addClass("active");
        });
    });

    $('.tanggal').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
    });

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd-mm-yyyy', {
        'placeholder': 'dd-mm-yyyy'
    })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm-dd-yyyy', {
        'placeholder': 'mm-dd-yyyy'
    })
    //Money Euro
    $('[data-mask]').inputmask()
    /* TAMBAH Progress */


    document.getElementById("FormulirTambah").addEventListener("submit", function(e) {
        blurForm();
        $('.help-block').hide();
        $('.form-group').removeClass('has-error');
        document.getElementById("submitform").setAttribute('disabled', 'disabled');
        $('#submitform').html('Loading ...');
        var form = $('#FormulirTambah')[0];
        var formData = new FormData(form);
        var xhrAjax = $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            dataType: 'json'
        }).done(function(data) {
            if (!data.success) {
                $('input[name=<?= csrf_token(); ?>]').val(data.token);
                document.getElementById("submitform").removeAttribute('disabled');
                $('#submitform').html('Submit');
                var objek = Object.keys(data.errors);
                for (var key in data.errors) {
                    if (data.errors.hasOwnProperty(key)) {
                        var msg = '<div class="help-block" for="' + key + '">' + data.errors[key] + '</span>';
                        $('.' + key).addClass('has-error');
                        $('input[name="' + key + '"]').after(msg);
                    }
                    if (key == 'fail') {
                        new PNotify({
                            title: 'Notifikasi',
                            text: data.errors[key],
                            type: 'danger'
                        });
                    }
                }
            } else {
                $('input[name=<?= csrf_token(); ?>]').val(data.token);
                PNotify.removeAll();
                document.getElementById("submitform").removeAttribute('disabled');
                $('#tambahData').modal('hide');
                document.getElementById("FormulirTambah").reset();
                $('#submitform').html('Submit');
                new PNotify({
                    title: 'Notifikasi',
                    text: data.message,
                    type: 'success'
                });
                window.setTimeout(function() {
                    window.location.href = "<?= base_url() ?>laporan/masalah_qs/"
                }, 2000);
            }
        }).fail(function(data) {
            new PNotify({
                title: 'Notifikasi',
                text: "Request gagal, browser akan direload",
                type: 'danger'
            });
            window.setTimeout(function() {
                location.reload();
            }, 2000);
        });
        e.preventDefault();
    });
</script>
</body>

</html>
<?= $this->endSection() ?>