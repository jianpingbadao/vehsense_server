<?php
    include "utility.php";

    $DEBUG = TRUE;
    $VIDEO_ALLOWED = TRUE;

    if (count($_FILES) == 0) {
        echo "no file is uploaded";
        exit;
    }

    if (count($_POST) == 0) {
        echo "no post request received.";
        exit;
    }

    if (!isset($_POST[$UPLOAD_FILE_PREFIX])) {
        echo "filepath prefix not being set.";
        exit;
    }

    // name of the trip folder
    $path_prefix = $_POST[$UPLOAD_FILE_PREFIX];
    if ($DEBUG) {
        echo "path prefix: " . $path_prefix . "<br>";
    }

    $device_id = "default";
    if (isset($_POST[$DEVICE_ID])) {
        $device_id = $_POST[$DEVICE_ID];
    }

    if(isset($_FILES[$UPLOAD_FILE_TAG]['name']) && !empty($_FILES[$UPLOAD_FILE_TAG]['name'])) {

        //echo "File received: ". $_FILES[$UPLOAD_FILE_TAG]['name'] . "<br>";
        //echo "FILES:";
        //echo "<pre>";
        //print_r($_FILES);
        //echo "</pre>";

        $log_file = fopen($UPLOAD_LOG_FILE, "a");
        $time = date("h:i:sa") . ": ";
        fwrite($log_file, $time);
        fwrite($log_file, "device: " . $device_id . ", trip: " . $path_prefix . ", filename: " . $_FILES[$UPLOAD_FILE_TAG]['name'] . ", ");

        if ($_FILES[$UPLOAD_FILE_TAG]["error"] !== 0) {
            echo "upload error";
            fwrite($log_file, "upload error.\n");
            fclose($log_file);
            exit;
        }

        $filename = basename($_FILES[$UPLOAD_FILE_TAG]['name']);

        $type = substr($filename, -4);
        if ($type != ".txt") {
            if (!($VIDEO_ALLOWED == TRUE && $type == "3gpp")) {
                echo "upload error file type";
                fwrite($log_file, " --> ERROR: file type not support.\n");
                fclose($log_file);
                exit;
            }
        }

        fwrite($log_file, "size: " . $_FILES[$UPLOAD_FILE_TAG]["size"] . ", ");
        if ($_FILES[$UPLOAD_FILE_TAG]["size"] > $LARGEST_FILE_SIZE) {
            echo "upload error file size too large";
            fwrite($log_file, " --> ERROR: file size too large.\n");
            fclose($log_file);
            exit;
        }

        $path = $DATA_SAVE_ROOT;
        check_or_make_dir($path);

        $path = $path . $device_id . "/";
        check_or_make_dir($path);

        $parent = $path . $path_prefix . "/";
        check_or_make_dir($parent);

        $target_path = $parent . $filename;

        // Check if file already exists. Need to be careful if it does exist,
        // since we want to delete the file on client in this case.
        if (file_exists($target_path)) {
            echo "upload successfully! File already exists.";
            fwrite($log_file, "file already exists.\n");
            fclose($log_file);
            exit;
        }

        if (move_uploaded_file($_FILES[$UPLOAD_FILE_TAG]['tmp_name'], $target_path)) {
            fwrite($log_file, "upload successfully.\n");
            echo "upload successfully!";
        } else {
            fwrite($log_file, "upload failed!\n");
            echo "upload failed!";
        }

        fclose($log_file);

    } else {
        echo "not sure what happened.";
    }

    exit;
