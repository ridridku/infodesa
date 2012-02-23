<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Beam-Template
 * 
 * @package Beam-Template
 * @category Library
 * @author Ardi Soebrata
 */
/**
 * Beam-Template Class
 */
class Template
{
	/**
	 * CodeIgniter instance
	 * 
	 * @var CodeIgniter 
	 */
	protected $ci;
	
	/**
	 * Path to Template Layout
	 * 
	 * @var string 
	 */
	protected $layout_path = 'layouts';
	
	/**
	 * Default layout
	 * 
	 * @var string 
	 */
	protected $default_layout = 'default';
	
	/**
	 * Current layout name
	 * 
	 * @var string 
	 */
	protected $layout = '';
	
	/**
	 * Path to Assets Directory
	 * 
	 * @var string 
	 */
	protected $assets_path = 'assets';
	
	/**
	 * Base Site Title
	 * 
	 * @var string 
	 */
	protected $base_title = 'My Site';
	
	/**
	 * Title Separator
	 * 
	 * @var string 
	 */
	protected $title_separator = ' | ';
	
	/**
	 * Page Title
	 * 
	 * @var string 
	 */
	protected $title = '';
	
	
	/**
	 * Site Metas
	 * 
	 * @var array 
	 */
	protected $metas = array();
	
	/**
	 * Css Files
	 * 
	 * @var array
	 */
	protected $css = array();
	
	/**
	 * Javascript Files on header.
	 * 
	 * @var array
	 */
	protected $js_header = array();
	
	/**
	 * Javascript Files on footer.
	 * 
	 * @var array
	 */
	protected $js_footer = array();
	
	/**
	 * View Partials.
	 * 
	 * @var array 
	 */
	protected $partials = array();
	
	/**
	 * Construct the Class
	 * 
	 * @param array $config Template configs.
	 */
	public function __construct($config = array())
	{
		$this->ci = &get_instance();
		
		$options = array();
		if ($this->ci->config->item('beam_template'))
			$options = $this->ci->config->item('beam_template');
		if (is_array($config))
			$options = array_merge($options, $config);
		
		foreach ($options as $key => $value)
		{
			switch ($key)
			{
				case 'metas':
					foreach($value as $metakey => $metaval)
					{
						if (!is_array($metaval))
							$this->set_meta($metakey, $metaval);
						else
							$this->set_meta($metakey, $metaval['content'], $metaval['key']);
					}
					break;
				case 'css':
					foreach($value as $csskey => $cssval)
					{
						if (is_numeric($csskey))
							$this->set_css($cssval);
						elseif (!is_array($cssval))
							$this->set_css($csskey, array('media' => $cssval));
						else
							$this->set_css($csskey, $cssval);
					}
					break;
				case 'js_header':
					foreach($value as $jskey => $jsval)
					{
						if (is_numeric($jskey))
							$this->set_js($jsval);
						else
							$this->set_js_script($jsval, $jskey);
					}
					break;
				case 'js_footer':
					foreach($value as $jskey => $jsval)
					{
						if (is_numeric($jskey))
							$this->set_js($jsval, TRUE);
						else
							$this->set_js_script($jsval, $jskey, TRUE);
					}
					break;
				case 'default_layout':
					$this->default_layout = $this->layout = $value;
					break;
				default:
					$this->$key = $value;
			}
		}
		
		log_message('debug', 'Template Class Initialized.');
	}
	
	/**
	 * Set Site Meta
	 * 
	 * @param string $name
	 * @param string $content
	 * @param string $key 
	 * @return Template
	 */
	public function set_meta($name, $content, $key = 'name')
	{
		$this->metas[$name]['key'] = $key;
		$this->metas[$name]['content'] = $content;
		
		return $this;
	}
	
	/**
	 * Set Stylesheet
	 * 
	 * @param string $name Name or link of CSS file.
	 * @param array $attr Attributes to apply to CSS tag.
	 * @return Template
	 */
	public function set_css($name, $attr = array('media' => 'screen'))
	{
		$this->css[$name] = $attr;
		
		return $this;
	}
	
	/**
	 * Set Stylesheet Style
	 * 
	 * Just like {@link Template::set_css}, but instead it will insert a css style.
	 * 
	 * @param string $style The CSS style to insert.
	 * @param array $attr Attributes to apply to CSS tag.
	 * @return Template
	 */
	public function set_css_style($style, $attr = array('media' => 'screen'))
	{
		$name = 'style' . count($this->css);
		$attr['content'] = $style;
		return $this->set_css($name, $attr);
	}
	
	/**
	 * Set Javascript
	 * 
	 * @param string $name Javascript file name or URL.
	 * @param boolean $footer Display javascript on footer? FALSE = header (default), TRUE = footer.
	 * @return Template 
	 */
	public function set_js($name, $footer = FALSE)
	{
		if ($footer)
			$this->js_footer[$name] = $name;
		else
			$this->js_header[$name] = $name;
		
		return $this;
	}
	
	/**
	 * Set Javascript Script
	 * 
	 * Just like {@link Template::set_js}, but instead it will insert a js script.
	 * 
	 * @param string $script The JS script to insert.
	 * @param string $name An optional temporary name of the script
	 * @param boolean $footer Display javascript on footer? FALSE = header (default), TRUE = footer.
	 * @return Template 
	 */
	public function set_js_script($script, $name = '', $footer = FALSE)
	{
		if ($footer)
		{
			if (empty($name))
				$name = 'script' . count($this->js_footer);
			$this->js_footer[$name] = $script;
		}
		else
		{
			if (empty($name))
				$name = 'script' . count($this->js_header);
			$this->js_header[$name] = $script;
		}
		return $this;
	}
	
	/**
	 * Load a content to view partial.
	 * 
	 * @param string $name Partial name.
	 * @param string $content Content to be append to the partial.
	 * @return Template
	 */
	public function load_partial($name, $content)
	{
		if (!isset($this->partials[$name])) $this->partials[$name] = '';
		$this->partials[$name] .= "\r\n{$content}\r\n";
		return $this;
	}
	
	/**
	 * Load a module controller to view partial.
	 * 
	 * @param string $name Partial name.
	 * @param string $uri URI of the module to be append to the partial.
	 * @return Template
	 */
	public function load_module_partial($name, $uri)
	{
		$this->load_partial($name, Modules::run($uri));
		return $this;
	}
		
	/**
	 * Get Layout Name
	 * 
	 * @return string
	 */
	public function get_layout()
	{
		return $this->layout;
	}
	
	/**
	 * Set Layout Name
	 * 
	 * @param string $name
	 * @return Template 
	 */
	public function set_layout($name)
	{
		$this->layout = $name;
		
		return $this;
	}
	
	/**
	 * Set Title Separator
	 * 
	 * @param string $sep 
	 * @return Template
	 */
	public function set_title_separator($sep)
	{
		$this->title_separator = $sep;
		
		return $this;
	}
	
	/**
	 * Set Title Page
	 * 
	 * @param string $title
	 * @return Template 
	 */
	public function set_title($title)
	{
		$this->title = $title;
		
		return $this;
	}
	
	/**
	 * Build The Template
	 * 
	 * @param string $view
	 * @param array $data
	 * @param boolean $output Return the output?
	 */
	public function build($view, $data = array(), $output = FALSE)
	{
		$template_data = array();
		
		// Create Page Title.
		$template_data['title'] = $this->base_title;
		if (!empty($this->title))
			$template_data['title'] .= $this->title_separator . $this->title;
		
		// Create Meta tags data.
		$template_data['metas'] = "\r\n";
		foreach($this->metas as $metaname => $metavalue)
			$template_data['metas'] .= "\t\t<meta {$metavalue['key']}=\"{$metaname}\" content=\"{$metavalue['content']}\" />\r\n";
		
		// Create CSS tags data.
		$template_data['css'] = "\r\n";
		foreach($this->css as $key => $value)
		{
			$style = '';
			if (isset($value['style']))
			{
				$style = $value['style'];
				unset($value['style']);
			}
			
			$attr = 'rel="stylesheet" ';
			foreach($value as $attrname => $attrvalue)
				$attr .= $attrname . '="' . $attrvalue . '" ';
			
			if (!empty($style))
				$template_data['css'] .= "\t\t<style>\r\n" . $style . "\r\n\t\t</style>\r\n";
			else
			{
				if (preg_match('!^\w+://! i', $key))
					$template_data['css'] .= "\t\t<link href=\"{$key}.css\" {$attr}/>\r\n";
				else
				{
					$css_path = $this->ci->config->base_url($this->assets_path . '/css/' . $key . '.css');
					$template_data['css'] .= "\t\t<link href=\"" . $css_path . "\" {$attr}/>\r\n";
				}
			}
		}
		
		// Create Javascript header file tags data.
		$template_data['js_header'] = "\r\n";
		foreach($this->js_header as $key => $value)
		{
			if ($key == $value)
				$template_data['js_header'] .= "\t\t<script src=\"" . $this->ci->config->base_url($this->assets_path . '/js/' . $key . '.js') . "\"></script>\r\n";
			else
			{
				$template_data['js_header'] .= "\t\t<script>\r\n" . $value . "\r\n</script>\r\n";
			}
		}		
		
		// Create Javascript footer file tags data.
		$template_data['js_footer'] = "\r\n";
		foreach($this->js_footer as $key => $value)
		{
			if ($key == $value)
				$template_data['js_footer'] .= "\t\t<script src=\"" . $this->ci->config->base_url($this->assets_path . '/js/' . $key . '.js') . "\"></script>\r\n";
			else
			{
				$template_data['js_footer'] .= "\t\t<script>\r\n" . $value . "\r\n</script>\r\n";
			}
		}
		
		// Add partials.
		$template_data['partials'] = $this->partials;
		
		// Save to view variable.
		$data['template'] = $template_data;
		
		// Load content view.
		$data['template']['content'] = $this->ci->load->view($view, $data, TRUE);
		
		// Apply content to layout.
		return $this->ci->load->view('layouts/' . $this->layout, $data, $output);
	}
}
