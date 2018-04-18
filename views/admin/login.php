<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'>
       	<title><?php echo $this->settings->site_name; ?> - <?php echo lang('login_title');?></title>
        <meta name="description" content="Responsive Admin Web App with Bootstrap and AngularJS">
        <meta name="keywords" content="angularjs admin, admin templates, admin themes, bootstrap admin">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

        <!-- Needs images, font... therefore can not be part of main.css -->
        <link rel="stylesheet" href="styles/loader.css">
        
        <?php Asset::css('styles/loader.css');?>
        <?php Asset::css('styles/main.css');?>
        <link href='http://fonts.googleapis.com/css?family=Roboto:400,100,500,700,300,300italic,500italic|Roboto+Condensed:400,300' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.css">
        <!-- end Needs images -->

            
        <?php echo Asset::render(); ?>

    </head>
    <body class="app ng-scope body-wide body-auth">
            <div class="main-container"
                 data-ng-class="{ 'app-nav-horizontal': main.menu === 'horizontal' }">
                <aside data-ng-include=" 'app/layout/sidebar.html' "
                       id="nav-container"
                       class="nav-container"  
                       data-ng-class="{ 'nav-fixed': main.fixedSidebar,
                                        'nav-horizontal': main.menu === 'horizontal',
                                        'nav-vertical': main.menu === 'vertical',
                                        'bg-white': ['31','32','33','34','35','36'].indexOf(main.skin) >= 0,
                                        'bg-dark': ['31','32','33','34','35','36'].indexOf(main.skin) < 0
                       }">
                </aside>
    
                <div id="content" class="content-container">
                    <section class="view-container animate-fade-up">
                             
                            <div class="page-signin ng-scope" ng-controller="authCtrl">

                                <div class="wrapper">
                                    <div class="main-body">
                                        <div class="body-inner">
                                            <?php echo form_open('admin/login','class="form-horizontal" id="form-submit"'); ?>
                                            <div class="card bg-white">
                                                <div class="card-content">
                                                    
                                                    <section class="logo text-center">
                                                        
                                                        <?php echo Asset::img('logo.jpg',true)?>
                                                    </section>
                            
                                                    
                                                    
                                                        <fieldset>
                                                            <div class="form-group">
                                                                <div class="ui-input-group">        
                                                                    <input type="text" required class="form-control" name="email"/>
                                                                    <span class="input-bar"></span>
                                                                    <label><?php echo lang('global:email'); ?></label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="ui-input-group">        
                                                                    <input type="password" required class="form-control" name="password"/>
                                                                    <span class="input-bar"></span>
                                                                    <label><?php echo lang('global:password'); ?></label>
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                    
                                                </div>
                                                <div class="card-action no-border text-right">
                                                    <button class="btn btn-primary" type="submit">Entrar</button>
                                                </div>
                                            </div>
                                            <?php echo form_close();?>
                                            <div class="additional-info">
                                                <!--a href="#/page/signup">Register</a>
                                                <span class="divider-h"></span>
                                                <a href="#/page/forgot-password">Forgot your password?</a-->
                                                <a href="<?=base_url()?>"><?=base_url()?></a>
                                            </div>
                            
                                        </div>                
                                    </div>
                            
                                </div>
                            
                            </div> 
                    </section>
                </div>
            </div>
    </body>
</html>