<?php

use FluentCrm\App\Services\Funnel\BaseBenchMark;
use FluentCrm\App\Services\Funnel\FunnelHelper;
use FluentCrm\App\Services\Funnel\FunnelProcessor;
use FluentCrm\Framework\Support\Arr;

class Benchmark_Field extends BaseBenchMark
{
   public function __construct() {

		$this->{'triggerName'}  = 'fluentcrm_contact_custom_data_updated';
		$this->{'priority'}     = 15;
		$this->{'actionArgNum'} = 3;
		parent::__construct();
	}

    public function getBlock()
    {
        return array (
            'title'       => __('Benchmark custom field is updated', 'fluentcampaign-pro'),
            'description' => __('Select the contact custom field that will trigger this automation when updated.', 'fluentcampaign-pro'),
            'icon' => 'fc-icon-link_clicked',//fluentCrmMix('images/funnel_icons/link_clicked.svg'),
        );
    }
    
    
 
    public function getBlockFields($funnel)
    {
$options = array();

		foreach ( fluentcrm_get_custom_contact_fields() as $field ) {

			$options[] = array(
				'id'    => $field['slug'],
				'title' => $field['label'],
			);
		}
        
        return array (
            'title'     => __('A custom field is updated', 'fluentcampaign-pro'),
            'sub_title' => __('This will run when once a field is triggred', 'fluentcampaign-pro'),
            'fields'    => array(
				'field_name' => array(
					'type'        => 'select',
					'options'     => $options,
					'label'       => __( 'Field', 'fluentcampaign-pro' ),
					'placeholder' => __( 'Select a field', 'fluentcampaign-pro' ),
				),
				'update_type'  => array(
    				'type'    => 'radio',
    				'label'   => __( 'If the field changes to?', 'fluentcampaign-pro' ),
    				'options' => array(
    					array(
    						'id'    => 'any',
    						'title' => __( 'Any Value', 'fluentcampaign-pro' ),
    					),
    					array(
    						'id'    => 'specific',
    						'title' => __( 'A Specific Value', 'fluentcampaign-pro' ),
    					),
    				),
    			),
    			'field_value'  => array(
    				'type'       => 'input-text',
    				'label'      => __( 'Field Value', 'fluentcampaign-pro' ),
    				'help'       => __( 'Enter the field value that must match to trigger the automation.', 'fluentcampaign-pro' ),
    				'dependency' => array(
    					'depends_on' => 'update_type',
    					'operator'   => '=',
    					'value'      => 'specific',
    				),
    			),
    			'field_empty'  => array(
    				'type'       => 'radio',
    				'label'      => __( 'Can the field be empty ?', 'fluentcampaign-pro' ),
    				'options' => array(
    					array(
    						'id'    => 'yes',
    						'title' => __( 'Yes', 'fluentcampaign-pro' ),
    					),
    					array(
    						'id'    => 'no',
    						'title' => __( 'No', 'fluentcampaign-pro' ),
    					),
    				),
    				'help'       => __( 'If the field can be empty, the automation will run. Otherwise it will be skipped.', 'fluentcampaign-pro' ),
    			),
    			'run_multiple' => array(
    				'type'        => 'yes_no_check',
    				'label'       => '',
    				'check_label' => __( 'Restart the Automation Multiple times for a contact for this event. (Only enable if you want to restart automation for the same contact)', 'fluentcampaign-pro' ),
    				'inline_help' => __( 'If you enable, then it will restart the automation for a contact even if the contact is already in the automation. Otherwise, It will just skip if already exist.', 'fluentcampaign-pro' ),
    			),
			),
        );
        
    }


	
    public function canEnterField()
    {
        return array (
            'type'        => 'yes_no_check',
            'check_label' => __('Contacts can enter directly to this sequence point. If you enable this then any contact meet with goal will enter in this goal point.', 'fluentcampaign-pro'),
            'default_set_value' => 'yes'
        );
    }

    public function handle($benchMark, $originalArgs)
    {
        $benchmarkId = $originalArgs[0];
        if($benchMark->id != $benchmarkId) {
            return;
        }

        $subscriber = $originalArgs[1];

        if($subscriber) {
            $funnelProcessor = new FunnelProcessor();
            $funnelProcessor->startFunnelFromSequencePoint($benchMark, $subscriber);
        }


        $url = Arr::get($benchMark->settings, 'redirect_to', site_url('/'));

        $url = str_replace(['&amp;', '+'], ['&', '%2B'], $url);

        wp_redirect($url);
        exit();
    }
}
new Benchmark_Field();