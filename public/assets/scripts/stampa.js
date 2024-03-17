document.addEventListener('DOMContentLoaded', function () {
    const stampaBtn = document.querySelector('.dodajNoviLink');
    stampaBtn.addEventListener('click', function (event) {
        console.log('radi');
        event.preventDefault();
        window.print();
    });
});

