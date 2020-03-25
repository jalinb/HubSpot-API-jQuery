<?php
/**
 * Template part for displaying the HubSpot blog partial
 */

$hide_block             = get_sub_field('hide_block');
$remove_margin_bottom   = get_sub_field('remove_margin_bottom');
$title                  = get_sub_field('title');
$api_key                = get_field('hubspot_api_key', 'option');
$filter_by_tags         = get_sub_field('filter_by_tags');
$hubspot_tags           = get_sub_field('hubspot_tags');
$blog_limit             = get_sub_field('blog_limit');
$blog_link_title        = get_sub_field('blog_link_title');
$blog_url               = get_sub_field('blog_url');
$apiKey                 = get_field('hubspot_api_key', 'option'); 

if($filter_by_tags):
    $tags = "&topic_id=$hubspot_tags";
else:
    $tags = '';
endif;
?>

<?php if( empty($hide_block) ) : ?>

    <!-- HubSpot Blog Roll
	========================= -->
    <section class="hubspot-blog<?php if(!$remove_margin_bottom): ?> mb-5<?php endif; ?> py-5">
        <div class="container">

            <div id="blog-header" class="row">
                <div class="col-12 text-center">
                    <h2 class="mb-4"><?php echo $title; ?></h2>
                </div>
            </div>

            <div id="blog-roll" class="row">
                <?php

                if($apiKey):

                    $url = "https://api.hubapi.com/content/api/v2/blog-posts?hapikey=$apiKey$tags&state=PUBLISHED&limit=$blog_limit"; // path to your JSON file
                    $data = file_get_contents($url); // put the contents of the file into a variable
                    $tags = json_decode($data,true); // decode the JSON feed

                    foreach( $tags['objects'] as $tag ) :

                        $blog_url           = $tag['live_domain'];
                        $post_id            = $tag['id'];
                        $title              = $tag['html_title'];
                        $excerpt            = $tag['meta_description'];
                        $image_url          = $tag['featured_image'];
                        $image_alt          = $tag['featured_image_alt_text'];
                        $post_url           = $tag['url'];
                        $raw_date           = $tag['publish_date'];
                        $author             = $tag['blog_author']['display_name'];
                        $author_slug        = $tag['blog_author']['slug'];
                        $author_url         = "https://$blog_url/author/$author_slug";
                        $formatted_date     = date('M d, Y g:sA',$raw_date/1000);
                        
                        if($blog_limit == 1): ?>

                            <div id="blogID-<?php echo $post_id; ?>" class="col-12 text-center">
                                <div class="h-100 bg-white row">
                                    <div class="col-12 col-sm-6 px-0">
                                        <div class="blog-img">
                                            <a href="<?php echo $post_url; ?>">
                                                <img class="featured-img img-fluid" src="<?php echo $image_url; ?>" alt="<?php echo $image_alt; ?>" />
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 p-3 d-flex align-items-center">
                                        <div class="blog-meta-wrap">
                                            <div class="blog-meta mb-3">
                                                <h3 class="blog-title"><?php echo $title; ?></h3>
                                                <div class="author-data dark font-weight-bold">
                                                    Posted by <span class="author-name"><?php echo $author; ?></span> on <span class="blog-date"><?php echo $formatted_date; ?></span>
                                                </div>
                                            </div>
                                            <div class="blog-description">
                                                <p><?php echo $excerpt; ?></p>
                                                <a class="btn btn-blue" href="<?php echo $post_url; ?>">Learn More</a> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php elseif($blog_limit == 2): ?>

                            <div id="blogID-<?php echo $post_id; ?>" class="col-12 col-md-6 blog-single mb-4">
                                <div class="h-100 bg-light">
                                    <div class="blog-img">
                                        <a href="<?php echo $post_url; ?>">
                                            <img class="featured-img img-fluid" src="<?php echo $image_url; ?>" alt="<?php echo $image_alt; ?>" />
                                        </a>
                                    </div>
                                    <div class="blog-content-wrap p-3">
                                        <div class="blog-meta mb-2">
                                            <h3 class="blog-title"><?php echo $title; ?></h3>
                                            <div class="author-data dark font-weight-bold">
                                                Posted by <a href="<?php echo $author_url; ?>" class="author-name"><?php echo $author; ?></a> on <span class="blog-date"><?php echo $formatted_date; ?></span>
                                            </div>
                                        </div>
                                        <div class="blog-description">
                                            <p><?php echo $excerpt; ?></p>
                                            <a class="btn btn-blue" href="<?php echo $post_url; ?>">Learn More</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                        <?php else: ?>

                            <div id="blogID-<?php echo $post_id; ?>" class="col-12 col-md-6 col-lg-4 blog-single mb-4">
                                <div class="h-100 bg-light">
                                    <div class="blog-img">
                                        <a href="<?php echo $post_url; ?>">
                                            <img class="featured-img img-fluid" src="<?php echo $image_url; ?>" alt="<?php echo $image_alt; ?>" />
                                        </a>
                                    </div>
                                    <div class="blog-content-wrap p-3">
                                        <div class="blog-meta mb-2">
                                            <h3 class="blog-title"><?php echo $title; ?></h3>
                                            <div class="author-data dark font-weight-bold">
                                                Posted by <span class="author-name"><?php echo $author; ?></span> on <span class="blog-date"><?php echo $formatted_date; ?></span>
                                            </div>
                                        </div>
                                        <div class="blog-description">
                                            <p><?php echo $excerpt; ?></p>
                                            <a class="btn btn-blue" href="<?php echo $post_url; ?>">Learn More</a> 
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php endif; ?>

                    <?php endforeach; 

                endif; ?>

            </div>

            <div id="blog-link" class="row">
                <div class="col-12 text-center">
                    <h3 class="mb-3"><?php echo $blog_link_title; ?></h3>
                    <a class="btn btn-blue" href="<?php echo $blog_url; ?>">All Articles</a>
                </div>
            </div>

        </div>
    </section>
  
<?php endif; ?>