<script type="text/javascript">
    let canvas = document.querySelector("#canvas");
    let video = document.querySelector("#preview");
    let scanner = new Instascan.Scanner({
        mirror: false,
        video: document.getElementById('preview')
    });

    $('#buka-kamera').click(function() {
        Instascan.Camera.getCameras().then(function(cameras) {
            if (cameras.length > 0) {
                var selectedCam = cameras[0];
                $.each(cameras, (i, c) => {
                    if (c.name.indexOf('back') !== -1) {
                        selectedCam = c;
                        return false;
                    }
                });
                scanner.start(selectedCam);

                $('#ganti-kamera').on('change', function() {
                    var gantiKamera = document.getElementById('ganti-kamera');
                    if (gantiKamera.checked) {
                        $.each(cameras, (i, c) => {
                            if (c.name.indexOf('front') !== -1) {
                                selectedCam = c;
                                return false;
                            }
                        });
                        scanner.start(selectedCam);
                    } else {
                        $.each(cameras, (i, c) => {
                            if (c.name.indexOf('back') !== -1) {
                                selectedCam = c;
                                return false;
                            }
                        });
                        scanner.start(selectedCam);
                    }
                })
            } else {
                Swal.fire(
                    'Error',
                    'Kamera tidak ditemukan.',
                    'error'
                )
            }
        }).catch(function(e) {
            Swal.fire(
                'Error',
                'Permission kamera tidak diaktifkan.',
                'error'
            )
            console.log(e);
        });

        scanner.addListener('scan', function(c) {
            document.getElementById('qr').value = c;
            document.getElementById('qr-checkout').value = c;
            if (document.getElementById('radio-checkin').checked) {
                document.getElementById('scancheckin').submit();
            } else if (document.getElementById('radio-checkout').checked) {
                document.getElementById('scancheckout').submit();
            }
        });
    })

    function showError(error) {
        switch (error.code) {
            case error.PERMISSION_DENIED:
                Swal.fire(
                    'Error',
                    'Permission lokasi tidak diaktifkan.',
                    'error'
                )
                break;
        }
    }
</script>