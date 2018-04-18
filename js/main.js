(function () {
    'use strict';
    
     angular.module('app.pyro')
      //.config('configCalendar',[configCalendar])
      .run(LoadConfig)
      
      .directive('formatDecimal',[formatDecimal])
      .directive('confirmAction',[confirmAction])
      .directive('closeBlock',[closeBlock])
      .directive('openModal',['$myModal','$rootScope',openModal])
      .directive('datepickerTimezone',[datepickerTimezone])
      .directive('slimScroller',[slimScroller])
      .directive('printArea',[printArea])
      .factory('$myModal', ['$uibModal',myModalFactory])
      .controller('ModalInstanceCtrl',['$scope','$uibModalInstance','$rootScope','$sce','title','body',ModalInstanceCtrl])
      .controller('ShortCuts',['$scope','$myModal',shortCuts])
      .controller('AlertCtrl', ['$scope', AlertCtrl])
      
      .controller('InputCtrl',['$scope',InputCtrl])
      .controller('PyroCtrl',['$scope',PyroCtrl])
      .directive('formatoMoneda',[formatoMoneda])
      .controller('PaginationCtrl',['$scope','$window',PaginationCtrl]);
     
       function formatoMoneda()
       {
            return {
               
                require:'^ngModel',
               
                restrict: 'A',
                
                link:function propiedades(scope,element,attr){
    
                                   
                 /*function updateValue() 
                          {
                    element.text(importe);
                  }
    
                  scope.$watch(attrs.formatoMoneda, function(value) 
                  {
                    format = value;
                    updateValue();
                  });*/
                    
                    element.on('focus',function(){
                        var text = $(element).val();
                        var number = text.replace(',','');
                       
                        $(element).val(number);
                    });
                    element.on('blur',function(){
                         var num      = $(element).val();
                         var regx_i=  /^[0-9]+([.])?([0-9]+)?$/;
    
                         if (!regx_i.test(num))
                         {
    
                         // console.log("El valor " + num + " no es un número");
                          $(element).val("");
                         }
                           else { 
                                  var separador =  ",", // separador para los miles
                                      sepDecimal = '.';
                                 
                                  var splitStr = num.split('.');
                                  var splitLeft = splitStr[0];
                                  var splitRight = splitStr.length > 1 ? sepDecimal + splitStr[1] : '.00';
                                      if(splitRight.length == 1 )
                                      {
                                       splitRight = splitRight + '00';
                                      }
                                      else if (splitRight.length == 2 )
                                      {
                                        splitRight = splitRight + '0';
                                      }
    
                                  
                                  var regx = /(\d+)(\d{3})/;
                                  while (regx.test(splitLeft)) {
                                    splitLeft = splitLeft.replace(regx, '$1' + separador + '$2');
                                  }
                                                                  
                                 $(element).val(splitLeft +splitRight);
    
                                }  
    
    
                        
                    });
                }
                
                
            }
         }
       function closeBlock()
        {
             return {
            
                restrict: 'A',
                
                link:function propiedades(scope,element,attr){
                    element.bind('click', function(e){
                        
                        e.preventDefault();
                        var parent    = element.attr('parent');
                        
                        if(parent == false)
                        {
                            alert('La definición del parent es requerido.');
                        }
                        
                        //if(no_image)
                        //{
                            $(element).parent(parent).html('<img src="'+SITE_URL+'files/cloud_thumb/dummy/100/100"/>');
                        //}
                        //else
                        //{
                          //   $(element).parent(parent).remove();
                        //}
                        
                        
                        //$rootScope.$broadcast('preloader:active');
                        //$myModal.open(element.attr('href'),attr.modalTitle,attr.modalController);
                       
                       
                       
                    });
                    
                }
                
                
            }
        }
        function printArea()
        {
            
        }
        function slimScroller() {
            return {
                restrict: 'A',
                link: function(scope, ele, attrs) {
                    scope.$watch('scroll',function(newVal,oldVal){
                        
                        console.log(scope.scroll);
                    });
                    return ele.slimScroll({
                       
                        start:'bottom',
                        height: attrs.scrollHeight || '100%'
                    });
                }
            };
        }
    
    
     function datepickerTimezone()
     {
        return {
            restrict: 'A',
            priority: 1,
            require: 'ngModel',
            link: function (scope, element, attrs, ctrl) {
                ctrl.$formatters.push(function (value) {
                    var date = new Date(Date.parse(value));
                    date = new Date(date.getTime() + (60000 * date.getTimezoneOffset()));
                    //if (!dateFormat || !modelValue) return "";
                    //var retVal = moment(modelValue).format(dateFormat);
                    return date;
                });
    
                ctrl.$parsers.push(function (value) {
                    var date = new Date(value.getTime() - (60000 * value.getTimezoneOffset()));
                    return date;
                });
            }
        };
     }
     function openModal($myModal,$rootScope)
     {
         return {
            
            restrict: 'A',
            
            link:function propiedades(scope,element,attr){
                element.bind('click', function(e){
                    
                    e.preventDefault();
                    $rootScope.$broadcast('preloader:active');
                    $myModal.open(element.attr('href'),attr.modalTitle,attr.modalController,attr.template);
                   
                   
                   
                });
                
            }
            
            
        }
     }     
     function myModalFactory($uibModal)
     {
         
         var open=function(url,title,controller,template)
         {
             
            
            return $uibModal.open({
                //animation: $scope.animationsEnabled,
                templateUrl: template?template:'myModalContent.html',
                controller: controller?controller:'ModalInstanceCtrl',
                controllerAs: 'vm',
                //size: size,
                resolve: {
                    title: function () {
                       return title;
                    },
                    body:function($http)
                    {
                        return $http.get(url);
                    },
                    url:function()
                    {
                        return url;    
                    }
                    /*controller:function()
                    {
                        return controller;
                    },
                    url:function()
                    {
                        return url;    
                    }*/
                    
                }
            });
         }
         return {open:open};
     }
     function PyroCtrl($scope)
     {
      
        var vm = this;

          vm.messages = [
            {
              'username': 'username1',
              'content': 'Hi!'
            },
            {
              'username': 'username2',
              'content': 'Hello!'
            },
            {
              'username': 'username2',
              'content': 'Hello!'
            },
            {
              'username': 'username2',
              'content': 'Hello!'
            },
            {
              'username': 'username2',
              'content': 'Hello!'
            },
            {
              'username': 'username2',
              'content': 'Hello!'
            }
          ];
        
          vm.username = 'username1';
        
          vm.sendMessage = function(message, username) {
            if(message && message !== '' && username) {
              vm.messages.push({
                'username': username,
                'content': message
              });
            }
          };
          vm.visible = true;
          vm.expandOnNew = true;
        
     }
     
     function ModalInstanceCtrl($scope, $uibModalInstance,$rootScope,$sce,title,body) {
        
        
        $rootScope.$broadcast('preloader:hide');
        $scope.modal_title = title;
        $scope.modal_body = $sce.trustAsHtml(body.data);
        
        
       

        $scope.cancel = function() {
            
            $uibModalInstance.dismiss("cancel");
        };

    }
     function shortCuts($scope,$myModal)
     {
        $scope.openModal=function(element)
        {
            //console.log($myModal.open());
            //console.log($(element).attr('href'));
        }
     }
     
     function InputCtrl($scope)
     {
        $scope.toolbar = [
          ['p','h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'pre', 'quote'],
          ['bold', 'italics', 'underline', 'strikeThrough', 'ul', 'ol', 'redo', 'undo', 'clear'],
          ['justifyLeft', 'justifyCenter', 'justifyRight', 'indent', 'outdent'],
          ['html','insertLink', 'insertVideo', 'wordcount', 'charcount']
       ];
       
       //$scope.htmlContent = '<h2>Try me!</h2><p>textAngular is a super cool WYSIWYG Text Editor directive for AngularJS</p><p><b>Features:</b></p><ol><li>Automatic Seamless Two-Way-Binding</li><li style="color: blue;">Super Easy <b>Theming</b> Options</li><li>Simple Editor Instance Creation</li><li>Safely Parses Html for Custom Toolbar Icons</li><li>Doesn&apos;t Use an iFrame</li><li>Works with Firefox, Chrome, and IE8+</li></ol><p><b>Code at GitHub:</b> <a href="https://github.com/fraywing/textAngular">Here</a> </p>';
     }
     function confirmAction()
     {
        return {
          priority: -1,
          restrict: 'A',
          link: function(scope, element, attrs){
            element.bind('click', function(e){
              var message = attrs.ngmessage || '¿Confirma realizar la siguiente acción?';
              if(message && !confirm(message)){
                e.stopImmediatePropagation();
                e.preventDefault();
              }
            });
          }
        }
     }
     
     
     function formatDecimal()
     {
        return {
           
            require:'^ngModel',
           
            restrict: 'A',
            
            link:function propiedades(scope,element,attr){
               
                
                
                
                element.on('blur',function(){
                    
                    
                    
                    
                    var new_value     = parseFloat(Math.round(scope.f_importe * 100) / 100).toFixed(2);
                    
                    $(element).val(new_value);
                    
                });
            }
            
            
        }
     }
     
     function LoadConfig($http,$cookies)
     {
        $http.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded; charset=UTF-8';
        //$http.defaults.headers.post['X-Requested-With']='XMLHttpRequest';
        $http.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
        
        $http.defaults.transformRequest = function(data) {
            
            
           if(!data)
           {
                var data={};
           } 
           
           data['csrf_hash_name']=$cookies.get(pyro.csrf_cookie_name);
           
           var new_data=$.param(data);
           
           
          
            
            return new_data;
        }
     }
     function PaginationCtrl($scope,$window)
     {
          $scope.selectPage=function(page,event)
          {
            alert(page);
          }
          
          $scope.$watch(function(newValue){
            
             if(!$scope.currentPage)
             {
                return ;
             }
             $window.location.href=$scope.currentPage;
             
          });
          
     }
     
     function AlertCtrl($scope)
     {
        
        $scope.show = true;
        $scope.closeAlert = function(index) {
           
           //index.status.isOpen=false;
            $scope.show = false;
            //console.log($scope);
           
        };
     }
     
})();