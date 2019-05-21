<?php

class book_rev_lite_Theme_Support extends WP_Customize_Control
{
	public function render_content()
    {
    }
}

/**

 * A class to create a dropdown for all categories in your wordpress site

 */

 class book_rev_lite_Category_Dropdown_Custom_Control extends WP_Customize_Control

 {

    private $cats = false;



    public function __construct($manager, $id, $args = array(), $options = array("hide_empty" => 0))

    {

        $this->cats = get_categories($options);

        parent::__construct( $manager, $id, $args );

    }



    /**

    * Render the content of the category dropdown

    *

    * @return HTML

    */

    public function render_content()

       {

            if(!empty($this->cats))

            {

                ?>

                    <label>

                      <span class="customize-category-select-control"><b><?php echo esc_html( $this->label ); ?></b></span>

                      <select <?php $this->link(); ?>>

                           <?php

                                foreach ( $this->cats as $cat )

                                {

                                    printf('<option value="%s" %s>%s</option>', $cat->term_id, selected($this->value(), $cat->term_id, false), $cat->name);

                                }

                           ?>

                      </select>

                    </label>

                <?php

            }

       }

 }