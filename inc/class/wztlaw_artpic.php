<?php 
class wztlaw_artpic extends WP_Widget
{
    public function __construct()
    {
        $widget_ops = array(
            'name' => __('文章图片', 'wztlaw_artpic'),
            'description' => __('可以选择显示最新文章、随机文章。', 'wztlaw_artpic'),
        );

        parent::__construct(false, false, $widget_ops);
    }
    public function widget($args, $instance)
    {
        extract( $args );
		$limit = $instance['limit'];
		$title = apply_filters('widget_name', $instance['title']);
		$cat          = $instance['cat'];
		$orderby      = $instance['orderby'];
		echo $before_widget;
		echo $before_title.$title.$after_title; 
        echo '<ul class="widget_SpecialCatPosts">';
			 $args = array(
				'post_status' => 'publish', // 只选公开的文章.
				'post__not_in' => array(get_the_ID()),//排除当前文章
				'ignore_sticky_posts' => 1, // 排除置頂文章.
				'orderby' =>  $orderby, // 排序方式.
				'cat'     => $cat,
				'order'   => 'DESC',
				'showposts' => $limit,
				'tax_query' => array( array( 
				'taxonomy' => 'post_format',
				'field' => 'slug',
				'terms' => array(
					//请根据需要保留要排除的文章形式
					'post-format-aside',
					
					),
				'operator' => 'NOT IN',
				) ),
			);
			$query_posts = new WP_Query();
			$query_posts->query($args);
			while( $query_posts->have_posts() ) { 
		    $query_posts->the_post(); 
			echo '<li>
				<a href="'.get_the_permalink().'">';
				$post_extend = get_post_meta( get_the_ID(), 'wztlaw', true );
				preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', get_the_content(), $matches); 
				$alt = isset($post_extend['alt'])&& $post_extend['alt']?$post_extend['alt']:get_the_title();
                if(isset($post_extend['pic']) && $post_extend['pic']){
                    echo '<img src="'. $post_extend['pic'].'" alt="'.$alt.'">';
                }elseif(isset($matches[1][0])){
                    echo '<img src="'. $matches[1][0].'" alt="'.$alt.'">';
                }else{
                    echo '<img src="'.get_template_directory_uri().'/assets/images/nohai.jpg" alt="'.$alt.'">';
                 }
                 echo '</a>
				<h4><a href="'.get_the_permalink().'">'.get_the_title().'</a></h4>
			</li>';
			}
			 wp_reset_query();
	    echo '</ul>';
        echo $after_widget;	
    }



    public function form($instance)
    {
       $instance['title'] = ! empty( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$instance['orderby'] = ! empty( $instance['orderby'] ) ? esc_attr( $instance['orderby'] ) : '';
		$instance['cat'] = ! empty( $instance['cat'] ) ? esc_attr( $instance['cat'] ) : '';
		$instance['limit']    = isset( $instance['limit'] ) ? absint( $instance['limit'] ) : 5;
		?>
        <p style="clear: both;padding-top: 10px;">
        	<label>显示标题：（例如：最新文章、随机文章）
        		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $instance['title']; ?>" />
        	</label>
        </p>
<p style="clear: both;padding-top: 10px;">
	<label> 排序方式：
		<select style="width:100%;" id="<?php echo $this->get_field_id('orderby'); ?>" name="<?php echo $this->get_field_name('orderby'); ?>" style="width:100%;">
			<option value="date" <?php selected('date', $instance['orderby']); ?>>发布时间</option>
			<option value="rand" <?php selected('rand', $instance['orderby']); ?>>随机文章</option>
		</select>
	</label>
</p>
<p style="clear: both;padding-top: 10px;">
	<label>
		分类限制：
		<p>只显示指定分类，填写数字，用英文逗号隔开，例如：1,2 </p>
		<p>排除指定分类的文章，填写负数，用英文逗号隔开，例如：-1,-2。</p>
		<input style="width:100%;" id="<?php echo $this->get_field_id('cat'); ?>" name="<?php echo $this->get_field_name('cat'); ?>" type="text" value="<?php echo $instance['cat']; ?>" size="24" />
	</label>
</p>
<p style="clear: both;padding-top: 10px;">
	<label> 显示数目：
		<input class="widefat" id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="number" value="<?php echo $instance['limit']; ?>" />
	</label>
</p>
<p style="clear: both;padding-top: 10px;"><?php wztlaw_show_category();?></p>
<?php
	
    }
}