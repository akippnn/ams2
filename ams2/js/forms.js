import "./main.js";

function submitForm() {
  // get form data
  var formData = new FormData(document.getElementById("myForm"));

  var xhr = new XMLHttpRequest();
  xhr.open("POST", "php/register.php", true);
  xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
  xhr.onreadystatechange = function() {
    if(xhr.readyState == 4 && xhr.status == 200) {
      console.log(this.responseText);
    };
  };
  xhr.send(formData);
};

document.getElementById("myForm").addEventListener("submit", event => {
  console.log("pressed");
  event.preventDefault();
  submitForm();
});

//(() => {
  //'use strict';
  //const forms = document.querySelectorAll('.needs-validation');

  //Array.from(forms).forEach(form => {
    //form.addEventListener('submit', event => {
      //if (!form.checkValidity()) {
        //event.preventDefault();
        //event.stopPropagation();
      //}

      //form.classList.add('was-validated')
    //}, false);
  //})
//})();