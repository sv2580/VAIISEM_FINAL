let percent = 25;
let beggining = 25;

var intervalNum = 0;


function increase(elementID) {
    var x = window.matchMedia("(min-width: 767px)")
    funkcia(x, elementID);
    resetWidth(x);
    x.addListener(funkcia);
}

function funkcia(x, elementID) {
    if (x.matches) {
        let beggining = 25;
        if(percent > 32)
        {
            percent = 25;
        }
        clearInterval(intervalNum);
        intervalNum = setInterval(
            function add() {
                if (percent < beggining + 7) {
                    percent++;
                    console.log(percent);
                    document.getElementById(elementID).style.width = percent + "%";
                } else {
                    clearInterval(intervalNum);
                }
            }, 20);
        } else {
        clearInterval(intervalNum);

        for(let i = 1; i < 6; i++){
            document.getElementById("column"+i).style.width = 100 + "%";
        }

    }
}

function resetWidth(x){
    if (!x.matches) {
        clearInterval(intervalNum);

        for(let i = 1; i < 6; i++){
            document.getElementById("column"+i).style.width = 100 + "%";
        }
        console.log(percent);} else {
        for(let i = 1; i < 6; i++){
            document.getElementById("column"+i).style.width = 25 + "%";
        }
    }
}

function reset(element) {
    clearInterval(intervalNum);
    intervalNum = setInterval(
        function add() {
            if (percent > beggining) {
                percent--;
                console.log(percent);
                document.getElementById(element).style.width = percent + "%";
            } else {
                clearInterval(intervalNum);

            }
        }, 1);
    console.log(percent);
}

