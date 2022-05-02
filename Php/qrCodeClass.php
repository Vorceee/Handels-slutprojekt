<?php
class SaveQrCode
{

    //URL OF GOOGLE CHART API
    private $apiUrl = 'http://chart.apis.google.com/chart';
    // DATA TO CREATE QR CODE
    private $data;




    // Function which is used to generate the URL type of QR Code.
    public function URL($url = null)
    {
        $this->data = preg_match("#^https?\:\/\/#", $url) ? $url :    "http://{$url}";
    }



    //Function which is used to save the qrcode image file.
    public function QRCODE($size = 400, $filename = null)
    {

        $location = 'qrcodes/';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->apiUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "chs={$size}x{$size}&cht=qr&chl=" . urlencode($this->data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        $img = curl_exec($ch);
        curl_close($ch);
        // creates the qrcode image

        if ($img) {
            if ($filename) { //checks if the file name has png in it
                if (!preg_match("#\.png$#i", $filename)) {
                    $filename .= ".png";
                }
                $filename = $location . $filename;
                return file_put_contents($filename, $img); // saves the qrcode
            } else { //displays the qrcode if no filename
                header("Content-type: image/png");
                print $img;
                return true;
            }
        }
        return null;
    }
}
