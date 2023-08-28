<script>
$(document).ready(function()
{
    <?php
    if (count($arAdditionalJsOnLoad) > 0)
    {
        echo implode(PHP_EOL, $arAdditionalJsOnLoad);
    }
    ?>
});
</script>

<script>
<?php
if (count($arAdditionalJs) > 0)
{
  echo implode(PHP_EOL, $arAdditionalJs);
}
?>
</script>

