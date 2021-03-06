<?php

/**
 * @file
 * Contains MiteCustomer.
 */

namespace Drupal\fluxmite\Plugin\Entity;

use Drupal\fluxservice\Entity\RemoteEntity;

/**
 * Entity class for Mite Customers.
 */
class MiteCustomer extends MiteEntityBase implements MiteCustomerInterface {

  public function __construct(array $values = array(), $entity_type = NULL) {
    parent::__construct($values, $entity_type);

    //case: active_hourly_rate = default
    if(isset($this->active_hourly_rate)&&gettype($this->active_hourly_rate)=='array'){
      $this->active_hourly_rate='nil';
    }

    if(isset($this->hourly_rates_per_service)){
      $rates=$this->hourly_rates_per_service;
      //serialize hourly_rates_per_service
      if(isset($rates['hourly-rate-per-service'])){
        $this->hourly_rates_per_service=json_decode(str_replace('-', '_', json_encode($rates['hourly-rate-per-service'])),1);
        if(!isset($this->hourly_rates_per_service[0])){
          $this->hourly_rates_per_service=array($this->hourly_rates_per_service);
        }
      }
      else{
        $this->hourly_rates_per_service=array();
      }
    }
  }

  /**
   * Defines the entity type.
   *
   * This gets exposed to hook_entity_info() via fluxservice_entity_info().
   */
  public static function getInfo() {
    return array(
      'name' => 'fluxmite_customer',
      'label' => t('Mite (remote): Customer'),
      'module' => 'fluxmite',
      'service' => 'fluxmite',
      'controller class' => '\Drupal\fluxmite\MiteCustomerController',
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

    $info['name'] = array(
      'label' => t('Name'),
      'description' => t("Customer name."),
      'type' => 'text',
      'required' => TRUE,
      'setter callback' => 'entity_property_verbatim_set',
    );
    $info['note'] = array(
      'label' => t('Note'),
      'description' => t("Customer note."),
      'type' => 'text',
      'setter callback' => 'entity_property_verbatim_set',
    );
    $info['archived'] = array(
      'label' => t('Archived'),
      'description' => t("Customer archived."),
      'type' => 'boolean',
      'setter callback' => 'entity_property_verbatim_set',
    );
    $info['hourly_rate'] = array(
      'label' => t('Hourly-rate'),
      'description' => t("Customer hourly-rate."),
      'type' => 'integer',
      'setter callback' => 'entity_property_verbatim_set',
    );
    $info['active_hourly_rate'] = array(
      'label' => t('Active-hourly-rate'),
      'description' => t("Customer active-hourly-rate."),
      'type' => 'text',
      'setter callback' => 'entity_property_verbatim_set',
    );
    $info['hourly_rates_per_service'] = array(
      'label' => t('Hourly-rates-per-service'),
      'description' => t("Customer hourly-rates-per-service."),
      'type' => 'list<struct>',
      'setter callback' => 'entity_property_verbatim_set',
      'property info' => array(
        'service_id' => array(
          'label' => t('Mite service id'),
          'description' => t('Mite service id'),
          'type' => 'integer',
          'setter callback' => 'entity_property_verbatim_set',
        ),
        'hourly_rate' => array(
          'label' => t('Hourly-rate'),
          'description' => t('Hourly-rate for service'),
          'type' => 'integer',
          'setter callback' => 'entity_property_verbatim_set',
        )        
      )
    );
    $info['hourly_rates_per_service_json'] = array(
      'label' => t('Hourly-rates-per-service json'),
      'description' => t("Hourly rates per service json string."),
      'type' => 'text',
      'setter callback' => 'entity_property_verbatim_set',
    );
    return $info;
  }
}