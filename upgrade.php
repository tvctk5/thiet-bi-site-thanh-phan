<?php

    function WriteLog($log){
        echo "<div>" . $log . "</div>";
    }

    function CreateFolder($dst){
        if (!file_exists($dst)) {
            if(mkdir($dst, 0777, true)){
                echo '<div>Created Dir: ' . $dst . '</div>';
                return true;
            } else {
                $error = error_get_last();
                echo '<div>Fail to create dir: ' . $dst . '; Error: ' . $error['message'] . '</div>';
                return false;
            }
        }
    }

    function DeleteFolder($dir){
        $src = opendir($dir);
        while(false !== ( $file = readdir($src)) ) {
            if (( $file == '.' ) || ( $file == '..' )) {
                continue;
            }

            $newPath = $dir . '/' . $file;
            WriteLog("[DELETING] newPath: ". $newPath);
            if ( is_dir($newPath) ) {
                DeleteFolder($newPath);
            }
            else {
                // unset($newPath);
                unlink($newPath); 
            }
        }

        closedir($src);
        rmdir($dir);

        return true;
    }



    function copy_directory($src,$dst, $ignoreList) {
        $dir = opendir($src);
        // Create
        CreateFolder($dst);
        
        while(false !== ( $file = readdir($dir)) ) {
            if (( $file != '.' ) && ( $file != '..' )) {
                if ( is_dir($src . '/' . $file) ) {
                    if(!isIgnoreData($ignoreList, $file)){
                        echo '<div>Dir: ' . $src . '/' . $file . '</div>';
                        copy_directory($src . '/' . $file,$dst . '/' . $file, $ignoreList);
                    } else {
                        echo '<div>IGNORE Dir: ' . $src . '/' . $file . '</div>';
                    }
                }
                else {
                    if(!isIgnoreData($ignoreList, $file)){
                        echo '<div>File: ' . $src . '/' . $file. '</div>';
                        if (!copy($src . '/' . $file,$dst . '/' . $file)) {
                            $error = error_get_last();
                            WriteLog('FAILED to copy: '. $src . '/' . $file .' to ' . $dst . '/' . $file. '; Error: '. $error['message']);
                        }
                    } else {
                        echo '<div>IGNORE File: ' . $src . '/' . $file . '</div>';
                    }
                }
            }
        }
        closedir($dir);
    }
    
    function isIgnoreData($list, $dataToCheck){
        if(sizeof($list) <= 0){
            return false;
        }
        foreach ($list as $value) {
            if(trim($value) == $dataToCheck){
                return true;
            }
        }
    
        return false;
    }

    // $url = "http://localhost:8080/thiet-bi-site-tong/download/test-download.zip";
    // $url = "https://s3-us-west-1.amazonaws.com/dev-veritone-media-test/tempfile.zip";
    // $url = "https://s3-us-west-1.amazonaws.com/dev-veritone-media-test/testzipfile.zip";
    
    $versionId= $_REQUEST["versionid"];
    $version= $_REQUEST["version"];
    $hostid= $_REQUEST["hostid"];
    $url= $_REQUEST["fileupgrade"];
    $localpath = $_REQUEST["localpath"];
    // $url = "https://s3-us-west-1.amazonaws.com/dev-veritone-media-test/testzipfile2.zip";
    
    $zip_file = "upgrade/downloadfile.zip";
    $upgradePath = "upgrade";
    $extractPath = "upgrade/extract";
    $originPath = $localpath; //"/var/www/download";

    $zip_file = $originPath . '/' . $zip_file;
    $upgradePath_FullPath = $originPath . '/' . $upgradePath;
    $extractPath_FullPath = $originPath . '/' . $extractPath;
    $ignoreFilePath = $extractPath_FullPath . '/ignore.txt';

    // Create
    // CreateFolder($originPath . '/' . $upgradePath);
    CreateFolder($upgradePath_FullPath);
    CreateFolder($extractPath_FullPath);

    WriteLog('Create File to download.');
    $zip_resource = fopen($zip_file, "w+");

    WriteLog('Downloading...');
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
    WriteLog('$page = curl_exec($ch_start);....');
    if(!$page)
    {
        WriteLog("Error :- " . curl_error($ch_start));
        
        fclose($zip_resource);
        curl_close($ch_start);
        return;
    }

    WriteLog('curl_close($ch_start);');
    
    //fclose($zip_resource);
    //fclose($zip_resource);
    curl_close($ch_start);

    fclose($zip_resource);
    // $zip_resource->close();

    WriteLog('Downloaded');
    WriteLog('Extracting...');
    if(!file_exists($zip_file)){
        WriteLog('The file does not exists');
        return;
    } 
    
    $zip = new ZipArchive;
    if ($zip->open($zip_file) === TRUE) {
        $zip->extractTo($extractPath);
        $zip->close();
        WriteLog('Extract done at: ' . $extractPath);
    } else {
        WriteLog('Extract failed');
        return;
    }

    $ignoreList = array("upgrade.php", "files");
    // Read ignore file
    if(!file_exists($ignoreFilePath)){
        WriteLog('The ignore file does not exists');
        // default
        WriteLog('Defailt ignore value: upgrade.php');
    } else {
        $ignore_content = file_get_contents($ignoreFilePath);
        WriteLog("Ignore_content: " . $ignore_content);
        $ignoreList = explode(",", $ignore_content);
    }

    WriteLog("Size of ignoreList: " . sizeof($ignoreList));

    // Copy file
    WriteLog("Copying to: " . $originPath);
    copy_directory($extractPath_FullPath, $originPath, $ignoreList);
    WriteLog("Copy done");

    // Delete file
    if(DeleteFolder($upgradePath_FullPath)){
        WriteLog('Xóa thành công thư mục: ' . $upgradePath_FullPath);
    } else {
        WriteLog('Xóa thất bại thư mục: ' . $upgradePath_FullPath);
    }
    
    include 'sql/sql-function.php';

    $conn = ConnectDatabse();

    // Cập nhật DB
    $sql = "UPDATE `host` SET versionId= $versionId, version ='$version', last_upgrade=SYSDATE() WHERE id=$hostid;";
            
    $result = mysqli_query($conn, $sql) or die("error to update host version; SQL: ". $sql . "; ERROR: " . $conn->error);

    WriteLog('SQL: ' . $sql);

    CloseDatabase($conn);
?>
