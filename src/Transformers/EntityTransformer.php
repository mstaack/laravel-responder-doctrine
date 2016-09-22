<?php

namespace Flugg\Responder\Transformers;

use League\Fractal\TransformerAbstract;
use JMS\Serializer\SerializationContext;

use Flugg\Responder\SerializerDoctrine;

class EntityTransformer extends TransformerAbstract
{

    protected $serializeGroups;

    protected $serializeBuilder;

    public function __construct()
    {
        $builder = app(SerializerDoctrine::class);
        $this->serializeBuilder = $builder;
    }

    public function setGroups($groups)
    {
        $this->serializeGroups = $groups;
        return $this;
    }

    public function transform($entity)
    {
        return $this->serializeBuilder->toArray(
            $entity,
            $this->createSerializationContext()
        );
    }

    protected function createSerializationContext()
    {
        $context = SerializationContext::create();
        if(!is_null($this->serializeGroups)) $context->setGroups($this->serializeGroups);
        return $context;
    }

}
