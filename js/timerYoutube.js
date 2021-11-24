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
  const youtube_box = document.getElementById('youtube_box');
  


  
  

  function modalOpen() {
    
    modal.classList.remove('hidden');
    mask.classList.remove('hidden');
    selectYoutube();
  }

  open.addEventListener('click',()=>{
    modalOpen();
  });
  
  close.addEventListener('click',()=>{
    modal.classList.add('hidden');
    mask.classList.add('hidden');
    selectYoutube();
  }); 

  mask.addEventListener('click',()=>{
    close.click();
  });
}