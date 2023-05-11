<?php

namespace Controllers;

use Core\Validator;

use Core\Response;

trait HandleFileUpload
{
    public function handleImageUpload(): string
    {
        if(empty($_FILES)) {
            return '';
        }
        if(!isset($_FILES['thumbnail'])) {
            Response::abort(400);
        }

        if($_FILES['thumbnail']['error'] === 0) {
            $tmp_path = $_FILES['thumbnail']['tmp_name'];
            $current_name = $_FILES['thumbnail']['name'];
            if(!Validator::image($tmp_path)) {
                $_SESSION['errors']['thumbnail'] = 'We only support images of type jpeg, jpg, gif or png';
                $_SESSION['old']=$_REQUEST;
                return '';
            }
            $name_parts = explode('.', $current_name);
            $extension = $name_parts[ array_key_last($name_parts) ];
            $new_name = sha1_file($tmp_path).'.'.$extension;

            return $new_name;
        }

        return '';
    }
}
