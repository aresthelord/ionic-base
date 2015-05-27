angular.module('ionicApp.services', ['ngCookies', 'http-auth-interceptor'])

.factory(
	"transformRequestAsFormPost",
	function () {

	// I prepare the request data for the form post.
	function transformRequest(data, getHeaders) {

		var headers = getHeaders();

		headers["Content-type"] = "application/x-www-form-urlencoded; charset=utf-8";

		return (serializeData(data));

	}

	// Return the factory value.
	return (transformRequest);

	// ---
	// PRVIATE METHODS.
	// ---


	// I serialize the given Object into a key-value pair string. This
	// method expects an object and will default to the toString() method.
	// --
	// NOTE: This is an atered version of the jQuery.param() method which
	// will serialize a data collection for Form posting.
	// --
	// https://github.com/jquery/jquery/blob/master/src/serialize.js#L45
	function serializeData(data) {

		// If this is not an object, defer to native stringification.
		if (!angular.isObject(data)) {

			return ((data == null) ? "" : data.toString());

		}

		var buffer = [];

		// Serialize each key in the object.
		for (var name in data) {

			if (!data.hasOwnProperty(name)) {

				continue;

			}

			var value = data[name];

			buffer.push(
				encodeURIComponent(name) +
				"=" +
				encodeURIComponent((value == null) ? "" : value));

		}

		// Serialize the buffer and clean it up for transportation.
		var source = buffer
			.join("&")
			.replace(/%20/g, "+");

		return (source);

	}

})

.factory('MessageService', function ($q, $http, $log) {

	var messages = [];

	return {
		findAll : function () {
			var deferred = $q.defer();
			$http.get('api/message', {
				ignoreAuthModule : false
			})
			.success(function (data) {
				deferred.resolve({
					data : data
				});
			}).error(function (msg, code) {

				console.log(msg);
				console.log(code);
				$log.error(msg, code);
				deferred.reject(msg);
			});

			return deferred.promise;
		},

		findById : function (messageId) {
			var deferred = $q.defer();
			$http.get('api/message/' + messageId)
			.success(function (data) {
				deferred.resolve({
					data : data
				});
			}).error(function (msg, code) {
				deferred.reject(msg);
				$log.error(msg, code);
			});
			return deferred.promise;
		},
		findByRange : function (begin, end) {
			var deferred = $q.defer();
			$http.get('api/message/' + begin + '/' + end, {
				ignoreAuthModule : false
			})
			.success(function (data) {
				deferred.resolve({
					data : data
				});
			}).error(function (msg, code) {
				deferred.reject(msg);
				$log.error(msg, code);
			});
			return deferred.promise;
		},

		findByName : function (searchKey) {
			var deferred = $q.defer();
			$http.get('api/message/name/' + searchKey)
			.success(function (data) {
				deferred.resolve({
					data : data
				});
			}).error(function (msg, code) {
				deferred.reject(msg);
				$log.error(msg, code);
			});
			return deferred.promise;
		}

	}

})
.factory('AuthenticationService', function ($q, $window, $rootScope, $http, authService, $httpBackend, $cookieStore) {
	var service = {

		login : function (user) {
			var deferred = $q.defer();
			var promise = deferred.promise;
			$http.post('api/auth', {
				"user" : user
			}, {
				ignoreAuthModule : true
			})
			.success(function (data, status, headers, config) {
				if (data.success) {
					var resultData = data.data[0];

					if (resultData.token) {
						$http.defaults.headers.common.Authorization = resultData.token; // Step 1
						$http.defaults.headers.common['X-Access-Token'] = resultData.token || $cookies.token;
						$cookieStore.put('token', resultData.token);
						$window.sessionStorage.uid = resultData.uid;
						// Need to inform the http-auth-interceptor that
						// the user has logged in successfully.  To do this, we pass in a function that
						// will configure the request headers with the authorization token so
						// previously failed requests(aka with status == 401) will be resent with the
						// authorization token placed in the header
						authService.loginConfirmed(data, function (config) { // Step 2 & 3

							config.headers.Authorization = resultData.token;
							return config;
						});
					} else {
						delete $window.sessionStorage.uid;
						config.headers.Authorization = null;
						$rootScope.$broadcast('event:auth-login-failed', status);

					}
				} else {

					$rootScope.$broadcast('event:auth-login-failed', status);
				}

			})
			.error(function (data, status, headers, config) {

				$rootScope.$broadcast('event:auth-login-failed', status);
			});

		},
		logout : function (user) {

			$http.post('api/auth', {}, {
				ignoreAuthModule : true
			})
			.finally (function (data) {
					$rootScope.$broadcast('event:auth-logout-complete');
					delete $http.defaults.headers.common.Authorization;
					delete $http.defaults.headers.common['X-Access-Token'];
					$cookieStore.put('token', resultData.token);
					delete $window.sessionStorage.uid;

				});
		},
		loginCancelled : function () {
			authService.loginCancelled();
		},
		getUser : function () {
			return $rootScope.user;
		},
		setUser : function (user) {
			$rootScope.user = user;
		}
	};
	return service;
})
.factory('authHttpResponseInterceptor', ['$q', '$location', function ($q, $location) {
			return {
				response : function (response) {
					if (response.status === 401) {
						console.log("Response 401");
					}
					return response || $q.when(response);
				},
				responseError : function (rejection) {
					if (rejection.status === 401) {
						console.log("Response Error 401", rejection);
						//$location.path('/login').search('returnTo', $location.path());
						$location.path('/#/main/login');
					}
					return $q.reject(rejection);
				}
			}
		}
	])

.factory('ContentService', function ($q, $http, $log) {

	var contents = [];

	return {
		findAll : function () {
			var deferred = $q.defer();
			$http.get('api/contents', {
				ignoreAuthModule : false
			})
			.success(function (data) {
				deferred.resolve({
					data : data
				});
			}).error(function (msg, code) {

				$log.error(msg, code);
				deferred.reject(msg);
			});

			return deferred.promise;
		},

		findById : function (contentid) {
			var deferred = $q.defer();
			$http.get('api/content/' + contentid)
			.success(function (data) {
				deferred.resolve({
					data : data
				});
			}).error(function (msg, code) {
				deferred.reject(msg);
				$log.error(msg, code);
			});
			return deferred.promise;
		},
		findByRange : function (begin, end) {
			var deferred = $q.defer();
			$http.get('api/content/' + begin + '/' + end, {
				ignoreAuthModule : false
			})
			.success(function (data) {
				deferred.resolve({
					data : data
				});
			}).error(function (msg, code) {
				deferred.reject(msg);
				$log.error(msg, code);
			});
			return deferred.promise;
		},

		findByName : function (searchKey) {
			var deferred = $q.defer();
			$http.get('api/content/name/' + searchKey)
			.success(function (data) {
				deferred.resolve({
					data : data
				});
			}).error(function (msg, code) {
				deferred.reject(msg);
				$log.error(msg, code);
			});
			return deferred.promise;
		}

	}

})
.factory('CameraService', ['$q', function ($q) {

			return {
				getPicture : function (options) {
					var q = $q.defer();

					navigator.camera.getPicture(function (result) {
						// Do any magic you need
						q.resolve(result);
					}, function (err) {
						q.reject(err);
					}, options);

					return q.promise;
				}
			}
		}
	]);
