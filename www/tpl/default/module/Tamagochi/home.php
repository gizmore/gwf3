<script type="text/javascript">
window.TGC = window.TGC || {};
window.TGC.root = '/';
window.TGC.cookie = "<?php echo $tVars['cookie']; ?>";
window.TGC.user = <?php echo json_encode($tVars['user']); ?>;
window.TGC.player = <?php echo json_encode($tVars['player']); ?>;
</script>
