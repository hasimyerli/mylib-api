<?= "<?php\n" ?>

namespace <?= $namespace; ?>;
<?php if(!empty($parent_class_name)) {
    echo 'use App\Service\\'.$parent_class_name.";";
}?>

class <?php echo $class_name." extends AbstractService"."\n";?>
{
}
