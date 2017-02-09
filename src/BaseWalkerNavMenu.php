<?php

namespace IndigoTree\BootstrapNavWalker;

class BaseWalkerNavMenu extends \Walker_Nav_Menu
{
    /**
     * Starts the list before the elements are added.
     * 
     * @since 3.0.0
     * @see Walker::start_lvl()
     *
     * @param string   $output Passed by reference. Used to append additional content.
     * @param int      $depth  Depth of menu item. Used for padding.
     * @param stdClass $args   An object of wp_nav_menu() arguments.
     */
    public function start_lvl(&$output, $depth = 0, $args = [])
    {
        if (isset($args->item_spacing) && 'discard' === $args->item_spacing) {
            $t = $n = '';
        } else {
            $t = "\t";
            $n = "\n";
        }

        $indent = str_repeat($t, $depth);
        $output .= "{$n}{$indent}<{$this->dropdown_tag} class=\"dropdown-menu\">{$n}";
    }

    /**
     * Traverse elements to create list from elements.
     *
     * @since 2.5.0
     *
     * @param object $element           Data object.
     * @param array  $children_elements List of elements to continue traversing.
     * @param int    $max_depth         Max depth to traverse.
     * @param int    $depth             Depth of current element.
     * @param array  $args              An array of arguments.
     * @param string $output            Passed by reference. Used to append additional content.
     */
    public function display_element($element, &$children_elements, $max_depth, $depth, $args, &$output)
    {
        if (!$element) {
            return;
        }

        if (isset($args[0]) && is_object($args[0])) {
            $args[0]->has_children = !empty($children_elements[$element->{$this->db_fields['id']}]);
        }

        parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
    }

    /**
     * Combine attribute array into a key/value string
     *
     * @param array $atts
     * @return string
     */
    protected function combineAttributes($atts)
    {
        $attributes = '';

        foreach ($atts as $attr => $value) {
            if (!empty($value)) {
                $value = 'href' === $attr ? esc_url($value) : esc_attr($value);
                $attributes .= ' '.$attr.'="'.$value.'"';
            }
        }

        return $attributes;
    }
}