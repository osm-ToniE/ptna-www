# Public Transport Network Analysis Website

This repository contains the website ([ptna.openstreetmap.de](https://ptna.openstreetmap.de)) for **PTNA**, a tool that provides a daily analysis of public transport lines mapped in [OpenStreetMap](https://www.openstreetmap.org). It checks route and route_master relations (train, subway, tram, bus, ferry, etc.) for selected areas and networks against the [Public Transport schema](https://wiki.openstreetmap.org/wiki/Public_Transport) and reports inconsistencies, errors and statistics.

## Features

For each configured network/area, PTNA produces:

- **Analysis reports** listing errors and warnings found in route/route_master relations (e.g. wrong order of stops, missing stops or platforms, gaps in the route line, roundtrip issues), plus overall statistics about the network.
- **Route catalogs** listing every route relation in the network with links back to OSM and to its individual analysis.
- **Diffs between analysis runs**, so changes made in OSM since the previous run are visible at a glance.
- **GTFS comparisons** ([`gtfs/`](gtfs), [`script/gtfs*.php`](script), [`api/gtfs.php`](api/gtfs.php)) that match OSM route relations against GTFS feeds to spot missing or mismatched trips/stops.
- An interactive **relation viewer** with a map ([`relation.php`](relation.php), [`script/relation.js`](script/relation.js)) built on [Leaflet](https://leafletjs.com/).

All of this is published per country/network under [`results/`](results).

## Quick start

This is a PHP-based website. To run it locally you need a PHP-enabled web server, e.g.:

```sh
php -S localhost:8000
```

Then open `http://localhost:8000/` in your browser.
