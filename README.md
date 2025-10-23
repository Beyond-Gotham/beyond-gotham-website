# Beyond_Gotham

Moderne, dunkle Nachrichtenagentur-Website (**WordPress**) mit **InfoTerminal**-Demo (**React/TypeScript**).
Dieses Repo bündelt:
- `wordpress/` (Child-Theme, künftige WP-Erweiterungen)
- `app-demo-infoterminal/` (Vite-App, statischer Build unter `/infoterminal/demo/`)
- `webroot/` (statische Assets für IONOS, inkl. Demo-Build)
- `services/` (spätere APIs: FastAPI/Spring; laufen **nicht** auf Shared Hosting)
- `.github/workflows/` (SFTP-Deploy zu IONOS)

## Quickstart (lokal)
```bash
chmod +x scripts/bootstrap_repo.sh
./scripts/bootstrap_repo.sh

cp .env.example .env
# … Werte später anpassen (für VPS-Stack)

# React-Demo lokal:
cd app-demo-infoterminal
npm ci
npm run dev
# build:
npm run build  # Output: app-demo-infoterminal/dist/
