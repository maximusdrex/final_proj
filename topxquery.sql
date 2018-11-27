SELECT bottom_10.pid, bottom_10.article_date, bottom_10.title FROM (SELECT * FROM 
	(SELECT mschaefer_posts.pid, mschaefer_posts.article_date, mschaefer_posts.title, mschaefer_posts.article_desc, mschaefer_posts.img_src, mschaefer_posts.article_src, mschaefer_posts.likes FROM `mschaefer_posts` INNER JOIN mschaefer_user_projects WHERE mschaefer_posts.pid=mschaefer_user_projects.pid AND mschaefer_user_projects.uuid=1 ORDER BY mschaefer_posts.article_date DESC LIMIT :pagelim) AS topx
    ORDER BY topx.article_date ASC LIMIT :pagesize) AS bottom_10
    ORDER BY bottom_10.article_date DESC