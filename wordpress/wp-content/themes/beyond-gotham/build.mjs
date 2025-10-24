import { build, context } from 'esbuild';
import * as sass from 'sass';
import postcss from 'postcss';
import autoprefixer from 'autoprefixer';
import cssnano from 'cssnano';
import { fileURLToPath } from 'url';
import path from 'path';
import fs from 'fs';
import { promises as fsp } from 'fs';

const isWatch = process.argv.includes('--watch');
const rootDir = path.dirname(fileURLToPath(import.meta.url));
const distDir = path.join(rootDir, 'dist');

async function ensureDist() {
  await fsp.mkdir(distDir, { recursive: true });
}

async function buildStyles() {
  const entryFile = path.join(rootDir, 'src', 'scss', 'main.scss');
  const result = await sass.compileAsync(entryFile, {
    style: 'expanded',
    sourceMap: true,
    loadPaths: [path.join(rootDir, 'src', 'scss')]
  });

  const processor = postcss([
    autoprefixer,
    cssnano({ preset: 'default' })
  ]);

  const processed = await processor.process(result.css, {
    from: 'src/scss/main.scss',
    to: 'dist/style.css',
    map: { prev: result.sourceMap, inline: false }
  });

  await fsp.writeFile(path.join(distDir, 'style.css'), processed.css, 'utf8');
  if (processed.map) {
    await fsp.writeFile(path.join(distDir, 'style.css.map'), processed.map.toString(), 'utf8');
  }
}

async function buildScripts() {
  const options = {
    entryPoints: [path.join(rootDir, 'src', 'js', 'theme.js')],
    bundle: true,
    minify: true,
    sourcemap: true,
    outfile: path.join(distDir, 'theme.js'),
    format: 'iife',
    target: ['es2018']
  };

  if (isWatch) {
    const ctx = await context(options);
    await ctx.watch();
    return ctx;
  }

  await build(options);
  return null;
}

async function runBuild() {
  await ensureDist();
  await buildStyles();
  await buildScripts();
}

async function start() {
  if (!isWatch) {
    await runBuild();
    return;
  }

  await ensureDist();
  const jsContext = await buildScripts();

  const scssDir = path.join(rootDir, 'src', 'scss');
  let watcher;
  try {
    watcher = fs.watch(scssDir, { recursive: true }, async () => {
      try {
        await buildStyles();
        console.log('[sass] rebuilt');
      } catch (error) {
        console.error(error);
      }
    });
  } catch (error) {
    console.warn('Recursive watch not supported on this platform. Re-run the build to pick up SCSS changes.');
  }

  try {
    await buildStyles();
    console.log('Watching for changes...');
  } catch (error) {
    console.error(error);
  }

  process.on('SIGINT', async () => {
    if (watcher) {
      watcher.close();
    }
    if (jsContext && jsContext.dispose) {
      await jsContext.dispose();
    }
    process.exit(0);
  });
}

start().catch((error) => {
  console.error(error);
  process.exitCode = 1;
});
