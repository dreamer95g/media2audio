<?php

// PARA PODER ENTRAR DE LOS NAVEGADORES
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, X-Auth-Token, Origin, Authorization');
header("Content-Type: application/json");

require_once("encoder.php");
require_once("api.php");

$encoder_api = new encoder();
$api = new api();

$source = $_POST["source"];
$quality = $_POST["quality"];

try {

  if ($api->exist($source)) {

    $global = -1;

    // OBTENER LOS ARCHIVOS DEL DIRECTORIO
    $files = scandir($source);

    //COMPROBAR QUE EL DIRECTORIO NO ESTE VACIO
    $empty = count($files);

    if ($empty !== 2) {

      for ($i = 2; $i <= count($files) - 1; $i++) {

        $name =  $files[$i];

        $toRename = $source . "\\" . $name;

        // CREAR FUNCION QUE ME RENOMBRE EL FICHERO Y ME QUITE LOS ESPACIOS
        $newName = $api->replaceSpecialCharacters($toRename);

        $onlyName = $api->getOnlyName($name);

        $input =  $newName;

        $output = $source . "\\" . $onlyName;

        if ($quality === "high") {
          $check = $output . "_high" . ".mp3";
        } else {
          $check = $output . "_low" . ".ogg";
        }

        if (!$api->exist($check)) {

          $result = $encoder_api->convert($input, $output, $quality);

          if ($result == "1") {
            echo " Some error!";
            break;
          } else {
            $global = $result;
          }
        } else {
          echo " Already exist: " . $check;
          break;
        }
      }
      if ($global == 0) {
        echo " All Ok! ";
      }
    } else {
      echo " Directory is empty ";
    }
  } else {
    echo " Don't exist: " . $source;
  }
} catch (Exception $e) {
  echo " Exception: " . $e->getMessage();
}
