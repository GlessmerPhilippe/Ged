https://console.cloud.google.com/storage/browser/ged-glessmer;tab=objects?inv=1&invt=Ab21Gg&project=gedglessmer&prefix=&forceOnObjectsSortingFiltering=false


docker-compose -f docker-compose.yml -f docker-compose.override.dev.yml up -d --build

docker-compose -f docker-compose.yml -f docker-compose.override.perf.yml up -d --build


docker exec -it symfony_app bash