<?php


class encoder
{


    public function __construct()
    {
    }


    public function convert($input, $output, $quality)
    {
        $result = 0;

        $bin = dirname(__FILE__) . "\\encoder\\ffmpeg.exe";

        $comand = "";

        switch ($quality) {
            case "low": {
                    //$comand = " -i " . $input . " -vn -c:a libopus -b:a 16k -ar 16000 -ac 2 -application voip " . $output;
                    $comand = " -i " . $input . " -vn -c:a libopus -b:a 16k -ac 2 -compression_level 10 -frame_duration 60 -application voip " . $output . "_low" . ".ogg";
                    break;
                }

            case "high": {
                    $comand = " -i " . $input . " -vn -ar 44100 -ac 2 -b:a 192k  -acodec libmp3lame -f mp3 " . $output . "_high" . ".mp3";
                    break;
                }
        }

        $arg = $bin . $comand;

        //EJECUTAR
        system($arg, $result);

        return $result;
    }
}
