<?php

$DATA_SAVE_ROOT = "/mnt/HDD/VehSenseData/";
$LARGEST_FILE_SIZE = 1000000000; // 1GB
$UPLOAD_FILE_TAG = "uploadedFile";
$UPLOAD_FILE_PREFIX = "filepathPrefix";
$DEVICE_ID = "deviceID";


function check_or_make_dir($full_dir) {
    if (!is_dir($full_dir)) {
        mkdir($full_dir);
    }
}
