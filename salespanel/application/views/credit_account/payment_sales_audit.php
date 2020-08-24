<div class="row p-10">
    <div class="col-md-6 text-left"><?php echo $start_date; ?> - <?php echo $end_date; ?></div>
    <div class="col-md-6 text-right"><?php echo date('d/m/Y'); ?></div>


</div>


<div class="card-header card-heading-text-two">VATABLE</div>
<div class="card-body">

    <?php echo $vatables; ?>

    <div class="card-header card-heading-text-two">VAT EXEMPT</div>
    <?php echo $vatexempts; ?>

    <br>
    <div class="card-header card-heading-text-two">VATABLE</div>
    <?php echo $novatables; ?>
    <div class="card-header card-heading-text-two">VAT EXEMPT</div>
    <?php echo $novatexempts; ?>


</div>