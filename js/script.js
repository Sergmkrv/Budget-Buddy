// script.js

// function to show/hide password
function showPassword() {
    const passwordField = document.querySelector('#password');
    const showPassword = document.querySelector('#showPassword');

    if (showPassword.innerText == 'Show Password') {
        showPassword.innerText = 'Hide Password';
        passwordField.type = 'text';
    } else if (showPassword.innerText == 'Hide Password') {
        passwordField.type = 'password';
        showPassword.innerText = 'Show Password';
    }
}

// is the user logged in or not?
fetch('helper/is_logged_in.php')
    .then(res => res.json())
    .then(function (res) {
        if (res.status == 'yes') {
            const login = document.querySelector('#login');
            login.style.display = 'none';
            const logout = document.querySelector('#logout');
            logout.style.display = 'inline-block';

            logout.addEventListener('click', function (e) {
                e.preventDefault();
                fetch('helper/logout_ajax.php')
                    .then(res => res.json())
                    .then(function (res) {
                        if (res.status == 'success') {
                            login.style.display = 'inline-block';
                            logout.style.display = 'none';
                            document.querySelector('#message').innerHTML = '<p>You have been logged out</p>';
                            document.querySelector('h1').innerText = 'Welecome to our Site!';
                        }
                    });
            });
        }
    });