#!/usr/bin/env node

import { existsSync, statSync } from "node:fs";
import { mkdir, mkdtemp, readFile, rm, writeFile } from "node:fs/promises";
import os from "node:os";
import path from "node:path";
import { spawn, spawnSync } from "node:child_process";
import { pathToFileURL } from "node:url";

const WIDTH = 3840;
const HEIGHT = 2160;
const PREVIEW_WIDTH = 1920;
const PREVIEW_HEIGHT = 1080;
const MIN_FONT_SIZE = 28;

function usage() {
  console.log(`Usage:
  node render-visual.mjs [--html <input.html>] [--png <output.png>] [--preview <preview.png>] [--browser <browser-path>]

Defaults:
  --html  visuals/project-overview.html
  --png   visuals/project-overview.png

Optional:
  --preview  1920x1080 readability-check PNG`);
}

function parseArgs(argv) {
  const result = {};
  for (let index = 0; index < argv.length; index += 1) {
    const token = argv[index];
    if (!token.startsWith("--")) throw new Error(`Unknown argument: ${token}`);
    const equalsAt = token.indexOf("=");
    if (equalsAt > 2) {
      result[token.slice(2, equalsAt)] = token.slice(equalsAt + 1);
      continue;
    }
    const key = token.slice(2);
    if (key === "help") {
      result.help = true;
      continue;
    }
    const value = argv[index + 1];
    if (!value || value.startsWith("--")) throw new Error(`Missing value for --${key}`);
    result[key] = value;
    index += 1;
  }
  return result;
}

function commandPath(command) {
  const finder = process.platform === "win32" ? "where.exe" : "which";
  const found = spawnSync(finder, [command], { encoding: "utf8", windowsHide: true });
  if (found.status !== 0) return null;
  return found.stdout
    .split(/\r?\n/)
    .map((line) => line.trim())
    .find((line) => line && existsSync(line)) ?? null;
}

function findBrowser(explicitPath) {
  const candidates = [];
  if (explicitPath) candidates.push(explicitPath);
  if (process.env.CHROME_PATH) candidates.push(process.env.CHROME_PATH);
  if (process.env.BROWSER_PATH) candidates.push(process.env.BROWSER_PATH);
  if (process.env.EDGE_PATH) candidates.push(process.env.EDGE_PATH);

  if (process.platform === "win32") {
    const local = process.env.LOCALAPPDATA;
    const programFiles = process.env.ProgramFiles;
    const programFilesX86 = process.env["ProgramFiles(x86)"];
    if (local) candidates.push(path.join(local, "Google", "Chrome", "Application", "chrome.exe"));
    if (programFiles) {
      candidates.push(path.join(programFiles, "Google", "Chrome", "Application", "chrome.exe"));
      candidates.push(path.join(programFiles, "Microsoft", "Edge", "Application", "msedge.exe"));
    }
    if (programFilesX86) {
      candidates.push(path.join(programFilesX86, "Google", "Chrome", "Application", "chrome.exe"));
      candidates.push(path.join(programFilesX86, "Microsoft", "Edge", "Application", "msedge.exe"));
    }
  } else if (process.platform === "darwin") {
    candidates.push(
      "/Applications/Google Chrome.app/Contents/MacOS/Google Chrome",
      "/Applications/Microsoft Edge.app/Contents/MacOS/Microsoft Edge",
      "/Applications/Chromium.app/Contents/MacOS/Chromium",
    );
  } else {
    candidates.push(
      "/usr/bin/google-chrome",
      "/usr/bin/chromium",
      "/usr/bin/chromium-browser",
      "/usr/bin/microsoft-edge",
    );
  }

  for (const candidate of candidates) {
    if (existsSync(candidate)) return candidate;
    const resolved = commandPath(candidate);
    if (resolved) return resolved;
  }
  for (const command of ["google-chrome", "chrome", "chromium", "chromium-browser", "msedge", "microsoft-edge"]) {
    const resolved = commandPath(command);
    if (resolved) return resolved;
  }
  return null;
}

function runBrowser(browser, htmlPath, pngPath, modernHeadless, width, height) {
  const args = [
    modernHeadless ? "--headless=new" : "--headless",
    "--disable-gpu",
    "--disable-background-networking",
    "--disable-component-update",
    "--disable-extensions",
    "--hide-scrollbars",
    "--no-default-browser-check",
    "--no-first-run",
    "--allow-file-access-from-files",
    "--force-device-scale-factor=1",
    `--window-size=${width},${height}`,
    "--run-all-compositor-stages-before-draw",
    "--virtual-time-budget=1500",
    `--screenshot=${pngPath}`,
  ];
  if (typeof process.getuid === "function" && process.getuid() === 0) args.push("--no-sandbox");
  args.push(pathToFileURL(htmlPath).href);

  return new Promise((resolve) => {
    const child = spawn(browser, args, { windowsHide: true, stdio: ["ignore", "pipe", "pipe"] });
    let stdout = "";
    let stderr = "";
    let lastSize = -1;
    let stableChecks = 0;
    let settled = false;
    let poll;
    let timeout;

    const finish = (status, error = null) => {
      if (settled) return;
      settled = true;
      clearInterval(poll);
      clearTimeout(timeout);
      resolve({ status, error, stdout, stderr });
    };

    child.stdout.on("data", (chunk) => { stdout = (stdout + chunk.toString()).slice(-12000); });
    child.stderr.on("data", (chunk) => { stderr = (stderr + chunk.toString()).slice(-12000); });
    child.once("error", (error) => finish(1, error));
    child.once("exit", (code) => finish(code ?? 1));

    poll = setInterval(() => {
      if (!existsSync(pngPath)) return;
      const size = statSync(pngPath).size;
      if (size > 24 && size === lastSize) stableChecks += 1;
      else stableChecks = 0;
      lastSize = size;
      if (stableChecks >= 3) {
        child.kill();
        finish(0);
      }
    }, 150);

    timeout = setTimeout(() => {
      child.kill();
      finish(1, new Error("Browser screenshot timed out after 30 seconds"));
    }, 30000);
  });
}

async function pngDimensions(pngPath) {
  const buffer = await readFile(pngPath);
  if (buffer.length < 24 || buffer.subarray(0, 8).toString("hex") !== "89504e470d0a1a0a") {
    throw new Error("Browser output is not a PNG file");
  }
  return { width: buffer.readUInt32BE(16), height: buffer.readUInt32BE(20) };
}

function validateTypography(html) {
  const declarations = [...html.matchAll(/font-size\s*:\s*([0-9]+(?:\.[0-9]+)?)px/gi)]
    .map((match) => Number(match[1]));
  const attributes = [...html.matchAll(/font-size\s*=\s*["']([0-9]+(?:\.[0-9]+)?)(?:px)?["']/gi)]
    .map((match) => Number(match[1]));
  const sizes = [...declarations, ...attributes];
  if (sizes.length === 0) {
    throw new Error("Typography check needs explicit font-size values in px");
  }
  const undersized = [...new Set(sizes.filter((size) => size < MIN_FONT_SIZE))].sort((a, b) => a - b);
  if (undersized.length > 0) {
    throw new Error(`Typography check failed: font-size below ${MIN_FONT_SIZE}px (${undersized.join(", ")}px)`);
  }
  console.log(`[OK] Typography: minimum ${Math.min(...sizes)}px (${sizes.length} declarations checked)`);
}

async function renderWithFallback(browser, htmlPath, pngPath, width, height) {
  await mkdir(path.dirname(pngPath), { recursive: true });
  await rm(pngPath, { force: true });
  const preferModern = process.platform !== "win32";
  let result = await runBrowser(browser, htmlPath, pngPath, preferModern, width, height);
  if (!existsSync(pngPath)) {
    result = await runBrowser(browser, htmlPath, pngPath, !preferModern, width, height);
  }
  if (!existsSync(pngPath)) {
    const details = [result.error?.message, result.stderr, result.stdout].filter(Boolean).join("\n").trim();
    throw new Error(`Browser screenshot failed${details ? `:\n${details}` : ""}`);
  }
  const dimensions = await pngDimensions(pngPath);
  if (dimensions.width !== width || dimensions.height !== height) {
    throw new Error(`PNG size is ${dimensions.width}x${dimensions.height}; expected ${width}x${height}`);
  }
}

async function renderPreview(browser, pngPath, previewPath) {
  if (path.resolve(pngPath) === path.resolve(previewPath)) {
    throw new Error("--preview must differ from --png");
  }
  const temporary = await mkdtemp(path.join(os.tmpdir(), "codex-visual-preview-"));
  const wrapperPath = path.join(temporary, "preview.html");
  try {
    const imageUrl = pathToFileURL(pngPath).href.replace(/&/g, "&amp;").replace(/"/g, "&quot;");
    await writeFile(wrapperPath, `<!doctype html><html><head><meta charset="utf-8"><style>*{box-sizing:border-box}html,body{margin:0;width:100%;height:100%;overflow:hidden;background:#fff}img{display:block;width:100%;height:100%;object-fit:fill}</style></head><body><img src="${imageUrl}" alt=""></body></html>`);
    await renderWithFallback(browser, wrapperPath, previewPath, PREVIEW_WIDTH, PREVIEW_HEIGHT);
  } finally {
    await rm(temporary, { recursive: true, force: true });
  }
}

async function main() {
  const args = parseArgs(process.argv.slice(2));
  if (args.help) {
    usage();
    return;
  }

  const htmlPath = path.resolve(args.html ?? "visuals/project-overview.html");
  const pngPath = path.resolve(args.png ?? "visuals/project-overview.png");
  const previewPath = args.preview ? path.resolve(args.preview) : null;
  if (!existsSync(htmlPath)) throw new Error(`HTML was not found: ${htmlPath}`);

  const html = await readFile(htmlPath, "utf8");
  if (!html.includes("3840") || !html.includes("2160")) {
    throw new Error("HTML must define a 3840x2160 canvas before rendering");
  }
  validateTypography(html);

  const browser = findBrowser(args.browser);
  if (!browser) throw new Error("Chrome, Edge, or Chromium was not found. Re-run with --browser <browser-path>.");

  await renderWithFallback(browser, htmlPath, pngPath, WIDTH, HEIGHT);
  console.log(`[OK] PNG: ${pngPath} (${WIDTH}x${HEIGHT})`);
  if (previewPath) {
    await renderPreview(browser, pngPath, previewPath);
    console.log(`[OK] Preview: ${previewPath} (${PREVIEW_WIDTH}x${PREVIEW_HEIGHT})`);
  }
}

main().catch((error) => {
  console.error(`[ERROR] ${error.message}`);
  process.exitCode = 1;
});
