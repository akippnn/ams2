<?php require_once("../php/register.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Registration Form</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
</head>
<body>
    <script type="module" src="../js/forms.js"></script>
    <div class="container position-absolute top-50 start-50 translate-middle">
        <?php if (!empty($success)): ?>
        <div class="alert alert-success" role="alert">
            <ul>
                <?php foreach ($success as $s): ?>
                    <li><?php echo $s; ?></li>
                <?php endforeach; ?>
            </ul>
        </div> <?php endif; ?>
        <?php if (!empty($err)): ?>
        <div class="alert alert-danger" role="alert">
            <ul>
                <?php foreach ($err as $e): ?>
                    <li><?php echo $e; ?></li>
                <?php endforeach; ?>
            </ul>
        </div> <?php endif; ?>
        <h2><b>Registration Form</b></h2><br>
        <form id="myForm" action="register.php" method="POST" class="needs-validation" target="hiddenFrame" novalidate>
            <div class="form-floating">
                <input class="form-control" type="text" name="user_id" id="user_id" placeholder="000012345" required>
                <label for="user_id">ID Number</label>
                <div class="invalid-feedback">Please enter a valid ID number.</div>
            </div>
            <div class="form-floating">
                <input class="form-control" type="text" name="first_name" id="first_name" placeholder="John" required>
                <label for="first_name">First Name</label>
                <div class="invalid-feedback">Please enter your first name.</div>
            </div>
            <div class="form-floating">
                <input class="form-control" type="text" name="last_name" id="last_name" placeholder="Doe" required>
                <label for="last_name">Last Name</label>
                <div class="invalid-feedback">Please enter your last name.</div>
            </div>
            <div class="form-group">
                <input class="form-check-input" type="checkbox" name="reg_authorized" id="reg_authorized" value="yes">
                <label class="form-check-label" for="reg_authorized">Is a school staff</label>
            </div>
            <div class="password-group">
                <div class="form-floating" id="password-input">
                    <!--<input type="password" class="form-control " id="password" placeholder="Enter password" name="password">
                    <label for="password">Password</label>
                    <div class="invalid-feedback">Please enter a password.</div>-->
                    <div class="row g-3 align-items-center">
                        <div class="col-auto">
                            <label for="inputPassword6" class="col-form-label">Password</label>
                        </div>
                        <div class="col-auto">
                            <input type="password" id="password" name="password" class="form-control" aria-describedby="passwordHelpInline" text-wrap novalidate>
                        </div>
                        <div class="col-auto">
                            <span id="passwordHelpInline" class="form-text">
                                Use a memorable and secure password.
                            </span>
                        </div>
                    </div>
                </div> 
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
        <iframe name="hiddenFrame" style="display:none;"></iframe>
    </div>
</body>
</html>
<script>
const passwordGroup = document.querySelector('.password-group');
const passwordInput = document.querySelector('#password');
const schoolStaffCheckbox = document.querySelector('#reg_authorized');
if (schoolStaffCheckbox) {
    schoolStaffCheckbox.addEventListener('change', function() {
        if (this.checked) {
            passwordGroup.classList.add('visible');
            passwordInput.removeAttribute('novalidate');
            passwordInput.setAttribute('required', true);
        } else {
            passwordGroup.classList.remove('visible');
            passwordInput.setAttribute('novalidate', true);
            passwordInput.removeAttribute('required');
        }
    });
}
</script>
<style>
.container {
    width: 400px;
    padding: 1.25%;
    line-height: 1.5;
}
.form-floating {
    margin: 10px 0px 10px 0px;
}
.password-group {
    opacity: 0;
    max-height: 10px;
    overflow: hidden;
    transition: opacity 0.3s ease-out, max-height 0.3s ease-out;
}
.password-group.visible {
    opacity: 1;
    max-height: 100px;
    transition: opacity 0.3s ease-in, max-height 0.3s ease-in;
    margin: 5px 0px 10px 0px;
}
</style>