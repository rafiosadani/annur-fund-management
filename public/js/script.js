$(document).ready(function () {
    // Input Number Only
    const inputs = document.getElementsByClassName('inputNumberOnly');
    for (let i = 0; i < inputs.length; i++) {
        inputs[i].addEventListener('input', function (e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    }
});
