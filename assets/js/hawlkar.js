function get_allPosts(params = {"category": '', "query" : "", "page": 1}) {
	let category = params.category ? params.category : "";
	let query = params.query ? params.query : ""; 
	let page = params.page ? params.page : 1;

	// Data to send in the POST request
	let postData = {
	    category,
	    query,
	    page
	};

	$.post("./incs/api.php?get=posts", postData, function(data, status) {
	    // console.log(data, status)
	    if (status === "success") {
	        let res = JSON.parse(data);
	        let posts = res.data;

	        // console.log(res)

	        // Handle the posts data
	        let postsHTML = '';
	        posts.forEach(function(post) {
	            // console.log(post);
	            postsHTML += `<div class="blog-box row">
	                <div class="col-md-4">
	                    <div class="post-media">
	                        <a href="./article/${post.post_id}" title="${post.title}">
	                            <img src="./assets/images/articles/${post.image}" alt="Article image" class="img-fluid">
	                            <div class="hovereffect"></div>
	                        </a>
	                    </div>
	                </div>

	                <div class="blog-meta big-meta col-md-8">
	                    <span class="bg-aqua"><a href="./article/${post.post_id}" title="${post.title}">${post.name}</a></span>
	                    <h4><a href="./article/${post.post_id}" title="${post.title}">${post.title}</a></h4>
	                    <p>${post.excerpt}</p>
	                    <small><a href="./${post.name.toLowerCase()}" title=""><i class="fa fa-eye"></i> ${post.views}</a></small>
	                    <small><a href="./article/${post.post_id}" title="${post.title}">${formatDate(post.created_at)}</a></small>
	                    <small><a title="">${post.full_name}</a></small>
	                </div>
	            </div> <hr class="invis">`;
	        });

	        $('#all_articlesHolder').html(postsHTML)

	        // Pagination
	        let pageNum = 1;
			let currentPage = page; // Assuming currentPage holds the current page number
			let pagination = '';

			console.log(page)
			// Generate pagination links
			pagination += `<li class="page-item"><a class="page-link ${currentPage == pageNum ? 'active' : ''}" href="./${pageNum}">${pageNum}</a></li>`;
			if (res.totalRows > 10) {
			    while (res.totalRows > 0) {
			        pageNum++;
			        pagination += `<li class="page-item "><a class="page-link ${currentPage == pageNum ? 'active' : ''}" href="./${pageNum}">${pageNum}</a></li>`;
			        res.totalRows -= 10;
			    }
			}
			pagination += `<li class="page-item"><a class="page-link" href="./${parseFloat(currentPage) + 1}">Next</a></li>`;

	        $('#pagination-list').html(pagination)
	    } else {
	        console.error("Failed to fetch posts");
	    }
	});

	// console.log(category, query, page) ;
}

function get_mostViewed() {
	$.post(base_uri+"/incs/api.php?get=mostViewed", function(data, status) {
	    // console.log(data, status)
	    if (status === "success") {
	        let res = JSON.parse(data);
	        let posts = res.data;

	        // Handle the posts data
	        let postsHTML = '';
	        posts.forEach(function(post) {
	            // console.log(post);
	            postsHTML += `<a href="./article/${post.post_id}" class="list-group-item list-group-item-action flex-column align-items-start">
                        <div class="w-100 justify-content-between">
                            <img src="${base_uri}/assets/images/articles/${post.image}" alt="Article image" class="img-fluid float-left">
                            <h5 class="mb-1">${post.title}</h5>
                            <small>${formatDate(post.created_at)}</small>
                        </div>
                    </a>`;
	        });

	        $('#most-viewed-posts').html(postsHTML)



	    } else {
	        console.error("Failed to fetch posts");
	    }
	});
}

function formatDate(inputDate) {
	// Parse input string into a Date object
	const date = new Date(inputDate);

	// Define month names
	const monthNames = [
	"January", "February", "March",
	"April", "May", "June", "July",
	"August", "September", "October",
	"November", "December"
	];

	// Extract components
	const day = date.getDate();
	const month = monthNames[date.getMonth()].toUpperCase();
	const year = date.getFullYear();

	// Format the desired date string
	const formattedDate = `${day.toString().padStart(2, '0')} ${month}, ${year}`;

	return formattedDate;
}


$('.search_posts').on('keyup', (e) => {
	let value = $(e.target).val();
	if(value.length > 0) {
		let data = {"query": value}
		get_allPosts(data);
	} else {
		get_allPosts();
	}
})

