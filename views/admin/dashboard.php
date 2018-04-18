
<div ng-controller="DashboardCtrl">
   
    
   <div class="alert alert-info"><?=sprintf(lang('global:welcome'),$this->current_user->display_name)?></div>
   
	<div class="row">
     <!-- Begin Recent Comments -->
	<?php if (isset($recent_comments) AND is_array($recent_comments) AND $theme_options->pyrocms_recent_comments == 'yes') : ?>
		<div class="col-md-6">
            <div class="panel">
                <div class="panel-heading text-center"><?php echo lang('comments:recent_comments') ?></div>
                <div class="panel-body">
                    
                    
                    
                        <?php if (count($recent_comments)): ?>
                            <div class="media-list media-divider-full">
                                <?php foreach ($recent_comments as $comment): ?>
        							<div class="media">
        								<div class="media-left"><?php echo gravatar($comment->user_email,NULL,NULL,NULL,NULL,'img-circle img64_64') ?></div>
                                        
                                        <div class="media-body">
        								    <h4><?php echo format_date($comment->created_on) ?></h4>
            								<p>
            									<?php echo sprintf(lang('comments:list_comment'), $comment->user_name, $comment->entry_title) ?> 
            									<span><?php echo (Settings::get('comment_markdown') AND $comment->parsed > '') ? strip_tags($comment->parsed) : $comment->comment ?></span>
            								</p>
                                        </div>
        							</div>
        						<?php endforeach ?>
                            </div>
        						
       					<?php else: ?>
        						<?php echo lang('comments:no_comments') ?>
       					<?php endif ?>
                           
                </div>
            </div>
        		
    		
        		
        </div>
       	<?php endif ?>
        <?php if ( isset($rss_items) AND $theme_options->pyrocms_news_feed == 'yes') : ?>
    	<div id="feed" class="col-md-6">
    		
            <div class="panel">
                <div class="panel-heading text-center"><?php echo lang('cp:news_feed_title') ?></div>
                <div class="panel-body">
                    <ul class="list-group">
                        <?php foreach($rss_items as $rss_item): ?>
        					<li class="list-group-item">
        							
        						<?php
        							$item_date	= strtotime($rss_item->get_date());
        							$item_month = date('M', $item_date);
        							$item_day	= date('j', $item_date);
        						?>
        							
        						<div class="date">
        							<div class="time">
        								<span class="month">
        									<?php echo $item_month ?>
        								</span>
        								<span class="day">
        									<?php echo $item_day ?>
        								</span>
        							</div>
        						</div>
        						<div class="post">
        							<h4><?php echo anchor($rss_item->get_permalink(), $rss_item->get_title(), 'target="_blank"') ?></h4>
        													
        							<p class='item_body'><?php echo $rss_item->get_description() ?></p>
        						</div>
        					</li>
    					<?php endforeach ?>
                    </ul>
                </div>
            </div>
    		
    		
    		
    
    	</div>		
    	<?php endif ?>
    	<!-- End RSS Feed -->
	</div>		

	<!-- End Recent Comments -->
    
    
    <?php if($this->current_user->group =='admin'):?>
    
    <div class="row">
        <div class="col-md-6">
            
            <div class="panel panel-default panel-labeled">
                <div class="panel-heading">Google Analytics (Por usuario)</div>
                <div class="panel-body">
                     <canvas class="chart chart-line"
                                                    chart-data="line.data"
                                                    chart-series="line.series"
                                                    chart-labels="line.labels"></canvas>
                      <div class="divider"></div> 
                      <span class="panel-label">Visitas diarias</span> 
                </div>
            </div>
            <!--table class="table table-list" cellspacing="0">
    				<thead>
    					<tr>
    						<th width="">Página</th>
    						<th width="10%">Visitas</th>
                            
    					</tr>
    				</thead>
    				
    				<tbody>
                    <?php foreach($analytic_views as $view){?>
                        <tr>
                            <td><?=$view[0]?></td>
                            <td><?=$view[1]?></td>
                        </tr>
                    <?php }?>
                    </tbody>
              </table-->  
        </div>
        
        <div class="col-md-6">
            <div class="panel panel-default panel-labeled">
                <div class="panel-heading">Google Analytics (Por navegador)</div>
                        <div class="panel-body">
                            <canvas class="chart chart-pie"
                                    chart-data="pie.data"
                                    chart-labels="pie.labels"></canvas>
                            <div class="divider"></div> 
                            <span class="panel-label">Visitas por navegador</span> 
                        </div>
            </div> 
        </div>
    </div>    
    <?php endif; ?>
    
    	                     
        
    
</div>