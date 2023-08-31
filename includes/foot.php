<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="assets/js/functions.js"></script>
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
if (count($arAdditionalJsFunctions) > 0)
{
  echo implode(PHP_EOL, $arAdditionalJsFunctions);
}
?>
</script>
<?php
if (count($arAdditionalJsScript) > 0)
{
  echo implode(PHP_EOL, $arAdditionalJsScript);
}
?>

</body>
</html>