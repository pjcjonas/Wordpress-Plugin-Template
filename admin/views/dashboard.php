<!--
- Dasboard View

All variables are contained in the $args variable
-->
<div class="wrap">
    <h2>$args</h2>
    <pre><?php print_r($args); ?></pre>
    <h1><?php echo $args['title']; ?></h1>
    <?php echo ofyt_FRAMERENAME_helper()->ofyt_get_setting('prefix'); ?>
</div>
