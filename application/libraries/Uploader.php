<?php

class Uploader {

    private static $_fileName;
    
    public function pl_upload($directory)
    {
        $data = $this->_process($directory);
        echo json_encode($data);
        die;
    }
    
    public function upload($directory)
    {
        $data = $this->_process($directory);
        return $data;
    }

    private static function _process($directory)
    {
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");

          // Support CORS
          header("Access-Control-Allow-Origin: *");
          // other CORS headers if any...
          if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
          exit; // finish preflight CORS requests here
          }

        // 5 minutes execution time
        @set_time_limit(5 * 60);

        // Uncomment this one to fake upload time
        // usleep(5000);
        // Settings
        $targetDir = $directory;
        $cleanupTargetDir = true; // Remove old files
        $maxFileAge = 5 * 3600; // Temp file age in seconds

        self::_create_directory($directory);
        $filePath = self::_file_path($targetDir);
        // Remove old temp files	
        if ($cleanupTargetDir)
        {
            self::_dir_clean_up($targetDir, $filePath, $maxFileAge);
        }

        // Chunking might be enabled
        $chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
        $chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;


        // Open temp file
        $out = self::_get_output_file($filePath, $chunks);

        $in = self::_get_input_file();

        while ($buff = fread($in, 4096))
        {
            fwrite($out, $buff);
        }

        @fclose($out);
        @fclose($in);

        // Check if file has been uploaded
        if (!$chunks || $chunk == $chunks - 1)
        {
            // Strip the temp .part suffix off 
            rename("{$filePath}.part", $filePath);
        }

        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : "";
        $data['params'] = $_REQUEST;
        $data['filename'] = self::$_fileName;

        return $data;
    }

    private static function _create_directory($targetDir)
    {
        // Create target dir
        if (!file_exists($targetDir))
        {
            // temporary set to full access
            @mkdir($targetDir);
        }
    }

    private static function _file_path($targetDir)
    {
        // Get a file name
        if (isset($_REQUEST["name"]))
        {
            $fileName = $_REQUEST["name"];
        }
        elseif (!empty($_FILES))
        {
            $fileName = $_FILES["file"]["name"];
        }
        else
        {
            $fileName = uniqid("file_");
        }

        self::$_fileName = $fileName;

        $filePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;

        return $filePath;
    }

    private static function _dir_clean_up($targetDir, $filePath, $maxFileAge)
    {
        if (!is_dir($targetDir) || !$dir = opendir($targetDir))
        {
            die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
        }

        while (($file = readdir($dir)) !== false)
        {
            $tmpfilePath = $targetDir . DIRECTORY_SEPARATOR . $file;

            // If temp file is current file proceed to the next
            if ($tmpfilePath == "{$filePath}.part")
            {
                continue;
            }

            // Remove temp file if it is older than the max age and is not the current file
            if (preg_match('/\.part$/', $file) && (filemtime($tmpfilePath) < time() - $maxFileAge))
            {
                @unlink($tmpfilePath);
            }
        }
        closedir($dir);
    }

    private static function _get_input_file()
    {
        if (!empty($_FILES))
        {
            if ($_FILES["file"]["error"] || !is_uploaded_file($_FILES["file"]["tmp_name"]))
            {
                die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
            }

            // Read binary input stream and append it to temp file
            if (!$in = @fopen($_FILES["file"]["tmp_name"], "rb"))
            {
                die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
            }
        }
        else
        {
            if (!$in = @fopen("php://input", "rb"))
            {
                die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
            }
        }

        return $in;
    }

    private static function _get_output_file($filePath, $chunks)
    {
        if (!$out = @fopen("{$filePath}.part", $chunks ? "ab" : "wb"))
        {
            die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
        }

        return $out;
    }

    public static function crop_image($post)
    {

        if (isset($post))
        {
            $user_id = $post['user_id'];
            $crop_dir = DOCROOT . 'uploads/profile-' . $user_id . "/thumbs/";

            if (!file_exists($crop_dir))
            {
                @mkdir($crop_dir);
            }

            $targ_w = $targ_h = 200;
            $jpeg_quality = 100;

            $src = DOCROOT . $post["src"];
            $img_r = imagecreatefromjpeg($src);
            $dst_r = ImageCreateTrueColor($targ_w, $targ_h);

            imagecopyresampled($dst_r, $img_r, 0, 0, $_POST['x'], $_POST['y'], $targ_w, $targ_h, $_POST['w'], $_POST['h']);
            $thumb_name = strtolower(Text::random('alnum', 20)) . '_crop.jpg';
            imagejpeg($dst_r, $crop_dir . $thumb_name, $jpeg_quality);

            //$user = ORM::factory("user", $user_id);
            //$user->thumb_pic = $thumb_name;
            //$user->update();

            $data['src'] = '/uploads/profile-' . $user_id . "/thumbs/" . $thumb_name;
            echo json_encode($data);
            exit;
        }
    }

}
