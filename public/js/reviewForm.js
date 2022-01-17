window.onload = () => {
    validateInput(document.getElementById("review"), function (value = null) {
        if (value == null || value.length == 0) {
            return "Recenzia musí byť zadaná!";
        }
        if (value.length > 500) {
            return "Recenzia musí byť kratšia!";
        }
    });

    validateInput(document.getElementById("message"), function (value = null) {
        if (value == null || value.length == 0) {
            return "Správa musí byť zadaná!";
        }
        if (value.length > 500) {
            return "Správa musí byť kratšia!";
        }
    });


}

