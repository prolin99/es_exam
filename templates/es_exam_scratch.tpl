<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>scratch player</title>

  <style media="screen">
  html, body {
    height: 100%;
  }
  body {
    margin: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: black;
    font-size: 0;
    font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
    overflow: hidden;
  }
  #w {
    display: block;
    width: 100vw;

    height: 75vw;


    position: relative;
  }
  #m {
    position: absolute;
    top: 0;
    left: 0;
  }

  @media (min-aspect-ratio: 4/3) {
    #w {
      height: 100vh;
      width: calc(400vh / 3);
    }
  }


  #s {
    width: 100%;
    height: 100%;
  }

  #l {
    color: #0ff;
    position: fixed;
    bottom: 0;
    left: 0;
    font-size: 16px;
  }

  #green {
    -webkit-appearance: none;
    border: none;
    background: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 30px;
    height: 30px;
    cursor: pointer;
    background-repeat: no-repeat;
    background-position: center;
    background-size: 24px;

    background-image: url('./js/greenFlag.svg');
    background-color: rgba(0, 0, 0, 0.5);
    border-bottom-left-radius: 10px;
  }

  #stop {
  -webkit-appearance: none;
  border: none;
  background: none;
  position: fixed;
  top: 0;
  left: 32px;
  width: 30px;
  height: 30px;
  cursor: pointer;
  background-repeat: no-repeat;
  background-position: center;
  background-size: 24px;

  background-image: url('./js/stop.svg');
  background-color: rgba(0, 0, 0, 0.5);
  border-bottom-left-radius: 10px;
}

  #f {
    -webkit-appearance: none;
    border: none;
    background: none;
    position: fixed;
    top: 0;
    right: 0;
    width: 30px;
    height: 30px;
    cursor: pointer;
    background-repeat: no-repeat;
    background-position: center;
    background-size: 24px;
    background-image: url('data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48"%3E%3Cpath d="M14 28h-4v10h10v-4h-6v-6zm-4-8h4v-6h6v-4H10v10zm24 14h-6v4h10V28h-4v6zm-6-24v4h6v6h4V10H28z" fill="%23fff"/%3E%3C/svg%3E');
    background-color: rgba(0, 0, 0, 0.5);
    border-bottom-left-radius: 10px;
  }
  .fullscreen #f {
    background-image: url('data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48"%3E%3Cpath d="M10 32h6v6h4V28H10v4zm6-16h-6v4h10V10h-4v6zm12 22h4v-6h6v-4H28v10zm4-22v-6h-4v10h10v-4h-6z" fill="%23fff"/%3E%3C/svg%3E');
  }

  .monitor {
    position: absolute;
    background-color: rgba(0, 0, 0, 0.3);
    border: 1px solid rgba(0, 0, 0, 0.2);
    border-radius: 0.25rem;
    font-size: 0.75rem;
    overflow: hidden;
    padding: 3px;
    color: white;
    white-space: pre;
  }
  .monitor-label {
    margin: 0 5px;
    font-weight: bold;
  }
  .monitor-value {
    display: inline-block;
    vertical-align: top;
    min-width: 34px;
    text-align: center;
    border-radius: 0.25rem;
    overflow: hidden;
    text-overflow: ellipsis;
    user-select: text;
    transform: translateZ(0);
  }
  .default .monitor-value, .slider .monitor-value {
    background-color: rgba(0, 0, 0, 0.5);
    margin: 0 5px;
    padding: 1px 3px;
  }
  .large {
    background-color: rgba(0, 0, 0, 0.6);
    padding: 0.1rem 0.25rem;
    min-width: 3rem;
  }
  .large .monitor-label {
    display: none;
  }
  .large .monitor-value {
    font-size: 1rem;
    width: 100%;
  }
  .list {
    padding: 0;
    overflow: auto;
    overflow-x: hidden;
  }
  .list .monitor-label {
    text-align: center;
    padding: 3px;
    width: 100%;
    display: block;
    margin: 0;
    box-sizing: border-box;
    white-space: pre-wrap;
  }
  .list .monitor-value {
    display: block;
  }
  .row {
    margin: 2px 5px;
    transform: translateZ(0);
    text-align: left;
    border-radius: 0.25rem;
    background-color: rgba(0, 0, 0, 0.5);
    border: 1px solid rgba(0, 0, 0, 0.2);
    height: 20px;
    line-height: 20px;
    padding: 0 5px;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .slider input {
    display: block;
    width: 100%;
    transform: translateZ(0);
  }
  #b {
    display: none;
    position: absolute;
    left: 0;
    bottom: 0;
    right: 0;
    background-color: rgba(0, 0, 0, 0.7);
  }
  .asking #b {
    display: block;
  }
  #q {
    display: block;
    margin: 0 10px;
    margin-top: 10px;
    font-size: 12px;
    color: white;
  }
  #a {
    border: none;
    background: none;
    width: 100%;
    font: inherit;
    font-size: 16px;
    color: white;
    padding: 10px;
    box-sizing: border-box;
  }
  #a:focus {
    outline: none;
  }
  </style>

</head>

  <body>
<div  id ="w">
<canvas id="s"></canvas>
<div id="m"></div>
<div id="b">
<label id="q" for="a">Question</label>
<input type="text" id="a">
</div>
</div>

<span id="l">...</span>
<button id="green"></button>
<button id="stop"></button>
<button id="f"></button>

<script src="./js/vm.min.js"></script>
<script type="text/javascript" id="j">
        //var sb3_base64  =  readSb3File('<{$file}>');
        var SRC = "file", FILE = "data:application/octet-stream;base64,<{$sb3_base64}>"   ;
        var
        DESIRED_USERNAME = "griffpatch",COMPAT = true, TURBO = false;
</script>

<script src="./js/play_scratch.js"></script>
</body>
</html>
