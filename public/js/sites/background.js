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
            imagePath = response.urls.regular;
            photo = response.links.html;
            author = response.user.name;
            authorLink = response.user.links.html;


        }).catch((error) => {
            console.error('Error:', error);
            document.getElementById('unsplashCredits').classList.add('hidden');
            document.body.style = `
            background: rgb(2,0,36);
            background: linear-gradient(310deg, rgba(2,0,36,1) 0%, rgba(9,9,121,1) 0%, rgba(0,212,255,1) 100%);
            `;
            return error;
        });
}

function setImageAsBackground() {

    if (imagePath === "" || imagePath === undefined || imagePath === null) {
        return;
    }

    document.getElementById("photo").href = photo + credit;
    document.getElementById("author").href = authorLink + credit;
    document.getElementById("author").innerHTML = author;

    document.getElementById('bg_image').style = `
                background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url(${imagePath});
                background-size: cover;
                background-repeat: no-repeat;
                background-position: center;
                background-attachment: fixed;
                background-color: #000000;
                filter: blur(5px);
            `;

}

getImage().then(r =>
    setImageAsBackground());

