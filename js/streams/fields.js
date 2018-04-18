(function () {
    'use strict';
    angular.module('app.streams')
    .controller('InputCtrl',['$scope','$http','$sce',InputCtrl]);
    
    function InputCtrl($scope,$http,$sce)
    {
        
        //$scope.data={field_type : ''};
        //console.log($scope.data.field_type);
        $scope.get_parameters= function()
        {
            
        }
        
        $scope.$watch('data.field_type',function(newValue,oldValue){
             
             
             if(!newValue)
                return ;
                
             
             var post_data = {
                data : newValue
             }
             
             $http.post(SITE_URL+'streams_core/ajax/build_parameters',post_data).then(function(response){
                
                $scope.parameters = $sce.trustAsHtml(response.data);
            });
        });
    }
})(); 

/*(function($) {

	$(function(){

	pyro.generate_slug('input[name="field_name"]', 'input[name="field_slug"]', '_', true);

	$('#field_type').change(function() {

		var field_type = $(this).val();

		$.ajax({
			dataType: 'text',
			type: 'POST',
			data: 'data='+field_type+'&csrf_hash_name='+$.cookie(pyro.csrf_cookie_name),
			url:  SITE_URL+'streams_core/ajax/build_parameters',
			success: function(returned_html){
				$('.streams_param_input').remove();
				$('.form_inputs > ul').append(returned_html);
				pyro.chosen();
			}
		});

	});
	
	$(document).ready(function() {
	  	$('.input :input:visible:first').focus();
	});
	
	});

})(jQuery);*/
