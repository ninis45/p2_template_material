<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Theme_Material extends Theme {

    public $name			= 'PyroCMS - Admin Theme';
    public $author			= 'PyroCMS Dev Team';
    public $author_website	= 'http://pyrocms.com/';
    public $website			= 'http://pyrocms.com/';
    public $description		= 'PyroCMS admin theme. HTML5 and CSS3 styling.';
    public $version			= '1.0.0';
	public $type			= 'admin';
	public $options 		= array('pyrocms_recent_comments' => array('title' 		=> 'Recent Comments',
																'description'   => 'Would you like to display recent comments on the dashboard?',
																'default'       => 'yes',
																'type'          => 'radio',
																'options'       => 'yes=Yes|no=No',
																'is_required'   => true),
																
									'pyrocms_news_feed' => 			array('title' => 'News Feed',
																'description'   => 'Would you like to display the news feed on the dashboard?',
																'default'       => 'yes',
																'type'          => 'radio',
																'options'       => 'yes=Yes|no=No',
																'is_required'   => true),
																
									'pyrocms_quick_links' => 		array('title' => 'Quick Links',
																'description'   => 'Would you like to display quick links on the dashboard?',
																'default'       => 'yes',
																'type'          => 'radio',
																'options'       => 'yes=Yes|no=No',
																'is_required'   => true),
																
									'pyrocms_analytics_graph' => 	array('title' => 'Analytics Graph',
																'description'   => 'Would you like to display the graph on the dashboard?',
																'default'       => 'yes',
																'type'          => 'radio',
																'options'       => 'yes=Yes|no=No',
																'is_required'   => true),
								   );
	
	/**
	 * Run() is triggered when the theme is loaded for use
	 *
	 * This should contain the main logic for the theme.
	 *
	 * @access	public
	 * @return	void
	 */
	public function run()
	{
		// only load these items on the dashboard
		if ($this->module == '' && $this->method != 'login' && $this->method != 'help')
		{
			// don't bother fetching the data if it's turned off in the theme
           
			if ($this->theme_options->pyrocms_analytics_graph == 'yes' AND in_array($this->current_user->group,array('admin')) AND  ENVIRONMENT=='production')		self::get_analytics();
			if ($this->theme_options->pyrocms_news_feed == 'yes' AND in_array($this->current_user->group,array('admin')))			self::get_rss_feed();
			if ($this->theme_options->pyrocms_recent_comments == 'yes' AND in_array($this->current_user->group,array('admin')))		self::get_recent_comments();
		}
	}
	
	public function get_analytics()
	{
		
            
           
			if ($cached_response = $this->pyrocache->get('analytics'))
			{
				$data['analytic_visits'] = $cached_response['analytic_visits'];
				$data['analytic_views'] = $cached_response['analytic_views'];
                $data['analytic_browsers'] = $cached_response['analytic_browsers'];
                
			}

			else
			{
			   
				try
				{
					$this->load->library('analytics');

					

					$visits   = $this->analytics->getVisitors();
                    $views    = $this->analytics->getPageviews();
                    $browsers = $this->analytics->getBrowsers();
                    //print_r($browsers);
                    //exit();
					//$views = $this->analytics->getPageviews();

					/* build tables */
					if (count($visits->getRows())>0)
					{
					    $flot_datas_visits   = array('label'=>array(),'data'=>array());
                        $flot_datas_browsers = array('label'=>array(),'data'=>array());
                       
						foreach ($visits->getRows() as $visit)
						{
						  
							$year = substr($visit[0], 0, 4);
							$month = substr($visit[0], 4, 2);
							$day = substr($visit[0], 6, 2);

							$utc = mktime(date('h') + 1, null, null, $month, $day, $year) * 1000;

							$flot_data_visits['label'][] = $day.'|'.month_short($month);//$utc;//'[' . $utc . ',' . $visit . ']';
                            $flot_data_visits['data'][] = $visit[1];
							$flot_datas_views[] = '[' . $utc . ',' . $views[$date] . ']';
						}
                        /*****Browsers******/
                        
                        foreach ($browsers->getRows() as $browser)
						{
						    $flot_datas_browsers['label'][] = $browser[0];
                            $flot_datas_browsers['data'][]  = $browser[1];
				        }
						
					}

					$data['analytic_visits']   = $flot_data_visits;
					$data['analytic_views']    =  $views->getRows();// $flot_data_views;
                    $data['analytic_browsers'] = $flot_datas_browsers;// $
                    
					// Call the model or library with the method provided and the same arguments
					$this->pyrocache->write(array('analytic_visits' => $flot_data_visits, 'analytic_views' =>  $views,'analytic_browsers' => $flot_datas_browsers), 'analytics', 60 * 60 * 6); // 6 hours
				}

				catch (Exception $e)
				{
					$data['messages']['notice'] = sprintf(lang('cp:google_analytics_no_connect'), anchor('admin/settings', lang('cp:nav_settings')));
				}
			}
          
			// make it available in the theme
			$this->template->append_metadata($this->load->view('admin/partials/meta_analytics',$data,true))
                    ->set($data);
		//}
	}
	
	public function get_rss_feed()
	{
		// Dashboard RSS feed (using SimplePie)
		$this->load->library('simplepie');
		$this->simplepie->set_cache_location($this->config->item('simplepie_cache_dir'));
		$this->simplepie->set_feed_url($this->settings->dashboard_rss);
		$this->simplepie->init();
		$this->simplepie->handle_content_type();

		// Store the feed items
		$data['rss_items'] = $this->simplepie->get_items(0, $this->settings->dashboard_rss_count);
		
		// you know
		$this->template->set($data);
	}
	
	public function get_recent_comments()
	{
		$this->load->library('comments/comments');
		$this->load->model('comments/comment_m');

		$this->load->model('users/user_m');

		$this->lang->load('comments/comments');

		$recent_comments = $this->comment_m->get_recent(5);
		$data['recent_comments'] = $this->comments->process($recent_comments);
		
		$this->template->set($data);
	}
}

/* End of file theme.php */
?>