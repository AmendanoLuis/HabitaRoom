// mapUtils.js
let mapInstance = null;

export function obtenerUbicacionUsuario(defaultCenter = [40.4168, -3.7038]) {
  return new Promise((resolve) => {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(
        (pos) => resolve([pos.coords.latitude, pos.coords.longitude]),
        () => resolve(defaultCenter),
        { timeout: 100 }
      );
    } else {
      resolve(defaultCenter);
    }
  });
}

export function iniciarMapa({ containerId = 'mapLeaflet', center = [37.1637, -3.5841], zoom = 13 } = {}) {
  const container = document.getElementById(containerId);
  if (!container) throw new Error(`Contenedor de mapa no encontrado: #${containerId}`);
  container.style.display = '';

  const map = L.map(containerId).setView(center, zoom);

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors',
    maxZoom: 19
  }).addTo(map);

  return map;
}

export async function obtenerMapaConGeolocalizacion({ containerId = 'mapLeaflet', defaultCenter = [40.4168, -3.7038], zoom = 13 } = {}) {
  if (mapInstance) {
    mapInstance.invalidateSize();
    return mapInstance;
  }

  const coords = await obtenerUbicacionUsuario(defaultCenter);
  mapInstance = iniciarMapa({ containerId, center: coords, zoom });
  return mapInstance;
}
