$('.dataBackupTable').DataTable({
    "ajax": "ajax/dataBackup.ajax.php",
    "deferRender": true,
    "retrieve": true,
    "processing": true,
    "order": [4, 'asc'],
    "iDisplayLength": 25
});

$(document).on("click", ".downloadFile", function () {
    var data_id = $(this).attr("data_id");

    swal({
        title: 'Do you want to download this backup file?',
        type: 'info',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'cancel',
        confirmButtonText: 'Yes'
    }).then(function (result) {
        if (result.value) {
            swal({
                title: "Please wait...",
                text: "Processing your download.",
                showConfirmButton: false,
                allowOutsideClick: false
            });
            $.ajax({
                url: "email/download_backup.php",
                type: "GET",
                data: { data_id: data_id },
                xhrFields: {
                    responseType: 'blob'
                },
                success: function (data, status, xhr) {
                    const filename = xhr.getResponseHeader('Content-Disposition').split('filename=')[1].replace(/"/g, '');
                    const blob = new Blob([data], { type: xhr.getResponseHeader('Content-Type') });
                    const link = document.createElement('a');
                    link.href = URL.createObjectURL(blob);
                    link.download = filename;
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);

                    swal('Download!', 'The backup file has been downloaded.', 'success');
                    $('.dataBackupTable').DataTable().ajax.reload(null, false);
                },
                error: function (xhr, status, error) {
                    swal('Error', 'Download failed: ' + error, 'error');
                }
            });
        }
    });
});

$(document).on("click", ".deleteFile", function () {
    var data_id = $(this).attr("data_id");

    swal({
        title: 'Do you want to delete this backup file?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancel',
        confirmButtonText: 'Yes'
    }).then(function (result) {
        if (result.value) {
            $.ajax({
                url: 'email/delete_backup.php',
                method: 'POST',
                dataType: 'json',
                data: { data_id: data_id },
                success: function (response) {
                    if (response.status === 'ok') {
                        console.log(response);
                        swal('Deleted!', 'The backup file has been deleted.', 'success');
                        $('.dataBackupTable').DataTable().ajax.reload(null, false);
                    } else {
                        swal('Error', response.message || 'Deletion failed.', 'error');
                    }
                },
                error: function () {
                    swal('Error', 'AJAX request failed.', 'error');
                }
            });
        }
    });
});








