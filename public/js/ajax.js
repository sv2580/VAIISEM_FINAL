//Kód prevzatý a prispôsobený z 10 cvičenia

window.onload = function () {
    var reviews = new Reviews();
    reviews.getReviews();
    reviews.run();
    document.getElementById('submit-review').onclick = () => {
        reviews.postReview();
    }
}

class Reviews {
    constructor() {
        document.getElementById("submit-review").onclick = () => this.postReview();
    }

    getReviews() {
        let total = 0;
        fetch("?c=auth&a=getReviews")
            .then(response => response.json())
            .then(data => {
                let html = "";
                for (let review of data) {
                    if (document.getElementById("receiver").value == review.receiver) {
                        total++;
                        html += '<div class="container mt-5" style="border-bottom-color: #9488ad"> <div class="be-comment"style="margin-bottom: 50px !important; border-bottom-color: #9488ad !important">'
                            + '<div class="be-comment-content" style="margin: 10px ; border-color: #9488ad"> <span class="be-comment-name">'
                            + '<strong style="margin-left: 1px"> ' + review.sender + ' </strong>'

                        console.log(document.getElementById("postid").value);
                        if (review.sender == document.getElementById("loggedUser").value) {
                            html +=      '                        <input type="hidden" name="parid" value="'+ document.getElementById("postid").value +'" >\n' +
                                '                        <input type="hidden" name="rewid" value="'+ review.id+ '">\n' +
                                '                                            <button class="btn send btn-primary"\n' +
                                '                                                    style=" border-color: transparent; margin-left: 20px"\n' +
                                '                                                    onclick="deleteRew(' + review.id + ')">\n' +
                                '                                        <strong style=" text-align: right">Zmazať</strong>\n' +
                                '                                    </button>\n' +
                                '                                </form>'
                        }
                        html +=' </span><span class="be-comment-time">' + review.dateof +
                            '<strong style="margin-left: 10px">Hodnotenie:</strong>' + '☆'.repeat(review.rating) +
                            '</span>' +
                            '</span>' +
                            ' <p class="be-comment-text"> ' + review.review + '  </p>    </div></div>  </div>'

                    }


                }
                if(total==0)
                {
                    html += '                <p>K doučovateľovi neboli zatiaľ pridané žiadne recenzie.</p>\n'
                }
                document.getElementById("reviewbox").innerHTML = html;
            });
    }

    run() {
        setInterval(() => {
            this.getReviews()
        }, 1000);
    }

    postReview() {

        let text = document.getElementById("review").value;
        let receiver = document.getElementById("receiver").value;
        let rating = document.querySelector('input[name="rating"]:checked').value;

        if (text.length == 0) {
            alert(" nla ");
            return;
        }
        fetch("?c=auth&a=addReview",
            {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body:
                    "text=" + text +
                    "&receiver=" + receiver +
                    "&rating=" + rating

            })
            .then(response => response.json())
            .then(response => {
                if (response == "error") {
                    alert(" nla ");
                }
            });
    }
}

function deleteRew(deleteRew) {
    console.log(deleteRew);
    fetch("?c=auth&a=deleteReview",
        {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body:
                "rewid=" + deleteRew
        })
}
