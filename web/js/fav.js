var elements = document.getElementsByClassName("heart");

var myFunction = function() {
    var id = this.getAttribute("id");
    var src = this.getAttribute("src");

    let heart = document.getElementById(id);
    if(src==="/images/heart2.png"){
        let url="/prikaz/favorite?id=" + id;
        console.log(url);
        $.ajax({
            url: url,
            type: "GET",
            async: false,
            cache: false,
            contentType: "application/json; charset=utf-8",
            success: function(data, textStatus, jqXHR) {
                let res=JSON.parse(data);
                if(res==='ok'){
                    console.log("ok")
                    heart.src="/images/heart.png"
                }
            }
        })
    }


    if(src==="/images/heart.png"){
        let url="/prikaz/delfav?id=" + id;
        console.log(url);
        $.ajax({
            url: url,
            type: "GET",
            async: false,
            cache: false,
            contentType: "application/json; charset=utf-8",
            success: function(data, textStatus, jqXHR) {
                let res=JSON.parse(data);
                if(res==='ok'){
                    heart.src="/images/heart2.png"
                }
            }
        })




    }

};

for (var i = 0; i < elements.length; i++) {
    elements[i].addEventListener('click', myFunction, false);
}