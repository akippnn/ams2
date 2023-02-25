const passwordGroup = document.querySelector('.password-group');
const schoolStaffCheckbox = document.querySelector('#school_staff');

schoolStaffCheckbox.addEventListener('change', function() {
    if (this.checked) {
        passwordGroup.classList.add('visible');
    } else {
        passwordGroup.classList.remove('visible');
    }
});