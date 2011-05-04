<div class="gwf_buttons">
<?php foreach ($tVars['buttons'] as $btn) { $sel = $btn[2] === true ? '_sel' : ''; ?>
<a class="gwf_tab<?php echo $sel;?>" href="<?php echo $btn[0]; ?>"><?php echo $btn[1]; ?></a>
<?php }?>
</div>