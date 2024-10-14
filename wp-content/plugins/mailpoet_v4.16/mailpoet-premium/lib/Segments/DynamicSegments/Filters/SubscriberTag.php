<?php declare(strict_types = 1);

namespace MailPoet\Premium\Segments\DynamicSegments\Filters;

if (!defined('ABSPATH')) exit;


use MailPoet\Entities\DynamicSegmentFilterData;
use MailPoet\Entities\DynamicSegmentFilterEntity;
use MailPoet\Entities\SubscriberEntity;
use MailPoet\Entities\SubscriberTagEntity;
use MailPoet\Segments\DynamicSegments\Filters\Filter;
use MailPoet\Util\Security;
use MailPoetVendor\Doctrine\DBAL\Connection;
use MailPoetVendor\Doctrine\DBAL\Query\QueryBuilder;
use MailPoetVendor\Doctrine\ORM\EntityManager;

class SubscriberTag implements Filter {
  /** @var EntityManager */
  private $entityManager;

  public function __construct(
    EntityManager $entityManager
  ) {
    $this->entityManager = $entityManager;
  }

  public function apply(QueryBuilder $queryBuilder, DynamicSegmentFilterEntity $filter): QueryBuilder {
    $filterData = $filter->getFilterData();
    $tags = is_array($filterData->getParam('tags')) ? $filterData->getParam('tags') : [];
    $operator = $filterData->getParam('operator');
    $parameterSuffix = $filter->getId() ?: Security::generateRandomString();
    $tagsParam = 'tags' . $parameterSuffix;

    $subscribersTable = $this->entityManager->getClassMetadata(SubscriberEntity::class)->getTableName();
    $subscriberTagTable = $this->entityManager->getClassMetadata(SubscriberTagEntity::class)->getTableName();

    $queryBuilder->leftJoin(
      $subscribersTable,
      $subscriberTagTable,
      'subscriber_tag',
      "$subscribersTable.id = subscriber_tag.subscriber_id"
      . ' AND subscriber_tag.tag_id IN (:' . $tagsParam . ')'
    );

    $queryBuilder->setParameter($tagsParam, $tags, Connection::PARAM_INT_ARRAY);

    if ($operator === DynamicSegmentFilterData::OPERATOR_NONE) {
      $queryBuilder->andWhere('subscriber_tag.id IS NULL');
    } else {
      $queryBuilder->andWhere('subscriber_tag.id IS NOT NULL');
    }

    if ($operator === DynamicSegmentFilterData::OPERATOR_ALL) {
      $queryBuilder->groupBy('subscriber_id');
      $queryBuilder->having('COUNT(1) = ' . count($tags));
    }

    return $queryBuilder;
  }
}
