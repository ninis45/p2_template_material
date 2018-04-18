<script type="text/javascript">
(function () {
    'use strict';
    
     angular.module('app.pyro')    
     .controller('DashboardCtrl',['$scope',DashboardCtrl]);
     
      function DashboardCtrl($scope)
     {
         $scope.line = {
            labels: ["<?=implode('","',$analytic_visits['label']);?>"],
            series: ['A'],
            data: [
                [<?=implode(',',$analytic_visits['data']);?>],
              
            ],
            options: {
                 scaleOverride: true,
                 scaleBeginAtZero: true
            }
        }
        $scope.pie = {
            labels: ["<?=implode('","',$analytic_browsers['label']);?>"],
            data: [<?=implode(',',$analytic_browsers['data']);?>]
        }
     }
     
})();

</script>