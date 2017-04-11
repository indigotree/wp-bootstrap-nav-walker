<?php

namespace IndigoTree\BootstrapNavWalker\Four;

use IndigoTree\BootstrapNavWalker\BaseWalkerNavMenu;

class WalkerNavMenu extends BaseWalkerNavMenu
{
    /**
     * HTML tag to use for dropdown menus
     *
     * @var string
     */
    protected $dropdown_tag = 'div';

    /**
     * Ends the list of after the elements are added.
     *
     * @since 3.0.0
     * @see Walker::end_lvl()
     *
     * @param string   $output Passed by reference. Used to append additional content.
     * @param int      $depth  Depth of menu item. Used for padding.
     * @param stdClass $args   An object of wp_nav_menu() arguments.
     */
    public function end_lvl(&$output, $depth = 0, $args = [])
    {
        if (isset($args->item_spacing) && 'discard' === $args->item_spacing) {
            $t = $n = '';
        } else {
            $t = "\t";
            $n = "\n";
        }

        $indent = str_repeat($t, $depth);
        $output .= "{$indent}</div>{$n}";
    }

    /**
     * Starts the element output.
     * 
     * @since 3.0.0
     * @see Walker::start_el()
     *
     * @param string   $output Passed by reference. Used to append additional content.
     * @param WP_Post  $item   Menu item data object.
     * @param int      $depth  Depth of menu item. Used for padding.
     * @param stdClass $args   An object of wp_nav_menu() arguments.
     * @param int      $id     Current item ID.
     */
    public function start_el(&$output, $item, $depth = 0, $args = [], $id = 0)
    {
        $t = isset($args->item_spacing) && 'discard' === $args->item_spacing ? '' : "\t";

        $indent = $depth ? str_repeat($t, $depth) : '';

        $classes = empty($item->classes) ? [] : (array) $item->classes;
        $classes[] = 'nav-item';

        if ($args->has_children) {
            $classes[] = 'dropdown';
        }

        if (in_array('current-menu-item', $classes)) {
            $classes[] = 'active';
        }

        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));
        $class_names = $class_names ? ' class="'.esc_attr($class_names).'"' : '';

        $id = apply_filters('nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args, $depth);
        $id = $id ? ' id="'.esc_attr($id).'"' : '';

        if (0 === $depth) {
            $output .= $indent.'<li'.$id.$class_names.'>';
        } else {
            $output .= $indent;
        }

        $atts = [];
        $atts['title']  = !empty($item->title)   ? $item->title  : '';
        $atts['target'] = !empty($item->target)  ? $item->target : '';
        $atts['rel']    = !empty($item->xfn)     ? $item->xfn    : '';
        $atts['class'] = 'nav-link';

        if ($args->has_children && 0 === $depth && $args->depth > 1) {
            $atts['href']           = '#';
            $atts['data-toggle']    = 'dropdown';
            $atts['class']         .= ' dropdown-toggle';
            $atts['aria-haspopup']  = 'true';
            $atts['aria-expanded']  = 'false';
        } else {
            if (1 === $depth) {
                $atts['class'] = 'dropdown-item';
            }
            $atts['href'] = !empty($item->url) ? $item->url : '';
        }

        $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args, $depth);
        $attributes = $this->combineAttributes($atts);

        $title = apply_filters('the_title', $item->title, $item->ID);
        $title = apply_filters('nav_menu_item_title', $title, $item, $args, $depth);

        $item_output = $args->before;
        $item_output .= '<a'.$attributes.'>';
        $item_output .= $args->link_before.$title.$args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }

    /**
     * Ends the element output, if needed.
     *
     * @since 3.0.0
     * @see Walker::end_el()
     *
     * @param string   $output Passed by reference. Used to append additional content.
     * @param WP_Post  $item   Page data object. Not used.
     * @param int      $depth  Depth of page. Not Used.
     * @param stdClass $args   An object of wp_nav_menu() arguments.
     */
    public function end_el(&$output, $item, $depth = 0, $args = [])
    {
        if (isset($args->item_spacing) && 'discard' === $args->item_spacing) {
            $t = $n = '';
        } else {
            $t = "\t";
            $n = "\n";
        }

        $output .= 0 === $depth ? "</li>{$n}" : "{$n}";
    }
}
