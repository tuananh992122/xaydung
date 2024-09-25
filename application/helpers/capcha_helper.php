<?php

if (!function_exists('generate_capture')) {

    function generate_capcha() {
        $CI =& get_instance();
        $md5 = md5(microtime() * time());
        $string = substr($md5, 0, 6);
        $captcha = imagecreatefrompng("images/captcha.png");
        $black = imagecolorallocate($captcha, 0, 0, 0);
        $line = imagecolorallocate($captcha, 255, 255, 255);
        for ($i = 0; $i < 10; $i++) {
            $v1 = rand(0, 64);
            $v2 = rand(0, 64);
            $v3 = rand(0, 64);
            $v4 = rand(0, 64);
            imageline($captcha, $v1, $v2, $v3, $v4, $line);
        }
        //imageline($captcha,40,0,64,29,$line);
        imagestring($captcha, 5, 25, 3, $string, $black);
        $session_data['activecode'] = md5($string);
        $CI->session->set_userdata($session_data);

        header("Content-type: image/png");
        imagepng($captcha);
    }

}



?>
