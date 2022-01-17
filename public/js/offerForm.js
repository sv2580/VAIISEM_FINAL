

window.onload = () => {
    validateInput(document.getElementById("title"), function (value = null) {
        if (value == null || value.length == 0) {
            return "Nadpis musí byť zadaný!";
        }
        if (value.length > 100) {
            return "Nadpis musí mať menej ako 100 znakov!";
        }
    });

    validateInput(document.getElementById("courses"), function (value = null) {
        if (value.length > 100) {
            return "Popis kurzov musí mať menej ako 100 znakov!";
        }
    });

    validateInput(document.getElementById("place"), function (value = null) {
        if (value == null || value.length == 0) {
            return "Miesto musí byť zadané!";
        }
        if (value.length > 100) {
            return "Popis miesta musí mať menej ako 50 znakov!";
        }
    });

    validateInput(document.getElementById("email"), function (value = null) {
        if (value == null || value.length == 0) {
            return "E-mailová adresa musí byť zadaná!";
        }
        if (value.length > 50) {
            return "E-mailová adresa musí mať menej ako 50 znakov!";
        }
        let re = new RegExp('^\\S+@\\S+\\.\\S+$');
        if (!re.test(value)) {
            return "Zadaný email nemá platný formát."
        }
    });

    validateInput(document.getElementById("info"), function (value = null) {
        if (value == null || value.length == 0) {
            return "Zadajte stručné informácie!";
        }
        if (value.length > 100) {
            return "Stručné informácie môžu mať max 255 znakov!";
        }
    });
    validateInput(document.getElementById("moreinfo"), function (value = null) {
        if (value == null || value.length == 0) {
            return "Zadajte ďalšie informácie!";
        }

    });

    validateInput(document.getElementById("pay"), function (value = null) {
        if (value == null || value.length == 0) {
            return "Popis platu musí byť zadaný!";
        }
        if (value.length > 100) {
            return "Popis miesta musí mať menej ako 50 znakov!";
        }
    });


}
