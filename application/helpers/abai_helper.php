<?php

function is_logged_in()
{
    $CI = get_instance();

    if (!$CI->session->userdata('is_login')) {
        redirect(base_url());
    }
}
