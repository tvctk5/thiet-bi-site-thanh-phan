<?php
    // $file = fopen("upgrade/my-zip.zip", "w+");
    // if (flock($file, LOCK_EX)) {
    //     fwrite($file, fopen("http://localhost:8080/thiet-bi-site-tong/download/test-download.zip", 'r'));
    //     $zip = new ZipArchive;
    //     $res = $zip->open('my-zip.zip');
    //     if ($res === TRUE) {
    //       $zip->extractTo('upgrade/extract-here');
    //       $zip->close();
    //       //
    //     } else {
    //       echo "Can't open zip file";
    //     }
    //     flock($file, LOCK_UN);
    // } else {
    //     echo "Couldn't download the zip file.";
    // }
    // fclose($file);

    // $url = "http://localhost:8080/thiet-bi-site-tong/download/test-download.zip";
    $url = "https://s3-us-west-1.amazonaws.com/dev-veritone-media-test/tempfile.zip";
    $zip_file = "upgrade/downloadfile.zip";

    $zip_resource = fopen($zip_file, "w");

    $ch_start = curl_init();
    curl_setopt($ch_start, CURLOPT_URL, $url);
    curl_setopt($ch_start, CURLOPT_FAILONERROR, true);
    curl_setopt($ch_start, CURLOPT_HEADER, 0);
    curl_setopt($ch_start, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch_start, CURLOPT_AUTOREFERER, true);
    curl_setopt($ch_start, CURLOPT_BINARYTRANSFER,true);
    curl_setopt($ch_start, CURLOPT_TIMEOUT, 1000000);
    curl_setopt($ch_start, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch_start, CURLOPT_SSL_VERIFYPEER, 0); 
    curl_setopt($ch_start, CURLOPT_FILE, $zip_resource);
    $page = curl_exec($ch_start);
    if(!$page)
    {
    echo "Error :- ".curl_error($ch_start);
    }
    curl_close($ch_start);

    $zip = new ZipArchive;
    $extractPath = "upgrade/extract";
    if($zip->open($zipFile) != "true")
    {
    echo "Error :- Unable to open the Zip File";
    } 

    $zip->extractTo($extractPath);
    $zip->close();
?>