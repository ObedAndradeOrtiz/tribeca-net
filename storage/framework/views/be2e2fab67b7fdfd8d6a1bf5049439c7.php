<div class="">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css">
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <div>

        <div class="ml-3 mr-3" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">

            <style>
                * {

                    padding: 0;
                    box-sizing: border-box;
                }

                .container-x {


                    display: flex;
                    width: 100%;
                    background-color: white;
                    height: 85vh;
                    max-width: 1800px;

                }

                /* Sidebar */
                .sidebar {
                    width: 30%;
                    background-color: #2b3a4a;
                    color: #fff;
                    display: flex;
                    flex-direction: column;
                }

                .sidebar-header {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    padding: 15px 20px;
                    background-color: #2a3942;
                    border-bottom: 1px solid #394c53;
                }

                .sidebar-header h2 {
                    font-size: 1.2rem;
                    font-weight: bold;
                    color: #d1d1d1;
                }

                .add-chat {
                    font-size: 1.8rem;
                    color: #25d366;
                    cursor: pointer;
                }

                .search-bar {
                    padding: 10px 20px;
                    background-color: #2a3942;
                    border-bottom: 1px solid #394c53;
                }

                .search-bar input {
                    width: 100%;
                    padding: 10px 15px;
                    border-radius: 20px;
                    border: none;
                    font-size: 0.9rem;
                    background-color: #394c53;
                    color: #fff;
                    outline: none;
                }

                .chat-list {
                    flex-grow: 1;
                    overflow-y: auto;
                    padding: 10px 0;
                }

                .chat-item {
                    display: flex;
                    align-items: center;
                    padding: 15px 20px;
                    cursor: pointer;
                    transition: background-color 0.2s ease;
                }

                .chat-item:hover {
                    background-color: #394c53;
                }

                .chat-item img {
                    width: 45px;
                    height: 45px;
                    border-radius: 50%;
                    margin-right: 15px;
                }

                .chat-item .chat-details {
                    flex-grow: 1;
                    border-bottom: 1px solid #394c53;
                    padding-bottom: 10px;
                }

                .chat-item .chat-details h3 {
                    font-size: 1rem;
                    font-weight: bold;
                    color: #d1d1d1;
                }

                .chat-item .chat-details p {
                    font-size: 0.85rem;
                    color: #a8a8a8;
                }

                /* Chat Area */
                .chat-area {
                    flex-grow: 1;
                    background-color: #efeae2;
                    display: flex;
                    flex-direction: column;
                }

                .chat-header {
                    background-color: white;
                    padding: 15px 20px;
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    border-bottom: 1px solid #ddd;
                }

                .chat-header h3 {
                    font-size: 1.2rem;
                    font-weight: bold;
                    color: #333;
                }

                .chat-messages {
                    flex-grow: 1;
                    padding: 20px;
                    overflow-y: auto;
                    background: url('https://i.imgur.com/6lZLKH3.png') center/cover;
                }

                .message {
                    margin-bottom: 20px;
                    max-width: 70%;
                    display: inline-block;
                }

                .message.sent {
                    align-self: flex-end;
                    text-align: right;
                }

                .message.received .bubble {
                    background-color: #fff;
                    color: #333;
                }

                .message.sent .bubble {
                    background-color: #d9fdd3;
                    color: #333;
                }

                .message .bubble {
                    padding: 10px 15px;
                    border-radius: 8px;
                    display: inline-block;
                    line-height: 1.4;
                    font-size: 0.9rem;
                    word-wrap: break-word;
                }

                .chat-input {
                    background-color: #f7f7f7;
                    padding: 15px 20px;
                    display: flex;
                    align-items: center;
                    border-top: 1px solid #ddd;
                }

                .chat-input textarea {
                    flex-grow: 1;
                    padding: 10px;
                    border: 1px solid #ccc;
                    border-radius: 20px;
                    resize: none;
                    font-size: 1rem;
                    outline: none;
                    margin-right: 15px;
                }

                .chat-input button {
                    padding: 10px 20px;
                    background-color: #25d366;
                    border: none;
                    border-radius: 20px;
                    color: #fff;
                    font-size: 1rem;
                    cursor: pointer;
                    transition: background-color 0.3s ease;
                }

                .chat-input button:hover {
                    background-color: #1da955;
                }
            </style>
            <style>
                body {
                    margin: 0;
                    font-family: Arial, sans-serif;
                }

                #map {
                    height: 80vh;
                    width: 100%;
                }

                .controls {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    padding: 10px;
                    background: #f4f4f4;
                    border-bottom: 1px solid #ccc;
                }

                .controls input {
                    width: 60%;
                    padding: 5px;
                    border: 1px solid #ccc;
                    border-radius: 4px;
                }
            </style>
            <style>
                .tabs {
                    display: flex;
                    border-bottom: 2px solid #ddd;
                    margin-bottom: 10px;
                }

                .tab-item {
                    flex: 1;
                    text-align: center;
                    padding: 10px 15px;
                    cursor: pointer;
                    font-weight: bold;
                    border-bottom: 2px solid transparent;
                    transition: all 0.3s;
                }

                .tab-item.active {
                    border-bottom: 2px solid #28a745;
                    /* Color verde de Bootstrap */
                    color: #28a745;
                }

                .tab-item:hover {
                    background-color: #f9f9f9;
                }
            </style>

            <div style="display: flex; height:85vh;  ">
                <!-- Sidebar -->
                <div class="sidebar">
                    <div class="sidebar-header">
                        <h2>Mapas</h2>
                        <button class="btn btn-success" wire:click="$set('agregar',true)">Agregar</button>
                    </div>
                    <div class="search-bar">
                        <input type="text" placeholder="Buscar mapa..." wire:model="busqueda">
                    </div>

                    <!-- Tabs -->
                    <div class="tabs">
                        <div class="tab-item <?php echo e($activeTab === 'Pendiente' ? 'active' : ''); ?>"
                            wire:click="$set('activeTab', 'Pendiente')">
                            Pendientes
                        </div>
                        <div class="tab-item <?php echo e($activeTab === 'Finalizado' ? 'active' : ''); ?>"
                            wire:click="$set('activeTab', 'Finalizado')">
                            Finalizados
                        </div>
                    </div>

                    <!-- Content for Tabs -->
                    <div class="chat-list">
                        <?php if($activeTab === 'Pendiente'): ?>
                            <div class="chat-item">
                                <div class="chat-details">
                                    <h3>Mapa 1</h3>
                                    <p>Descripción de un mapa pendiente...</p>
                                </div>
                            </div>
                            <div class="chat-item">
                                <div class="chat-details">
                                    <h3>Mapa 2</h3>
                                    <p>Otro mapa pendiente...</p>
                                </div>
                            </div>
                        <?php elseif($activeTab === 'Finalizado'): ?>
                            <div class="chat-item">
                                <div class="chat-details">
                                    <h3>Mapa 3</h3>
                                    <p>Descripción de un mapa finalizado...</p>
                                </div>
                            </div>
                            <div class="chat-item">
                                <div class="chat-details">
                                    <h3>Mapa 4</h3>
                                    <p>Otro mapa finalizado...</p>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>


                <div class="chat-area verchat" id="mapa">
                    <div class="chat-header">
                        <h3>Nuevo mapa</h3>
                    </div>
                    <div class="chat-messages">
                        <div class="row form-group">
                            <div class="form-group col-md-6">
                                <label class="form-label" for="">Nombre:</label>
                                <input type="text" class="form-control" id="texto"
                                    oninput="convertirAMayusculas()" wire:model="name">
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label" for="exampleInputdate">Fecha de servicio:</label>
                                <input type="date" class="form-control" id="exampleInputdate" value="2000-01-01"
                                    wire:model="fechainicio">
                            </div>
                        </div>
                        <div class="controls">
                            <input type="text" id="search" placeholder="Buscar lugar (e.g., Bolivia)">
                            <button id="searchBtn" class="btn btn-primary">Buscar</button>
                            <button id="selectAreaBtn" class="btn btn-primary">Seleccionar Área</button>
                            <button id="saveAreaBtn" class="btn btn-success">Agregar</button>
                        </div>
                         <?php if($agregar): ?>
                         <div id="map" style="height: 60vh;" ></div>
                         <?php endif; ?>


                    </div>
                </div>


                <script>
        

                    // Lógica para la selección del área
                    let isSelecting = false;
                    let points = []; // Array para las coordenadas seleccionadas
                    let polygon = null; // Polígono en el mapa

                    document.getElementById('selectAreaBtn').addEventListener('click', function() {
                        isSelecting = !isSelecting;
                        this.textContent = isSelecting ? 'Finalizar Selección' : 'Seleccionar Área';

                        if (!isSelecting && points.length > 2) {
                            points.push(points[0]); // Cerrar el polígono
                            polygon = L.polygon(points, {
                                color: 'blue'
                            }).addTo(map);
                        }
                    });

                    map.on('click', function(e) {
                        if (isSelecting) {
                            const latLng = [e.latlng.lat, e.latlng.lng];
                            points.push(latLng);
                            L.circle(latLng, {
                                radius: 5,
                                color: 'black',
                                fillColor: 'black',
                                fillOpacity: 1
                            }).addTo(map);
                        }
                    });

                    // Función de búsqueda
                    document.getElementById('searchBtn').addEventListener('click', function() {
                        const query = document.getElementById('search').value;
                        if (!query) {
                            alert('Por favor, escribe un lugar para buscar.');
                            return;
                        }

                        fetch(
                                `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}`
                            )
                            .then(response => response.json())
                            .then(data => {
                                if (data.length === 0) {
                                    alert('Lugar no encontrado.');
                                    return;
                                }

                                const lat = data[0].lat;
                                const lon = data[0].lon;
                                map.setView([lat, lon], 13);
                            })
                            .catch(error => {
                                console.error('Error al buscar el lugar:', error);
                                alert('Hubo un error al buscar el lugar. Intenta nuevamente.');
                            });
                    });

                    // Guardar área
                    document.getElementById('saveAreaBtn').addEventListener('click', function() {
                        if (points.length > 1) {
                            window.livewire.find('<?php echo e($_instance->id); ?>').set('coordinates', points); // Pasar las coordenadas a Livewire
                            Livewire.emitTo('panel-inicio.ver-panel', 'guardarjson');
                        } else {
                            alert('Debes seleccionar al menos 1 punto antes de guardar.');
                        }
                    });
                </script>
            </div>

        </div>
    </div>

</div>
<?php /**PATH D:\0.APROJECTS\4.HOTEL-ROJAS\1.CODE\public_html\resources\views/livewire/panel-inicio/ver-panel.blade.php ENDPATH**/ ?>