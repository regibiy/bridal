<?php

function login_admin()
{
    if (isset($_SESSION["login_admin"]) && $_SESSION["login_admin"] === "Login") return true;
    else return false;
}

function alert_with_redirect($msg, $url)
{
    echo "
    <script>
    alert('" . $msg . "')
    location.href = '" . $url . "'
    </script>
    ";
}

function unggah_gambar($file_name, $file_size, $temp_loc, $target_loc)
{
    $valid_ext = ['jpg', 'jpeg', 'png'];
    $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    if (!in_array($ext, $valid_ext)) return false;
    else {
        if ($file_size > 3000000) return false;
        else {
            $new_file_name = uniqid() . "." . $ext;
            move_uploaded_file($temp_loc, $target_loc . $new_file_name);
            return $new_file_name;
        }
    }
}
