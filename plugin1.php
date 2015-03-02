<?php
/*
Plugin Name: My first widget
Plugin URI:
Author: yuriy
Author URI:
*/
 class trueTopPostsWidget extends WP_Widget {

    function __construct() {
        parent::__construct(
            'true_top_widget',
            'Popular posts',
            array( 'description' => 'Allows you to display the posts sorted by the number of comments they.' )
        );
    }

    public function widget( $args, $instance ) {
        $title = apply_filters( 'my Widget ', $instance['title'] );
        $posts_per_page = $instance['posts_per_page'];

        echo $args['before_widget'];

        if ( ! empty( $title ) )
            echo $args['before_title'] . $title . $args['after_title'];

        $q = new WP_Query("posts_per_page=$posts_per_page&orderby=comment_count");
        if( $q->have_posts() ):
            ?><ul><?php
            while( $q->have_posts() ): $q->the_post();
                ?>
                 <li><a href ="<?php the_permalink();?> ">
                      <?php the_title(); the_content(); ?>
                      <?php the_post(); ?></li>
            <?php
            endwhile;
            ?><ul><?php
        endif;
        wp_reset_postdata();

        echo $args['after_widget'];
    }
    public function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        }
        if ( isset( $instance[ 'posts_per_page' ] ) ) {
            $posts_per_page = $instance[ 'posts_per_page' ];
        }
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>">Title</label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'posts_per_page' ); ?>">Number of posts:</label>
            <input id="<?php echo $this->get_field_id( 'posts_per_page' ); ?>" name="<?php echo $this->get_field_name( 'posts_per_page' ); ?>" type="text" value="<?php echo ($posts_per_page) ? esc_attr( $posts_per_page ) : '5'; ?>" size="3" />
        </p>
    <?php
    }
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['posts_per_page'] = ( is_numeric( $new_instance['posts_per_page'] ) ) ?     $new_instance['posts_per_page'] : '5';
        return $instance;
    }
}
function true_top_posts_widget_load() {
    register_widget( 'trueTopPostsWidget' );
}
add_action( 'widgets_init', 'true_top_posts_widget_load' );