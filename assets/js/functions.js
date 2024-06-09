jQuery( document ).ready(function() {
    $(window).scroll(function(){
    $('.topnav').toggleClass('scrollednav py-0', $(this).scrollTop() > 50);
    });
    
});

/*function get_navbar() {
    $.post("./config/functions.php?get=navbar", function(data) {
        // console.log(data)
        let res = JSON.parse(data);
        let navs = '';
        res.navs.map((nav) => {
            navs += `<li class="nav-item">
                <a class="nav-link" href="./${nav.link}">${nav.category}</a>
            </li>`
        })

        $('#site-navigation').append(navs);
    });
}

async function get_articles(category) {
    let data = await $.post("./config/functions.php?get=articles", function(data) {
    });

    console.log(data)

    let res = JSON.parse(data);
    console.log(res)
    let articles = '';
    res.articles.map((article) => {
        articles += `<div class="mb-3 d-flex justify-content-between">
            <div class="pr-3">
                <h2 class="mb-1 h4 font-weight-bold">
                <a class="text-dark" href="./${article.link}">${article.title}</a>
                </h2>
                <p>
                    ${article.excerpt}
                </p>
                <div class="card-text text-muted small">
                     ${article.author} in ${article.category}
                </div>
                <small class="text-muted">${article.published_at} &middot; ${article.time} min read</small>
            </div>
            <img height="120" style="width:180px;" src="./assets/img/articles/${article.image}">
        </div>`
    })

    $('#all-articles').append(articles);
}*/