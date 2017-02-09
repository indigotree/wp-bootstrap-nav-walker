<?php

namespace IndigoTree\BootstrapNavWalker\Three;

use IndigoTree\BootstrapNavWalker\BaseWalkerNavMenu;

class WalkerNavMenu extends BaseWalkerNavMenu
{
    /**
     * HTML tag to use for dropdown menus
     *
     * @var string
     */
    protected $dropdown_tag = 'ul';
    
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

        $output .= $indent.'<li'.$id.$class_names.'>';

        $atts = [];
        $atts['title']  = !empty($item->title)   ? $item->title  : '';
        $atts['target'] = !empty($item->target)  ? $item->target : '';
        $atts['rel']    = !empty($item->xfn)     ? $item->xfn    : '';

        if ($args->has_children && 0 === $depth) {
            $atts['href']           = '#';
            $atts['data-toggle']    = 'dropdown';
            $atts['class']          = 'dropdown-toggle';
            $atts['aria-haspopup']  = 'true';
            $atts['aria-expanded']  = 'false';
        } else {
            $atts['href'] = !empty($item->url) ? $item->url : '';
        }

        $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args, $depth);
        $attributes = $this->combineAttributes($atts);

        $title = apply_filters('the_title', $item->title, $item->ID);
        $title = apply_filters('nav_menu_item_title', $title, $item, $args, $depth);

        $item_output = $args->before;
        $item_output .= '<a'.$attributes.'>';
        $item_output .= $args->link_before.$title.$args->link_after;
        $item_output .= $args->has_children && 0 === $depth ? ' <span class="caret"></span></a>' : '</a>';
        $item_output .= $args->after;

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
}
