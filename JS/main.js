alert(
	"Actuellement en 2ème année de DUT MMI, je suis à la recherche d'un stage pour valider ma formation. \n\n Bien cordialement, \n REMOND Sven"
);

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
