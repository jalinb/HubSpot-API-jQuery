<?php
/**
 * Template part for displaying the HubSpot blog partial
 */

?>

<?php
$hide_block             = get_sub_field('hide_block');
$remove_margin_bottom   = get_sub_field('remove_margin_bottom');
$title                  = get_sub_field('title');
$api_key                = get_field('hubspot_api_key', 'option');
$filter_by_tags         = get_sub_field('filter_by_tags');
$hubspot_tags           = get_sub_field('hubspot_tags');
$blog_limit             = get_sub_field('blog_limit');
$blog_link_title        = get_sub_field('blog_link_title');
$blog_url               = get_sub_field('blog_url');
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

            <div id="blog-roll" class="row"></div>

            <div id="blog-link" class="row">
                <div class="col-12 text-center">
                    <h3 class="mb-3"><?php echo $blog_link_title; ?></h3>
                    <a class="btn btn-blue" href="<?php echo $blog_url; ?>">All Articles</a>
                </div>
            </div>

        </div>
    </section>


    <script>
        $(document).ready(function() {
            var apiKey = '<?php echo $api_key; ?>'; // Client's API key
            var tagID = '<?php echo $hubspot_tags; ?>'; // Tag ID to filter by
            var blogLimit = '<?php echo $blog_limit; ?>'; // How many blog posts to display
            var blogURL = '<?php echo $blog_url; ?>' // URL for the blog home page
            
            $.ajax({
            url: "https://cors-anywhere.herokuapp.com/https://api.hubapi.com/content/api/v2/blog-posts?hapikey="+apiKey+"<?php if($filter_by_tags):?>&topic_id="+tagID+"<?php endif; ?>&state=PUBLISHED&limit="+blogLimit,
            dataType: "json",
            type: "GET",
        
            success: function(json) {
                $.each(json.objects, function(i, v) {

                    // Date Formatting
                    Date.prototype.customFormat = function(formatString){
                        var YYYY,YY,MMMM,MMM,MM,M,DDDD,DDD,DD,D,hhhh,hhh,hh,h,mm,m,ss,s,ampm,AMPM,dMod,th;
                        YY = ((YYYY=this.getFullYear())+"").slice(-2);
                        MM = (M=this.getMonth()+1)<10?('0'+M):M;
                        MMM = (MMMM=["January","February","March","April","May","June","July","August","September","October","November","December"][M-1]).substring(0,3);
                        DD = (D=this.getDate())<10?('0'+D):D;
                        DDD = (DDDD=["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"][this.getDay()]).substring(0,3);
                        th=(D>=10&&D<=20)?'th':((dMod=D%10)==1)?'st':(dMod==2)?'nd':(dMod==3)?'rd':'th';
                        formatString = formatString.replace("#YYYY#",YYYY).replace("#YY#",YY).replace("#MMMM#",MMMM).replace("#MMM#",MMM).replace("#MM#",MM).replace("#M#",M).replace("#DDDD#",DDDD).replace("#DDD#",DDD).replace("#DD#",DD).replace("#D#",D).replace("#th#",th);
                        h=(hhh=this.getHours());
                        if (h==0) h=24;
                        if (h>12) h-=12;
                        hh = h<10?('0'+h):h;
                        hhhh = hhh<10?('0'+hhh):hhh;
                        AMPM=(ampm=hhh<12?'am':'pm').toUpperCase();
                        mm=(m=this.getMinutes())<10?('0'+m):m;
                        ss=(s=this.getSeconds())<10?('0'+s):s;
                        return formatString.replace("#hhhh#",hhhh).replace("#hhh#",hhh).replace("#hh#",hh).replace("#h#",h).replace("#mm#",mm).replace("#m#",m).replace("#ss#",ss).replace("#s#",s).replace("#ampm#",ampm).replace("#AMPM#",AMPM);
                    };
                    
                    var date = v.publish_date;
                    var blogDate = new Date(date);
                    var formatedDate = blogDate.customFormat("#MMM# #D#, #YYYY# #h#:#mm##AMPM#");
        
                    // Append Blog Posts
                    if(blogLimit == 1){
                        $("#blog-roll").append(
                            "<div id='blogID-"+v.id+"' class='col-12 text-center'>" +
                                "<div class='h-100 bg-white row'>" +
                                    "<div class='col-12 col-sm-6 px-0'>" +
                                        "<div class='blog-img'>" +
                                            "<a href='"+v.url+"'>" +
                                                "<img class='featured-img img-fluid' src='"+v.featured_image+"' alt='"+v.featured_image_alt_text+"' />"+
                                            "</a>" +
                                        "</div>" +
                                    "</div>" +
                                    "<div class='col-12 col-sm-6 p-3 d-flex align-items-center'>" +
                                        "<div class='blog-meta-wrap'>" +
                                            "<div class='blog-meta mb-3'>" +
                                                "<h4 class='blog-title'>"+v.html_title+"</h4>" +
                                                "<div class='author-data'>" +
                                                    "Posted by <span class='author-name'>"+v.blog_author.display_name+"</span> on <span class='blog-date'>"+formatedDate+"</span>" +
                                                "</div>" +
                                            "</div>" +
                                            "<div class='blog-description'>" +
                                                "<p>"+v.meta_description+"</p>" +
                                                "<a class='btn btn-blue' href='"+v.url+"'>Learn More</a>" + 
                                            "</div>" +
                                        "</div>" +
                                    "</div>" +
                                "</div>" +
                            "</div>"
                        );
                    } else if(blogLimit == 2) {
                        $("#blog-roll").append(
                            "<div id='blogID-"+v.id+"' class='col-12 col-md-6 blog-single mb-4'>" +
                                "<div class='h-100 bg-light'>" +
                                    "<div class='blog-img'>" +
                                        "<a href='"+v.url+"'>" +
                                            "<img class='featured-img img-fluid' src='"+v.featured_image+"' alt='"+v.featured_image_alt_text+"' />"+
                                        "</a>" +
                                    "</div>" +
                                    "<div class='blog-content-wrap p-3'>"+
                                        "<div class='blog-meta mb-2'>" +
                                            "<h3 class='blog-title mb-1'>"+v.html_title+"</h3>" +
                                            "<div class='author-data dark font-weight-bold'>" +
                                                "Posted on <span class='blog-date'>"+formatedDate+"</span>" +
                                            "</div>" +
                                        "</div>" +
                                        "<div class='blog-description'>" +
                                            "<p>"+v.meta_description+"</p>" +
                                            "<a class='btn btn-blue' href='"+v.url+"'>Learn More</a>" + 
                                        "</div>" +
                                    "</div>"+
                                "</div>" +
                            "</div>"
                        );
                    } else {
                        $("#blog-roll").append(
                            "<div id='blogID-"+v.id+"' class='col-12 col-md-6 col-lg-4 blog-single mb-4'>" +
                                "<div class='h-100 bg-light'>" +
                                    "<div class='blog-img'>" +
                                        "<a href='"+v.url+"'>" +
                                            "<img class='featured-img img-fluid' src='"+v.featured_image+"' alt='"+v.featured_image_alt_text+"' />"+
                                        "</a>" +
                                    "</div>" +
                                    "<div class='blog-content-wrap p-3'>"+
                                        "<div class='blog-meta mb-2'>" +
                                            "<h3 class='blog-title mb-1'>"+v.html_title+"</h3>" +
                                            "<div class='author-data dark font-weight-bold'>" +
                                                "Posted on <span class='blog-date'>"+formatedDate+"</span>" +
                                            "</div>" +
                                        "</div>" +
                                        "<div class='blog-description'>" +
                                            "<p>"+v.meta_description+"</p>" +
                                            "<a class='btn btn-blue' href='"+v.url+"'>Learn More</a>" + 
                                        "</div>" +
                                    "</div>"+
                                "</div>" +
                            "</div>"
                        );
                    }
                    
                });

            },

            error: function(xhr, status, errorThrown) {

                $("#blog-roll").append(
                    "<div class='col-12 blog-error text-center white'>" +
                        "<p>There was an error loading the featured blog posts. Please click the link below to see all our blog posts.</p>"+
                    "</div>"
                );

            }
            });
        });
    </script>
    
<?php endif; ?>
