<script>
    function getRoundedCanvas(sourceCanvas) {
        var canvas = document.createElement('canvas');
        var context = canvas.getContext('2d');
        var width = sourceCanvas.width;
        var height = sourceCanvas.height;

        canvas.width = width;
        canvas.height = height;
        context.imageSmoothingEnabled = true;
        context.drawImage(sourceCanvas, 0, 0, width, height);
        context.globalCompositeOperation = 'destination-in';
        context.beginPath();
        context.arc(width / 2, height / 2, Math.min(width, height) / 2, 0, 2 * Math.PI, true);
        context.fill();
        return canvas;
    }

    var $modal = $('#modal');

    var image = document.getElementById('previewfoto');

    var cropper;

    $('#upload_image').change(function(event) {
        var files = event.target.files;

        var done = function(url) {
            image.src = url;
            $modal.modal({
                show: true,
                backdrop: 'static',
                keyboard: false
            });
        };

        if (files && files.length > 0) {
            reader = new FileReader();
            reader.onload = function(event) {
                done(reader.result);
            };
            reader.readAsDataURL(files[0]);
        }
    });

    $modal.on('shown.bs.modal', function() {
        cropper = new Cropper(image, {
            aspectRatio: 1,
            viewMode: 3,
        });
    }).on('hidden.bs.modal', function() {
        cropper.destroy();
        cropper = null;
    });

    $('#crop').click(function() {
        document.getElementById('crop').innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menunggu..';
        gambarcrop = cropper.getCroppedCanvas();
        roundedCanvas = getRoundedCanvas(gambarcrop);

        document.getElementById('cropfoto').value = roundedCanvas.toDataURL('image/png');
        document.getElementById('uploadprofile').submit();
    });
</script>