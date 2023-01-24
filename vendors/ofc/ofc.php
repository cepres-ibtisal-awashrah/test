<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

class open_flash_chart
{
	public function __construct()
	{
		$this->elements = array();
		$this->num_decimals = 0;
		$this->is_fixed_num_decimals_forced = false;
		$this->is_thousand_separator_disabled = true;
	}
	
	public function set_x_axis( $x )
	{
		$this->x_axis = $x;	
	}
	
	public function set_y_axis( $y )
	{
		$this->y_axis = $y;
	}

	public function set_y_axis_right( $y )
	{
		$this->y_axis_right = $y;
	}
	
	public function add_element( $e )
	{
		$this->elements[] = $e;
	}
	
	public function set_bg_colour( $colour )
	{
		$this->bg_colour = $colour;	
	}
	
	public function set_tooltip( $tooltip )
	{
		$this->tooltip = $tooltip;	
	}
}

class ofc_dot_style
{
	public function set_type( $type )
	{
		$this->type = $type;
	}	

	public function set_halo_size( $size )
	{
		$tmp = 'halo-size';
		$this->$tmp = $size;		
	}	
	
	public function set_colour( $colour )
	{
		$this->colour = $colour;
	}	
		
	public function set_dot_size( $size )
	{
		$tmp = 'dot-size';
		$this->$tmp = $size;		
	}	
}

class ofc_line
{
	public function __construct()
	{
		$this->type = 'line';
		$this->values = array();
	}
	
	public function set_dot_style( $style )
	{
		$tmp = 'dot-style';
		$this->$tmp = $style;	
	}
	
	public function set_default_dot_style( $style )
	{
		$tmp = 'dot-style';
		$this->$tmp = $style;	
	}
	
	public function set_values( $v )
	{
		$this->values = $v;		
	}
	
    public function append_value($v)
    {
        $this->values[] = $v;       
    }
	
	public function set_width( $width )
	{
		$this->width = $width;		
	}
	
	public function set_colour( $colour )
	{
		$this->colour = $colour;
	}

	public function set_halo_size( $size )
	{
		$tmp = 'halo-size';
		$this->$tmp = $size;		
	}
	
	public function set_key( $text, $font_size )
	{
		$this->text = $text;
		$tmp = 'font-size';
		$this->$tmp = $font_size;
	}
	
	public function set_tooltip( $tip )
	{
		$this->tip = $tip;
	}
	
	public function set_on_click( $text )
	{
		$tmp = 'on-click';
		$this->$tmp = $text;
	}
	
	public function loop()
	{
		$this->loop = true;
	}
	
	public function line_style( $s )
	{
		$tmp = "line-style";
		$this->$tmp = $s;
	}
	
    public function set_text($text)
    {
        $this->text = $text;
    }
	
	public function set_axis($axis)
	{
		$this->axis = $axis;
	}
}

class ofc_pie
{
	public function __construct()
	{
		$this->type = 'pie';
	}
	
	public function set_colours( $colours )
	{
		$this->colours = $colours;
	}
	
	public function set_alpha( $alpha )
	{
		$this->alpha = $alpha;
	}
	
	public function set_values( $v )
	{
		$this->values = $v;		
	}

	public function set_animate( $bool )
	{
		if( $bool )
		{
			$this->add_animation( new ofc_pie_fade() );
		}
		else 
		{
			$this->animate = false;
		}
	}
	
	public function add_animation( $animation )
	{
		if( !isset( $this->animate ) )
		{
			$this->animate = array();
		}
			
		$this->animate[] = $animation;		
		return $this;
	}
	
	public function set_start_angle( $angle )
	{
		$tmp = 'start-angle';
		$this->$tmp = $angle;
	}
	
	public function start_angle($angle)
	{
		$this->set_start_angle( $angle );
		return $this;
	}
	
	public function set_tooltip( $tip )
	{
		$this->tip = $tip;
	}
	
	public function set_gradient_fill()
	{
		$tmp = 'gradient-fill';
		$this->$tmp = true;
	}
	
	public function set_label_colour( $label_colour )
	{
		$tmp = 'label-colour';
		$this->$tmp = $label_colour;	
	}
	
	public function set_no_labels()
	{
		$tmp = 'no-labels';
		$this->$tmp = true;
	}
	
	public function on_click( $event )
	{
		$tmp = 'on-click';
		$this->$tmp = $event;
	}
	
	public function set_radius( $radius )
	{
		$this->radius = $radius;
	}
}

class ofc_pie_fade
{
	public function __construct()
	{
		$this->type = "fade";
	}
}

class ofc_pie_bounce
{
	public function __construct( $distance )
	{
		$this->type = "bounce";
		$this->distance = $distance;
	}
}

class ofc_tooltip
{
	public function set_shadow( $shadow )
	{
		$this->shadow = $shadow;
	}
	
	public function set_stroke( $stroke )
	{
		$this->stroke = $stroke;
	}
	
	public function set_colour( $colour )
	{
		$this->colour = $colour;
	}
	
	public function set_background_colour( $bg )
	{
		$this->background = $bg;
	}
	
	public function set_title_style( $style )
	{
		$this->title = $style;
	}
	
    public function set_body_style( $style )
	{
		$this->body = $style;
	}
	
	public function set_proximity()
	{
		$this->mouse = 1;
	}
	
	public function set_hover()
	{
		$this->mouse = 2;
	}
}

class ofc_x_axis_labels
{
	public function set_steps( $steps )
	{
		$this->steps = $steps;
	}
	
	public function set_labels( $labels )
	{
		$this->labels = $labels;
	}
	
	public function set_colour( $colour )
	{
		$this->colour = $colour;
	}
	
	public function set_size( $size )
	{
		$this->size = $size;
	}
	
	public function set_vertical()
	{
		$this->rotate = 270;
	}
	
	public function rotate( $angle )
	{
		$this->rotate = $angle;
	}
}

class ofc_x_axis
{
	public function set_stroke( $stroke )
	{
		$this->stroke = $stroke;	
	}
	
	public function set_colour( $colour )
	{
		$this->colour = $colour;	
	}
	
	public function set_tick_height( $height )
	{
		$tmp = 'tick-height';
		$this->$tmp = $height;
	}
	
	public function set_grid_colour( $colour )
	{
		$tmp = 'grid-colour';
		$this->$tmp = $colour;
	}
	
	public function set_offset( $o )
	{
		$this->offset = $o ? true : false;	
	}
	
	public function set_steps( $steps )
	{
		$this->steps = $steps;
	}
	
	public function set_3d( $val )
	{
		$tmp = '3d';
		$this->$tmp = $val;
	}
	
	public function set_labels( $x_axis_labels )
	{
		$this->labels = $x_axis_labels;
	}
	
	public function set_labels_from_array( $a )
	{
		$x_axis_labels = new ofc_x_axis_labels();
		$x_axis_labels->set_labels( $a );
		$this->labels = $x_axis_labels;
		
		if( isset( $this->steps ) )
		{
			$x_axis_labels->set_steps( $this->steps );
		}
	}
	
	public function set_range( $min, $max )
	{
		$this->min = $min;
		$this->max = $max;
	}
}

class ofc_y_axis_labels
{
	public function set_colour( $colour )
	{
		$this->colour = $colour;
	}
}

class ofc_y_axis
{
	public function set_stroke( $s )
	{
		$this->stroke = $s;
	}
	
	public function set_tick_length( $val )
	{
		$tmp = 'tick-length';
		$this->$tmp = $val;
	}
	
	public function set_colours( $colour, $grid_colour )
	{
		$this->set_colour( $colour );
		$this->set_grid_colour( $grid_colour );
	}
	
	public function set_colour( $colour )
	{
		$this->colour = $colour;
	}
	
	public function set_grid_colour( $colour )
	{
		$tmp = 'grid-colour';
		$this->$tmp = $colour;
	}
	
	public function set_range( $min, $max, $steps = 1 )
	{
		$this->min = $min;
		$this->max = $max;
		$this->set_steps( $steps );
	}
	
	public function set_offset( $off )
	{
		$this->offset = $off ? true : false;
	}
	
	public function set_labels( $labels )
	{
		$this->labels = $labels;	
	}
	
	public function set_steps( $steps )
	{
		$this->steps = $steps;	
	}
	
	public function set_vertical()
	{
		$this->rotate = 'vertical';
	}
}
