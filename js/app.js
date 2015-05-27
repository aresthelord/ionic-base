angular.module('ionicApp', ['ionic', 'ionicApp.services', 'ionicApp.controllers', 'ionicApp.directives', 'ngCordova'])

.config(function ($compileProvider) {
	$compileProvider.imgSrcSanitizationWhitelist(/^\s*(https?|ftp|mailto|file|tel):/);
})

.config(['$httpProvider', function ($httpProvider) {
			//Http Intercpetor to check auth failures for xhr requests
			$httpProvider.interceptors.push('authHttpResponseInterceptor');
		}
	])
.config(function ($stateProvider, $urlRouterProvider) {

	$stateProvider

	.state('main', {
		url : '/main',
		templateUrl : 'templates/tabs.html',
		abstract : true,
		controller : 'MainController'
	})
	.state('main.photos', {
		url : "/photos",
		views : {
			'photo-tab' : {
				templateUrl : "templates/photos.html",
				controller : 'PhotosCtrl'
			}
		}
	})

	.state('main.facts2', {
		url : "/facts2",
		views : {
			'home-tab' : {
				templateUrl : "templates/facts2.html"
			}
		}
	})
	.state('main.content1', {
		url : "/content",
		views : {
			'content1-tab' : {
				templateUrl : "templates/content.html",
				controller : 'ContentTabCtrl'
			}
		}
	})
	.state('main.content2', {
		url : "/content-2",
		views : {
			'content2-tab' : {
				templateUrl : "templates/content-2.html",
				controller : 'Content2TabCtrl'
			}
		}
	})
	.state('main.content3', {
		url : "/content-3",
		views : {
			'content3-tab' : {
				templateUrl : "templates/content-3.html",
				controller : 'Content3TabCtrl'

			}
		}
	})
	.state('main.content4', {
		url : "/content-4",
		views : {
			'content1-tab' : {
				templateUrl : "templates/content-4.html",
				controller : 'ContentTabCtrl'
			}
		}
	})
	.state('main.message', {
		url : "/messages",
		views : {
			"login-tab" : {
				templateUrl : 'templates/message-index.html',
				controller : 'MessageIndexCtrl'
			}
		}
	})
	.state('main.messagebyrange', {
		url : "/messages/:begin/:end",
		views : {
			"login-tab" : {
				templateUrl : 'templates/message-index.html',
				controller : 'MessageIndexCtrl'
			}
		}
	})
	.state('main.messagebykey', {
		url : "/message/name/:key",
		views : {
			"message-bykey-tab" : {
				templateUrl : 'templates/message-index.html',
				controller : 'MessageIndexCtrl'
			}
		}
	})

	.state('main.message-detail', {
		url : "/message/:messageId",
		views : {
			"login-tab" : {
				templateUrl : 'templates/message-detail.html',
				controller : 'MessageDetailCtrl'
			}
		}
	})
	.state('main.contents', {
		url : "/contents",
		views : {
			"login-tab" : {
				templateUrl : 'templates/content-index.html',
				controller : 'ContentIndexCtrl'
			}
		}
	})
	.state('main.content-detail', {
		url : "/contents/:contentId",
		views : {
			"login-tab" : {
				templateUrl : 'templates/content-detail.html',
				controller : 'ContentDetailCtrl'
			}
		}
	})
	.state('main.camera', {
		url : "/camera",
		views : {
			"login-tab" : {
				templateUrl : 'templates/camera.html',
				controller : 'CameraCtrl'
			}
		}
	})

	.state('main.login', {
		url : "/login",
		views : {
			"login-tab" : {
				templateUrl : 'templates/login.html',
				controller : 'LoginCtrl'
			}
		}
	});

	$urlRouterProvider.otherwise("/main/photos");

})

.run(function ($ionicPlatform) {
	$ionicPlatform.ready(function () {
		console.log("ionicPlatforReady")
	});
});
