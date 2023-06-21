// const menu = document.getElementsByClassName('list-item');

// for (var i = 0; i < menu.length; i++) {
//   menu[i].addEventListener('click', function (event) {
//     event.preventDefault();
//     this.classList.toggle('aktif');
//     console.log('ok');
//   });
// }

const menu = document.getElementsByClassName('list-item');
let activeItem = null;

for (var i = 0; i < menu.length; i++) {
  menu[i].addEventListener('click', function (event) {
    // event.preventDefault();
    if (activeItem !== null) {
      activeItem.classList.remove('aktif');
    }
    activeItem = this;
    this.classList.add('aktif');
  });
}
