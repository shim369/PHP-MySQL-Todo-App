'use strict';
{
  //hamburgerMenu
  const openMenu = document.getElementById('open-menu');
  const overlay = document.querySelector('.overlay');
  const closeMenu = document.getElementById('close-menu');

  openMenu.addEventListener('click',()=>{
    overlay.classList.add('show-menu');
    openMenu.classList.add('hide');
  });
  closeMenu.addEventListener('click',()=>{
    overlay.classList.remove('show-menu');
    openMenu.classList.remove('hide');
  });
  
}