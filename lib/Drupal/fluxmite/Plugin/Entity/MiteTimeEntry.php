<?php

/**
 * @file
 * Contains MiteTimeEntry.
 */

namespace Drupal\fluxmite\Plugin\Entity;

use Drupal\fluxservice\Entity\RemoteEntity;

/**
 * Entity class for Mite Time entries.
 */
class MiteTimeEntry extends MiteEntityBase implements MiteTimeEntryInterface {
   public function __construct(array $values = array(), $entity_type = NULL) {
    
    parent::__construct($values, $entity_type);
    
    if(isset($this->date_at)){
      $this->date_at=strtotime($this->date_at);
    }
    if(isset($this->revenue)){
      $this->revenue=(float)$this->revenue;
    }
  }
  /**
   * Defines the entity type.
   *
   * This gets exposed to hook_entity_info() via fluxservice_entity_info().
   */
  public static function getInfo() {
    return array(
      'name' => 'fluxmite_time_entry',
      'label' => t('Mite (remote): Time entry'),
      'module' => 'fluxmite',
      'service' => 'fluxmite',
      'controller class' => '\Drupal\fluxmite\MiteTimeEntryController',
      'label callback' => 'entity_class_label',
      'entity keys' => array(
        'id' => 'id',
        'remote id' => 'id',
      ),
    );
  }

  /**
   * Gets the entity property definitions.
   */
  public static function getEntityPropertyInfo($entity_type, $entity_info) {
    $info=parent::getEntityPropertyInfo($entity_type,$entity_info);
  
    $info['date_at'] = array(
      'label' => t('Date-at'),
      'description' => t("Time date-at."),
      'type' => 'date',
      'setter callback' => 'entity_property_verbatim_set',
    );
    $info['minutes'] = array(
      'label' => t('Minutes'),
      'description' => t("Time minutes."),
      'type' => 'integer',
      'setter callback' => 'entity_property_verbatim_set',
    );
    $info['revenue'] = array(
      'label' => t('Revenue'),
      'description' => t("Time revenue."),
      'type' => 'decimal',
      'setter callback' => 'entity_property_verbatim_set',
    );
    $info['hourly_rate'] = array(
      'label' => t('Hourly-rate'),
      'description' => t("Time hourly-rate."),
      'type' => 'integer',
      'setter callback' => 'entity_property_verbatim_set',
    );
    $info['billable'] = array(
      'label' => t('Billable'),
      'description' => t("Time billable."),
      'type' => 'boolean',
      'setter callback' => 'entity_property_verbatim_set',
    );
    $info['note'] = array(
      'label' => t('Note'),
      'description' => t("Time note."),
      'type' => 'text',
      'setter callback' => 'entity_property_verbatim_set',
    );
    $info['user_id'] = array(
      'label' => t('User-id'),
      'description' => t("Time user-id."),
      'type' => 'integer',
      'setter callback' => 'entity_property_verbatim_set',
    );
    $info['user_name'] = array(
      'label' => t('User-name'),
      'description' => t("Time user-name."),
      'type' => 'text',
      'setter callback' => 'entity_property_verbatim_set',
    );
    $info['project_id'] = array(
      'label' => t('Project-id'),
      'description' => t("Time project-id."),
      'type' => 'integer',
      'setter callback' => 'entity_property_verbatim_set',
    );
    $info['project_name'] = array(
      'label' => t('Project-name'),
      'description' => t("Time project-name."),
      'type' => 'text',
      'setter callback' => 'entity_property_verbatim_set',
    );
    $info['service_id'] = array(
      'label' => t('Service-id'),
      'description' => t("Time service-id."),
      'type' => 'integer',
      'setter callback' => 'entity_property_verbatim_set',
    );
    $info['service_name'] = array(
      'label' => t('Service-name'),
      'description' => t("Time service-name."),
      'type' => 'text',
      'setter callback' => 'entity_property_verbatim_set',
    );
    $info['customer_id'] = array(
      'label' => t('Customer-id'),
      'description' => t("Time customer-id."),
      'type' => 'integer',
      'setter callback' => 'entity_property_verbatim_set',
    );
    $info['customer_name'] = array(
      'label' => t('Customer-name'),
      'description' => t("Time Customer-name."),
      'type' => 'text',
      'setter callback' => 'entity_property_verbatim_set',
    );
    $info['locked'] = array(
      'label' => t('Locked'),
      'description' => t("Time locked."),
      'type' => 'boolean',
      'setter callback' => 'entity_property_verbatim_set',
    );
    return $info;
  }
}