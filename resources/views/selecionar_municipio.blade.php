<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <title>IBGE</title>
</head>
<body>
    <div id="container">  
        <h1>Buscar IBGE</h1>

        <div>
            <label for="estado">Estado:</label>
            <select name="estado" id="estado">
                <option value="">Selecione um estado</option>
                @foreach ($estados as $estado)
                    <option value="{{ $estado->id }}">{{ $estado->nome }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="municipio">Município:</label>
            <select name="municipio" id="municipio" size="1" disabled>
                <option value="">Selecione um estado primeiro</option>
            </select>
        </div>

        <div>
            <label for="ibge">IBGE:</label>
            <span id="municipio-ibge">Selecione um município primeiro</span>
    </div>
    </div>
    <script>
        const estadoSelect = document.getElementById('estado');
        const municipioSelect = document.getElementById('municipio');
        const municipioIbgeSpan = document.getElementById('municipio-ibge');
    
        estadoSelect.addEventListener('change', function () {
            const estadoId = estadoSelect.value;
    
            fetch(`/get-municipios?estado_id=${estadoId}`)
                .then(response => response.json())
                .then(municipios => {
                    municipioSelect.innerHTML = '<option value="">Selecione um município</option>';
                    municipios.forEach(municipio => {
                        municipioSelect.innerHTML += `<option value="${municipio.id}" data-ibge="${municipio.ibge}" data-uf="${municipio.uf}">${municipio.nome}</option>`;
                    });
    
                    municipioSelect.disabled = false;
                })
                .catch(error => console.error('Erro ao buscar municípios', error));
        });
    
        municipioSelect.addEventListener('change', function () {
            const selectedOption = municipioSelect.options[municipioSelect.selectedIndex];
            const uf = selectedOption.getAttribute('data-uf');
            const nomeMunicipio = selectedOption.text;
            const ibge = selectedOption.getAttribute('data-ibge');
            municipioIbgeSpan.textContent = ibge ? `${ibge} - ${nomeMunicipio} / ${uf}` : 'Selecione um município primeiro';
        });
    </script>
</body>
</html>
