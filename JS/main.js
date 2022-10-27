function getAge(date) {
	var today = new Date();
	var birthDate = new Date(date);
	var age = today.getFullYear() - birthDate.getFullYear();
	var m = today.getMonth() - birthDate.getMonth();
	if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
		age = age - 1;
	}

	document.getElementById("age").innerHTML = age + " ans";

	return age;
}

getAge("11/27/2001");

// Envoie du mail avec AJAX
var xhr = new XMLHttpRequest();

xhr.onreadystatechange = function () {
	switch (this.readyState) {
		case 0:
			console.log("Requête non initialisée");
			break;
		case 1:
			console.log("Connexion au serveur établie");
			break;
		case 2:
			console.log("Requête reçue par le serveur");
			break;
		case 3:
			console.log("Traitement de la requête");
			break;
		case 4:
			console.log("Requête terminée et réponse reçue");
			if (this.status == 200) {
				etat("ok");
			} else if (this.status == 403) {
				console.log("Erreur 403");
				etat("no");
			} else if (this.status == 404) {
				console.log("Erreur 404");
				etat("no");
			}
			break;
	}
};

var form = document.querySelector(".Contact__form");

form.addEventListener("submit", (e) => {
	e.preventDefault();

	var data = new FormData(form);
	xhr.open("POST", "mail.php", true);
	xhr.send(data);
});

function etat(message) {
	var txt = document.querySelector(".button__send");

	if (message == "ok") {
		txt.classList.add("button__send--ok");
		txt.innerHTML = '<i class="far fa-check-circle"></i>';
	} else if (message == "no") {
		txt.classList.add("button__send--no");
		txt.innerHTML = '<i class="fas fa-times"></i>';
	}
}
