<?php

use CoreDB\Kernel\BaseController;
use CoreDB\Kernel\Database\MySQL\MySQLDriver;
use CoreDB\Kernel\DatabaseDriver;
use CoreDB\Kernel\Messenger;
use CoreDB\Kernel\Router;

class CoreDB
{
    const ENCRYPTION_METHOD = "aes128";

    public static function get_current_date()
    {
        return date("Y-m-d H:i:s");
    }

    public static function HTMLMail($email, $subject, $message, $username)
    {
        $mail = new \PHPMailer\PHPMailer\PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = SMTP_SECURE;
        $mail->Host = SMTP_HOST;
        $mail->Port = SMTP_PORT;
        $mail->IsHTML(true);
        $mail->SetLanguage("en", "phpmailer/language");
        $mail->CharSet  = "utf-8";
        $mail->Username = EMAIL;
        $mail->Password = EMAIL_PASSWORD;
        $mail->SetFrom(EMAIL, EMAIL_USERNAME);
        $mail->AddAddress($email, $username);
        $mail->Subject = $subject;
        $mail->Body = $message;
        return $mail->Send();
    }

    public static function normalizeFiles(array $files = null)
    {
        if (!$files) {
            $files = $_FILES;
        }
        $normalized_files = [];
        if (empty($files) || (isset($files["name"]) && !is_array($files["name"]))) {
            $normalized_files = $files;
        } elseif (!isset($files["name"])) {
            foreach ($files as $key => $file) {
                $normalized_files[$key] = self::normalizeFiles($file);
            }
        } else {
            foreach ($files["name"] as $key => $name) {
                $normalized_files[$key] = [
                    "name" => $name,
                    "type" => $files["type"][$key],
                    "tmp_name" => $files["tmp_name"][$key],
                    "error" => $files["error"][$key],
                    "size" => $files["size"][$key]
                ];
            }
        }
        return $normalized_files;
    }

    public static function goTo(string $uri)
    {
        header("Location: $uri");
        die();
    }

    public static function requestUrl()
    {
        return $_SERVER["REDIRECT_URL"];
    }

    public static function storeUploadedFile($table, $field_name, $file)
    {
        if ($file["error"]) {
            return false;
        }
        $file_url = getcwd()."/files/uploaded/$table/$field_name/";
        is_dir($file_url) ?: mkdir($file_url, 0777, true);
        $file_url .= $file["name"];
        return move_uploaded_file($file["tmp_name"], $file_url);
    }

    public static function removeUploadedFile($table, $field_name, $file)
    {
        $file_url = getcwd()."/files/uploaded/$table/$field_name/$file";
        if (is_file($file_url)) {
            unlink($file_url);
        }
    }

    public static function cleanXSS($data)
    {
        if ($data == strip_tags($data)) {
            // is HTML
            //If not html then no need to sanitize
            return $data;
        }
        $data = htmlspecialchars_decode($data);
        $dom = new DOMDocument();
        @$dom->loadHTML(mb_convert_encoding($data, 'HTML-ENTITIES', 'UTF-8'));
        $elements = $dom->getElementsByTagName('*');
        foreach ($elements as $element) {
            $allowed_attributes = ["class", "style"];
            if ($element->tagName == "a") {
                $element->setAttribute('href', htmlspecialchars($element->getAttribute('href')));
                $allowed_attributes[] = "href";
                $allowed_attributes[] = "target";
            } elseif ($element->tagName == "img") {
                $element->setAttribute('src', htmlspecialchars($element->getAttribute('src')));
                $allowed_attributes[] = "src";
            }
            foreach ($element->attributes as $attribute) {
                if (in_array($attribute->name, $allowed_attributes)) {
                    continue;
                } else {
                    $element->removeAttribute($attribute->name);
                }
            }
        }
        // we are done...
        return strip_tags($dom->saveHTML(), "<table><thead><tbody><tr><td><label><strong><p><em><i><u><ul><li><a><img><blockquote><span><pre><code><br><h1><h2><h3><h4><h5><h6><div>");
    }

    public static function baseHost()
    {
        $trusted_hosts = explode(",", TRUSTED_HOSTS);
        if (!in_array($_SERVER["HTTP_HOST"], $trusted_hosts)) {
            return $trusted_hosts[0];
        } else {
            return $_SERVER["HTTP_HOST"];
        }
    }


    public static function database() : DatabaseDriver{
        return MySQLDriver::getInstance();
    }

    /**
     * Returns Messenger Instance
     * @return Messenger
     *  Messenger Instance
     */
    public static function messenger() : Messenger{
        return Messenger::getInstance();
    }

    /**
     * Returns active controller
     * @return BaseController
     * Active Controller
     */
    public static function controller() : BaseController{
        return Router::getInstance()->getController();
    }
}
