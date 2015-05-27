angular.module('ionicApp.controllers', [])

.controller('MainController', ['$scope', '$ionicSideMenuDelegate', function ($scope, $ionicSideMenuDelegate) {
			console.log("MainController");
			$scope.toggleMenu = function () {
				$ionicSideMenuDelegate.toggleLeft();
			}
		}
	])
.controller('TabsCtrl', function ($scope) {
	console.log("TAbsCtrl");

})
.controller('ContentTabCtrl', function ($scope) {
	//console.log('ContentTabCtrl');
})
.controller('Content2TabCtrl', function ($scope) {
	//console.log('Content2TabCtrl');
})
.controller('Content3TabCtrl', function ($scope, $http, transformRequestAsFormPost, $ionicPopup) {
	$scope.post = {};
	$scope.posts = [];
	$scope.clearPost = function () {
		$scope.post = {
			username : '',
			email : '',
			phone : '',
			body : ''
		};

	};
	$scope.sendPost = function (post) {
		$scope.result = "";
		var request = $http({
				method : "post",
				url : "api/message",
				//transformRequest: transformRequestAsFormPost,
				data : {
					username : post.username,
					email : post.email,
					phone : post.phone,
					message : post.body
				}
			});

		// Store the data-dump of the FORM scope.
		request.success(
			function (result) {
			//console.log(result);
			if (result.success) {
				$scope.result = result;
				$scope.showPopup("Bilgi", " Mesajınız Başarı ile gönderilmiştir.");
				$scope.clearPost();

			} else {
				$scope.error = result.error;
				$scope.showPopup("Hata!", result.data);
			}

		});
	};
	$scope.showPopup = function (title, content) {
		$scope.data = {};

		// An elaborate, custom popup
		var myPopup = $ionicPopup.show({
				template : content,
				title : title,
				subTitle : '',
				scope : $scope,
				buttons : [{
						text : '<b>Tamam</b>',
						type : 'button-royal',
						onTap : function (e) {
							return;
						}
					}
				]
			});
		myPopup.then(function (res) {
			//console.log('Tapped!', res);
		});

	};

})
.controller('Content4TabCtrl', function ($scope) {
	//console.log('Content4TabCtrl');
})

.controller('PhotosCtrl', ['$scope', '$ionicModal', '$ionicSlideBoxDelegate', '$ionicSideMenuDelegate', function ($scope, $ionicModal, $ionicSlideBoxDelegate, $ionicSideMenuDelegate) {
			$scope.leftButtons = [{
					type : 'button-icon icon ion-navicon',
					tap : function (e) {
						$scope.toggleMenu();
					}
				}
			];
			$scope.toggleMenu = function () {
				console.log("toggle");
				$ionicSideMenuDelegate.toggleLeft();
			};

			$ionicModal.fromTemplateUrl('templates/image-modal.html', {
				scope : $scope,
				animation : 'slide-in-up'
			}).then(function (modal) {
				$scope.modal = modal;
			});

			$scope.openModal = function () {
				$ionicSlideBoxDelegate.slide(0);
				$scope.modal.show();
			};

			$scope.closeModal = function () {
				$scope.modal.hide();
			};

			// Cleanup the modal when we're done with it!
			$scope.$on('$destroy', function () {
				$scope.modal.remove();
			});
			// Execute action on hide modal
			$scope.$on('modal.hide', function () {
				// Execute action
			});
			// Execute action on remove modal
			$scope.$on('modal.removed', function () {
				// Execute action
			});
			$scope.$on('modal.shown', function () {
				//console.log('Modal is shown!');
			});

			// Call this functions if you need to manually control the slides
			$scope.next = function () {
				$ionicSlideBoxDelegate.next();
			};

			$scope.previous = function () {
				$ionicSlideBoxDelegate.previous();
			};

			$scope.goToSlide = function (index) {
				console.log(index);
				$scope.modal.show();
				$ionicSlideBoxDelegate.slide(index);
			};

			// Called each time the slide changes
			$scope.slideChanged = function (index) {
				$scope.slideIndex = index;
			};
		}
	])

.controller('MessageIndexCtrl', function ($scope, $location, $stateParams, $cookieStore, $state, MessageService) {

	$scope.searchKey = "";

	$scope.clearSearch = function () {
		$scope.searchKey = "";
		findAllMessages();
	}

	$scope.search = function () {
		console.log($scope.searchKey);
		console.log($stateParams.key);
		MessageService.findByName($scope.searchKey).then(function (result) {
			$scope.messages = result.data.data;
		});
	}

	var findAllMessages = function () {

		MessageService.findAll().then(function (result) {
			if (result.data.success) {
				$scope.messages = result.data.data;
			} else {
				console.log("failed");
			}
		}, function (msg, code) {
			$scope.error = msg;
			console.log($scope.error);
			if (code == 401) {

				$state.go('main.login', {}, {
					reload : false,
					inherit : true
				});
			}
		});

	}
	var findMessagesByRange = function () {
		MessageService.findByRange($stateParams.begin, $stateParams.end).then(function (result) {
			if (result.data.success) {
				$scope.messages = result.data.data;
			} else {
				console.log("failed");
			}
		}, function (status) {
			$scope.error = result.data.error;
			console.log(error);
			if (status == 401) {

				$state.go('main.login', {}, {
					reload : false,
					inherit : true
				});
			}
		});
	}
	if ($stateParams.begin && $stateParams.end) {
		findMessagesByRange($stateParams.begin, $stateParams.end);
		$scope.begin = $stateParams.end;
		$scope.end = 2 * ($stateParams.end) - $stateParams.begin;

	} else {
		findAllMessages();
	}

})

.controller('MessageDetailCtrl', function ($scope, $stateParams, MessageService) {
	MessageService.findById($stateParams.messageId).then(function (result) {
		if (result.data.success) {
			//console.log(result.data.data[0]);
			$scope.message = result.data.data[0];
		} else {
			$scope.error = result.data.error;
		}
	});
})
.controller('LoginCtrl', function ($scope, $http, $state, AuthenticationService) {

	if (!$http.defaults.headers.common['X-Access-Token']) {
		$scope.authenticated = false;
	}
	$scope.message = "";
	$scope.authenticated = false;

	$scope.user = {
		"username" : null,
		"password" : null
	};

	$scope.login = function () {
		AuthenticationService.login($scope.user);
	};
	$scope.logout = function () {
		AuthenticationService.logout($scope.user);
	};

	$scope.$on('event:auth-loginRequired', function (e, rejection) {
		$state.go('main.login', {}, {
			reload : false,
			inherit : true
		});
	});

	$scope.$on('event:auth-loginConfirmed', function (event, data) {
		$scope.authenticated = true;
		$scope.user = data.data[0];
		//$state.go('main.message', {}, {reload: false, inherit: true});
	});

	$scope.$on('event:auth-login-failed', function (e, status) {
		var error = "Kullanıcı Adı ve Şifreniz Hatalı.";
		if (status == 401) {
			error = "Invalid Username or Password.";
		}
		$scope.message = error;
		$scope.authenticated = false;
	});

	$scope.$on('event:auth-logout-complete', function () {
		$scope.authenticated = false;
		$state.go('main.photos', {}, {
			reload : true,
			inherit : false
		});
	});

})
.controller('ContentIndexCtrl', function ($scope, $location, $stateParams, $cookieStore, $state, ContentService) {

	$scope.searchKey = "";

	$scope.clearSearch = function () {
		$scope.searchKey = "";
		findAllMessages();
	};

	$scope.search = function () {
		console.log($scope.searchKey);
		console.log($stateParams.key);
		MessageService.findByName($scope.searchKey).then(function (result) {
			$scope.contents = result.data.data;
		});
	};

	var findAllContents = function () {

		ContentService.findAll().then(function (result) {
			if (result.data.success) {
				$scope.contents = result.data.data;
			} else {
				console.log("failed");
			}
		}, function (msg, code) {
			$scope.error = msg;
			console.log($scope.error);
			if (code == 401) {

				$state.go('main.login', {}, {
					reload : false,
					inherit : true
				});
			}
		});

	};
	findAllContents();

})
.controller('ContentDetailCtrl', function ($scope, $stateParams, ContentService) {
	ContentService.findById($stateParams.contentId).then(function (result) {
		if (result.data.success) {
			//console.log(result.data.data[0]);
			$scope.content = result.data.data[0];
		} else {
			$scope.error = result.data.error;
		}
	});

})

.controller('CameraCtrl', function ($scope, CameraService) {
	console.log("CameraCtrl");
	$scope.getPhoto = function () {
		Camera.getPicture().then(function (imageURI) {
			console.log(imageURI);
			$scope.lastPhoto = imageURI;
		}, function (err) {
			console.err(err);
		}, {
			quality : 75,
			targetWidth : 320,
			targetHeight : 320,
			saveToPhotoAlbum : false
		});
	};

});
