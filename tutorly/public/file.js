let percent = 25;
var interveralID =0;
function add(element) {
    if (percent < 30) {
        percent++;
        console.log(percent);
        document.getElementById(element).style.width = percent + "%";
    } else {
        clearInterval(interveralID);

    }
}

function increase(element) {
    clearInterval(interveralID);

    interveralID=setInterval(
        function add() {
            if (percent < 32) {
                percent++;
                console.log(percent);
                document.getElementById(element).style.width = percent + "%";
            } else {
                clearInterval(interveralID);

            }
        },20);
    console.log(percent);
}

function reset(element)
{
    clearInterval(interveralID);

    interveralID=setInterval(
        function add() {
            if (percent > 25) {
                percent--;
                console.log(percent);
                document.getElementById(element).style.width = percent + "%";
            } else {
                clearInterval(interveralID);

            }
        },1);
    console.log(percent);
}

