//<?php

$form->add( new \IPS\Helpers\Form\Number( 'userTopicStats_maxResults', \IPS\Settings::i()->userTopicStats_maxResults,
	false, array( 'min' => 1 ) ) );
$form->add( new \IPS\Helpers\Form\YesNo( 'userTopicStats_includeGuests',
	\IPS\Settings::i()->userTopicStats_includeGuests, false ) );

if ( $values = $form->values() )
{
	$form->saveAsSettings();
	return TRUE;
}

return $form;