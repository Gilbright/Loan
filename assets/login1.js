module.exports = function(name) {
    return `Yo yo ${name} - welcome to Encore!`;
};

// Show/hide password onClick of button using Javascript only

// https://stackoverflow.com/questions/31224651/show-hide-password-onclick-of-button-using-javascript-only

module.exports = function show() {
    const p = document.getElementById('pwd');
    p.setAttribute('type', 'text');
}

module.exports = function hide() {
    var p = document.getElementById('pwd');
    p.setAttribute('type', 'password');
}

var pwShown = 0;

module.exports = document.getElementById("eye").addEventListener("click", function () {
    if (pwShown === 0) {
        pwShown = 1;
        show();
    } else {
        pwShown = 0;
        hide();
    }
}, false);

