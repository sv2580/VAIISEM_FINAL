    window.onload = (editProfile) => {
    validateInput(document.getElementById("newpassword"), function (value = null){
        if (value == null || value.length == 0) {
            return "Nové heslo musí byť zadané";
        }
        if (value.length < 8 || value.length > 30) {
            return "Nové heslo musí mať od 8 do 30 znakov!";
        }
        var hasNumber = /\d/;
        if (!hasNumber.test(value) || !isUpper(value))
        {
            return "Heslo musí obsahovať aspoň jedno veľké písmeno a číslo";
        }
    });
    validateInput(document.getElementById("oldpassword"), function (value = null){
    if (value == null || value.length == 0) {
    return "Pôvodné heslo musí byť zadané";
}
});
    validateInput(document.getElementById("password"), function (value = null){
    if (value == null || value.length == 0) {
    return "Pôvodné heslo musí byť zadané";
}
});
}