<!doctype html>
<?php
  /*
  All Emoncms code is released under the GNU Affero General Public License.
  See COPYRIGHT.txt and LICENSE.txt.

  ---------------------------------------------------------------------
  Emoncms - open source energy visualisation
  Part of the OpenEnergyMonitor project:
  http://openenergymonitor.org
  */
  global $ltime,$path,$fullwidth,$menucollapses,$emoncms_version,$theme,$themecolor,$favicon,$menu;

?>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Emoncms - <?php echo $route->controller.' '.$route->action.' '.$route->subaction; ?></title>
        <link rel="shortcut icon" href="<?php echo $path; ?>Theme/<?php echo $theme; ?>/<?php echo $favicon; ?>" />
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <link rel="apple-touch-startup-image" href="<?php echo $path; ?>Theme/<?php echo $theme; ?>/ios_load.png">
        <link rel="apple-touch-icon" href="<?php echo $path; ?>Theme/<?php echo $theme; ?>/logo_normal.png">
        <link href="<?php echo $path; ?>Lib/bootstrap/css/bootstrap.css" rel="stylesheet">
        <link href="<?php echo $path; ?>Lib/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
        
        <?php if ($themecolor=="blue") { ?>
            <link href="<?php echo $path; ?>Theme/<?php echo $theme; ?>/emon-blue.css" rel="stylesheet">
        <?php } else if ($themecolor=="sun") { ?>
            <link href="<?php echo $path; ?>Theme/<?php echo $theme; ?>/emon-sun.css" rel="stylesheet">
        <?php } else { ?>
            <link href="<?php echo $path; ?>Theme/<?php echo $theme; ?>/emon-standard.css" rel="stylesheet">
        <?php } ?>
             <link href="<?php echo $path; ?>Theme/<?php echo $theme; ?>/emon-CCoop.css" rel="stylesheet">

        <?php //compute dynamic @media properties depending on numbers and lengths of shortcuts
        $maxwidth1=1200;
        $maxwidth2=480;
        $maxwidth3=340;
        $sumlength1 = 0;
        $sumlength2 = 0;
        $sumlength3 = 0;
        $sumlength4 = 0;
        $sumlength5 = 0;
        $nbshortcuts1 = 0;
        $nbshortcuts2 = 0;
        $nbshortcuts3 = 0;
        $nbshortcuts4 = 0;
        $nbshortcuts5 = 0;

        foreach($menu['dashboard'] as $item){
           if(isset($item['name'])){$name = $item['name'];}
           if(isset($item['published'])){$published = $item['published'];} //only published dashboards
           if($name && $published){
             $sumlength1 += strlen($name);
             $nbshortcuts1 ++;
           }
       }

        foreach($menu['left'] as $item){
           if(isset($item['name'])) {$name = $item['name'];}
           $sumlength2 += strlen($name);
           $nbshortcuts2 ++;
       }

        if(count($menu['dropdown']) && $session['read']){
           $extra['name'] = 'Extra';
           $sumlength3 = strlen($extra['name']);
           $nbshortcuts3 ++;
       }

        if(count($menu['dropdownconfig'])){
           $setup['name'] = 'Setup';
           $sumlength4 = strlen($setup['name']);
           $nbshortcuts4 ++;
       }

	    foreach($menu['right'] as $item) {
           if (isset($item['name'])){$name = $item['name'];}
           $sumlength5 += strlen($name);
           $nbshortcuts5 ++;
       }
    $maxwidth1=intval((($sumlength1+$sumlength2+$sumlength3+$sumlength4+$sumlength5)+($nbshortcuts1+$nbshortcuts2+$nbshortcuts3+$nbshortcuts4+$nbshortcuts5+1)*6)*85/9);
    $maxwidth2=intval(($nbshortcuts1+$nbshortcuts2+$nbshortcuts3+$nbshortcuts4+$nbshortcuts5+3)*6*75/9);
    if($maxwidth2>$maxwidth1){$maxwidth2=$maxwidth1-1;}
    if($maxwidth3>$maxwidth2){$maxwidth3=$maxwidth2-1;}
?>

        <script type="text/javascript" src="<?php echo $path; ?>Lib/jquery-1.11.3.min.js"></script>
    </head>
    <body>
        <div id="wrap">
        
        <div id="emoncms-navbar" class="navbar navbar-inverse navbar-fixed-top">
            <div class="navbar-inner">
                    <?php  if ($menucollapses) { ?>
                    <style>
                        /* this is menu colapsed */
                        @media (max-width: 979px){
                          .menu-description {
                            display: inherit !important ;
                          }
                        }
                        @media (min-width: 980px) and (max-width: <?php if($maxwidth1<981){$maxwidth1=981;} echo $maxwidth1; ?>px){
                          .menu-text {
                            display: none !important;
                          }
                        }
                    </style>
                    <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <img src="<?php echo $path; ?>Theme/<?php echo $theme; ?>/favicon.png" style="width:28px;"/>
                    </button>

                    <div class="nav-collapse collapse">
                    <?php } else { ?>
                        <style>
                            @media (max-width: <?php echo $maxwidth1; ?>px){
                              .menu-text {
                                display: none !important;
                              }
                            }
                            @media (max-width: <?php echo $maxwidth2; ?>px){
                              .menu-dashboard {
                                display: none !important;
                              }
                            }
                            @media (max-width: <?php echo $maxwidth3; ?>px){
                              .menu-extra {
                                display: none !important;
                              }
                            }
                        </style>
                    <?php } ?>
                        <div style="display: inline" class="menu-assessment cc pull-left">
                            CARBON COOP
                        </div>
                    <?php
                        echo $mainmenu;
                    ?>
                    <?php if($session['read']){ ?>
                        <div style="display: inline" class="menu-assessment pull-right">
                            <a href="<?php echo $path ?>/user/view">Account</a>
                        </div>
                        <div style="display: inline" class="menu-assessment pull-right">
                            <a href="<?php echo $path ?>assessment/list">Assessments</a>
                        </div>
                    <?php } ?>
                    <?php
                        if ($menucollapses) {
                    ?>
                    </div>
                    <?php
                        }
                    ?>
            </div>
        </div>

        <div id="topspacer"></div>

        <?php if (isset($submenu) && ($submenu)) { ?>
          <div id="submenu">
              <div class="container">
                  <?php echo $submenu; ?>
              </div>
          </div><br>
        <?php } ?>

        <?php
          if ($fullwidth && $route->controller=="dashboard") {
        ?>
        <div>
            <?php echo $content; ?>
        </div>
        <?php } else if ($fullwidth) { ?>
        <div class = "container-fluid"><div class="row-fluid"><div class="span12">
            <?php echo $content; ?>
        </div></div></div>
        <?php } else { ?>
        <div class="container">
            <?php echo $content; ?>
        </div>
        <?php } ?>

        <div style="clear:both; height:60px;"></div>
        </div>

        <div id="footer">
            <?php echo _('Powered by '); ?>
            <a href="http://openenergymonitor.org">OpenEnergyMonitor.org</a>
            <span> | <a href="https://github.com/emoncms/emoncms/releases"><?php echo $emoncms_version; ?></a></span>
            <p>Carbon Co-op's <a href='https://carbon.coop/privacy' target='blank'>privacy policy</a> </p>
        </div>
        <script type="text/javascript" src="<?php echo $path; ?>Lib/bootstrap/js/bootstrap.js"></script>
        <script>
            <?php if(!$session['read']){ ?>
                $( document ).ready(function() {
                    $('.span12').attr('style',"background-image:url('<?php echo $path ?>Theme/CCoop/background.jpg'); background-repeat: no-repeat; width:100%; background-size:1200px; background-position: center; ");
                    $('.main .well').prepend('<h2>Login</h2><p>My Home Energy Planner</p>');
                });
             <?php } ?>
        </script>
    </body>
</html>
