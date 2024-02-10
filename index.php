<!DOCTYPE html>
<html>
<head>
    <title>Formulário de Envio</title>
    <meta name="viewport" content="initial-scale=1.0, width=device-width" />
    <script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-core.js"></script>
    <script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-service.js"></script>
    <script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-mapevents.js"></script>
    <script type="text/javascript" charset="utf-8" src="https://js.api.here.com/v3/3.1/mapsjs-ui.js" ></script>
    <script type="text/javascript" src="apikey.js"></script>
    <link rel="stylesheet" type="text/css" href="https://js.api.here.com/v3/3.1/mapsjs-ui.css" />
</head>
<body>
<h2>Formulário de Envio</h2>

<form action="" method="get">
    <label for="logradouro">Logradouro:</label><br>
    <input type="text" id="logradouro" name="logradouro"><br><br>
    
    <label for="numero">Número:</label><br>
    <input type="text" id="numero" name="numero"><br><br>
    
    <label for="pais">País:</label><br>
    <input type="text" id="pais" name="pais"><br><br>
    
    <label for="estado">Estado:</label><br>
    <input type="text" id="estado" name="estado"><br><br>
    
    <label for="cidade">Cidade:</label><br>
    <input type="text" id="cidade" name="cidade"><br><br>
    
    <input type="submit" value="Enviar">
</form>

<div style="width: 640px; height: 480px" id="mapContainer"></div>

<script>
function loadMap(lat, lng) {
    var platform = new H.service.Platform({
        'apikey': API_KEY
    });

    var defaultLayers = platform.createDefaultLayers();

    var map = new H.Map(
        document.getElementById('mapContainer'),
        defaultLayers.vector.normal.map,
        {
            zoom: 15,
            center: {
                lat: lat,
                lng: lng
            }
        });
    const behavior = new H.mapevents.Behavior(new H.mapevents.MapEvents(map));
    window.addEventListener('resize', () => map.getViewPort().resize());
    var ui = H.ui.UI.createDefault(map, defaultLayers, );
    var marker = new H.map.Marker({lat: lat, lng: lng});
    map.addObject(marker);
}

document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM is ready');
    <?php 
    if ($_SERVER["REQUEST_METHOD"] == "GET"  && isset($_GET['logradouro']) && isset($_GET['numero']) && isset($_GET['pais']) && isset($_GET['estado']) && isset($_GET['cidade'])) {
        $logradouro = $_GET["logradouro"];
        $numero = $_GET["numero"];
        $pais = $_GET["pais"];
        $estado = $_GET["estado"];
        $cidade = $_GET["cidade"];

        $address_query = urlencode($logradouro . "+" . $numero . "+" . $pais . "+" . $estado . "+" . $cidade);
        $url = "https://geocode.search.hereapi.com/v1/geocode?q=" . $address_query . "&apiKey=_c7yqpPQS6wTXt9slP7pd5pg00WA5Dm1iPCOnqOm3N8";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,  $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,  true);
        $resp = curl_exec($ch);

        if ($e = curl_error($ch)) {
            echo $e;
        } else {
            $decoded = json_decode($resp);
            // Verifique se a resposta foi bem-sucedida e se há uma localização disponível
            if ($decoded && isset($decoded->items) && count($decoded->items) > 0) {
                // Obtenha a latitude e a longitude da primeira localização
                $lat = $decoded->items[0]->position->lat;
                $lng = $decoded->items[0]->position->lng;
                echo "loadMap($lat, $lng);";
            } else {
                echo "console.log('Nenhuma localização encontrada.');";
            }
        }

        curl_close($ch);
    }
    ?>
});
</script>

</body>
</html>
