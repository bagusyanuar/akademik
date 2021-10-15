function confirmSweetAlert(title = 'Konfirmasi?', text = 'Apakah Anda Yakin?', callback = function () {}) {
    Swal.fire({
        title: title,
        text: text,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya'
    }).then(async (result) => {
        if(result.value) {
            callback()
        }
    })
}

function sweetAlertMessage(title = 'Success', text = 'Berhasil', icon = 'success') {
    Swal.fire({
        title: title,
        text: text,
        icon: icon,
        confirmButtonText: 'Ok'
    })
}
