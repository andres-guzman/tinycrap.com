// Load random image when any "random--button" is clicked
const randomButtons = Array.from(document.getElementsByClassName("random--button"));
let requestInProgress = false;

function loadRandomImage() {
    if (requestInProgress) {
        console.log("Request is already in progress, skipping this click.");
        return;
    }

    const randomImage = document.querySelector("#random--image");
    randomImage.classList.add("fade--out");
    randomImage.addEventListener("animationend", handleAnimationEnd);
    requestInProgress = true;

    function handleAnimationEnd() {
        const xhr = new XMLHttpRequest();
        
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                requestInProgress = false;
                if (xhr.status === 200) {
                    var parser = new DOMParser();
                    var htmlDoc = parser.parseFromString(xhr.responseText, "text/html");
                    var newRandomImage = htmlDoc.querySelector("#random--image");
                    document.querySelector("#random--image").outerHTML = newRandomImage.outerHTML;
                } else {
                    const smile = document.querySelector(".image--wrapper");
                    const errorMessage = document.querySelector(".image--wrapper");
                    smile.classList.add("is--hidden");
                    errorMessage.innerHTML += '<p id="error--message">Error loading the image. Please refresh the page.</p>';
                    console.log("Error!");
                }
            }
        };

        xhr.open("GET", "loader.php", true);
        xhr.send();
    }
}

randomButtons.forEach(button => {
    button.addEventListener('click', e => {
        e.preventDefault();
        loadRandomImage();
    });
});