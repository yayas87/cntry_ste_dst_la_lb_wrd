<?php

namespace Drupal\cntry_ste_dst_la_lb_wrd;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\user\EntityOwnerInterface;
use Drupal\Core\Entity\EntityChangedInterface;

/**
 * Provides an interface defining a Slider entity.
 *
 * We have this interface so we can join the other interfaces it extends.
 *
 * @ingroup cntry_ste_dst_la_lb_wrd
 */
interface LocalbodyListInterface extends ContentEntityInterface, EntityOwnerInterface, EntityChangedInterface {

}
