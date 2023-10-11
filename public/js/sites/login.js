let imagePath = "";
let brightnessThreshold = 150;
let photo = "";
let author = "";
let authorLink = "";
let credit = '?utm_source=CyanFox&utm_medium=referral'

async function getImage() {
    await fetch("/api/v1/unsplash", {
        cache: "no-store",
    })
        .then((response) => response.json())
        .then((response) => {
            imagePath = response.urls.full;
            photo = response.links.html;
            author = response.user.name;
            authorLink = response.user.links.html;


        }).catch((error) => {
            console.error('Error:', error);
        });
}

function setImageAsBackground() {

    setTextColorFromImageBrightness();
    document.getElementById("photo").href = photo + credit;
    document.getElementById("author").href = authorLink + credit;
    document.getElementById("author").innerHTML = author;

    document.body.style = `
                background-image: url(${imagePath});
                background-size: cover;
                background-repeat: no-repeat;
                background-position: center;
                background-attachment: fixed;
                background-color: #000000;
            `;

}

function setTextColorFromImageBrightness() {
    isImageBright(imagePath, brightnessThreshold, function (isBright) {
        if (isBright) {
            document.getElementById('logo_text').classList.remove('text-white');
            document.getElementById('logo_text').classList.add('text-black');

            document.getElementById('credits').classList.remove('text-white');
            document.getElementById('credits').classList.add('text-black');
        } else {
            document.getElementById('logo_text').classList.remove('text-black');
            document.getElementById('logo_text').classList.add('text-white');

            document.getElementById('credits').classList.remove('text-black');
            document.getElementById('credits').classList.add('text-white');
        }
    });
}

function isImageBright(imageUrl, brightnessThreshold, callback) {
    var img = new Image();
    img.crossOrigin = 'Anonymous';

    img.onload = function () {
        var canvas = document.createElement('canvas');
        canvas.width = img.width;
        canvas.height = img.height;

        var ctx = canvas.getContext('2d');
        ctx.drawImage(img, 0, 0);

        var imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
        var data = imageData.data;
        var brightness = 0;

        for (var i = 0; i < data.length; i += 4) {
            var r = data[i];
            var g = data[i + 1];
            var b = data[i + 2];

            // https://www.w3.org/TR/AERT/#color-contrast
            brightness += (0.299 * r + 0.587 * g + 0.114 * b);
        }

        brightness = brightness / (img.width * img.height);

        var isBright = brightness > brightnessThreshold;

        callback(isBright);
    };

    img.src = imageUrl;
}
getImage().then(r =>
    setImageAsBackground());

document.addEventListener("DOMContentLoaded", function () {
    window.addEventListener('userExists', event => {
        setTextColorFromImageBrightness();
    });
});
