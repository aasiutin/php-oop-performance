<?php

class RemoteIP {

    public static function get() {
        if (!empty($_SERVER['HTTP_CF_CONNECTING_IP'])) {
            $ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
        } elseif (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_FORWARDED'])) {
            $str_parts = explode(", ", $_SERVER['HTTP_FORWARDED']);
            $parts_num = count($str_parts);
            $str = $str_parts[$parts_num - 1];
            $str = substr($str, 5, -1);
            list($ip,) = explode(":", $str);
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        return $ip;
    }

    public function getIP() {
        if (!empty($_SERVER['HTTP_CF_CONNECTING_IP'])) {
            $ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
        } elseif (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_FORWARDED'])) {
            $str_parts = explode(", ", $_SERVER['HTTP_FORWARDED']);
            $parts_num = count($str_parts);
            $str = $str_parts[$parts_num - 1];
            $str = substr($str, 5, -1);
            list($ip,) = explode(":", $str);
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        return $ip;
    }
}