<!DOCTYPE html>
<html>

<head>
    <title>Formulário de Envio</title>
    <meta name="viewport" content="initial-scale=1.0, width=device-width" />
    <script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-core.js"></script>
    <script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-service.js"></script>
    <script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-mapevents.js"></script>
    <script type="text/javascript" charset="utf-8" src="https://js.api.here.com/v3/3.1/mapsjs-ui.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script type="text/javascript" src="apikey.js"></script>
    <link rel="stylesheet" type="text/css" href="https://js.api.here.com/v3/3.1/mapsjs-ui.css" />
    <link rel="stylesheet" type="text/css" href="stylesheet.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

</head>

<body>
    <div class="container border border-secondary rounded">
        <div class="row">
            <div class="col-md-6">
                <h2>Formulário de Envio</h2>
                <form action="" method="get" class="form-container">
                    <div class="form-group">
                        <label for="logradouro">Logradouro:</label>
                        <input type="text" class="form-control" id="logradouro" name="logradouro" required>
                    </div>
                    <div class="form-group">
                        <label for="numero">Número:</label>
                        <input type="text" class="form-control" id="numero" name="numero" required>
                    </div>
                    <div class="form-group">
                        <label for="pais">País:</label>
                        <input type="text" class="form-control" id="pais" name="pais" required>
                    </div>
                    <div class="form-group">
                        <label for="estado">Estado:</label>
                        <input type="text" class="form-control" id="estado" name="estado" required>
                    </div>
                    <div class="form-group">
                        <label for="cidade">Cidade:</label>
                        <input type="text" class="form-control" id="cidade" name="cidade" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </form>
            </div>
            <div class="col-md-6 align-self-center">
                <div id="mapContainer"></div>
            </div>
        </div>
    </div>

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
            var ui = H.ui.UI.createDefault(map, defaultLayers,);
            var marker = new H.map.Marker({ lat: lat, lng: lng });
            map.addObject(marker);
        }
    <?php 
        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['logradouro']) && isset($_GET['numero']) && isset($_GET['pais']) && isset($_GET['estado']) && isset($_GET['cidade'])) {
            $logradouro = $_GET["logradouro"];
            $numero = $_GET["numero"];
            $pais = $_GET["pais"];
            $estado = $_GET["estado"];
            $cidade = $_GET["cidade"];

            $address_query = urlencode($logradouro. "+".$numero. "+".$pais. "+".$estado. "+".$cidade);
            $url = "https://geocode.search.hereapi.com/v1/geocode?q=".$address_query. "&apiKey=_c7yqpPQS6wTXt9slP7pd5pg00WA5Dm1iPCOnqOm3N8";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $resp = curl_exec($ch);

            if ($e = curl_error($ch)) {
            echo $e;
            } else {
                $decoded = json_decode($resp);
                // Verifique se a resposta foi bem-sucedida e se há uma localização disponível
                if ($decoded && isset($decoded -> items) && count($decoded -> items) > 0) {
                    // Obtenha a latitude e a longitude da primeira localização
                    $lat = $decoded -> items[0] -> position -> lat;
                    $lng = $decoded -> items[0] -> position -> lng;
                echo "loadMap($lat, $lng);";
                } else {
                echo "console.log('Nenhuma localização encontrada.');";
                }
            }

            curl_close($ch);
        }
    ?>
    </script>

</body>

</html>