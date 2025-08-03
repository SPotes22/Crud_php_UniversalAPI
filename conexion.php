<?php
function llamarAPI($ruta, $metodo = "GET", $datos = null) {
    $url = "http://localhost:5000/transacciones" . $ruta;
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $metodo);

    if ($datos !== null) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($datos));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    }

    $respuesta = curl_exec($ch);
    curl_close($ch);

    return json_decode($respuesta, true);
}
?>
