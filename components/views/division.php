
<?php



?>

<div style="background-color: <?php echo $color; ?>;" <?php  echo $hidden ? 'hidden id="division-hidden"': ''; ?> class="<?php echo $small ? "prikaz-division-small" : "prikaz-division" ?>">
    <?php echo $name; ?>

</div>

<style>
    .prikaz-division{
        border-radius: 4px;
        font-size: medium;
        display: inline-block;
        color: white;
        margin: 1px;
        padding: 3px 5px 3px 5px;
    }
    .prikaz-division-small{
        border-radius: 4px;
        font-size: x-small;
        display: inline-block;
        color: white;
        margin: 1px;
        padding: 3px 5px 3px 5px;
    }
</style>