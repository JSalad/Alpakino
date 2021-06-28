<? use app\models\Movie;
   use app\models\Slot;


?>

<script type="text/javascript">
  $pos_id = '<?= $pos_id ?>';
</script>

<div class="row ticket-holder" step="1">
  <? include("step1.php") ?>
</div>
<div class="row ticket-holder hidden" step="2" style="display: none;" >
  <? include("step2.php") ?>
</div>
<div class="row ticket-holder hidden" step="3" style="display: none;">
  <? include("step3.php") ?>
</div>
