<?php

declare (strict_types=1);
namespace RectorPrefix20211117;

use Rector\Php80\Rector\Class_\AnnotationToAttributeRector;
use Rector\Php80\ValueObject\AnnotationToAttribute;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Php80\Rector\Class_\AnnotationToAttributeRector::class)->call('configure', [[\Rector\Php80\Rector\Class_\AnnotationToAttributeRector::ANNOTATION_TO_ATTRIBUTE => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Php80\ValueObject\AnnotationToAttribute('Doctrine\\ORM\\Mapping\\Table'), new \Rector\Php80\ValueObject\AnnotationToAttribute('Doctrine\\ORM\\Mapping\\Entity'), new \Rector\Php80\ValueObject\AnnotationToAttribute('Doctrine\\ORM\\Mapping\\Column'), new \Rector\Php80\ValueObject\AnnotationToAttribute('Doctrine\\ORM\\Mapping\\Id'), new \Rector\Php80\ValueObject\AnnotationToAttribute('Doctrine\\ORM\\Mapping\\GeneratedValue'), new \Rector\Php80\ValueObject\AnnotationToAttribute('Doctrine\\ORM\\Mapping\\OneToOne'), new \Rector\Php80\ValueObject\AnnotationToAttribute('Doctrine\\ORM\\Mapping\\ManyToMany'), new \Rector\Php80\ValueObject\AnnotationToAttribute('Doctrine\\ORM\\Mapping\\JoinTable'), new \Rector\Php80\ValueObject\AnnotationToAttribute('Doctrine\\ORM\\Mapping\\ManyToOne'), new \Rector\Php80\ValueObject\AnnotationToAttribute('Doctrine\\ORM\\Mapping\\JoinColumn'), new \Rector\Php80\ValueObject\AnnotationToAttribute('Doctrine\\ORM\\Mapping\\InverseJoinColumn'), new \Rector\Php80\ValueObject\AnnotationToAttribute('Doctrine\\ORM\\Mapping\\OneToMany'), new \Rector\Php80\ValueObject\AnnotationToAttribute('Doctrine\\ORM\\Mapping\\UniqueConstraint'), new \Rector\Php80\ValueObject\AnnotationToAttribute('Doctrine\\ORM\\Mapping\\SequenceGenerator'), new \Rector\Php80\ValueObject\AnnotationToAttribute('Doctrine\\ORM\\Mapping\\OrderBy'), new \Rector\Php80\ValueObject\AnnotationToAttribute('Doctrine\\ORM\\Mapping\\Index'), new \Rector\Php80\ValueObject\AnnotationToAttribute('Doctrine\\ORM\\Mapping\\CustomIdGenerator'), new \Rector\Php80\ValueObject\AnnotationToAttribute('Doctrine\\ORM\\Mapping\\Embeddable'), new \Rector\Php80\ValueObject\AnnotationToAttribute('Doctrine\\ORM\\Mapping\\Embedded'), new \Rector\Php80\ValueObject\AnnotationToAttribute('Doctrine\\ORM\\Mapping\\MappedSuperclass'), new \Rector\Php80\ValueObject\AnnotationToAttribute('Doctrine\\ORM\\Mapping\\InheritanceType'), new \Rector\Php80\ValueObject\AnnotationToAttribute('Doctrine\\ORM\\Mapping\\DiscriminatorColumn'), new \Rector\Php80\ValueObject\AnnotationToAttribute('Doctrine\\ORM\\Mapping\\DiscriminatorMap'), new \Rector\Php80\ValueObject\AnnotationToAttribute('Doctrine\\ORM\\Mapping\\Version'), new \Rector\Php80\ValueObject\AnnotationToAttribute('Doctrine\\ORM\\Mapping\\ChangeTrackingPolicy'), new \Rector\Php80\ValueObject\AnnotationToAttribute('Doctrine\\ORM\\Mapping\\HasLifecycleCallbacks'), new \Rector\Php80\ValueObject\AnnotationToAttribute('Doctrine\\ORM\\Mapping\\PostLoad'), new \Rector\Php80\ValueObject\AnnotationToAttribute('Doctrine\\ORM\\Mapping\\PostPersist'), new \Rector\Php80\ValueObject\AnnotationToAttribute('Doctrine\\ORM\\Mapping\\PostRemove'), new \Rector\Php80\ValueObject\AnnotationToAttribute('Doctrine\\ORM\\Mapping\\PostUpdate'), new \Rector\Php80\ValueObject\AnnotationToAttribute('Doctrine\\ORM\\Mapping\\PrePersist'), new \Rector\Php80\ValueObject\AnnotationToAttribute('Doctrine\\ORM\\Mapping\\PreRemove'), new \Rector\Php80\ValueObject\AnnotationToAttribute('Doctrine\\ORM\\Mapping\\PreUpdate'), new \Rector\Php80\ValueObject\AnnotationToAttribute('Doctrine\\ORM\\Mapping\\Cache')])]]);
};
