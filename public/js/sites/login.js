let imagePath = "";
let brightnessThreshold = 150;

function changeBackground() {
    fetch("/api/v1/unsplash", {
        cache: "no-store"
    })
        .then((response) => response.json())
        .then((response) => {
            imagePath = response.urls.raw;
            let photo = response.links.html;
            let author = response.user.name;
            let authorLink = response.user.links.html;
            let credit = '?utm_source=CyanFox&utm_medium=referral'
            document.getElementById("photo").href = photo + credit;
            document.getElementById("author").href = authorLink + credit;
            document.getElementById("author").innerHTML = author;

            setTextColorFromImageBrightness();

            document.body.style = `
                background-image: url(${imagePath});
                background-size: cover;
                background-repeat: no-repeat;
                background-position: center;
                background-attachment: fixed;
                background-color: #000000;
            `;
        }).catch((error) => {
        console.error('Error:', error);
    });

}

function setTextColorFromImageBrightness() {
    let spans = document.getElementsByTagName("span");

    isImageBright(imagePath, brightnessThreshold, function (isBright) {
        if (isBright) {
            if (document.getElementById("username") === null) {
                document.getElementById("username").classList.add("text-black");
            }
            if (document.getElementById("two_factor_code_label") !== null) {
                document.getElementById("two_factor_code_label").classList.add("text-black");
            }

            for (let i = 0; i < spans.length; i++) {
                spans[i].classList.remove("text-white");
                spans[i].classList.add("text-black");
            }
        } else {
            if (document.getElementById("username") === null) {
                document.getElementById("username").classList.add("text-white");
            }
            if (document.getElementById("two_factor_code_label") !== null) {
                document.getElementById("two_factor_code_label").classList.add("text-white");
            }

            for (let i = 0; i < spans.length; i++) {
                spans[i].classList.remove("text-black");
                spans[i].classList.add("text-white");
            }
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

document.addEventListener("DOMContentLoaded", function () {
    changeBackground();
    window.addEventListener('userExists', event => {
        setTextColorFromImageBrightness();
    });
});
