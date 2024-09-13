<?php
if (!function_exists('serialNumber')) {
    function serialNumber($data, $loop)
    {
        return $data->firstItem() + $loop->index;
    }
}
