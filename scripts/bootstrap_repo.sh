#!/usr/bin/env bash
set -euo pipefail

info() { echo -e "[+] $1"; }
create() {
  local path="$1"; shift || true
  if [[ -e "$path" ]]; then
    echo "[skip] $path existiert"; return 0
  fi
  mkdir -p "$(dirname "$path")"
  cat >"$path" <<'EOF'
EOF
  echo "[new ] $path"
}

# Root
mkdir -p scripts infra/caddy infra/opensearch infra/keycloak infra/matomo infra/listmonk \
         wordpress/wp-content/themes/beyondgotham-dark-child \
         app-demo-infoterminal/src services/gateway-fastapi/app services/demo-java/src/main/java

# .gitignore
create .gitignore <<'EOF'
# Node
node_modules/
*.log
# Python
__pycache__/
*.pyc
.venv/
# Java
**/target/
# WP
wordpress/wp-content/uploads/
# Env
.env
.env.*
# Misc
.DS_Store
EOF

# .editorconfig
create .editorconfig <<'EOF'
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

# .env.example
create .env.example <<'EOF'
# --- General ---
PROJECT_NAME=Beyond_Gotham
DOMAIN=localhost
# --- DB ---
MARIADB_DATABASE=wp
MARIADB_USER=wp
MARIADB_PASSWORD=wp
MARIADB_ROOT_PASSWORD=root
# --- OpenSearch ---
OPENSEARCH_INITIAL_ADMIN_PASSWORD=opensearchPW123!
# --- Keycloak ---
KEYCLOAK_ADMIN=admin
KEYCLOAK_ADMIN_PASSWORD=admin
# --- Matomo DB ---
MATOMO_DB=matomo
MATOMO_USER=matomo
MATOMO_PASSWORD=matomo
MATOMO_ROOT_PASSWORD=root
EOF

# LICENSE placeholder
create LICENSE <<'EOF'
TBD – Bitte gewünschte Lizenz wählen (z.B. AGPL-3.0, Apache-2.0, MIT).
EOF

# README.md
create README.md <<'EOF'
# Beyond_Gotham

Moderne, dunkle Nachrichtenagentur‑Website (WordPress) mit InfoTerminal‑Demo (React/TS), self‑hosted.

Siehe `README` im Repo oder Projektseite.
EOF

# infra/docker-compose.yml (Skeleton)
create infra/docker-compose.yml <<'EOF'
version: "3.9"
services:
  caddy:
    image: caddy:2
    ports: ["80:80", "443:443"]
    volumes:
      - ./caddy/Caddyfile:/etc/caddy/Caddyfile:ro
    depends_on: [wordpress]
  wordpress:
    image: wordpress:php8.2-apache
    env_file: ["../.env"]
    volumes:
      - wp_data:/var/www/html
      - ../wordpress/wp-content:/var/www/html/wp-content
    depends_on: [db]
  db:
    image: mariadb:11
    environment:
      - MARIADB_DATABASE=${MARIADB_DATABASE}
      - MARIADB_USER=${MARIADB_USER}
      - MARIADB_PASSWORD=${MARIADB_PASSWORD}
      - MARIADB_ROOT_PASSWORD=${MARIADB_ROOT_PASSWORD}
    volumes: [db_data:/var/lib/mysql]
  app-demo-infoterminal:
    build: ../app-demo-infoterminal
    environment: ["BASE_PATH=/infoterminal/demo"]
    expose: ["5173"]
  gateway-fastapi:
    build: ../services/gateway-fastapi
    expose: ["8000"]
  demo-java:
    build: ../services/demo-java
    expose: ["8081"]
  keycloak:
    image: quay.io/keycloak/keycloak:26.0
    command: ["start-dev"]
    environment:
      - KEYCLOAK_ADMIN=${KEYCLOAK_ADMIN}
      - KEYCLOAK_ADMIN_PASSWORD=${KEYCLOAK_ADMIN_PASSWORD}
    expose: ["8080"]
  matomo:
    image: matomo:latest
    environment:
      - MATOMO_DATABASE_HOST=db-matomo
    depends_on: [db-matomo]
    expose: ["80"]
  db-matomo:
    image: mariadb:11
    environment:
      - MARIADB_DATABASE=${MATOMO_DB}
      - MARIADB_USER=${MATOMO_USER}
      - MARIADB_PASSWORD=${MATOMO_PASSWORD}
      - MARIADB_ROOT_PASSWORD=${MATOMO_ROOT_PASSWORD}
    volumes: [db_matomo:/var/lib/mysql]
  opensearch:
    image: opensearchproject/opensearch:2
    environment:
      - discovery.type=single-node
      - OPENSEARCH_INITIAL_ADMIN_PASSWORD=${OPENSEARCH_INITIAL_ADMIN_PASSWORD}
    ports: ["9200:9200"]
    ulimits:
      memlock:
        soft: -1
        hard: -1
    volumes: [os_data:/usr/share/opensearch/data]
volumes:
  wp_data: {}
  db_data: {}
  db_matomo: {}
  os_data: {}
EOF

# Caddyfile (Skeleton)
create infra/caddy/Caddyfile <<'EOF'
{
  auto_https off
}
:80 {
  encode zstd gzip
  @wp path /*
  reverse_proxy wordpress:80

  handle_path /infoterminal/demo/* {
    reverse_proxy app-demo-infoterminal:5173
  }
  handle_path /api/* {
    reverse_proxy gateway-fastapi:8000
  }
  handle_path /auth/* {
    reverse_proxy keycloak:8080
  }
  handle_path /matomo/* {
    reverse_proxy matomo:80
  }

  header {
    X-Frame-Options "SAMEORIGIN"
    X-Content-Type-Options "nosniff"
    Referrer-Policy "strict-origin-when-cross-origin"
  }
}
EOF

# WordPress Child Theme
create wordpress/wp-content/themes/beyondgotham-dark-child/style.css <<'EOF'
/*
 Theme Name: BeyondGotham Dark (Child)
 Template:   twentytwentyfour
 Version:    0.1.0
*/
:root{ --bg:#0f1115; --fg:#e7eaee; --muted:#a9b0bb; --accent:#33d1ff; }
body{ background:var(--bg); color:var(--fg); }
a{ color:var(--accent); }
EOF

create wordpress/wp-content/themes/beyondgotham-dark-child/functions.php <<'EOF'
<?php
add_action('wp_enqueue_scripts', function(){
  wp_enqueue_style('parent-style', get_template_directory_uri().'/style.css');
  wp_enqueue_style('child-style', get_stylesheet_uri(), ['parent-style'], '0.1.0');
});
EOF

create wordpress/wp-content/themes/beyondgotham-dark-child/README.md <<'EOF'
# BeyondGotham Dark Theme (Child)
- Aktiviere dieses Child‑Theme nach WP‑Installation.
- Erweiterungen: eigene Gutenberg‑Blöcke, Dark‑Tokens, Layouts für Dossiers.
EOF

# React/Vite App (Skeleton)
create app-demo-infoterminal/package.json <<'EOF'
{
  "name": "app-demo-infoterminal",
  "private": true,
  "version": "0.0.1",
  "scripts": {
    "dev": "vite",
    "build": "tsc -b && vite build",
    "preview": "vite preview"
  },
  "devDependencies": {
    "typescript": "^5.6.0",
    "vite": "^5.4.0",
    "@types/react": "^18.2.0",
    "@types/react-dom": "^18.2.0"
  },
  "dependencies": {
    "react": "^18.3.1",
    "react-dom": "^18.3.1"
  }
}
EOF

create app-demo-infoterminal/vite.config.ts <<'EOF'
import { defineConfig } from 'vite'
import react from '@vitejs/plugin-react'
export default defineConfig({
  plugins: [react()],
  base: '/infoterminal/demo/'
})
EOF

create app-demo-infoterminal/src/main.tsx <<'EOF'
import React from 'react'
import { createRoot } from 'react-dom/client'

function App(){
  return (
    <div style={{padding:16}}>
      <h1>InfoTerminal Demo</h1>
      <p>Tabs: Search | Graph | Map | Timeline (Platzhalter)</p>
    </div>
  )
}
createRoot(document.getElementById('root')!).render(<App />)
EOF

create app-demo-infoterminal/index.html <<'EOF'
<!doctype html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>InfoTerminal Demo</title>
  </head>
  <body>
    <div id="root"></div>
    <script type="module" src="/src/main.tsx"></script>
  </body>
</html>
EOF

# FastAPI Gateway (minimal)
create services/gateway-fastapi/app/main.py <<'EOF'
from fastapi import FastAPI
from fastapi.responses import JSONResponse

app = FastAPI(title="BG Gateway")

@app.get("/api/healthz")
def healthz():
    return {"status": "ok"}

@app.get("/api/demo/search")
def demo_search(q: str = ""):
    return {"query": q, "results": [{"title": "Demo Result", "score": 1.0}]}
EOF

# Java Spring Boot (pom.xml placeholder)
create services/demo-java/pom.xml <<'EOF'
<!-- TODO: Minimal Spring Boot pom.xml einfügen (Web Starter) -->
<project></project>
EOF

chmod +x scripts/bootstrap_repo.sh 2>/dev/null || true
info "Bootstrap abgeschlossen. Prüfe README und .env.example."
