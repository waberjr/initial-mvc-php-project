$(document).ready(function () {

});

// //render the toast message
// function renderHtmlToast(text) {
//     return `${text}
//             <button onclick="M.Toast.getInstance(this.parentElement).dismiss();" class="btn-flat toast-action">
//                 <i id="dismiss-toast" class="material-icons white-text">close
//             </button>`;
// }

//shows the flash message
function flash(response) {
    if (response) {
        // M.toast({
        //     html: renderHtmlToast(response.message.text),
        //     classes: response.message.classes,
        //     displayLength: 5000,
        // });
        console.log(response.message.text)
        console.log(response.message.classes)
    }
}