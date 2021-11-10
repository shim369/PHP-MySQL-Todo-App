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
}