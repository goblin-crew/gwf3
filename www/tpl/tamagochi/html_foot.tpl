	<div ui-view id="MAINVIEW"></div>
	
	<!-- FastLoaders Ninja -->
	<script src="http://maps.google.com/maps/api/js?key=AIzaSyBrEK28--B1PaUlvpHXB-4MzQlUjNPBez0"></script>
	
	<script src="{$root}tpl/tamagochi/bower_components/angular/angular.js"></script>
	<script src="{$root}tpl/tamagochi/bower_components/angular-animate/angular-animate.js"></script>
	<script src="{$root}tpl/tamagochi/bower_components/angular-aria/angular-aria.js"></script>
	<script src="{$root}tpl/tamagochi/bower_components/angular-messages/angular-messages.js"></script>
	<script src="{$root}tpl/tamagochi/bower_components/angular-ui/build/angular-ui.js"></script>
	<script src="{$root}tpl/tamagochi/bower_components/angular-ui-router/release/angular-ui-router.js"></script>
	<script src="{$root}tpl/tamagochi/bower_components/angular-material/angular-material.js"></script>
	<script src="{$root}tpl/tamagochi/bower_components/ngmap/build/scripts/ng-map.js"></script>


	<!-- All hail to the hypnotoad 0-o -->

	<script src="{$root}tpl/tamagochi/js/config/tamagochi.conf.js"></script>
	
	<script src="{$root}tpl/tamagochi/js/tamagochi.js"></script>

	<script src="{$root}tpl/tamagochi/js/config/ConstSrvc.js"></script>

	<script src="{$root}tpl/tamagochi/js/util/MapUtil.js"></script>
	<script src="{$root}tpl/tamagochi/js/util/StringUtil.js"></script>

	<script src="{$root}tpl/tamagochi/js/model/Avatar.js"></script>
	<script src="{$root}tpl/tamagochi/js/model/GWFMessage.js"></script>
	<script src="{$root}tpl/tamagochi/js/model/Player.js"></script>
	<script src="{$root}tpl/tamagochi/js/model/User.js"></script>

	<script src="{$root}tpl/tamagochi/js/srvc/AvatarSrvc.js"></script>
	<script src="{$root}tpl/tamagochi/js/srvc/ErrorSrvc.js"></script>
	<script src="{$root}tpl/tamagochi/js/srvc/PingSrvc.js"></script>
	<script src="{$root}tpl/tamagochi/js/srvc/PlayerSrvc.js"></script>
	<script src="{$root}tpl/tamagochi/js/srvc/PositionSrvc.js"></script>
	<script src="{$root}tpl/tamagochi/js/srvc/RequestInterceptor.js"></script>
	<script src="{$root}tpl/tamagochi/js/srvc/RequestSrvc.js"></script>

	<script src="{$root}tpl/tamagochi/js/ctrl/DashboardCtrl.js"></script>
	<script src="{$root}tpl/tamagochi/js/ctrl/HomeCtrl.js"></script>
	<script src="{$root}tpl/tamagochi/js/ctrl/LoginCtrl.js"></script>
	<script src="{$root}tpl/tamagochi/js/ctrl/MapCtrl.js"></script>
	<script src="{$root}tpl/tamagochi/js/ctrl/TGCCtrl.js"></script>
	
	
	<!-- Let's boot it -->
	
	<script>angular.element(document).ready(function() { angular.bootstrap(document.body, ['tgc']); });</script>

</body>