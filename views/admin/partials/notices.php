<?php if ($this->session->flashdata('error')): ?>
<!--div class="alert error animated fadeIn">
	<p><?php echo $this->session->flashdata('error'); ?></p>
</div-->

<uib-alert  type="danger" close="closeAlert()" ng-if="show"><?php echo $this->session->flashdata('error');?></uib-alert>
<?php endif; ?>

<?php if (validation_errors()): ?>


 <uib-alert  type="danger" close="closeAlert()" ng-if="show" ><?php echo validation_errors(); ?></uib-alert>
 
<?php endif; ?>

<?php if ( ! empty($messages['error'])): ?>
<div class="alert error animated fadeIn">
	<p><?php echo $messages['error']; ?></p>
</div>
<?php endif; ?>

<?php if ($this->session->flashdata('notice')): ?>
<!--div class="alert warning animated fadeIn">
	<p><?php echo $this->session->flashdata('notice');?></p>
</div-->
<uib-alert  type="" close="closeAlert()" ng-if="show"><?php echo $this->session->flashdata('notice');?></uib-alert>
<?php endif; ?>

<?php if ( ! empty($messages['notice'])): ?>
<!--div class="alert warning animated fadeIn">
	<p><?php echo $messages['notice']; ?></p>
</div-->
<uib-alert  type="alert" close="closeAlert(this)"><?php echo $messages['notice']; ?></uib-alert>
<?php endif; ?>

<?php if ($this->session->flashdata('success')): ?>
<!--div class="alert success animated fadeIn">
	<p><?php echo $this->session->flashdata('success'); ?></p>
</div-->
<uib-alert  type="success" close="closeAlert()" ng-if="show"><?php echo $this->session->flashdata('success'); ?></uib-alert>
<?php endif; ?>

<?php if ( ! empty($messages['success'])): ?>
<div class="alert alert-success">
	<p><?php echo $messages['success']; ?></p>
</div>


<?php endif; ?>

<?php 

	/**
	 * Admin Notification Event
	 */
	Events::trigger('admin_notification');
	
?>