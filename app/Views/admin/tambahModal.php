<div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="/karyawan/simpan" method="POST">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Karyawan</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <label>Nama Karyawan</label>
                            <input type="text" class="form-control" name="nama" placeholder="Masukkan nama karyawan">
                        </div>
                        <div class="col-sm-6 mt-3">
                            <label>Nomor Induk Karyawan</label>
                            <input type="number" class="form-control" name="nik" placeholder="Masukkan nomor induk karyawan">
                        </div>
                        <div class="col-sm-6 mt-3">
                            <label>Jabatan</label>
                            <input type="text" class="form-control" name="jabatan" placeholder="Masukkan jabatan">
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>