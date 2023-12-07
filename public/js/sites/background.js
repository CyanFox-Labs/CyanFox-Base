let imagePath = "";
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
            imagePath = response[0].urls.regular;
            photo = response[0].links.html;
            author = response[0].user.name;
            authorLink = response[0].user.links.html;


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

function setImageAsBackground(imagePath, photo, credit, authorLink, author) {

    if (!imagePath) {
        return;
    }

    const bgImageElement = document.getElementById('bg_image');
    const authorElement = document.getElementById("author");
    const photoElement = document.getElementById("photo");

    let translatedPhotoMessage = photoElement.dataset.trans;

    function setSafeHref(element, url, text) {
        let a = document.createElement('a');
        let txt = document.createTextNode(text);

        a.appendChild(txt);
        a.href = url;
        element.parentElement.replaceChild(a, element);
    }

    setSafeHref(photoElement, `${photo}${credit}`, translatedPhotoMessage);
    setSafeHref(authorElement, `${authorLink}${credit}`, author);

    bgImageElement.style.backgroundImage = 'url('+encodeURI(imagePath)+')';
    bgImageElement.style.backgroundSize = 'cover';
    bgImageElement.style.backgroundRepeat = 'no-repeat';
    bgImageElement.style.backgroundPosition = 'center';
    bgImageElement.style.backgroundAttachment = 'fixed';
    bgImageElement.style.backgroundColor =  '#000000';
    bgImageElement.style.filter = "blur(5px)";
}

getImage().then(() =>
    setImageAsBackground(imagePath, photo, credit, authorLink, author)
).catch((error) => {
    console.error('Error:', error);
    document.getElementById('unsplashCredits').classList.add('hidden');
    document.body.style = `
            background: rgb(2,0,36);
            background: linear-gradient(310deg, rgba(2,0,36,1) 0%, rgba(9,9,121,1) 0%, rgba(0,212,255,1) 100%);
            `;
    return error;
});

