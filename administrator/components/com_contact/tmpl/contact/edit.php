<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_contact
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Associations;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;

HTMLHelper::_('behavior.formvalidator');
HTMLHelper::_('behavior.keepalive');

HTMLHelper::_('script', 'com_contenthistory/admin-history-versions.js', ['version' => 'auto', 'relative' => true]);

$app = Factory::getApplication();
$input = $app->input;

$assoc = Associations::isEnabled();
$hasAssoc = ($this->form->getValue('language', null, '*') !== '*');

// Fieldsets to not automatically render by /layouts/joomla/edit/params.php
$this->ignore_fieldsets = ['details', 'item_associations', 'jmetadata'];
$this->useCoreUI = true;

// In case of modal
$isModal = $input->get('layout') === 'modal';
$layout  = $isModal ? 'modal' : 'edit';
$tmpl    = $isModal || $input->get('tmpl', '', 'cmd') === 'component' ? '&tmpl=component' : '';
?>

<form action="<?php echo Route::_('index.php?option=com_contact&layout=' . $layout . $tmpl . '&id=' . (int) $this->item->id); ?>" method="post" name="adminForm" id="contact-form" class="form-validate">

	<?php echo LayoutHelper::render('joomla.edit.title_alias', $this); ?>

	<div>
		<?php echo HTMLHelper::_('uitab.startTabSet', 'myTab', array('active' => 'details')); ?>

		<?php echo HTMLHelper::_('uitab.addTab', 'myTab', 'details', empty($this->item->id) ? Text::_('COM_CONTACT_NEW_CONTACT') : Text::_('COM_CONTACT_EDIT_CONTACT')); ?>
		<div class="row">
			<div class="col-lg-9">
				<div class="card">
					<div class="card-body">
						<div class="row">
							<div class="col-md-6">
								<?php echo $this->form->renderField('user_id'); ?>
								<?php echo $this->form->renderField('image'); ?>
								<?php echo $this->form->renderField('con_position'); ?>
								<?php echo $this->form->renderField('email_to'); ?>
								<?php echo $this->form->renderField('address'); ?>
								<?php echo $this->form->renderField('suburb'); ?>
								<?php echo $this->form->renderField('state'); ?>
								<?php echo $this->form->renderField('postcode'); ?>
								<?php echo $this->form->renderField('country'); ?>
							</div>
							<div class="col-md-6">
								<?php echo $this->form->renderField('telephone'); ?>
								<?php echo $this->form->renderField('mobile'); ?>
								<?php echo $this->form->renderField('fax'); ?>
								<?php echo $this->form->renderField('webpage'); ?>
								<?php echo $this->form->renderField('sortname1'); ?>
								<?php echo $this->form->renderField('sortname2'); ?>
								<?php echo $this->form->renderField('sortname3'); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-3">
				<div class="card">
					<div class="card-body">
						<?php echo LayoutHelper::render('joomla.edit.global', $this); ?>
					</div>
				</div>
			</div>
		</div>
		<?php echo HTMLHelper::_('uitab.endTab'); ?>

		<?php echo HTMLHelper::_('uitab.addTab', 'myTab', 'misc', Text::_('JGLOBAL_FIELDSET_MISCELLANEOUS')); ?>
		<div class="row">
			<div class="col-md-12">
				<fieldset id="fieldset-misc" class="options-grid-form options-grid-form-full">
					<legend><?php echo $this->form->getField('misc')->title; ?></legend>
					<div>
					<?php echo $this->form->getInput('misc'); ?>
					</div>
				</fieldset>
			</div>
		</div>
		<?php echo HTMLHelper::_('uitab.endTab'); ?>

		<?php echo LayoutHelper::render('joomla.edit.params', $this); ?>

		<?php echo HTMLHelper::_('uitab.addTab', 'myTab', 'publishing', Text::_('JGLOBAL_FIELDSET_PUBLISHING')); ?>
		<div class="row">
			<div class="col-md-6">
				<fieldset id="fieldset-publishingdata" class="options-grid-form options-grid-form-full">
					<legend><?php echo Text::_('JGLOBAL_FIELDSET_PUBLISHING'); ?></legend>
					<div>
					<?php echo LayoutHelper::render('joomla.edit.publishingdata', $this); ?>
					</div>
				</fieldset>
			</div>
			<div class="col-md-6">
				<fieldset id="fieldset-metadata" class="options-grid-form options-grid-form-full">
					<legend><?php echo Text::_('JGLOBAL_FIELDSET_METADATA_OPTIONS'); ?></legend>
					<div>
					<?php echo LayoutHelper::render('joomla.edit.metadata', $this); ?>
					</div>
				</fieldset>
			</div>
		</div>
		<?php echo HTMLHelper::_('uitab.endTab'); ?>

		<?php if (!$isModal && $assoc) : ?>
			<?php echo HTMLHelper::_('uitab.addTab', 'myTab', 'associations', Text::_('JGLOBAL_FIELDSET_ASSOCIATIONS')); ?>
			<?php if ($hasAssoc) : ?>
				<fieldset id="fieldset-associations" class="options-grid-form options-grid-form-full">
				<legend><?php echo Text::_('JGLOBAL_FIELDSET_ASSOCIATIONS'); ?></legend>
				<div>
				<?php echo LayoutHelper::render('joomla.edit.associations', $this); ?>>
				</div>
				</fieldset>
			<?php endif; ?>
			<?php echo HTMLHelper::_('uitab.endTab'); ?>
		<?php elseif ($isModal && $assoc) : ?>
			<div class="hidden"><?php echo LayoutHelper::render('joomla.edit.associations', $this); ?></div>
		<?php endif; ?>

		<?php echo HTMLHelper::_('uitab.endTabSet'); ?>
	</div>
	<input type="hidden" name="task" value="">
	<input type="hidden" name="forcedLanguage" value="<?php echo $input->get('forcedLanguage', '', 'cmd'); ?>">
	<?php echo HTMLHelper::_('form.token'); ?>
</form>
