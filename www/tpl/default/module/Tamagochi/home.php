<script type="text/javascript">
window.TGCConfig = window.TGCConfig || {};
window.TGCConfig.root = '<?php echo GWF_WEB_ROOT; ?>';
window.TGCConfig.user = <?php echo json_encode($tVars['user']); ?>;
window.TGCConfig.player = <?php echo json_encode($tVars['player']); ?>;
window.TGCConfig.ws_url = '<?php echo $tVars['ws_url']; ?>';
</script>
