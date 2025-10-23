#!/usr/bin/env bash
set -euo pipefail

log()   { printf '[%s] %s\n' "$(date +%H:%M:%S)" "$*"; }
skip()  { printf '[skip] %s (existiert)\n' "$1"; }
newf()  { printf '[new ] %s\n' "$1"; }

# Datei aus STDIN erzeugen, falls sie noch nicht existiert
create_file() {
  local path="$1"
  if [[ -e "$path" ]]; then skip "$path"; return 0; fi
  mkdir -p "$(dirname "$path")"
  cat > "$path"
  newf "$path"
}

# Leere Datei anlegen (ohne STDIN)
touch_file() {
  local path="$1"
  if [[ -e "$path" ]]; then skip "$path"; return 0; fi
  mkdir -p "$(dirname "$path")"
  : > "$path"
  newf "$path"
}

log "Erzeuge Verzeichnisstruktur …"
mkdir -p \
  scripts \
  .github/workflows \
  wordpress/wp-content/themes/beyondgotham-dark-child \
  services/gateway-fastapi/app \
  services/demo-java/src/main/java

create_file ".gitignore" <<'EOF'
# Node
node_modules/
npm-debug.log*
yarn-error.log*
pnpm-lock.yaml

# Python
__pycache__/
*.pyc
.venv/

# Java
**/target/

# WP uploads
wordpress/wp-content/uploads/

# Env/Secrets
.env
.env.*
.DS_Store
EOF

create_file ".editorconfig" <<'EOF'
root = true
[*]
charset = utf-8
end_of_line = lf
insert_final_newline = true
indent_style = space
indent_size = 2
trim_trailing_whitespace = true
[*.{yml,yaml,py,ts,tsx,js,json,md,sh,php}]
indent_size = 2
EOF

create_file ".env.example" <<'EOF'
# --- General ---
PROJECT_NAME=Beyond_Gotham
DOMAIN=localhost

# --- WordPress DB (bei IONOS via Installer, Platzhalter bleiben hier egal) ---
MARIADB_DATABASE=wp
MARIADB_USER=wp
MARIADB_PASSWORD=wp
MARIADB_ROOT_PASSWORD=root

# --- OpenSearch (für späteren VPS) ---
OPENSEARCH_INITIAL_ADMIN_PASSWORD=opensearchPW123!

# --- Keycloak (für späteren VPS) ---
KEYCLOAK_ADMIN=admin
KEYCLOAK_ADMIN_PASSWORD=admin

# --- Matomo DB (für späteren VPS) ---
MATOMO_DB=matomo
MATOMO_USER=matomo
MATOMO_PASSWORD=matomo
MATOMO_ROOT_PASSWORD=root
EOF

create_file "README.md" <<'EOF'
# Beyond_Gotham

Moderne, dunkle Nachrichtenagentur-Website (**WordPress**) mit **InfoTerminal**-Showcase.
Dieses Repo bündelt:
- `wordpress/` (Child-Theme, künftige WP-Erweiterungen)
- `webroot/` (statische Assets für IONOS)
- `services/` (spätere APIs: FastAPI/Spring; laufen **nicht** auf Shared Hosting)
- `.github/workflows/` (SFTP-Deploy zu IONOS)

## Quickstart (lokal)
```bash
chmod +x scripts/bootstrap_repo.sh
./scripts/bootstrap_repo.sh

cp .env.example .env
# … Werte später anpassen (für VPS-Stack)

# InfoTerminal-Seite bearbeiten:
# In WordPress das Template "InfoTerminal Showcase" auswählen und optional
# eine Demo-URL im Custom Field `_bg_infoterminal_embed_url` hinterlegen.
