var elms = document.getElementsByClassName('splide');

for (var i = 0; i < elms.length; i++) {
    new Splide(elms[i], {
        perPage: 5,
        type: 'loop',
        focus: 'center'
    }).mount();
}