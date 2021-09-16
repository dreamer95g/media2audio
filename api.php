
<?php

class api
{


  public function __construct()
  {
  }

  public function exist($source)
  {
    if (file_exists($source)) {
      return true;
    }
    return false;
  }

  public function getOnlyName($file)
  {

    $file = str_replace(" ", "_", $file);
    //$file = str_replace("&", "_", $file);
    //$file = str_replace("(", "_", $file);
    //$file = str_replace(")", "_", $file);

    $name = "";

    for ($i = 0; $i < strlen($file); $i++) {
      $w = $file[$i];
      if ($w !== ".") {
        $name .= $w;
      } else {
        break;
      }
    }
    return $name;
  }

  public function replaceSpecialCharacters($name)
  {
    $new_name = str_replace(" ", "_", $name);
    //$new_name = str_replace("&", "_", $name);
    //$new_name = str_replace("(", "_", $name);
    //$new_name = str_replace(")", "_", $name);

    rename($name, $new_name);

    return $new_name;
  }

  public function createTxtFileWithContent($name, $content)
  {

    if (!file_exists($name)) {

      $file = fopen($name, 'a');

      fputs($file, $content);

      fclose($file);
    } else {
      unlink($name);

      $file = fopen($name, 'a');

      fputs($file, $content);

      fclose($file);
    }

    return $name;
  }
}
