<!DOCTYPE html>
<!-- Created with https://packager.turbowarp.org/ -->
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <!-- We only include this to explicitly loosen the CSP of various packager environments. It does not provide any security. -->
  <meta http-equiv="Content-Security-Policy" content="default-src * 'self' 'unsafe-inline' 'unsafe-eval' data: blob:">
  <title>Diwali (An Indian Festival) #Diwali #India #Lights</title>
  <style>
    body {
      color: #ffffff;
      font-family: sans-serif;
      overflow: hidden;
      margin: 0;
      padding: 0;
    }
    :root, body.is-fullscreen {
      background-color: #000000;
    }
    [hidden] {
      display: none !important;
    }
    h1 {
      font-weight: normal;
    }
    a {
      color: inherit;
      text-decoration: underline;
      cursor: pointer;
    }

    #app, #loading, #error, #launch {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
    }
    .screen {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      text-align: center;
      cursor: default;
      user-select: none;
      -webkit-user-select: none;
      background-color: #000000;
    }
    #launch {
      background-color: rgba(0, 0, 0, 0.7);
      cursor: pointer;
    }
    .green-flag {
      width: 80px;
      height: 80px;
      padding: 16px;
      border-radius: 100%;
      background: rgba(255, 255, 255, 0.75);
      border: 3px solid hsla(0, 100%, 100%, 1);
      display: flex;
      justify-content: center;
      align-items: center;
      box-sizing: border-box;
    }
    #loading {
      
    }
    .progress-bar-outer {
      border: 1px solid currentColor;
      height: 10px;
      width: 200px;
      max-width: 200px;
    }
    .progress-bar-inner {
      height: 100%;
      width: 0;
      background-color: currentColor;
    }
    .loading-text, noscript {
      font-weight: normal;
      font-size: 36px;
      margin: 0 0 16px;
    }
    .loading-image {
      margin: 0 0 16px;
    }
    #error-message, #error-stack {
      font-family: monospace;
      max-width: 600px;
      white-space: pre-wrap;
      user-select: text;
      -webkit-user-select: text;
    }
    #error-stack {
      text-align: left;
      max-height: 200px;
      overflow: auto;
    }
    .control-button {
      width: 2rem;
      height: 2rem;
      padding: 0.375rem;
      border-radius: 0.25rem;
      margin-top: 0.5rem;
      margin-bottom: 0.5rem;
      user-select: none;
      -webkit-user-select: none;
      cursor: pointer;
      border: 0;
      border-radius: 4px;
    }
    .control-button:hover {
      background: #ff4c4c26;
    }
    .control-button.active {
      background: #ff4c4c59;
    }
    .fullscreen-button {
      background: white !important;
    }
    .standalone-fullscreen-button {
      position: absolute;
      top: 0;
      right: 0;
      background-color: rgba(0, 0, 0, 0.5);
      border-radius: 0 0 0 4px;
      padding: 4px;
      cursor: pointer;
    }
    .sc-canvas {
      cursor: auto;
    }
    .sc-monitor-root[opcode^="data_"] .sc-monitor-value-color {
      background-color: #ff8c1a;
    }
    .sc-monitor-row-value-outer {
      background-color: #fc662c;
    }
    .sc-monitor-row-value-editing .sc-monitor-row-value-outer {
      background-color: #e25b27;
    }
    
  </style>
  <meta name="theme-color" content="#000000">
  
</head>
<body>
  <div id="app"></div>

  <div id="launch" class="screen" hidden title="Click to start">
    <div class="green-flag">
      <svg viewBox="0 0 16.63 17.5" width="42" height="44">
        <defs><style>.cls-1,.cls-2{fill:#4cbf56;stroke:#45993d;stroke-linecap:round;stroke-linejoin:round;}.cls-2{stroke-width:1.5px;}</style></defs>
        <path class="cls-1" d="M.75,2A6.44,6.44,0,0,1,8.44,2h0a6.44,6.44,0,0,0,7.69,0V12.4a6.44,6.44,0,0,1-7.69,0h0a6.44,6.44,0,0,0-7.69,0"/>
        <line class="cls-2" x1="0.75" y1="16.75" x2="0.75" y2="0.75"/>
      </svg>
    </div>
  </div>

  <div id="loading" class="screen">
    <noscript>Enable JavaScript</noscript>
    
    
    <div class="progress-bar-outer"><div class="progress-bar-inner" id="loading-inner"></div></div>
  </div>

  <div id="error" class="screen" hidden>
    <h1>Error</h1>
    <details>
      <summary id="error-message"></summary>
      <p id="error-stack"></p>
    </details>
  </div>

  <script src="./js/script.js"></script>
  <script>
    const appElement = document.getElementById('app');
    const launchScreen = document.getElementById('launch');
    const loadingScreen = document.getElementById('loading');
    const loadingInner = document.getElementById('loading-inner');
    const errorScreen = document.getElementById('error');
    const errorScreenMessage = document.getElementById('error-message');
    const errorScreenStack = document.getElementById('error-stack');

    const handleError = (error) => {
      console.error(error);
      if (!errorScreen.hidden) return;
      errorScreen.hidden = false;
      errorScreenMessage.textContent = '' + error;
      let debug = error && error.stack || 'no stack';
      debug += '\nUser agent: ' + navigator.userAgent;
      errorScreenStack.textContent = debug;
    };
    const setProgress = (progress) => {
      if (loadingInner) loadingInner.style.width = progress * 100 + '%';
    };
    const interpolate = (a, b, t) => a + t * (b - a);

    try {
      setProgress(0.1);

      const scaffolding = new Scaffolding.Scaffolding();
      scaffolding.width = 480;
      scaffolding.height = 360;
      scaffolding.resizeMode = "preserve-ratio";
      scaffolding.editableLists = false;
      scaffolding.usePackagedRuntime = true;
      scaffolding.setup();
      scaffolding.appendTo(appElement);

      const vm = scaffolding.vm;
      window.scaffolding = scaffolding;
      window.vm = scaffolding.vm;
      window.Scratch = {
        vm,
        renderer: vm.renderer,
        audioEngine: vm.runtime.audioEngine,
        bitmapAdapter: vm.runtime.v2BitmapAdapter,
        videoProvider: vm.runtime.ioDevices.video.provider
      };

      scaffolding.setUsername("player####".replace(/#/g, () => Math.floor(Math.random() * 10)));
      scaffolding.setAccentColor("#ff4c4c");

      scaffolding.addCloudProvider(new Scaffolding.Cloud.WebSocketProvider(["wss://clouddata.turbowarp.org","wss://clouddata.turbowarp.xyz"], "738682253"));

      vm.setTurboMode(false);
      if (vm.setInterpolation) vm.setInterpolation(false);
      if (vm.setFramerate) vm.setFramerate(30);
      if (vm.renderer.setUseHighQualityRender) vm.renderer.setUseHighQualityRender(false);
      if (vm.setRuntimeOptions) vm.setRuntimeOptions({
        fencing: true,
        miscLimits: true,
        maxClones: 300,
      });
      if (vm.setCompilerOptions) vm.setCompilerOptions({
        enabled: true,
        warpTimer: false
      });

      if (typeof ScaffoldingAddons !== 'undefined') {
        ScaffoldingAddons.run(scaffolding, {"gamepad":false,"pointerlock":false,"specialCloudBehaviors":false,"unsafeCloudBehaviors":false,"pause":false});
      }

      for (const extension of []) {
        vm.extensionManager.loadExtensionURL(extension);
      }

    } catch (e) {
      handleError(e);
    }
  </script>
  
  
    <script>
      const getProjectData = (function() {
        const storage = scaffolding.storage;
        storage.onprogress = (total, loaded) => {
          setProgress(interpolate(0.2, 0.98, loaded / total));
        };
        
        storage.addWebStore(
          [storage.AssetType.ImageVector, storage.AssetType.ImageBitmap, storage.AssetType.Sound],
          (asset) => new URL('<{$sb3_path}>' + asset.assetId + '.' + asset.dataFormat, location).href
        );
        return () => new Promise((resolve, reject) => {
        const xhr = new XMLHttpRequest();
        xhr.onload = () => {
          resolve(xhr.response);
        };
        xhr.onerror = () => {
          if (location.protocol === 'file:') {
            reject(new Error('Zip environment must be used from a website, not from a file URL.'));
          } else {
            reject(new Error('Request to load project data failed.'));
          }
        };
        xhr.onprogress = (e) => {
          if (e.lengthComputable) {
            setProgress(interpolate(0.1, 0.2, e.loaded / e.total));
          }
        };
        xhr.responseType = 'arraybuffer';
        xhr.open('GET', "<{$sb3_path}>project.json");
        xhr.send();
      });
      })();
    </script>
  <script>
    const run = async () => {
      const projectData = await getProjectData();
      await scaffolding.loadProject(projectData);
      setProgress(1);
      loadingScreen.hidden = true;
      if (false) {
        scaffolding.start();
      } else {
        launchScreen.hidden = false;
        launchScreen.addEventListener('click', () => {
          launchScreen.hidden = true;
          scaffolding.start();
        });
        launchScreen.focus();
      }
    };
    run().catch(handleError);
  </script>
</body>
</html>
