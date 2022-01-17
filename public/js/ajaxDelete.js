function deleteUser(userId) {
    fetch("?c=auth&a=deleteUser",
        {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body:
                "userId=" + userId
        })
}

window.onload = function () {
    var users = new Users();
    users.getUsers();
    users.run();
}

class Users {

    getUsers() {
        let total = 0;
        fetch("?c=auth&a=getUsers")
            .then(response => response.json())
            .then(data => {
                let html = "";
                let total = 0;
                let style = "";
                for (let user of data) {
                    let col = "";
                    let but = "";
                    if(user.reports == 1){
                        col = "#ffedea";
                    } else if(user.reports >= 2){
                        col = "#f6c4ce";
                    }
                    if (document.getElementById('admin').value == user.email){
                        style = "font-weight: bold";
                        but = "disabled";
                    }
                    total ++;
                    html += ' <tr  style="background-color: '+ col + '"> \n' +
                        '\n' +
                        '            <th scope="row">' + total + '</th>\n' +
                        '            <td  style="'+ style +'">' + user.email +
                         ' </td>\n' +
                        '            <td>'+ user.reports +  '</td>\n' +
                        '\n' +
                        '\n' +
                        '            <td>\n' +
                        '                    <input type="hidden" name="userId" value="<?= $login->getId() ?>">\n' +
                        '                    <button class="btn btn-primary" '+ but +' style="border-color: transparent"\n' +
                        '                              onclick="deleteUser(' + user.id + ') ">\n' +
                        '                        Zmaž\n' +
                        '                    </button>\n' +
                        '            </td>\n' +
                        '\n' +
                        '        </tr>'
                }
                document.getElementById("tableu").innerHTML = html;
            });
    }

    run() {
        setInterval(() => {
            this.getUsers()
        }, 1000);
    }

}

