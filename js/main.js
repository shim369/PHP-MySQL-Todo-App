'use strict';
{
  const token = document.getElementById('app').dataset.token;
  const inputTitle = document.querySelector('[name="title"]');
  const inputUrls = document.querySelector('[name="urls"]');
  const inputYoutubeId = document.querySelector('[name="youtubeId"]');
  const ul = document.getElementById('list-ul');

  
  inputTitle.focus();

  ul.addEventListener('click', e => {
    if (e.target.type === 'checkbox') {
      fetch('?action=toggle', {
        method: 'POST',
        body: new URLSearchParams({
          id: e.target.parentNode.dataset.id,
          token: token,
        }),
      })
      .then(response => {
        if (!response.ok) {
          throw new Error('This todo has been deleted!');
        }

        return response.json();
      })
      .then(json => {
        if (json.is_done !== e.target.checked) {
          alert('This Todo has been updated. UI is being updated.');
          e.target.checked = json.is_done;
        }
      })
      .catch(err => {
        alert(err.message);
        location.reload();
      });
    }
    if (e.target.classList.contains('delete')) {
      if (!confirm('Are you sure?')) {
        return;
      }
      fetch('?action=delete', {
        method: 'POST',
        body: new URLSearchParams({
          id: e.target.parentNode.dataset.id,
          token: token,
        }),
      });
      e.target.parentNode.remove();
    }
  });

  function addTodo(id,titleValue,urlsValue) {
    const li = document.createElement('li');
    li.dataset.id = id;
    const checkbox = document.createElement('input');
    checkbox.type = 'checkbox';
    const title = document.createElement('span');
    title.textContent = titleValue;
    const alink = document.createElement('a');
    alink.href = urlsValue;
    alink.setAttribute('target', '_blank');
    alink.textContent = titleValue;
    const deleteSpan = document.createElement('span');
    deleteSpan.textContent = 'delete';
    deleteSpan.classList.add('delete','material-icons');

    li.appendChild(checkbox);
    if(urlsValue) {
      const emptySpan = document.createElement('span');
      li.appendChild(emptySpan);
      emptySpan.appendChild(alink);
    } else {
      li.appendChild(title);
    }
    li.appendChild(deleteSpan);

    
    ul.insertBefore(li, ul.firstChild);

  }

  document.getElementById('mainForm').addEventListener('submit', e => {
    e.preventDefault();

    const title = inputTitle.value;
    const urls = inputUrls.value;

    fetch('?action=add', {
      method: 'POST',
      body: new URLSearchParams({
        title: title,
        urls: urls,
        token: token,
      }),
    })
    .then(response => response.json())
    .then(json => {
      addTodo(json.id,title,urls);
    });

    inputTitle.value = '';
    inputUrls.value = '';
    inputTitle.focus();
  });


  const purge = document.querySelector('.purge');
  purge.addEventListener('click',() => {
    if (!confirm('Are you sure?')) {
      return;
    }
    fetch('?action=purge', {
      method: 'POST',
      body: new URLSearchParams({
        token: token,
      }),
    });
    const lis = document.querySelectorAll('li');
      lis.forEach(li => {
        if (li.children[0].checked) {
          li.remove();
        }
      });
  });


  // function addYoutube(ytId) {
  //   const video = ytId;
  //   const youtube_box = getElementById('youtube_box');
  //   youtube_box.innerHTML = `<iframe width="100%" height="315" src="https://www.youtube.com/embed/${video}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>`;

  // }

  document.querySelector('.videoForm').addEventListener('submit', e => {
    e.preventDefault();
    const ytId = inputYoutubeId.value;

    fetch('?action=addYoutube', {
      method: 'POST',
      body: new URLSearchParams({
        youtubeId: ytId,
        token: token,
      }),
    });
    
    inputYoutubeId.value = '';

  });
}