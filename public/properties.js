/**
 * page-properties
 * Created by idavis on 7/15/14.
 */

rcm.addAngularModule('openGraph');
/**
 * openGraph.OpenGraphProperties
 */
angular.module('openGraph', ['rcmApi', 'rcmAdminApi'])
.controller(
    'OpenGraphProperties',
    [
        '$scope',
        'rcmApiService',
        'rcmAdminApiUrlService',
        function ($scope, rcmApiService, rcmAdminApiUrlService) {

            var data = RcmAdminService.model.RcmPageModel.getData();
            var currentSettings = JSON.parse(jQuery('meta[property="wshafer:opengraph"]').attr('content'));

            $scope.loading = false;

            $scope.saveOk = false;
            $scope.saveFail = false;
            $scope.message = '';

            //getting title, description and keywords from dom to our form
            $scope.title = data.page.title;
            $scope.description = data.page.description;
            $scope.keywords = data.page.keywords;
            
            $scope.host = window.location.host;

            $scope.ogTypes = [
                {ogType: 'website'},
                {ogType: 'article'}
            ];

            $scope.openGraph = currentSettings;

            if (!$scope.openGraph.article.tags[0]) {
                $scope.openGraph.article.tags.push('');
            }

            console.log($scope.openGraph.article);
            $scope.addTag = function() {
                $scope.openGraph.article.tags.push('');
            };

            $scope.removeTag = function(index) {
                $scope.openGraph.article.tags.splice(index,1);
            };

            //save function
            $scope.save = function () {
                $scope.saveOk = false;
                $scope.saveFail = false;
                $scope.message = '';

                RcmAdminService.model.RcmPageModel.setData(data);

                var apiParams = {
                    url: '/open-graph/save/site/{siteId}/page/{pageId}',
                    urlParams: {
                        siteId: data.page.siteId,
                        pageId: data.page.id
                    },
                    data: {
                        openGraph: $scope.openGraph
                    },
                    loading: function (loading) {
                        $scope.loading = loading;
                    },
                    success: function (data) {
                        jQuery('meta[property="wshafer:opengraph"]').attr('content', JSON.stringify($scope.openGraph));
                        $scope.saveOk = true
                    },
                    error: function (data) {
                        $scope.saveFail = true;
                        $scope.message = 'An error occurred while saving data: ' + data.message
                    }
                };
                
                // this service the put acts as a patch
                rcmApiService.put(apiParams);
            }
        }
    ]
)
    .directive('typeForm', function() {
        return {
            link: function(scope, element, attrs) {
                // Function returns the correct template for each field.
                scope.getFormTemplateUrl = function() {
                    var path = '/modules/open-graph/forms';

                    switch (scope.openGraph.general.ogType) {
                        case 'website':
                        case 'article':
                            return path+'/'+scope.openGraph.general.ogType+'.html';
                        default:
                            return path+'/blank.html';
                    }
                }
            },

            template: '<div class="dynamic-field" ng-include="getFormTemplateUrl()"></div>'
        };
    })

    .directive('typePreview', function() {
        return {
            link: function(scope, element, attrs) {
                // Function returns the correct template for each field.
                scope.getPreviewTemplateUrl = function() {
                    var path = '/modules/open-graph/previews';

                    switch (scope.openGraph.general.ogType) {
                        case 'website':
                        case 'article':
                            return path+'/'+scope.openGraph.general.ogType+'.html';
                        default:
                            return path+'/blank.html';
                    }
                }
            },

            template: '<div class="dynamic-field" ng-include="getPreviewTemplateUrl()"></div>'
        };
    })
    .directive('imageSelector', function($parse) {
        return {
            compile: function (element, attrs) {
                return function (scope, element, attrs, controller) {

                    var modelAccessor = $parse(attrs.ngModel);
                    var newElem = $.dialogIn('image', attrs.name, modelAccessor(scope));
                    element.replaceWith(newElem);

                    var processChange = function () {
                        var image = newElem.val();

                        scope.$apply(function (scope) {
                            // Change bound variable
                            modelAccessor.assign(scope, image);
                        });
                    };

                    newElem.change(processChange);
                };
            }
        };
    });
