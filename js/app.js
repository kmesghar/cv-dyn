function showElement(element) {
    element.classList.remove("hidden");
    element.classList.add("shown");
}

function hideElement(element) {
    element.classList.remove("shown");
    element.classList.add("hidden");
}

function manageAbstract() {
    var btn = document.getElementById("btn-abstract");
    var row = document.getElementById("row-abstract");

    if (btn.innerText == "Ajouter un extrait") {
        showElement(row);
        btn.innerText = "Retirer l'extrait";
    } else {
        hideElement(row);
        btn.innerText = "Ajouter un extrait";

        // réinitialiser le champs:
        document.getElementById("abstract").value = "";
    }

    return false;
}

function manageHeader() {
    var btn = document.getElementById("btn-header");
    var row = document.getElementById("row-header");

    if (btn.innerText == "Ajouter un en-tête") {
        showElement(row);
        btn.innerText = "Retirer l'en-tête";
    } else {
        hideElement(row);
        btn.innerText = "Ajouter un en-tête";

        // réinitialiser le champs:
        document.getElementById("header").value = "";
    }

    return false;
}

function manageFooter() {
    var btn = document.getElementById("btn-footer");
    var row = document.getElementById("row-footer");

    if (btn.innerText == "Ajouter un pied de page") {
        showElement(row);
        btn.innerText = "Retirer le pied de page";
    } else {
        hideElement(row);
        btn.innerText = "Ajouter un pied de page";

        // réinitialiser le champs:
        document.getElementById("footer").value = "";
    }

    return false;
}

function manageKeywords() {
    var btn = document.getElementById("btn-keywords");
    var row = document.getElementById("row-keywords");

    if (btn.innerText == "Ajouter des mots-clés") {
        showElement(row);
        btn.innerText = "Retirer les mots-clés";
    } else {
        hideElement(row);
        btn.innerText = "Ajouter des mots-clés";

        // réinitialiser le champs:
        document.getElementById("keywords").value = "";
    }

    return false;
}

function init() {
    console.log("init...");

    var lay = document.getElementById("btn-overlay");
    if (lay) {
        document.getElementById("btn-abstract").addEventListener("click", manageAbstract);
        document.getElementById("btn-header").addEventListener("click", manageHeader);
        document.getElementById("btn-footer").addEventListener("click", manageFooter);
        document.getElementById("btn-keywords").addEventListener("click", manageKeywords);
    }
}

document.addEventListener("DOMContentLoaded", init);