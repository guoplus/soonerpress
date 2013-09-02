<?php


    /**
    * 
    * Post Types Order Walker Class
    * 
    */
    class Post_Types_Order_Walker extends Walker 
        {

            var $db_fields = array ('parent' => 'post_parent', 'id' => 'ID');


            function start_lvl(&$output, $depth = 0, $args = array()) 
                {
                    extract($args, EXTR_SKIP);
                      
                    $indent = str_repeat("\t", $depth);
                    $output .= "\n$indent<ul class='children'>\n";
                }


            function end_lvl(&$output, $depth = 0, $args = array()) 
                {
                    extract($args, EXTR_SKIP);
                           
                    $indent = str_repeat("\t", $depth);
                    $output .= "$indent</ul>\n";
                }


            function start_el(&$output, $post_info, $depth = 0, $args = array(), $current_object_id = 0) 
                {
                    if ( $depth )
                        $indent = str_repeat("\t", $depth);
                    else
                        $indent = '';

                    $post_data = get_post($post_info);
                    
                    if ($post_data->post_type == 'attachment')
                        $post_data->post_parent = null;
                        
                    extract($args, EXTR_SKIP);
                    
                    $is_woocommerce = FALSE;                
                    if ($post_data->post_type == "product" && in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) )
                        $is_woocommerce = TRUE;

                    $options = get_option('cpto_options');
                    
                    //check post thumbnail
                    if (function_exists('get_post_thumbnail_id'))
                            {
                                $image_id = get_post_thumbnail_id( $post_data->ID , 'post-thumbnail' );
                            }
                        else
                            {
                                $image_id = NULL;    
                            }
                    if ($image_id > 0)
                        {
                            $image = wp_get_attachment_image_src( $image_id , array(64,64)); 
                            if($image !== FALSE)
                                $image_html =  '<img src="'. $image[0] .'" width="64" alt="" />';
                                else
                                $image_html =  '<img src="'. CPTURL .'/images/nt.gif" width="64" alt="" />'; 
                        }
                        else
                            {
                                $image_html =  '<img src="'. CPTURL .'/images/nt.gif" width="64" alt="" />';    
                            }
                    
                    
                    //allow the thumbnail image to be changed through a filter
                    $image_html = apply_filters( 'apto_reorder_item_thumbnail', $image_html, $post_data->ID );
                    
                    $noNestingClass = '';
                    $post_type_data = get_post_type_object($post_data->post_type);
                    if ($post_type_data->hierarchical !== TRUE && $is_woocommerce === FALSE)
                        $noNestingClass = ' no-nesting';
                    
                    $output .= $indent . '<li class="post_type_li'.$noNestingClass.'" id="item_'.$post_data->ID.'"><div class="item"><div class="post_type_thumbnail"';
                    
                    if (isset($options['always_show_thumbnails']) && $options['always_show_thumbnails'] == "1")
                        $output .= ' style="display: block"';
                        
                    $output .= '>'. $image_html .'</div><span class="i_description">'.apply_filters( 'the_title', $post_data->post_title, $post_data->ID );
                    
                    $additiona_details = ' ('.$post_data->ID.')';
                    $additiona_details = apply_filters('apto_reorder_item_additional_details', $additiona_details, $post_data);
                    $output .= $additiona_details;
                    
                    if ($post_data->post_status != 'publish')
                        $output .= ' <span>'.$post_data->post_status.'</span>';
                     
                    $output .= '</span><span class="move_top" title="Move to Top" onClick="apto_move_top(jQuery(this).closest(\'.post_type_li\'))"><img src="'. CPTURL  .'/images/move-top.png" alt="Move to Top" width="11" height="16" /></span><span class="edit" title="Edit"><a href="'. get_bloginfo('wpurl') .'/wp-admin/post.php?post='.$post_data->ID.'&action=edit">Edit</a></span></div>';
                }


            function end_el(&$output, $post_data, $depth = 0, $args = array()) 
                {
                    $output .= "</li>\n";
                }
                
            function display_element( $element, &$children_elements, $max_depth, $depth = 0, $args = array(), &$output ) 
                {
                    if ( !$element )
                        return;

                    $id_field = $this->db_fields['id'];

                    $element = get_post($element);
                    
                    //display this element
                    if ( is_array( $args[0] ) )
                        $args[0]['has_children'] = ! empty( $children_elements[$element->$id_field] );
                    $cb_args = array_merge( array(&$output, $element, $depth), $args);
                    call_user_func_array(array($this, 'start_el'), $cb_args);

                    $id = $element->$id_field;

                    // descend only when the depth is right and there are childrens for this element
                    if ( ($max_depth == 0 || $max_depth > $depth+1 ) && isset( $children_elements[$id]) ) 
                        {

                            foreach( $children_elements[ $id ] as $child )
                                {

                                    if ( !isset($newlevel) ) 
                                        {
                                            $newlevel = true;
                                            //start the child delimiter
                                            $cb_args = array_merge( array(&$output, $depth), $args);
                                            call_user_func_array(array($this, 'start_lvl'), $cb_args);
                                        }
                                    $this->display_element( $child, $children_elements, $max_depth, $depth + 1, $args, $output );
                                }
                            unset( $children_elements[ $id ] );
                        }

                    if ( isset($newlevel) && $newlevel )
                        {
                            //end the child delimiter
                            $cb_args = array_merge( array(&$output, $depth), $args);
                            call_user_func_array(array($this, 'end_lvl'), $cb_args);
                        }

                    //end this element
                    $cb_args = array_merge( array(&$output, $element, $depth), $args);
                    call_user_func_array(array($this, 'end_el'), $cb_args);
                }

        }





?>