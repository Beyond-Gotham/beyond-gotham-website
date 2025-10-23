import { mkdirSync, rmSync, copyFileSync, writeFileSync } from 'node:fs';
import { dirname, join } from 'node:path';
import { fileURLToPath } from 'node:url';

const __filename = fileURLToPath(import.meta.url);
const __dirname = dirname(__filename);
const distDir = join(__dirname, 'dist');

// Clean previous build output
rmSync(distDir, { recursive: true, force: true });
mkdirSync(distDir, { recursive: true });

// Copy HTML template
copyFileSync(join(__dirname, 'src', 'index.html'), join(distDir, 'index.html'));
copyFileSync(join(__dirname, 'src', 'styles.css'), join(distDir, 'styles.css'));

// Add a small metadata file for deployment checks
writeFileSync(
  join(distDir, 'build-info.json'),
  JSON.stringify({ builtAt: new Date().toISOString() }, null, 2)
);

console.log('Demo assets prepared in', distDir);
