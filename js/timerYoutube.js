'use strict';

{
   // alert sound
   function sound(type, sec) {
    const ctx = new AudioContext()
    const osc = ctx.createOscillator()
    osc.type = type
    osc.connect(ctx.destination)
    osc.start()
    osc.stop(sec)
  }
  //Timer
  let timer = document.getElementById('timer');
  let reset = document.getElementById('reset');
  let start = document.getElementById('start');
  let stop = document.getElementById('stop');


  let startTime;
  let timeLeft;
  let timeToCountDown = 1500 * 1000;
  let timerId;
  var isRunning = false;

  function updateTimer(t) {
    let d = new Date(t);
    let m = d.getMinutes();
    let s = d.getSeconds();
    m = ('0' + m).slice(-2);
    s = ('0' + s).slice(-2);
    timer.textContent = m + ':' + s;
  }

  function countDown() {
    timerId = setTimeout(() => {
      timeLeft = timeToCountDown - (Date.now() - startTime);
      if (timeLeft < 0) {
        clearTimeout(timerId);
        timeLeft = 0;
        timeToCountDown = 1500 * 1000;
        updateTimer(1500 * 1000);
        sound("sine", 0.3);
        modalOpen();
        return;
      }
      updateTimer(timeLeft);
      countDown();
    }, 10);
  }

  start.addEventListener('click', () => {
    startTime = Date.now();
    countDown();
  });
  stop.addEventListener('click', () => {
      timeToCountDown = timeLeft;
      clearTimeout(timerId);
  });
  reset.addEventListener('click', () => {
    timeToCountDown = 1500 * 1000;
    updateTimer(timeToCountDown);
  });

  // modal & YouTube
  const open = document.getElementById('open');
  const close = document.getElementById('close');
  const modal = document.getElementById('modal');
  const mask = document.getElementById('mask');
  
  let frame;

  function modalOpen() {
    
    modal.classList.remove('hidden');
    mask.classList.remove('hidden');
    // const videos = [
    // "sFMGAjLQ92Q",
    // "F_8_v4Ye5ug",
    // "RvrYaYVpgyE",
    // "N1kikkete70",
    // "j9tUjXhOrm4",
    // "3KKlcKt7Zac",
    // "Kk0Ua-Idzwo",
    // "6aIIUxPGgdI",
    // "0gmIc0ihJlI",
    // "WRyZS31pLwE",
    // "Oa8kBuxddnQ",
    // "Z2IPlLYHnf4",
    // "DyAG1LiNcsg",
    // "4zMGuAIi6ok",
    // "a3uBXTKJyrI",
    // "QzcTkVSGQBg",
    // "uSIX3N4JTH8",
    // "P0dZXxC8FIo",
    // "i1uXiEIv70U",
    // "nT9EhAWDcws",
    // "YpNmj7dZzT4",
    // "t0mWGmOlw6M",
    // "spiHw2VYbK4",
    // "UeEZouPYgfY",
    // "gXS7wtAW1Bw",
    // "PlDQ7lpIR28",
    // "799z9cygU0s",
    // "UjxtLwbii1k",
    // "sqfkNcRC92g",
    // "bFN3m9uDd9o",
    // "cBKV1KCUgB4",
    // "cnHEwZbK_T8",
    // "ttcHMC1z2Gc",
    // "PIejo90_yxM",
    // "_spJ1v1YcG0",
    // "1Epp195KDs8",
    // "aXpj8w6MkcU",
    // "jgsKy2Yrapw",
    // "1Epp195KDs8",
    // "Uw5jOOiBdsY",
    // "GI7NS2dLWw4",
    // "7Cs2HFYiJCQ",
    // "Mx-wGyI1nSI",
    // "DLLy90Vlem4",
    // "aXpj8w6MkcU",
    // "Uw5jOOiBdsY",
    // "rxw73wYKeSs",
    // "VdhYYpj_g6A",
    // ];

    // let video = videos[Math.floor(Math.random() * videos.length)];

    // frame = `<iframe width="100%" height="315" src="https://www.youtube.com/embed/${video}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>`;
    // youtube_box.innerHTML = frame;
  }

  open.addEventListener('click',()=>{
    modalOpen();
  });
  
  close.addEventListener('click',()=>{
    modal.classList.add('hidden');
    mask.classList.add('hidden');
    frame = "";
    youtube_box.innerHTML = frame;
  }); 

  mask.addEventListener('click',()=>{
    // modal.classList.add('hidden');
    // mask.classList.add('hidden');
    close.click();
  });
}