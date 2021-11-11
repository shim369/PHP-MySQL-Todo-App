'use strict';
//チェックボッスに変化があると（チェックを入れると）チェックボックスのformでidが送信され、テーブルのis_doneカラムにtrueが入る。
{
  const checkboxes = document.querySelectorAll('input[type="checkbox"]');

  checkboxes.forEach(checkbox => {
    checkbox.addEventListener('change',()=>{
      checkbox.parentNode.submit();
    });
  });

  const deletes = document.querySelectorAll('.delete');
  deletes.forEach(span => {
    span.addEventListener('click',()=>{
      if (!confirm('Are you sure?')) {
        return;
      }
      span.parentNode.submit();
    });
  });
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