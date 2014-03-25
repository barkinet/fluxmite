<?php

/**
 * @file
 * Contains updateRemoteEntity.
 */

namespace Drupal\fluxmite\Plugin\Rules\Action;

use Drupal\fluxmite\Plugin\Service\MiteAccountInterface;
use Drupal\fluxmite\Plugin\Entity\MiteCustomer;
use Drupal\fluxmite\Rules\RulesPluginHandlerBase;

/**
 * update remote entities.
 */
class updateRemoteEntity extends RulesPluginHandlerBase implements \RulesActionHandlerInterface {

  /**
   * Defines the action.
   */
  public static function getInfo() {

    return static::getInfoDefaults() + array(
      'name' => 'fluxmite_update_remote_entity',
      'label' => t('Update remote entity'),
      'parameter' => array(
        'account' => static::getServiceParameterInfo(),
        'remote_entity' => array(
          'type' => 'entity',
          'label' => t('Mite: Entity'),
          'wrapped' => FALSE,
          'required' => TRUE,
        ),
        'local_entity' => array(
          'type' => 'entity',
          'label' => t('Local: Entity'),
          'wrapped' => FALSE,
          'required' => TRUE,
        ),
      )
    );
  }

  /**
   * Executes the action.
   */
  public function execute(MiteAccountInterface $account, $remote_entity, $local_entity) {
    dpm("update remote");
    print_r("update remote<br>");
    
    $controller = entity_get_controller($remote_entity->entityType());
    
    $remote = $controller->updateRemote($local_entity->id, $local_entity->entityType(), $account, $remote_entity);
    
    //local update
    if(isset($remote)){
      $res=db_query("SELECT event FROM {rules_trigger} WHERE event LIKE :type", array(':type'=>$remote_entity->entityType().'_event--%'));
      $res=$res->fetch();
      rules_invoke_event($res->event, $account, $remote, 'update', $local_entity->id);
    }
  }
}