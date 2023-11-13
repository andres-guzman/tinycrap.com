/* 

BACKUP FILE ONLY

*/



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
    requestInProgress = true;
    randomImage.addEventListener("animationend", handleAnimationEnd);

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
                    
                    // const imgURL = xhr.responseText;
                    // randomImage.src = imgURL;
                    // randomImage.classList.remove("fade--out");
                    // randomImage.removeEventListener("animationend", handleAnimationEnd);
                    // console.log(xhr.responseText);
                } else {
                    const smile = document.querySelector(".modal--content__main");
                    const errorMessage = document.querySelector(".modal--topbar__error");
                    smile.classList.add("is--hidden");
                    errorMessage.innerHTML += ' <span id="error--message">Error loading the image. Please try again!</span>';
                    console.log("Error!", xhr.responseText);
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