<?php

// Function to display error messages
function display_error_bucket($error_bucket)
{
    echo '<div class="d-flex justify-content-center">';
    echo '<div class="pt-4 mt-3 mb-0 alert alert-warning shadow col-6" role="alert">';
    echo '<p class="fw-bold">All of these fields are required:</p>';
    echo '<ul>';
    // Loop through the error bucket and display each error message
    foreach ($error_bucket as $text) {
        echo '<li>' . $text . '</li>';
    }
    echo '</ul>';
    echo '</div>';
    echo '</div>';
}
