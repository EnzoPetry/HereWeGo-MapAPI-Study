<?php
    if (isset($_SERVER['HTTP_APIKEY'])) {
        $apiKey = $_SERVER['HTTP_APIKEY'];

    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['logradouro']) && isset($_GET['numero']) && isset($_GET['pais']) && isset($_GET['estado']) && isset($_GET['cidade'])) {
        $logradouro = $_GET["logradouro"];
        $numero = $_GET["numero"];
        $pais = $_GET["pais"];
        $estado = $_GET["estado"];
        $cidade = $_GET["cidade"];

        $address_query = urlencode($logradouro. "+".$numero. "+".$pais. "+".$estado. "+".$cidade);
        $url = "https://geocode.search.hereapi.com/v1/geocode?q=".$address_query. "&apiKey=".$apiKey;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $resp = curl_exec($ch);

        if ($e = curl_error($ch)) {
        echo json_encode(array('error' => $e));
        } else {
            $decoded = json_decode($resp);
            // Verifique se a resposta foi bem-sucedida e se há uma localização disponível
            if ($decoded && isset($decoded -> items) && count($decoded -> items) > 0) {
                // Obtenha a latitude e a longitude da primeira localização
                $lat = $decoded -> items[0] -> position -> lat;
                $lng = $decoded -> items[0] -> position -> lng;
                echo json_encode(array('lat' => $lat, 'lng' => $lng));
            } else {
            echo json_encode(array('error' => 'Nenhuma localização encontrada.'));
            }
        }
        curl_close($ch);
        }
    }else{
        echo json_encode(array('error' => 'Chave de API não fornecida.'));
    }
    
?>