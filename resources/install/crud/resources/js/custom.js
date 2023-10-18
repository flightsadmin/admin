// Import Trix Editor
import trix from "trix";
window.trix = trix;

// Import Sweet Alert 2
import Swal from "sweetalert2";
window.Swal = Swal;

window.addEventListener("closeModal", function (event) {
    Swal.fire({
        text: event.detail.message,
        icon: event.detail.icon,
        showConfirmButton: false,
        timerProgressBar: true,
        position: 'top-end',
        timer: 3000,
        toast: true,
    });     
});