'use strict';

//要素を取得
const edit_modal = document.querySelector('.edit_modal');
const edit_open = document.querySelector('.edit_modal_open_button');
const edit_close = document.querySelector('.edit_modal_close');
const edit_modal_content = document.querySelector('.edit_modal_content');
const array_num = document.querySelector('.tag_edit_select');

//「開くボタン」をクリックしてモーダルを開く
function modalOpen() {
  edit_modal.classList.add('is-active');
  const input_tag_name = document.createElement('input');
  input_tag_name.value = array_num.options[array_num.selectedIndex].text;
  input_tag_name.type = 'text';
  input_tag_name.name = 'tag_name';
  input_tag_name.className = 'edit_input_form';
  const input_tag_id = document.createElement('input');
  input_tag_id.type = 'hidden';
  input_tag_id.name = 'tag_id';
  input_tag_id.value = array_num.value;
  edit_modal_content.appendChild(input_tag_id);
  edit_modal_content.prepend(input_tag_name);
}
edit_open.addEventListener('click', modalOpen);

//「閉じるボタン」をクリックしてモーダルを閉じる
function modalClose() {
  edit_modal.classList.remove('is-active');
  edit_modal_content.firstElementChild.remove();
  edit_modal_content.lastElementChild.remove();
}
edit_close.addEventListener('click', modalClose);

//「モーダルの外側」をクリックしてモーダルを閉じる
function modalOut(e) {
  if (e.target == edit_modal) {
    edit_modal.classList.remove('is-active');
    edit_modal_content.firstElementChild.remove();
    edit_modal_content.lastElementChild.remove();
  }
}
addEventListener('click', modalOut);