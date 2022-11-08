<script type="text/javascript">
    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition, showError);
        } else {
            alert("Geolocation tidak di support oleh browser ini.")
        }
    }

    function showPosition(position) {
        var lokasi = document.querySelector('.formAbsen input[name = "lokasi"]');
        var lokasiCheckout = document.getElementById('lokasi-checkout');
        var lokasiIzin = document.getElementById('lokasi-izin');
        var lokasiKantor = document.getElementById('lokasiKantor');
        var posisi = position.coords.latitude + ', ' + position.coords.longitude;
        var primafrom = '-6.272195, 106.747218'
        var primato = '-6.272966, 106.746793'
        var arcadefrom = '-6.272379, 106.714021';
        var arcadeto = '-6.273117, 106.715066';
        let reverse = 'https://api.geoapify.com/v1/geocode/reverse?lat=' + position.coords.latitude + '&lon=' + position.coords.longitude + '&format=json&apiKey=566ce04fb05b4967b10660569214a4e9';
        var requestOptions = {
            method: 'GET',
        };

        fetch(reverse, requestOptions)
            .then(response => response.json())
            // .then(result => console.log(result))
            .then(result => {
                let lokasifull = result.results[0].formatted;
                let lokasijalan = result.results[0].street

                if (posisi >= arcadefrom && posisi <= arcadeto && lokasifull == 'Jalan Boulevard Bintaro Jaya, Pondok Jaya, South Tangerang 15229, Banten, Indonesia' || lokasifull == 'Total, Jalan Boulevard Bintaro B7/D2, Pondok Jaya, 15229, Banten, Indonesia' || lokasifull == 'Pondok Jaya, South Tangerang 15229, Banten, Indonesia') {
                    lokasi.value = 'Kantor Arcade 1';
                    lokasiCheckout.value = 'Kantor Arcade 1';
                } else if (posisi >= primafrom && posisi <= primato && lokasifull == 'Aesthetic & Family Dentistry, Bintaro Utama 3 Blok AC No.1, Pondok Betung, South Tangerang 12330, Banten, Indonesia' || lokasifull == 'Pondok Betung, South Tangerang 12330, Banten, Indonesia' || lokasifull == 'Camar XXIV, Pondok Betung, South Tangerang 12330, Banten, Indonesia' || lokasifull == 'Bintaro Utama 3, Pondok Betung, South Tangerang 12330, Banten, Indonesia') {
                    lokasi.value = 'Kantor Century 21 Prima'
                    lokasiCheckout.value = 'Kantor Century 21 Prima'
                } else {
                    lokasi.value = lokasifull
                    lokasiCheckout.value = lokasijalan
                }

                lokasiIzin.value = lokasifull
            })
            .catch(error => console.log('error', error));

        fetch(reverse, requestOptions)
            .then(response => response.json())
            // .then(result => console.log(result))
            .then(result => {
                let lokasifull = result.results[0].formatted;

                if (posisi >= arcadefrom && posisi <= arcadeto && lokasifull == 'Jalan Boulevard Bintaro Jaya, Pondok Jaya, South Tangerang 15229, Banten, Indonesia' || lokasifull == 'Total, Jalan Boulevard Bintaro B7/D2, Pondok Jaya, 15229, Banten, Indonesia' || lokasifull == 'Pondok Jaya, South Tangerang 15229, Banten, Indonesia') {
                    lokasiKantor.value = 'Kantor Arcade 1';
                } else if (posisi >= primafrom && posisi <= primato && lokasifull == 'Aesthetic & Family Dentistry, Bintaro Utama 3 Blok AC No.1, Pondok Betung, South Tangerang 12330, Banten, Indonesia' || lokasifull == 'Pondok Betung, South Tangerang 12330, Banten, Indonesia' || lokasifull == 'Camar XXIV, Pondok Betung, South Tangerang 12330, Banten, Indonesia' || lokasifull == 'Bintaro Utama 3, Pondok Betung, South Tangerang 12330, Banten, Indonesia') {
                    lokasiKantor.value = 'Kantor Century 21 Prima'
                } else {
                    lokasiKantor.value = result.results[0].formatted;
                }
            })
            .catch(error => console.log('error', error));
    }

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